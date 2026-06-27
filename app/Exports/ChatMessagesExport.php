<?php

namespace App\Exports;

use App\Models\ChatMessage;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ChatMessagesExport implements FromCollection, WithHeadings
{
    protected $conversationId;
    private $headings = null;
    private $rows = null;

    public function __construct($conversationId)
    {
        $this->conversationId = $conversationId;
        $this->parse();
    }

    private function parse()
    {
        // Ưu tiên xuất danh sách sản phẩm trực tiếp từ DB theo yêu cầu mới nhất trong hội thoại.
        $productRows = $this->buildProductRowsFromConversation();
        if (count($productRows) > 0) {
            $this->headings = [
                'ID',
                'Mã sản phẩm',
                'Tên sản phẩm',
                'Danh mục',
                'Giá bán (VNĐ)',
                'Tồn kho',
                'Loại sân',
                'Size',
                'Đường dẫn sản phẩm',
                'Cập nhật lúc',
            ];
            $this->rows = $productRows;
            return;
        }

        // Find the last bot message in the session that contains a table
        $lastBotMessage = ChatMessage::where('session_id', $this->conversationId)
            ->where('sender', 'bot')
            ->orderBy('id', 'desc')
            ->get()
            ->first(function ($msg) {
                // Improved regex to detect Markdown table: | something | something |
                return preg_match('/\|.*\|.*\|/', $msg->content) && preg_match('/\|[ ]*:?-+:?[ ]*\|/', $msg->content);
            });

        if (!$lastBotMessage) {
            $this->headings = ['Người gửi', 'Nội dung', 'Thời gian'];
            $this->rows = ChatMessage::where('session_id', $this->conversationId)
                ->orderBy('id', 'asc')
                ->get()
                ->map(function ($msg) {
                    return [
                        $msg->sender === 'user' ? 'Khách hàng' : 'Trợ lý AI',
                        strip_tags($msg->content),
                        optional($msg->created_at)->format('d/m/Y H:i:s')
                    ];
                })
                ->toArray();
            return;
        }

        // Parse markdown table
        $lines = explode("\n", $lastBotMessage->content);
        $tempRows = [];
        
        foreach ($lines as $line) {
            $line = trim($line);
            
            // A table line must start and end with | or at least have | inside
            if (!str_starts_with($line, '|') && !str_ends_with($line, '|') && strpos($line, '|') === false) continue;
            
            // Skip separator line like |---|---| or | :--- | :--- |
            if (preg_match('/^[|:\-\s]+$/', $line)) {
                continue;
            }

            // Split line by '|'
            $cells = explode('|', $line);
            
            // Clean up empty first/last elements caused by leading/trailing pipes
            if (count($cells) >= 2) {
                if (trim($cells[0]) === '') {
                    array_shift($cells);
                }
                if (count($cells) > 0 && trim($cells[count($cells) - 1]) === '') {
                    array_pop($cells);
                }
            }

            // If it's just a separator line without alphanumeric characters, skip it
            $lineContent = implode('', $cells);
            if (!preg_match('/[a-zA-Z0-9]/', $lineContent)) {
                continue;
            }

            $cleanCells = [];
            foreach ($cells as $cell) {
                $cellVal = trim($cell);
                // 1. Clean markdown links: [Text](URL) -> Text
                $cellVal = preg_replace('/\[([^\]]+)\]\([^\)]+\)/', '$1', $cellVal);
                // 2. Clean HTML tags: <a ...>Text</a> -> Text
                $cellVal = strip_tags($cellVal);
                $cleanCells[] = $cellVal;
            }

            if (count($cleanCells) > 0) {
                $tempRows[] = $cleanCells;
            }
        }

        if (count($tempRows) >= 2) { // Need at least header and one data row
            $this->headings = array_shift($tempRows);
            $this->rows = $tempRows;
        } else {
            // Fallback to conversation history if no valid table found
            $this->headings = ['Người gửi', 'Nội dung', 'Thời gian'];
            $this->rows = ChatMessage::where('session_id', $this->conversationId)
                ->orderBy('id', 'asc')
                ->get()
                ->map(function ($msg) {
                    return [
                        $msg->sender === 'user' ? 'Khách hàng' : 'Trợ lý AI',
                        strip_tags($msg->content),
                        optional($msg->created_at)->format('d/m/Y H:i:s')
                    ];
                })
                ->toArray();
        }
    }

    public function collection()
    {
        return collect($this->rows);
    }

    public function headings(): array
    { 
        return $this->headings;
    }

    private function buildProductRowsFromConversation(): array
    {
        $question = $this->getLastRelevantQuestion();
        if ($question === null) {
            return [];
        }

        $filters = $this->extractProductFilters($question);

        $query = Product::query()->with('Cat_product:id,name');

        if ($filters['keyword'] !== '') {
            $kw = $filters['keyword'];
            $query->where(function ($q) use ($kw) {
                $q->where('name', 'like', "%{$kw}%")
                    ->orWhere('slug', 'like', "%{$kw}%")
                    ->orWhere('code', 'like', "%{$kw}%");
            });
        }

        if ($filters['min'] !== null) {
            $query->where('new_price', '>=', (int) $filters['min']);
        }

        if ($filters['max'] !== null) {
            $query->where('new_price', '<=', (int) $filters['max']);
        }

        $limit = $filters['isExportRequest'] && $filters['keyword'] === '' && $filters['min'] === null && $filters['max'] === null
            ? 1000
            : 200;

        $products = $query
            ->orderBy('updated_at', 'desc')
            ->limit($limit)
            ->get([
                'id',
                'code',
                'name',
                'cat_id',
                'new_price',
                'amount',
                'field_type',
                'size',
                'slug',
                'updated_at',
            ]);

        if ($products->isEmpty()) {
            return [];
        }

        return $products->map(function ($product) {
            $url = url('san-pham/' . ($product->slug ?: $product->id));
            return [
                (int) $product->id,
                (string) ($product->code ?? ''),
                (string) ($product->name ?? ''),
                (string) (optional($product->Cat_product)->name ?? ''),
                (int) ($product->new_price ?? 0),
                (int) ($product->amount ?? 0),
                (string) ($product->field_type ?? ''),
                (string) ($product->size ?? ''),
                $url,
                optional($product->updated_at)->format('d/m/Y H:i:s'),
            ];
        })->toArray();
    }

    private function getLastRelevantQuestion(): ?string
    {
        $messages = ChatMessage::where('session_id', $this->conversationId)
            ->where('sender', 'user')
            ->orderBy('id', 'desc')
            ->get(['content']);

        foreach ($messages as $msg) {
            $content = trim((string) $msg->content);
            if ($content === '') {
                continue;
            }

            if ($this->isExportRequest($content) || $this->isProductQuestion($content)) {
                return $content;
            }
        }

        return null;
    }

    private function extractProductFilters(string $question): array
    {
        $keyword = trim((string) $this->extractProductKeyword($question));
        $price = $this->extractPriceFilter($question);

        return [
            'keyword' => $keyword,
            'min' => $price['min'] ?? null,
            'max' => $price['max'] ?? null,
            'isExportRequest' => $this->isExportRequest($question),
        ];
    }

    private function isExportRequest(string $q): bool
    {
        $q = mb_strtolower($q, 'UTF-8');
        $keywords = ['excel', 'xlsx', 'xuất file', 'xuất excel', 'export', 'tải file', 'download'];
        foreach ($keywords as $k) {
            if (mb_strpos($q, $k) !== false) {
                return true;
            }
        }
        return false;
    }

    private function isProductQuestion(string $q): bool
    {
        $q = mb_strtolower($q, 'UTF-8');
        $keywords = ['giày', 'giay', 'sneaker', 'nike', 'adidas', 'puma', 'vans', 'converse', 'mẫu', 'size', 'cỡ', 'giá', 'triệu', 'k', 'sản phẩm', 'sp', 'xem hàng'];
        foreach ($keywords as $k) {
            if (mb_strpos($q, $k) !== false) {
                return true;
            }
        }
        return false;
    }

    private function extractProductKeyword(string $q): string
    {
        $q = mb_strtolower($q, 'UTF-8');

        $removePhrases = ['cho tôi xem', 'xem giúp', 'xem vài mẫu', 'vài mẫu', 'cho tôi', 'giúp tôi', 'mình muốn', 'tôi muốn', 'mình cần', 'tôi cần', 'mua', 'bán', 'tìm', 'xem', 'với', 'nhé', 'ạ', 'xuất excel', 'xuất file', 'export'];
        foreach ($removePhrases as $p) {
            $q = str_replace($p, '', $q);
        }

        $brands = ['nike', 'adidas', 'puma', 'vans', 'converse', 'reebok', 'new balance'];
        foreach ($brands as $brand) {
            if (mb_strpos($q, $brand) !== false) {
                return $brand;
            }
        }

        if (preg_match('/giày\s+([a-z0-9\s]+)/u', $q, $m)) {
            return trim($m[1]);
        }

        return trim($q);
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
        if ($digits !== '' && ctype_digit($digits)) {
            return (int) $digits;
        }

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
            if ($v !== null) {
                $min = $v;
            }
        }

        if (preg_match('/\b(dưới|nhỏ hơn|<=)\s*(.+)$/u', $qLower, $m)) {
            $v = $this->extractFirstAmount($m[2]);
            if ($v !== null) {
                $max = $v;
            }
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
}
