@extends('layouts.client')
@section('content')
<section id="myContent">
    <div class="container">
        <div class="col-md-12">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="{{ route('home') }}" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Bài viết</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 sidebar d-none d-md-block">
                @include('inc.sbPage')
            </div>
            <div class="col-md-9">
                <style>
                    .content img {
                        width: 100%;
                        height: auto;
                    }

                    .content {
                        line-height: 30px
                    }
                </style>
                <div id="wp-detail-blog" class="rounded">
                    <div class="content">
                        <h2 class="fs-3 mb-2">{{$page->title}}</h2>
                        <div class="section-detail">
                            <div class="detail">
                                {!!$page->content!!}
                            </div>
                        </div>
                    </div>
                    <div class="btn-society my-5">
                        <div class="btn-like d-block">
                            <div class="fb-like" data-href="http://quy.unitopcv.com/project/TQStore/" data-width="1000"
                                data-share="true"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection