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
                @include('inc.sbBlog')
            </div>
            <div class="col-md-9">
                <div id="wp-blog">
                    <ul>
                        @foreach ($posts as $post)
                        <li class="item d-xl-flex">
                            <div class="col-12 col-xl-4">
                                <div class="thumb-blog me-3">
                                    <a href="{{ route('client.blog.detail', $post->slug) }}"><img
                                            src="{{ asset($post->thumb_main) }}" alt="err"></a>
                                </div>
                            </div>
                            <div class="col-12 col-xl-8">
                                <div class="wp-content-blog">
                                    <div class="title"><a href="{{ route('client.blog.detail', $post->slug) }}">{{
                                            $post->name }}</a>
                                    </div>
                                    <div class="atTime">
                                        <span><i class="far fa-clock"></i></span>
                                        <span>{{ $post->created_at->format('d/m/Y | H:i') }}</span>
                                    </div>
                                    <div class="atTime bg-success text-white d-inline-block rounded p-1 my-1">
                                        <span><i class="fas fa-book"></i></span>
                                        <span>{{ $post->Cat_blog->name }}</span>
                                    </div>
                                    <div class="content-demo">
                                        <a href="{{ route('client.blog.detail', $post->slug) }}">
                                            {{ Str::limit($post->content_demo, $limit = 250, $end = '...') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection