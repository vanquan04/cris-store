@extends('layouts.client')
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v17.0"
    nonce="67vbHzoI"></script>

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
                @include('inc.sbBlog')
            </div>
            <div class="col-md-9">
                <div id="wp-detail-blog">
                    <div class="title">{{ $post->name }}</div>
                    <div class="d-flex">
                        <div class="atTime me-4 col-12 my-2">
                            <span><i class="far fa-clock"></i></span>
                            <span>{{ $post->created_at->format('d/m/Y | H:i') }}</span>
                        </div>
                        <div class="atTime me-4 col-12 my-2">
                            <span><i class="fas fa-user-edit"></i></span>
                            <span>{{ $post->Users ? $post->Users->name : 'Admin' }}</span>
                        </div>
                        <div class="category col-12 my-2">
                            <span>
                                <i class="fas fa-book"></i>
                            </span>
                            <span>{{ $post->Cat_blog->name }}</span>
                        </div>
                    </div>
                    <audio id="audio" controls class="w-100 form-control my-3">
                        <source src="{{ asset('blogAudio/Nho-em-nhieu-hon-Hoa-tau.mp3') }}" type="audio/mpeg">
                    </audio>
                    <style>
                        .content img {
                            width: 100%;
                            height: auto;
                        }

                        .content {
                            line-height: 30px
                        }
                    </style>
                    <div class="content">
                        {!! $post->content !!}
                    </div>
                    <div class="btn-society my-5">
                        <div class="btn-like d-block">
                            <div class="fb-like" data-href="http://quan.unitopcv.com/project/TQStore/" data-width="1000"
                                data-layout="" data-action="" data-size="" data-share="true"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection