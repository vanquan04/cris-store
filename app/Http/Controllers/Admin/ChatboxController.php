<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Ai_knowledge;
use App\Models\ChatSession;
use App\Models\ChatMessage;
use App\Models\Product;
use App\Models\Order;
use App\Exports\ChatMessagesExport;

class ChatboxController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'chatbox']);
            return $next($request);
        });
    }

    // =========================================================
    // ADMIN: Danh sách kiến thức AI
    // =========================================================

    public function index()
    {
        $knowledges = Ai_knowledge::all();
        return view('admin.chatbox.list', compact('knowledges'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Ai_knowledge::create([
            'category' => $request->input('category'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'creator' => Auth::guard('sanctum')->id() ?? 41,
        ]);

        toastr()->success('💾 Đã thêm kiến thức mới!');
        return redirect()->route('admin.chatbox.list');
    }

    public function delete(Ai_knowledge $knowledge)
    {
        $knowledge->delete();
        toastr()->success('Đã xóa kiến thức!');
        return redirect()->route('admin.chatbox.list');
    }

    public function detail(Ai_knowledge $knowledge)
    {
        return response()->json([
            'id' => $knowledge->id,
            'category' => $knowledge->category,
            'title' => $knowledge->title,
            'content' => $knowledge->content,
            'created_at' => $knowledge->created_at,
            'updated_at' => $knowledge->updated_at,
        ]);
    }

    public function update(Request $request, Ai_knowledge $knowledge)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $knowledge->update([
            'category' => $request->input('category'),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        toastr()->success('Cập nhật kiến thức thành công!');
        return redirect()->route('admin.chatbox.list');
    }

    // =========================================================
    // ADMIN: Quản lý cuộc hội thoại
    // =========================================================

    public function conversation()
    {
        $conversations = ChatSession::withCount('messages')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('admin.chatbox.conversation', compact('conversations'));
    }

    public function getSessionMessages($id)
    {
        $session = ChatSession::with('messages')->find($id);

        if (!$session) {
            return response()->json(['error' => 'Session không tồn tại'], 404);
        }

        $messages = $session->messages->map(function ($msg) {
            return [
                'sender' => $msg->sender,
                'content' => $msg->content,
                'created_at' => $msg->created_at->format('H:i d/m/Y'),
            ];
        });

        return response()->json(['messages' => $messages]);
    }

    public function deleteSession($id)
    {
        $session = ChatSession::find($id);
        if ($session) {
            $session->messages()->delete();
            $session->delete();
            toastr()->success('Xóa hội thoại thành công!');
        }
        return redirect()->route('admin.chatbox.conversation');
    }

    public function export($sessionId)
    {
        $fileName = "conversation_{$sessionId}.xlsx";
        return Excel::download(new ChatMessagesExport($sessionId), $fileName);
    }

    // =========================================================
    // CHATBOT: Xử lý câu hỏi từ người dùng
    // =========================================================

    public function ask(Request $request)
    {
        try {
            $question = trim($request->input('message', ''));

            if ($question === '') {
                return response()->json(['error' => 'Vui lòng nhập câu hỏi.'], 422);
            }

            // ✅ FIX: Bỏ dòng khai báo $conversation thừa ở đầu
            $conversationId = $request->input('conversation_id')
                ?? session('chat_conversation_id');

            $conversation = $conversationId
                ? ChatSession::find($conversationId)
                : null;

            if (!$conversation) {
                $conversation = ChatSession::create([]);
                session(['chat_conversation_id' => $conversation->id]);
            }

            // Lấy lịch sử hội thoại (tối đa 20 tin gần nhất)
            $history = ChatMessage::where('session_id', $conversation->id)
                ->orderBy('id', 'desc')
                ->take(20)
                ->get(['sender', 'content'])
                ->reverse()
                ->values();

            // Lưu tin nhắn người dùng
            ChatMessage::create([
                'session_id' => $conversation->id,
                'sender' => 'user',
                'content' => $question,
            ]);

            // Lấy kiến thức từ DB
            $knowledgeText = Ai_knowledge::all()
                ->map(fn($item) => "- {$item->title}: {$item->content}")
                ->implode("\n");

            // Kiểm tra xem yêu cầu này có phải từ admin không
            $isAdmin = (bool) $request->input('is_admin', false) || (session('isAdmin') == 1) || (auth()->check() && auth()->user()->isAdmin);

            // Gọi AI (truyền conversation->id để export đúng session và biến isAdmin)
            $aiReply = $this->sendToAI($question, $knowledgeText, $history, $conversation->id, $isAdmin);

            // Đảm bảo câu trả lời sản phẩm luôn có đường dẫn click trực tiếp.
            $aiReply = $this->ensureProductLinksInReply($aiReply, $question);

            // Lưu phản hồi của bot
            ChatMessage::create([
                'session_id' => $conversation->id,
                'sender' => 'bot',
                'content' => $aiReply,
            ]);

            return response()->json([
                'conversation_id' => $conversation->id,
                'reply' => $aiReply,
            ], 200, [], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $ex) {
            Log::error('Chat ask error: ' . $ex->getMessage() . "\n" . $ex->getTraceAsString());
            return response()->json([
                'error' => 'Lỗi máy chủ nội bộ. Vui lòng thử lại sau.',
            ], 500);
        }
    }

    // =========================================================
    // PRIVATE HELPERS
    // =========================================================

    private function sendToAI(string $question, string $knowledgeText = '', $history = null, int $conversationId = 37, bool $isAdmin = false): string
    {
        $question = trim($question);
        if ($question === '')
            return "Bạn vui lòng nhập câu hỏi nhé.";

        // ✅ FIX: dùng config() thay vì env()
        $apiKey = config('services.openrouter.key') ?: env('OPENROUTER_API_KEY');
        if (!$apiKey) {
            Log::error('OPENROUTER_API_KEY chưa được cấu hình.');
            return "⚠️ Chưa cấu hình API Key.";
        }

        $exportUrl = url("admin/chatbox/export/{$conversationId}");

        // --- Lấy thông tin đơn hàng nếu có mã bill ---
        $orderInfoText = $this->buildOrderInfo($question);

        // --- Lấy thông tin sản phẩm nếu là câu hỏi về sản phẩm ---
        $productInfoText = $this->buildProductInfo($question);

        // --- Lấy thông tin kiểm tra, thống kê database nếu được hỏi ---
        $dbInspectText = $this->buildDatabaseInspectionContext($question);

        // --- Cắt bớt knowledge nếu quá dài ---
        $knowledgeText = trim($knowledgeText);
        if ($knowledgeText !== '' && mb_strlen($knowledgeText, 'UTF-8') > 6000) {
            $knowledgeText = mb_substr($knowledgeText, 0, 6000, 'UTF-8') . "\n...(truncated)";
        }

        // --- Ghép context ---
        $contextParts = [];
        if ($knowledgeText !== '')
            $contextParts[] = "KNOWLEDGE:\n{$knowledgeText}";
        if ($productInfoText !== '')
            $contextParts[] = $productInfoText;
        if ($orderInfoText !== '')
            $contextParts[] = $orderInfoText;
        if ($dbInspectText !== '')
            $contextParts[] = $dbInspectText;
        $userContext = implode("\n\n", $contextParts);

        $excelRules = "";
        if ($isAdmin) {
            $excelRules = "QUY TẮC DÀNH CHO ADMIN (QUẢN TRỊ VIÊN):\n"
                . "Khi người dùng là Admin (Quản trị viên) hỏi, bạn có quyền hỗ trợ quản trị hệ thống:\n"
                . "- 📊 Thống kê doanh thu, 📦 quản lý và tra cứu đơn hàng, 👟 quản lý sản phẩm và tồn kho, 👥 quản lý khách hàng, 🎁 quản lý khuyến mãi, 🚚 theo dõi vận chuyển, ⭐ quản lý đánh giá và phản hồi, 📈 báo cáo và xuất Excel, 🔍 tìm kiếm dữ liệu nhanh, 🔔 cảnh báo và thông báo hệ thống, 🤖 hỏi đáp dữ liệu dựa trên Database.\n"
                . "- 🛡️ Chỉ cung cấp thông tin thực tế từ dữ liệu cơ sở dữ liệu được cung cấp (DATABASE_ORDER_STATS, DATABASE_PRODUCT_STATS, DATABASE_USER_STATS), tuyệt đối không được tự ý bịa đặt hay suy diễn dữ liệu.\n\n"
                . "KỊCH BẢN TRẢ LỜI KHI HỖ TRỢ XUẤT EXCEL (BẮT BUỘC):\n"
                . "Khi Admin yêu cầu xuất file Excel (ví dụ: \"xuất excel\", \"tải báo cáo\",...):\n"
                . "Trường hợp 1: Xuất thành công (Tìm thấy dữ liệu phù hợp)\n"
                . "✅ Đã tìm thấy {so_ban_ghi} bản ghi phù hợp.\n"
                . "📄 Loại báo cáo: {ten_bao_cao}\n"
                . "📅 Phạm vi dữ liệu: {tu_ngay} - {den_ngay} (Nếu không rõ ngày thì ghi \"Tất cả\")\n"
                . "📥 File Excel đã được tạo thành công:\n"
                . "🔗 Tải xuống: [📥 Tải Excel]({$exportUrl})\n\n"
                . "Trường hợp 2: Không có dữ liệu phù hợp\n"
                . "⚠️ Không tìm thấy dữ liệu phù hợp với yêu cầu của bạn.\n"
                . "Vui lòng kiểm tra lại:\n"
                . "1. Khoảng thời gian.\n"
                . "2. Bộ lọc tìm kiếm.\n"
                . "3. Loại báo cáo cần xuất.\n"
                . "Hiện tại hệ thống không thể tạo file Excel do không có dữ liệu.\n\n"
                . "Trường hợp 3: Thiếu thông tin (Người dùng yêu cầu xuất chung chung, chưa rõ loại báo cáo hoặc thời gian)\n"
                . "Để xuất báo cáo, vui lòng cung cấp thêm:\n"
                . "📄 Loại báo cáo:\n"
                . "  - Đơn hàng\n"
                . "  - Sản phẩm\n"
                . "  - Khách hàng\n"
                . "  - Doanh thu\n"
                . "  - Tồn kho\n"
                . "📅 Khoảng thời gian cần xuất.\n"
                . "Ví dụ:\n"
                . "\"Xuất Excel doanh thu tháng 06/2026\"\n\n"
                . "Trường hợp 4: Dữ liệu quá lớn (Khi số bản ghi dữ liệu cần xuất từ 100 bản ghi trở lên)\n"
                . "⚠️ Có {so_ban_ghi} bản ghi cần xuất.\n"
                . "Việc tạo file có thể mất vài giây, vui lòng chờ...\n"
                . "Sau khi hoàn tất, hệ thống sẽ cung cấp link tải file Excel:\n"
                . "[📥 Tải Excel]({$exportUrl})\n\n"
                . "QUY TẮC BẮT BUỘC:\n"
                . "- Chỉ xuất dữ liệu thực tế từ Database. Không tự tạo hoặc suy diễn dữ liệu.\n"
                . "- File Excel phải phản ánh đúng dữ liệu trong hệ thống tại thời điểm xuất.\n"
                . "- Nếu không có dữ liệu, không tạo file Excel rỗng hoặc dữ liệu mẫu.\n"
                . "- Chỉ hỗ trợ xuất Excel đối với Admin (Quản trị viên). Khách hàng bình thường tuyệt đối không được hỗ trợ.";
        } else {
            $excelRules = "QUY TẮC XUẤT EXCEL (BẢO MẬT DÀNH CHO KHÁCH HÀNG):\n"
                . "- Tuyệt đối KHÔNG hỗ trợ chức năng xuất excel, tải file báo cáo hay thống kê đối với khách hàng (trang khách hàng).\n"
                . "- Chỉ hỗ trợ tư vấn trả lời và gửi đường link sản phẩm cụ thể. Từ chối lịch sự nếu khách hàng yêu cầu xuất excel hay tải báo cáo.";
        }

        $baseUrl = url('/');

        // --- System Prompt ---
        $systemPrompt = <<<SYS
Bạn là trợ lý AI của Cris Store. Nhiệm vụ của bạn là tư vấn sản phẩm, size giày, sân cỏ, khuyến mãi, đặt hàng, vận chuyển, đổi trả, bảo hành, v.v.

QUY TẮC TƯ VẤN SẢN PHẨM (BẮT BUỘC):
Khi khách hàng hỏi về sản phẩm hoặc cần gợi ý danh sách sản phẩm, hãy trả lời đúng theo định dạng bên dưới đối với mỗi sản phẩm.
Tuyệt đối KHÔNG được chèn thêm bất kỳ dòng trống hay khoảng trắng thừa nào ở giữa các dòng thông tin của cùng một sản phẩm:

{Số thứ tự}. **{Tên sản phẩm}**
   Giá: {Giá sản phẩm}
   [Xem sản phẩm]({Link sản phẩm})

Ví dụ:
Khách hỏi: "Cho tôi một số mẫu giày Nike"
Trả lời:
Dưới đây là một số mẫu giày Nike bạn có thể tham khảo:

1. **Nike Air Zoom Mercurial Vapor 16 Pro TF Max Voltage - Limelight/Volt/Hyper Crimson**
   Giá: 1.170.000 VNĐ
   [Xem sản phẩm]({$baseUrl}/san-pham/nike-air-zoom-mercurial-vapor-16-pro-tf-max-voltage)

2. **Nike Tiempo Legend 10 Academy TF Scary Good - Blue Eclipse/Black**
   Giá: 1.200.000 VNĐ
   [Xem sản phẩm]({$baseUrl}/san-pham/nike-tiempo-legend-10-academy-tf-scary-good)

LƯU Ý CỰC KỲ QUAN TRỌNG VỀ ĐỊNH DẠNG:
- TUYỆT ĐỐI KHÔNG sử dụng các emoji như 👟, 💰, 📝, 🔗, 🖼️, 📌 trong danh sách sản phẩm.
- Tên sản phẩm phải viết hoa đậm bằng markdown: **{Tên sản phẩm}**.
- Dòng giá bán bắt buộc viết ngay dưới tên sản phẩm (thụt đầu dòng 3 khoảng trắng, không để trống dòng ở giữa) có định dạng: "   Giá: {giá_tiền}".
- Dòng tiếp theo là text link markdown "Xem sản phẩm" trỏ tới link thật của sản phẩm (thụt đầu dòng 3 khoảng trắng, không để trống dòng ở giữa): "   [Xem sản phẩm]({Link sản phẩm})".
- Giữa các sản phẩm khác nhau trong danh sách, chỉ dùng chính xác MỘT dòng trống để phân cách.
- KHÔNG dùng định dạng liệt kê rút gọn hoặc gộp dòng cho sản phẩm. Mọi danh sách sản phẩm (bao gồm cả sản phẩm bán chạy nhất, sản phẩm nổi bật, sản phẩm theo danh mục...) đều bắt buộc phải dùng đúng định dạng 3 dòng có kèm link "[Xem sản phẩm](url)" ở trên.
- Không tự tạo/bịa đặt bất kỳ đường link nào. Luôn lấy link trực tiếp từ trường 'url' trong dữ liệu PRODUCT_RESULTS hoặc TOP 5 SẢN PHẨM BÁN CHẠY NHẤT.

CÁC QUY TẮC KHÁC:
1. NẾU TÌM THẤY SẢN PHẨM: Hiển thị TỐI ĐA 3 sản phẩm kèm link từ PRODUCT_RESULTS.
2. NẾU KHÔNG TÌM THẤY SẢN PHẨM: BẮT BUỘC TRẢ LỜI ĐÚNG CÂU SAU (Không thêm văn bản nào khác):
"Xin lỗi, hiện tại Cris Store chưa có sản phẩm phù hợp với yêu cầu của bạn. Bạn có thể tham khảo thêm tại: {$baseUrl}/san-pham"
3. KHÔNG TỰ TẠO ĐƯỜNG LINK: Luôn lấy link trực tiếp từ dữ liệu sản phẩm trong PRODUCT_RESULTS (thuộc tính 'url').
4. ANTI-SPAM: Bất kỳ câu hỏi nào ngoài phạm vi giày đá bóng (ví dụ: lập trình, lịch sử, nấu ăn...) PHẢI TỪ CHỐI lịch sự.
{$excelRules}
SYS;

        // --- Build messages ---
        $messages = [
            ["role" => "system", "content" => $systemPrompt],
        ];

        // Nhét history
        if (!empty($history)) {
            $historyArray = ($history instanceof \Illuminate\Support\Collection)
                ? $history->all()
                : (array) $history;

            if (count($historyArray) > 20) {
                $historyArray = array_slice($historyArray, -20);
            }

            foreach ($historyArray as $msg) {
                $sender = is_array($msg) ? ($msg['sender'] ?? '') : ($msg->sender ?? '');
                $content = trim((string) (is_array($msg) ? ($msg['content'] ?? '') : ($msg->content ?? '')));

                if ($content === '')
                    continue;
                if (mb_strtolower($content, 'UTF-8') === mb_strtolower($question, 'UTF-8'))
                    continue;

                $messages[] = [
                    "role" => ($sender === 'user') ? 'user' : 'assistant',
                    "content" => $content,
                ];
            }
        }

        // Câu hỏi hiện tại
        $messages[] = [
            "role" => "user",
            "content" => ($userContext !== '' ? $userContext . "\n\n" : "") . "USER_QUESTION:\n{$question}",
        ];

        // --- Gọi OpenRouter với cơ chế Auto-Retry ---
        $maxRetries = 3;
        $retryDelay = 2; // Giây
        $response = null;

        for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
            try {
                $response = Http::withHeaders([
                    'Content-Type'  => 'application/json',
                    'Authorization' => "Bearer {$apiKey}",
                    'Referer'       => config('app.url', 'http://localhost'),
                    'X-Title'       => 'TQStore Chatbox',
                ])->timeout(30)->post("https://openrouter.ai/api/v1/chat/completions", [
                    "model"       => "liquid/lfm-2.5-1.2b-instruct:free",
                    "messages"    => $messages,
                    "temperature" => 0.4,
                    "max_tokens"  => 1000,
                ]);

                if ($response->successful()) {
                    break;
                }

                $decoded = $response->json();
                $code = data_get($decoded, 'error.code');
                if ($response->status() == 429 || $code == 429) {
                    if ($attempt < $maxRetries) {
                        Log::warning("AI API rate-limited (lần thử $attempt/$maxRetries). Đang thử lại sau {$retryDelay}s...");
                        sleep($retryDelay);
                        continue;
                    }
                }
            } catch (\Exception $ex) {
                if ($attempt < $maxRetries) {
                    Log::warning("AI API gặp sự cố kết nối (lần thử $attempt/$maxRetries). Đang thử lại sau {$retryDelay}s...");
                    sleep($retryDelay);
                    continue;
                }
                Log::error("AI HTTP exception: " . $ex->getMessage());
                return "⚠️ Không thể kết nối tới máy chủ AI.";
            }
        }

        if ($response->failed()) {
            $decoded = $response->json();
            $errMsg = data_get($decoded, 'error.message', "HTTP " . $response->status());
            Log::error("AI API error. HTTP={$response->status()}. Body=" . $response->body());
            return "⚠️ AI trả về lỗi: {$errMsg}";
        }

        $decoded = $response->json();
        if (!is_array($decoded)) {
            Log::error("AI non-JSON response. Body=" . $response->body());
            return "⚠️ Phản hồi AI không hợp lệ.";
        }

        $content = trim((string) data_get($decoded, 'choices.0.message.content', ''));
        return $content !== '' ? $content : "Xin lỗi, mình chưa tạo được câu trả lời. Bạn hỏi lại giúp mình nhé.";
    }

    private function ensureProductLinksInReply(string $reply, string $question): string
    {
        return $this->cleanWhitespaceAndFormat($reply);
    }

    private function cleanWhitespaceAndFormat(string $text): string
    {
        // 1. Chuẩn hóa xuống dòng và loại bỏ khoảng trắng thừa cuối dòng
        $text = str_replace("\r\n", "\n", $text);
        $text = preg_replace('/[ \t]+$/m', '', $text);

        // 2. Xóa bỏ các dòng trống thừa trong khối sản phẩm (giữa Tiêu đề, Giá và Link)
        // Trường hợp 1: Giữa tên sản phẩm (chữ đậm) và dòng Giá
        $text = preg_replace('/(^\s*\d+\.\s+\*\*[^*]+\*\*\s*)\n+(\s*(?:Giá|Giá bán):)/mi', "$1\n$2", $text);
        
        // Trường hợp 2: Giữa dòng Giá và dòng Xem sản phẩm/Xem chi tiết
        $text = preg_replace('/(\s*(?:Giá|Giá bán):[^\n]+)\n+(\s*\[Xem sản phẩm\]\([^\)]+\)|\s*\[Xem chi tiết\]\([^\)]+\))/mi', "$1\n$2", $text);

        // 3. Xóa bỏ dòng trống thừa giữa các gạch đầu dòng / bullet points / list items liên tiếp
        $text = preg_replace('/(^\s*[\-\*]\s+[^\n]+)\n+(?=\s*[\-\*]\s)/m', "$1\n", $text);

        // 4. Giới hạn tối đa chỉ cho phép 2 dòng trống liên tiếp (tránh thừa khoảng trắng ở phần khác)
        $text = preg_replace('/\n{3,}/', "\n\n", $text);

        return trim($text);
    }

    private function buildOrderInfo(string $question): string
    {
        $code = $this->extractCodeBill($question);
        if (!$code)
            return '';

        $order = Order::where('code_bill', $code)->first();

        if (!$order) {
            return "ORDER_LOOKUP:\n- Không tìm thấy: true\n- code_bill: {$code}\n";
        }

        $status = $this->progressText((int) $order->progress);
        $methodPay = ((int) $order->method_pay === 0) ? 'Thanh toán khi nhận hàng (COD)' : 'Thanh toán online qua VNPAY';

        return "ORDER_INFO:\n"
            . "- Mã đơn hàng: {$order->code_bill}\n"
            . "- Trạng thái: {$status}\n"
            . "- Tổng tiền: " . number_format((int) $order->total, 0, '', '.') . " VNĐ\n"
            . "- Phương thức: {$methodPay}\n"
            . "- Thời gian đặt hàng: {$order->created_at}\n";
    }

    private function buildProductInfo(string $question): string
    {
        if (!$this->isProductQuestion($question))
            return '';

        $criteria = $this->extractSearchCriteria($question);
        $priceFilter = $this->extractPriceFilter($question);
        $minPrice = $priceFilter['min'] ?? null;
        $maxPrice = $priceFilter['max'] ?? null;

        $products = $this->queryProductsByQuestion($question, 3); // Giới hạn 3 sản phẩm

        if ($products->isEmpty()) {
            return "PRODUCT_RESULTS:\n- empty: true\n";
        }

        $lines = ["PRODUCT_RESULTS:"];
        if ($criteria['brand']) $lines[] = "- brand: {$criteria['brand']}";
        if ($criteria['size']) $lines[] = "- size: {$criteria['size']}";
        if ($criteria['field_type']) $lines[] = "- field_type: {$criteria['field_type']}";
        if ($criteria['keyword'] !== '') $lines[] = "- keyword: {$criteria['keyword']}";
        if ($minPrice !== null || $maxPrice !== null) {
            $lines[] = "- price_filter: "
                . ($minPrice !== null ? "min=" . number_format((int) $minPrice, 0, '', '.') : "min=null")
                . ", "
                . ($maxPrice !== null ? "max=" . number_format((int) $maxPrice, 0, '', '.') : "max=null");
        }

        foreach ($products as $p) {
            $price = number_format((int) $p->new_price, 0, '', '.') . " VNĐ";
            $productUrl = url('san-pham/' . ($p->slug ?: $p->id));
            $imageUrl = $p->thumb_main ? url($p->thumb_main) : 'Không có hình ảnh';
            $desc = strip_tags((string)$p->desc_quick);
            if (mb_strlen($desc, 'UTF-8') > 150) {
                $desc = mb_substr($desc, 0, 150, 'UTF-8') . '...';
            }
            if ($desc === '') $desc = 'Sản phẩm chính hãng Cris Store.';

            $lines[] = "- PRODUCT_ITEM:\n  name: {$p->name}\n  price: {$price}\n  desc: {$desc}\n  url: {$productUrl}\n  image: {$imageUrl}";
        }

        return implode("\n", $lines) . "\n";
    }

    private function queryProductsByQuestion(string $question, int $limit = 5)
    {
        $criteria = $this->extractSearchCriteria($question);
        $priceFilter = $this->extractPriceFilter($question);
        $minPrice = $priceFilter['min'] ?? null;
        $maxPrice = $priceFilter['max'] ?? null;

        $query = Product::query()->with('Cat_product:id,name');

        if ($criteria['brand']) {
            $query->where(function($q) use ($criteria) {
                $q->where('name', 'like', "%{$criteria['brand']}%")
                  ->orWhere('slug', 'like', "%{$criteria['brand']}%");
            });
        }

        if ($criteria['size']) {
            $query->where('size', 'like', "%{$criteria['size']}%");
        }

        if ($criteria['field_type']) {
            $query->where('field_type', 'like', "%{$criteria['field_type']}%");
        }

        if ($criteria['keyword'] !== '') {
            $query->where(function ($q) use ($criteria) {
                $kw = $criteria['keyword'];
                $q->where('name', 'like', "%{$kw}%")
                    ->orWhere('slug', 'like', "%{$kw}%")
                    ->orWhere('code', 'like', "%{$kw}%");
            });
        }

        if ($minPrice !== null) {
            $query->where('new_price', '>=', (int) $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('new_price', '<=', (int) $maxPrice);
        }

        return $query
            ->orderBy('new_price', 'asc')
            ->limit(max(1, (int) $limit))
            ->get([
                'id',
                'name',
                'code',
                'new_price',
                'slug',
                'size',
                'field_type',
                'amount',
                'cat_id',
                'desc_quick',
                'thumb_main',
                'updated_at',
            ]);
    }

    private function extractCodeBill(string $question): ?string
    {
        if (preg_match('/\b(bill-\d+)\b/i', $question, $m)) {
            return strtolower($m[1]);
        }
        return null;
    }

    private function progressText(int $progress): string
    {
        return match ($progress) {
            0 => 'Chờ xác nhận',
            4 => 'Đã xác nhận',
            1 => 'Đang giao',
            2 => 'Giao hàng thành công',
            3 => 'Đã hủy',
            default => 'Không xác định',
        };
    }

    private function isProductQuestion(string $q): bool
    {
        $q = mb_strtolower($q, 'UTF-8');
        $keywords = [
            'giày', 'giay', 'sneaker', 'nike', 'adidas', 'puma', 'vans', 'converse', 'mizuno', 'kamito',
            'mẫu', 'size', 'cỡ', 'giá', 'triệu', 'k', 'sản phẩm', 'sp', 'xem hàng',
            'tf', 'fg', 'ag', 'ic', 'cỏ nhân tạo', 'sân cỏ', 'futsal', 'trong nhà',
            'tư vấn', 'chọn giày', 'mua giày', 'đá bóng', 'đá banh'
        ];
        foreach ($keywords as $k) {
            if (mb_strpos($q, $k) !== false)
                return true;
        }
        return false;
    }

    private function extractSearchCriteria(string $question): array
    {
        $q = mb_strtolower($question, 'UTF-8');
        
        $criteria = [
            'brand' => null,
            'size' => null,
            'field_type' => null,
            'keyword' => ''
        ];

        // 1. Extract brand
        $brands = ['nike', 'adidas', 'puma', 'vans', 'converse', 'reebok', 'new balance', 'mizuno', 'kamito', 'wika', 'zocker'];
        foreach ($brands as $brand) {
            if (mb_strpos($q, $brand) !== false) {
                $criteria['brand'] = $brand;
                $q = str_replace($brand, '', $q);
                break;
            }
        }

        // 2. Extract size
        if (preg_match('/size\s*(\d{2}(\.\d)?)/', $q, $m)) {
            $criteria['size'] = $m[1];
            $q = str_replace($m[0], '', $q);
        }

        // 3. Extract field_type (TF, FG, AG, IC, cỏ nhân tạo, tự nhiên, futsal)
        $fieldTypes = [
            'tf' => ['tf', 'cỏ nhân tạo', 'co nhan tao'],
            'fg' => ['fg', 'cỏ tự nhiên', 'co tu nhien'],
            'ag' => ['ag'],
            'ic' => ['ic', 'futsal', 'trong nhà', 'trong nha']
        ];
        foreach ($fieldTypes as $dbType => $aliases) {
            foreach ($aliases as $alias) {
                if (mb_strpos($q, $alias) !== false) {
                    $criteria['field_type'] = $dbType;
                    $q = str_replace($alias, '', $q);
                    break 2;
                }
            }
        }

        // 4. Extract keyword (cleanup remaining text)
        $removePhrases = [
            'cho tôi xem', 'xem giúp', 'xem vài mẫu', 'vài mẫu', 'cho tôi', 'giúp tôi',
            'mình muốn', 'tôi muốn', 'mình cần', 'tôi cần', 'mua', 'bán', 'tìm', 'xem',
            'với', 'nhé', 'ạ', 'tư vấn', 'gợi ý', 'giới thiệu', 'có', 'của', 'giày', 'giay'
        ];
        foreach ($removePhrases as $p) {
            $q = str_replace($p, '', $q);
        }

        $criteria['keyword'] = trim(preg_replace('/\s+/', ' ', $q));
        
        return $criteria;
    }

    private function parseVndAmount(string $raw): ?int
    {
        $raw = mb_strtolower(trim($raw), 'UTF-8');
        $raw = str_replace(['vnd', 'đ', 'vnđ', ' '], '', $raw);

        if (preg_match('/^([\d]+([\,\.]\d+)?)\s*(tr|trieu|triệu|t)$/u', $raw, $m)) {
            return (int) round((float) str_replace(',', '.', $m[1]) * 1_000_000);
        }

        if (preg_match('/^([\d]+([\,\.]\d+)?)\s*(k)$/u', $raw, $m)) {
            return (int) round((float) str_replace(',', '.', $m[1]) * 1_000);
        }

        $digits = preg_replace('/[^\d]/u', '', $raw);
        if ($digits !== '' && ctype_digit($digits))
            return (int) $digits;

        return null;
    }

    private function extractFirstAmount(string $text): ?int
    {
        $text = mb_strtolower($text, 'UTF-8');

        if (preg_match('/(\d+(?:[\,\.]\d+)?)\s*(triệu|trieu|tr|t|k)\b/u', $text, $m)) {
            return $this->parseVndAmount($m[1] . $m[2]);
        }

        if (preg_match('/\b(\d[\d\.\,]{4,})\b/u', $text, $m)) {
            return $this->parseVndAmount($m[1]);
        }

        return null;
    }

    private function extractPriceFilter(string $q): array
    {
        $qLower = mb_strtolower($q, 'UTF-8');
        $min = null;
        $max = null;

        if (preg_match('/từ\s+(.+?)\s*(đến|\-)\s*(.+)/u', $qLower, $m)) {
            $a = $this->extractFirstAmount($m[1]);
            $b = $this->extractFirstAmount($m[3]);
            if ($a !== null && $b !== null) {
                return ['min' => min($a, $b), 'max' => max($a, $b)];
            }
        }

        if (preg_match('/\b(trên|hơn|>=)\s*(.+)$/u', $qLower, $m)) {
            $v = $this->extractFirstAmount($m[2]);
            if ($v !== null)
                $min = $v;
        }

        if (preg_match('/\b(dưới|nhỏ hơn|<=)\s*(.+)$/u', $qLower, $m)) {
            $v = $this->extractFirstAmount($m[2]);
            if ($v !== null)
                $max = $v;
        }

        if ($min === null && $max === null && preg_match('/\bkhoảng\s*(.+)$/u', $qLower, $m)) {
            $v = $this->extractFirstAmount($m[1]);
            if ($v !== null) {
                $min = (int) round($v * 0.9);
                $max = (int) round($v * 1.1);
            }
        }

        return ['min' => $min, 'max' => $max];
    }

    private function buildDatabaseInspectionContext(string $question): string
    {
        $q = mb_strtolower(trim($question), 'UTF-8');
        $context = [];

        // Check if question asks about order statistics, sales, or revenue
        if (
            mb_strpos($q, 'đơn hàng') !== false ||
            mb_strpos($q, 'hóa đơn') !== false ||
            mb_strpos($q, 'doanh thu') !== false ||
            mb_strpos($q, 'bán hàng') !== false ||
            mb_strpos($q, 'thống kê') !== false ||
            mb_strpos($q, 'báo cáo') !== false
        ) {
            $totalOrders = Order::count();
            $confirmCount = Order::where('progress', 0)->count();
            $acceptedCount = Order::where('progress', 4)->count();
            $shippingCount = Order::where('progress', 1)->count();
            $successCount = Order::where('progress', 2)->count();
            $cancelCount = Order::where('progress', 3)->count();
            $revenue = Order::where('progress', 2)->sum('total');

            $context[] = "DATABASE_ORDER_STATS:\n"
                . "- Tổng số đơn hàng trong hệ thống: {$totalOrders}\n"
                . "- Đơn hàng chờ xác nhận (progress=0): {$confirmCount}\n"
                . "- Đơn hàng đã xác nhận (progress=4): {$acceptedCount}\n"
                . "- Đơn hàng đang giao (progress=1): {$shippingCount}\n"
                . "- Đơn hàng thành công (progress=2): {$successCount}\n"
                . "- Đơn hàng đã hủy (progress=3): {$cancelCount}\n"
                . "- Tổng doanh thu thực tế (đơn thành công): " . number_format($revenue, 0, '', '.') . " VNĐ\n";

            // Fetch 5 most recent orders
            $recentOrders = Order::orderBy('id', 'desc')->limit(5)->get();
            if ($recentOrders->isNotEmpty()) {
                $orderLines = ["DANH SÁCH 5 ĐƠN HÀNG MỚI NHẤT:"];
                foreach ($recentOrders as $o) {
                    $status = match ((int) $o->progress) {
                        0 => 'Chờ xác nhận',
                        4 => 'Đã xác nhận',
                        1 => 'Đang giao',
                        2 => 'Thành công',
                        3 => 'Đã hủy',
                        default => 'Không rõ',
                    };
                    $orderLines[] = "  * Mã: {$o->code_bill} | Khách hàng: {$o->fullname} | Tổng tiền: " . number_format((int) $o->total, 0, '', '.') . "đ | Trạng thái: {$status}";
                }
                $context[] = implode("\n", $orderLines);
            }
        }

        // Check if question asks about products or inventory
        if (
            mb_strpos($q, 'sản phẩm') !== false ||
            mb_strpos($q, 'hàng hóa') !== false ||
            mb_strpos($q, 'kho hàng') !== false ||
            mb_strpos($q, 'tồn kho') !== false ||
            mb_strpos($q, 'danh mục') !== false
        ) {
            $totalProducts = Product::count();
            $featuredProducts = Product::where('featured_products', 1)->count();
            $outOfStock = Product::where('amount', '<=', 0)->count();

            $context[] = "DATABASE_PRODUCT_STATS:\n"
                . "- Tổng số sản phẩm đang có: {$totalProducts}\n"
                . "- Số sản phẩm nổi bật: {$featuredProducts}\n"
                . "- Số sản phẩm hết hàng: {$outOfStock}\n";

            // Fetch product categories count
            $catCount = \App\Models\Cat_product::count();
            $context[] = "- Tổng số danh mục sản phẩm: {$catCount}\n";

            // List categories
            $categories = \App\Models\Cat_product::limit(20)->get();
            if ($categories->isNotEmpty()) {
                $catLines = ["DANH SÁCH DANH MỤC GIÀY ĐÁ BÓNG:"];
                $catLines[] = "| STT | Tên danh mục | Đường dẫn (Slug) |";
                $catLines[] = "|:---:|:---|:---|";
                foreach ($categories as $index => $c) {
                    $stt = $index + 1;
                    $catLines[] = "| {$stt} | {$c->name} | {$c->slug} |";
                }
                $context[] = implode("\n", $catLines);
            }

            // List top 5 bestselling products
            $bestSellers = Product::orderBy('purchases', 'desc')->limit(5)->get();
            if ($bestSellers->isNotEmpty()) {
                $bestLines = ["TOP 5 SẢN PHẨM BÁN CHẠY NHẤT:"];
                foreach ($bestSellers as $p) {
                    $productUrl = url('san-pham/' . ($p->slug ?: $p->id));
                    $bestLines[] = "  * {$p->name} | Số lượt mua: {$p->purchases} | Giá: " . number_format((int) $p->new_price, 0, '', '.') . "đ | url: {$productUrl}";
                }
                $context[] = implode("\n", $bestLines);
            }
        }

        // Check if question asks about users or customers
        if (
            mb_strpos($q, 'khách hàng') !== false ||
            mb_strpos($q, 'thành viên') !== false ||
            mb_strpos($q, 'người dùng') !== false ||
            mb_strpos($q, 'tài khoản') !== false ||
            mb_strpos($q, 'user') !== false
        ) {
            $totalUsers = \App\Models\User::count();
            $adminCount = \App\Models\User::where('isAdmin', 1)->count();
            $customerCount = \App\Models\User::where('isAdmin', 0)->count();

            $context[] = "DATABASE_USER_STATS:\n"
                . "- Tổng số tài khoản đăng ký: {$totalUsers}\n"
                . "- Tài khoản quản trị viên (Admin): {$adminCount}\n"
                . "- Tài khoản khách hàng: {$customerCount}\n";

            // List 5 most recently registered users
            $recentUsers = \App\Models\User::orderBy('id', 'desc')->limit(5)->get();
            if ($recentUsers->isNotEmpty()) {
                $userLines = ["DANH SÁCH 5 THÀNH VIÊN MỚI ĐĂNG KÝ:"];
                $userLines[] = "| STT | Họ tên | Email | Điểm | Vai trò |";
                $userLines[] = "|:---:|:---|:---|:---:|:---|";
                foreach ($recentUsers as $index => $u) {
                    $stt = $index + 1;
                    $role = $u->isAdmin == 1 ? 'Admin' : 'Khách hàng';
                    $userLines[] = "| {$stt} | {$u->name} | {$u->email} | {$u->points} | {$role} |";
                }
                $context[] = implode("\n", $userLines);
            }
        }

        return implode("\n\n", $context);
    }
}