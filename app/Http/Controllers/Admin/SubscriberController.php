<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromotionSubscriber;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Throwable;

class SubscriberController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'subscriber']);
            return $next($request);
        });
    }

    function list(Request $request)
    {
        $this->ensureSupportSchema();

        $keyword = "";
        $hasRequestTypeColumn = Schema::hasColumn('promotion_subscribers', 'request_type');
        $hasSupportContentColumn = Schema::hasColumn('promotion_subscribers', 'support_content');
        $hasStatusColumn = $this->ensureStatusColumn();
        if ($request->input('keyword')) {
            $keyword = $request->input('keyword');
        }
        
        $subscribers = PromotionSubscriber::where('is_active', 1)
            ->where(function($query) use ($keyword, $hasRequestTypeColumn, $hasSupportContentColumn, $hasStatusColumn) {
                $query->where('name', 'LIKE', "%{$keyword}%")
                      ->orWhere('email', 'LIKE', "%{$keyword}%")
                      ->orWhere('phone', 'LIKE', "%{$keyword}%");

                if ($hasRequestTypeColumn) {
                    $query->orWhere('request_type', 'LIKE', "%{$keyword}%");
                }

                if ($hasSupportContentColumn) {
                    $query->orWhere('support_content', 'LIKE', "%{$keyword}%");
                }

                if ($hasStatusColumn) {
                    $query->orWhere('status', 'LIKE', "%{$keyword}%");
                }
            })
            ->orderBy('id', 'desc')
            ->paginate(20);

        $emails = $subscribers->getCollection()
            ->pluck('email')
            ->filter()
            ->unique()
            ->values();

        $userByEmail = collect();
        if ($emails->isNotEmpty() && Schema::hasColumn('users', 'email')) {
            $userByEmail = User::whereIn('email', $emails->all())
                ->get()
                ->keyBy(function ($user) {
                    return mb_strtolower((string) $user->email);
                });
        }

        $subscribers->getCollection()->transform(function ($subscriber) use ($userByEmail) {
            $matchedUser = null;

            if (!empty($subscriber->user)) {
                $matchedUser = $subscriber->user;
            } elseif (!empty($subscriber->email)) {
                $matchedUser = $userByEmail->get(mb_strtolower((string) $subscriber->email));
            }

            $subscriber->matched_user = $matchedUser;
            return $subscriber;
        });

        $totalSubscribers = PromotionSubscriber::where('is_active', 1)->count();

        return view('admin.subscriber.list', compact('subscribers', 'keyword', 'totalSubscribers', 'hasStatusColumn', 'hasRequestTypeColumn', 'hasSupportContentColumn'));
    }

    public function delete($id)
    {
        PromotionSubscriber::findOrFail($id)->update(['is_active' => 0]);
        return redirect('admin/subscriber/list')->with([
            'status' => 'Đã xóa yêu cầu hỗ trợ thành công!',
            'color' => 'alert-success'
        ]);
    }

    public function detail($id)
    {
        $this->ensureSupportSchema();

        $subscriber = PromotionSubscriber::where('is_active', 1)
            ->with('user')
            ->findOrFail($id);

        $matchedUser = null;
        if (!empty($subscriber->user)) {
            $matchedUser = $subscriber->user;
        } elseif (!empty($subscriber->email) && Schema::hasColumn('users', 'email')) {
            $matchedUser = User::where('email', $subscriber->email)->first();
        }

        $hasStatusColumn = $this->ensureStatusColumn();
        return view('admin.subscriber.detail', compact('subscriber', 'hasStatusColumn', 'matchedUser'));
    }

    public function updateStatus(Request $request, $id)
    {
        $this->ensureSupportSchema();

        if (!$this->ensureStatusColumn()) {
            return redirect('admin/subscriber/list')->with([
                'status' => 'Cột trạng thái chưa tồn tại. Vui lòng chạy migration mới nhất.',
                'color' => 'alert-warning'
            ]);
        }

        $request->validate([
            'status' => ['required', 'in:new,processing,resolved'],
        ], [
            'status.required' => 'Vui lòng chọn trạng thái!',
            'status.in' => 'Trạng thái không hợp lệ!',
        ]);

        $subscriber = PromotionSubscriber::findOrFail($id);
        $subscriber->status = $request->status;
        $subscriber->save();

        return redirect('admin/subscriber/list')->with([
            'status' => 'Cập nhật trạng thái thành công!',
            'color' => 'alert-success'
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
            });
        } catch (Throwable $e) {
            report($e);
        }
    }

    private function ensureStatusColumn(): bool
    {
        if (!Schema::hasTable('promotion_subscribers')) {
            return false;
        }

        if (Schema::hasColumn('promotion_subscribers', 'status')) {
            return true;
        }

        try {
            $hasSupportContentColumn = Schema::hasColumn('promotion_subscribers', 'support_content');
            Schema::table('promotion_subscribers', function (Blueprint $table) use ($hasSupportContentColumn) {
                if ($hasSupportContentColumn) {
                    $table->string('status', 20)->default('new')->after('support_content');
                } else {
                    $table->string('status', 20)->default('new');
                }
            });
        } catch (Throwable $e) {
            report($e);
            return false;
        }

        return Schema::hasColumn('promotion_subscribers', 'status');
    }
}
