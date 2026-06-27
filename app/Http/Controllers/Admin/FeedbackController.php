<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'feedback']);
            return $next($request);
        });
    }

    function list(Request $request)
    {
        if ($request->input('status') == 'active' && $request->input('status') != '' || $request->input('status') == '') {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $feedbacks = Feedback::whereHas('User', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            })->with('User')->orderBy('id', 'desc')->paginate(10);
            $list_act = [
                'delete' => 'Xóa'
            ];
            $url_delete = 'admin/feedback/delete/';
            $status = 'active';
        } else {
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $feedbacks = Feedback::onlyTrashed()->whereHas('User', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            })->with('User')->orderBy('id', 'desc')->paginate(10);
            $list_act = [
                'restore' => 'Khôi phục',
                'forceDelete' => 'Xóa vĩnh viễn'
            ];
            $url_delete = 'admin/feedback/forcedelete/';
            $status = 'trash';
        }
        
        $numActive = Feedback::count();
        $numTrash = Feedback::onlyTrashed()->count();
        $averageStar = number_format(Feedback::avg('star'), 1);
        $starCounts = Feedback::select('star', DB::raw('count(*) as count'))
            ->groupBy('star')
            ->pluck('count', 'star')
            ->toArray();
        
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($starCounts[$i])) {
                $starCounts[$i] = 0;
            }
        }
        krsort($starCounts);

        return view('admin.feedback.list', compact(
            'feedbacks', 'keyword', 'numActive', 'numTrash', 'list_act', 
            'url_delete', 'status', 'averageStar', 'starCounts'
        ));
    }

    public function show($id)
    {
        $feedback = Feedback::withTrashed()->with('User')->findOrFail($id);

        return response()->json([
            'id' => $feedback->id,
            'user_name' => $feedback->User ? $feedback->User->name : 'N/A',
            'user_email' => $feedback->User ? $feedback->User->email : 'N/A',
            'user_phone' => $feedback->User ? ($feedback->User->phone ?? 'N/A') : 'N/A',
            'star' => $feedback->star,
            'content' => $feedback->content ?: 'Không có nội dung',
            'created_at' => $feedback->created_at->format('d/m/Y H:i:s'),
            'updated_at' => $feedback->updated_at->format('d/m/Y H:i:s'),
        ]);
    }

    public function delete($id)
    {
        Feedback::find($id)->delete();
        return redirect('admin/feedback/list')->with([
            'status' => 'Đã xóa đánh giá thành công!',
            'color' => 'alert-success'
        ]);
    }

    public function forceDelete($id)
    {
        Feedback::withTrashed()->find($id)->forceDelete();
        return redirect('admin/feedback/list')->with([
            'status' => 'Đã xóa vĩnh viễn đánh giá!',
            'color' => 'alert-success'
        ]);
    }

    public function restore($id)
    {
        Feedback::withTrashed()->find($id)->restore();
        return redirect('admin/feedback/list')->with([
            'status' => 'Đã khôi phục đánh giá!',
            'color' => 'alert-success'
        ]);
    }

    public function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            $act = $request->input('act');
            if ($act == 'delete') {
                Feedback::destroy($list_check);
                return redirect('admin/feedback/list')->with([
                    'status' => 'Đã xóa thành công!',
                    'color' => 'alert-danger'
                ]);
            } elseif ($act == 'restore') {
                Feedback::withTrashed()
                    ->whereIn('id', $list_check)
                    ->restore();
                return redirect('admin/feedback/list')->with([
                    'status' => 'Đã khôi phục thành công!',
                    'color' => 'alert-success'
                ]);
            } elseif ($act == 'forceDelete') {
                Feedback::withTrashed()
                    ->whereIn('id', $list_check)
                    ->forceDelete();
                return redirect('admin/feedback/list')->with([
                    'status' => 'Đã xóa vĩnh viễn!',
                    'color' => 'alert-danger'
                ]);
            }
        } else {
            return redirect('admin/feedback/list')->with([
                'status' => 'Bạn cần chọn phần tử trước khi thực thi!',
                'color' => 'alert-danger'
            ]);
        }
    }

    public function export(Request $request)
    {
        $keyword = $request->input('keyword', '');
        
        $feedbacks = Feedback::with('User')
            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('User', function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', "%{$keyword}%");
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(12);

        $section = $phpWord->addSection();
        
        $section->addText('BÁO CÁO ĐÁNH GIÁ PHẢN HỒI KHÁCH HÀNG', [
            'bold' => true,
            'size' => 16,
            'align' => 'center'
        ]);
        $section->addText('Ngày xuất: ' . date('d/m/Y H:i:s'), [
            'size' => 11,
            'align' => 'center'
        ]);
        $section->addText('Tổng số đánh giá: ' . $feedbacks->count(), [
            'size' => 11,
            'align' => 'center'
        ]);
        $section->addText('');

        $tableStyle = [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 80,
        ];
        
        $cellStyle = ['bgColor' => 'E0E0E0'];
        $header = $section->addTable()->addRow()->addCell()->addTable();
        $table = $section->addTable();

        $table->addRow()->addCell('STT', $cellStyle);
        $table->addRow()->addCell('Khách hàng', $cellStyle);
        $table->addRow()->addCell('Email', $cellStyle);
        $table->addRow()->addCell('Số sao', $cellStyle);
        $table->addRow()->addCell('Nội dung', $cellStyle);
        $table->addRow()->addCell('Ngày đánh giá', $cellStyle);

        $stt = 1;
        foreach ($feedbacks as $feedback) {
            $table->addRow()->addCell($stt++);
            $table->addRow()->addCell($feedback->User ? $feedback->User->name : 'N/A');
            $table->addRow()->addCell($feedback->User ? $feedback->User->email : 'N/A');
            $table->addRow()->addCell($feedback->star . ' / 5');
            $table->addRow()->addCell($feedback->content ?: 'Không có nội dung');
            $table->addRow()->addCell($feedback->created_at->format('d/m/Y H:i'));
        }

        $fileName = 'danh_gia_khach_hang_' . date('Ymd_His') . '.docx';
        $objectWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objectWriter->save(storage_path('app/export/' . $fileName));

        return response()->download(storage_path('app/export/' . $fileName))->deleteFileAfterSend(true);
    }
}
