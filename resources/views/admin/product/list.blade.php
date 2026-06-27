@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách sản phẩm</h5>
            <div class="form-search form-inline">
                <form action="{{route('product.view')}}" method="GET" class="d-flex flex-wrap" style="gap: 5px;">
                    <select name="cat_id" class="form-control" style="max-width: 200px;">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach ($categoryOptions as $categoryOption)
                            <option value="{{ $categoryOption['id'] }}" {{ $cat_id == $categoryOption['id'] ? 'selected' : '' }}>
                                {{ str_repeat('— ', $categoryOption['lever']) . $categoryOption['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <input type="text" name="key" class="form-control form-search" value="{{ request()->input('key') }}" placeholder="Nhập vào tên sản phẩm">
                    <input type="submit" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="{{request()->fullUrlWithQuery(['status'=>'active'])}}" class="text-primary">Đang kích hoạt<span
                        class="text-muted">({{$numUsersActive}})</span></a>
                <a href="{{request()->fullUrlWithQuery(['status'=>'trash'])}}" class="text-primary">Đã vô hiệu hóa<span
                        class="text-muted">({{$numSoftDelete}})</span></a>
            </div>
            <form action="{{route('product.action')}}" method="POST">
                @csrf
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" id="" name="act">
                        <option>Chọn</option>
                        @foreach($list_act as $k => $v)
                        <option value="{{$k}}">{{$v}}</option>
                        @endforeach
                    </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th class="text-center" scope="col">#</th>
                            <th class="text-center" scope="col">Ảnh</th>
                            <th class="text-center" scope="col">Tên sản phẩm</th>
                            <th class="text-center" scope="col">Giá</th>
                            <th class="text-center" scope="col">Tồn kho</th>
                            <th class="text-center" scope="col">Danh mục</th>
                            <th class="text-center" scope="col">Người tạo</th>
                            <th class="text-center" scope="col">Trạng thái</th>
                            <th class="text-center" scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $i = 0;
                        @endphp
                        @foreach ($products as $product)
                        <tr class="">
                            <td>
                                <input type="checkbox" name="list_check[]" value="{{$product -> id}}">
                            </td>
                            <td>{{++$i}}</td>
                            <td><img src="{{asset($product->thumb_main)}}" alt="" width="80" height="80"></td>
                            <td><a href="{{route('product.edit',$product->id)}}"><b>{{Str::limit($product->name,
                                        $limit = 30, $end =
                                        '...')}}</b></></a></td>
                            <td class="text-danger">{{number_format($product->new_price, 0, '.','.').'đ'}}</>
                            </td>
                            <td class="text-center">{{ $product->amount }}</td>
                            <td class="text-center">{{ optional($product->cat_product)->name ?? '—' }}</>
                            </td>
                            <td class="text-center"><small><b>{{ optional($product->users)->name ?? '—' }}</b></small>
                                <br>
                                <p class="bg-secondary text-white rounded px-1 text-center d-inline-block mb-0">
                                    {{ isset($product->users->roles[0]['name']) ? $product->users->roles[0]['name'] : '—' }}</p>
                            </td>
                            <td>{!!$product->status == 0?'<span class="badge badge-warning">Chờ duyệt</span>':'<span
                                    class="badge badge-success">Công khai</span>'!!}</td>
                            <td>
                                <a href="{{url($url_btn_success.$product->id)}}"
                                    class="btn btn-success btn-sm rounded text-white" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                        class="fa fa-edit"></i></a>
                                <a href="{{url($url_delete.$product->id)}}"
                                    class="btn btn-danger btn-sm rounded text-white" type="button" data-toggle="tooltip"
                                    data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $products->links() }}
            </form>
        </div>
    </div>
</div>
@endsection