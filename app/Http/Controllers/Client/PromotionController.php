<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PromotionSubscriber;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Throwable;
use App\Jobs\SendRawEmailJob;

class PromotionController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['client_module_active' => 'support']);
            return $next($request);
        });
    }

    function index()
    {
        $this->ensureSupportSchema();

        $mySupportRequests = collect();
        $hasUserIdColumn = Schema::hasColumn('promotion_subscribers', 'user_id');
        $hasEmailColumn = Schema::hasColumn('promotion_subscribers', 'email');
        $hasPhoneColumn = Schema::hasColumn('promotion_subscribers', 'phone');
        $hasNameColumn = Schema::hasColumn('promotion_subscribers', 'name');

        if (Auth::check()) {
            $query = PromotionSubscriber::where('is_active', 1);
            $authEmail = trim((string) Auth::user()->email);
            $authPhone = trim((string) Auth::user()->phone);
            $authName = trim((string) Auth::user()->name);
            $hasIdentityFilter = false;

            if ($hasUserIdColumn) {
                $hasIdentityFilter = true;
                $query->where(function ($q) use ($authEmail, $authPhone, $hasEmailColumn, $hasPhoneColumn, $hasNameColumn, $authName) {
                    $q->where('user_id', Auth::id());

                    // Include older records created before user_id column existed.
                    if ($hasEmailColumn && $authEmail !== '') {
                        $q->orWhere('email', $authEmail);
                    }
                    if ($hasPhoneColumn && $authPhone !== '') {
                        $q->orWhere('phone', $authPhone);
                    }
                    if ($hasNameColumn && $authName !== '') {
                        $q->orWhere('name', $authName);
                    }
                });
            } else {
                // Fallback for environments that have not run latest migration yet.
                $hasIdentityFilter = ($hasEmailColumn && $authEmail !== '')
                    || ($hasPhoneColumn && $authPhone !== '')
                    || ($hasNameColumn && $authName !== '');

                if (!$hasIdentityFilter) {
                    $query->whereRaw('1 = 0');
                } else {
                    $query->where(function ($q) use ($authEmail, $authPhone, $authName, $hasEmailColumn, $hasPhoneColumn, $hasNameColumn) {
                        if ($hasEmailColumn && $authEmail !== '') {
                            $q->orWhere('email', $authEmail);
                        }
                        if ($hasPhoneColumn && $authPhone !== '') {
                            $q->orWhere('phone', $authPhone);
                        }
                        if ($hasNameColumn && $authName !== '') {
                            $q->orWhere('name', $authName);
                        }
                    });
                }
            }

            $mySupportRequests = $query->orderBy('id', 'desc')->get();

            // Final fallback: use session IDs captured at submit time.
            if ($mySupportRequests->isEmpty()) {
                $sessionIds = collect(session('my_support_request_ids', []))
                    ->filter(fn($id) => is_numeric($id))
                    ->map(fn($id) => (int)$id)
                    ->unique()
                    ->values();

                if ($sessionIds->isNotEmpty()) {
                    $mySupportRequests = PromotionSubscriber::where('is_active', 1)
                        ->whereIn('id', $sessionIds->all())
                        ->orderBy('id', 'desc')
                        ->get();
                }
            }
        }

        return view('client.pages.promotion', compact('mySupportRequests', 'hasUserIdColumn'));
    }

    function subscribe(Request $request)
    {
        $this->ensureSupportSchema();

        if (!Schema::hasTable('promotion_subscribers')) {
            return response()->json([
                'success' => false,
                'message' => 'Bảng dữ liệu hỗ trợ chưa được khởi tạo. Vui lòng liên hệ quản trị hệ thống.'
            ], 500);
        }

        $hasRequestTypeColumn = Schema::hasColumn('promotion_subscribers', 'request_type');
        $hasSupportContentColumn = Schema::hasColumn('promotion_subscribers', 'support_content');
        $availableColumns = Schema::getColumnListing('promotion_subscribers');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'regex:/^(0)[0-9]{9,10}$/'],
            'request_type' => ['required', 'in:return_exchange,complaint,support'],
            'support_content' => ['required', 'string', 'max:2000'],
        ], [
            'name.required' => 'Tên không được để trống!',
            'email.required' => 'Email không được để trống!',
            'email.email' => 'Email không hợp lệ!',
            'phone.regex' => 'Số điện thoại không hợp lệ!',
            'request_type.required' => 'Vui lòng chọn loại yêu cầu!',
            'request_type.in' => 'Loại yêu cầu không hợp lệ!',
            'support_content.required' => 'Vui lòng nhập nội dung cần hỗ trợ!',
            'support_content.max' => 'Nội dung hỗ trợ tối đa 2000 ký tự!',
        ]);

        $insertData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_active' => true,
        ];

        if ($hasRequestTypeColumn) {
            $insertData['request_type'] = $request->request_type;
        }

        if ($hasSupportContentColumn) {
            $insertData['support_content'] = $request->support_content;
        }

        if (Schema::hasColumn('promotion_subscribers', 'status')) {
            $insertData['status'] = 'new';
        }

        if (Schema::hasColumn('promotion_subscribers', 'user_id')) {
            $insertData['user_id'] = Auth::check() ? Auth::id() : null;
        }

        // Ensure we never attempt to insert fields that don't exist in current schema.
        $insertData = array_intersect_key($insertData, array_flip($availableColumns));

        try {
            $subscriber = PromotionSubscriber::create($insertData);
        } catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            $isDuplicateEmail = str_contains($errorMessage, 'promotion_subscribers.email')
                || str_contains($errorMessage, 'Duplicate entry');

            if ($isDuplicateEmail) {
                // Temporary compatibility path when old DB still has unique(email).
                $subscriber = PromotionSubscriber::where('email', $request->email)
                    ->orderBy('id', 'desc')
                    ->first();

                if (!$subscriber) {
                    report($e);
                    return response()->json([
                        'success' => false,
                        'message' => 'Không thể ghi nhận yêu cầu lúc này. Vui lòng thử lại sau.'
                    ], 500);
                }

                $updatableData = array_intersect_key([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'is_active' => true,
                    'request_type' => $request->request_type,
                    'support_content' => $request->support_content,
                    'status' => Schema::hasColumn('promotion_subscribers', 'status') ? 'new' : null,
                    'user_id' => Schema::hasColumn('promotion_subscribers', 'user_id') && Auth::check() ? Auth::id() : null,
                ], array_flip($availableColumns));

                foreach ($updatableData as $field => $value) {
                    if ($value !== null || $field === 'phone') {
                        $subscriber->{$field} = $value;
                    }
                }
                $subscriber->save();
            } else {
                report($e);

                return response()->json([
                    'success' => false,
                    'message' => app()->environment('local')
                        ? ('Lỗi ghi dữ liệu: ' . $e->getMessage())
                        : 'Không thể ghi nhận yêu cầu lúc này. Vui lòng thử lại sau.'
                ], 500);
            }
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => app()->environment('local')
                    ? ('Lỗi ghi dữ liệu: ' . $e->getMessage())
                    : 'Không thể ghi nhận yêu cầu lúc này. Vui lòng thử lại sau.'
            ], 500);
        }

        $requestTypeLabels = [
            'return_exchange' => 'Đổi trả',
            'complaint' => 'Khiếu nại',
            'support' => 'Cần hỗ trợ',
        ];

        $requestTypeText = $requestTypeLabels[$request->request_type] ?? 'Yêu cầu hỗ trợ';

        if ($request->email) {
            try {
                $content = "Xin chào {$request->name},\n\nCRIS Store đã nhận được yêu cầu hỗ trợ của bạn.\n\nLoại yêu cầu: {$requestTypeText}\nNội dung: {$request->support_content}\n\nĐội ngũ chăm sóc khách hàng sẽ phản hồi trong thời gian sớm nhất.\n\nTrân trọng,\nCRIS Store";
                SendRawEmailJob::dispatch($content, $request->email, $request->name, 'Đã tiếp nhận yêu cầu hỗ trợ - CRIS Store');
            } catch (Throwable $e) {
                report($e);
            }
        }

        $supportMailbox = config('mail.support_address');
        if (!empty($supportMailbox) && filter_var($supportMailbox, FILTER_VALIDATE_EMAIL)) {
            $internalBody = "Có yêu cầu hỗ trợ mới từ khách hàng.\n\n"
                . "Mã yêu cầu: #{$subscriber->id}\n"
                . "Họ tên: {$request->name}\n"
                . "Email: {$request->email}\n"
                . "SĐT: " . ($request->phone ?: 'N/A') . "\n"
                . "Loại yêu cầu: {$requestTypeText}\n"
                . "Nội dung: {$request->support_content}\n"
                . "User ID: " . (Auth::check() ? Auth::id() : 'Guest') . "\n";

            try {
                SendRawEmailJob::dispatch($internalBody, $supportMailbox, null, '[' . config('app.name') . '] Yêu cầu hỗ trợ mới #' . $subscriber->id);
            } catch (Throwable $e) {
                report($e);
            }
        }

        if (Auth::check()) {
            $ids = collect(session('my_support_request_ids', []))
                ->push($subscriber->id)
                ->filter(fn($id) => is_numeric($id))
                ->map(fn($id) => (int)$id)
                ->unique()
                ->take(-30)
                ->values()
                ->all();

            session(['my_support_request_ids' => $ids]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Yêu cầu hỗ trợ đã được ghi nhận thành công!'
        ]);
    }

    private function ensureSupportSchema(): void
    {
        if (!Schema::hasTable('promotion_subscribers')) {
            return;
        }

        try {
            Schema::table('promotion_subscribers', function (Blueprint $table) {
                if (!Schema::hasColumn('promotion_subscribers', 'request_type')) {
                    $table->string('request_type', 30)->default('support')->after('phone');
                }

                if (!Schema::hasColumn('promotion_subscribers', 'support_content')) {
                    $table->text('support_content')->nullable()->after('request_type');
                }

                if (!Schema::hasColumn('promotion_subscribers', 'status')) {
                    $table->string('status', 20)->default('new')->after('support_content');
                }

                if (!Schema::hasColumn('promotion_subscribers', 'user_id')) {
                    $table->unsignedBigInteger('user_id')->nullable()->after('status');
                }
            });
        } catch (Throwable $e) {
            report($e);
        }

        // Remove unique index on email so one email can create many support requests.
        try {
            if (Schema::hasColumn('promotion_subscribers', 'email')) {
                $indexes = DB::select("SHOW INDEX FROM promotion_subscribers WHERE Column_name = 'email' AND Non_unique = 0");

                foreach ($indexes as $index) {
                    $keyName = $index->Key_name ?? null;
                    if (!empty($keyName) && $keyName !== 'PRIMARY') {
                        DB::statement("ALTER TABLE promotion_subscribers DROP INDEX `{$keyName}`");
                    }
                }
            }
        } catch (Throwable $e) {
            report($e);
        }
    }
}
