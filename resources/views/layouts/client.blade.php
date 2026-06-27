<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta property="og:image" content="{{asset('uploads/slider2.jpg')}}" />
    <meta property="og:title" content="CRIS STORE" />
    <meta property="og:url" content="https://quan.unitopcv.com/" />
    <meta property="og:type" content="product" />
    <meta property="og:description"
        content="Cris Store luôn cung cấp sản phẩm chính hãng có thông tin rõ ràng, chính sách ưu đãi cực lớn cho khách hàng có thẻ thành viên." />
    <title>Cris Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
        var BASE_URL = "{{ url('/') }}";
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400;1,500;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('client/style.css?v='.time()) }}">
    <link rel="icon" href="https://cdn.haitrieu.com/wp-content/uploads/2021/10/Logo-DH-Cong-Nghe-Dong-A-EAUT.png"
        type="image/gif" sizes="16x16">
    <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="{{ asset('client/owlcarousel/assets/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('client/owlcarousel/assets/owl.theme.default.css') }}">
    <link rel="stylesheet" href="{{ asset('client/owlcarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/owlcarousel/assets/owl.theme.default.min.css') }}">
    <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.css
    " rel="stylesheet" />
    <script src="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js
    "></script>
    <!-- Markdown rendering libs -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dompurify@3.0.6/dist/purify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/highlight.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/styles/github.min.css" media="(prefers-color-scheme: light), (prefers-color-scheme: no-query)" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/styles/github-dark.min.css" media="(prefers-color-scheme: dark)" />
</head>

<body>
    <div id="header" class="d-none d-sm-block">
        <section id="myTopHeader" class="py-1">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <p class="col">Cris Store - Cùng bạn bước đến muôn nơi</p>
                    <div class="col">
                        <div class="d-flex justify-content-end">
                            <div class="iconHoline me-3 text-danger"><i class="fas fa-phone"></i></div>
                            <p class="me-3">Hotline: 0325994526</p>
                            <a href="" class="me-2">Hệ thống cửa hàng |</a>
                            <a href="">Tuyển dụng</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="myMainHeader">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-white">
                            <div class="logo py-3">
                                <a href="{{ route('home') }}" class="mb-1 d-block"><b class="text-white fs-2">CRIS
                                        Store</b></a>
                                <p>Nâng niu bàn chân Việt</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group py-4" id="earch-suggestions">
                            <input type="text" class="form-control" id="input-search-home"
                                placeholder="Tìm kiếm sản phẩm">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <div id="search-suggestions"></div>
                        </div>
                        <script>
                            $(window).scroll(function() {
                                $('#search-suggestions').hide();
                                $('#input-search-home').val('');
                            });

                            $(document).click(function(event) {
                                if (!$(event.target).closest('#search-suggestions').length) {
                                    // Nếu không phải, ẩn #search-suggestions
                                    $('#search-suggestions').hide();
                                    $('#input-search-home').val('');
                                }
                            });

                            $('#input-search-home').on('input', function() {
                                const keyword = $(this).val();
                                // console.log(keyword); 
                                $.ajax({
                                    url: "{{route('client.product.suggest')}}",
                                    method: 'POST',
                                    data: {
                                        keyword: keyword,
                                        _token: '{{ csrf_token() }}',
                                    },
                                    dataType: "json",
                                    success: function(response) {
                                        // console.log(response);
                                        const suggestions = response.listProduct;
                                        console.log(suggestions);
                                        if (suggestions == '') {
                                            $('#search-suggestions').hide();
                                        } else {
                                            $('#search-suggestions').show();
                                            const html = suggestions.map(suggestion => {
                                                // Chuyển đổi đoạn đường dẫn tương đối thành đường dẫn tuyệt đối
                                                const imageAbsoluteURL = url(suggestion.thumb_main);
                                                const linkAbsoluteURL = url(`san-pham/${suggestion.slug}`);

                                                // Sử dụng đường dẫn tuyệt đối trong HTML
                                                return `<li class='d-flex'>
            <a href="${linkAbsoluteURL}">
              <img src="${imageAbsoluteURL}" class="rounded me-1" width="40" height="40" alt="err">
            </a>
            <a class="nameProduct" href="${linkAbsoluteURL}">${suggestion.name}</a>
          </li>`;
                                            }).join('');

                                            $('#search-suggestions').html(html);
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorThrown) {
                                        console.error(errorThrown);
                                    }
                                });
                            });
                        </script>
                    </div>
                    <div class="col-md-3 d-flex align-items-center">
                        @if (!Auth::check())
                        <div class="col-md-3">
                            <div class="iconUser text-white fs-4 text-center">
                                <i class="fas fa-user-ninja" id="userIcon"></i>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="wp-login">
                                <span> <a href="{{ route('client.login') }}" class="text-white">Đăng nhập /</a></span>
                                <span> <a href="{{ route('client.register') }}" class="text-white">Đăng kí</a></span>
                            </div>
                            <p class="mb-0 mt-1 text-white">Tài khoản của bạn</p>
                        </div>
                        @else
                        <div class="col-md-3">
                            <div class="iconUser text-white fs-4 text-center">
                                <i class="fas fa-user-ninja" id="userIcon"></i>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="wp-login">
                                <span><a><span class="text-danger">{{ Auth::user()->name }}</span>
                                        <span class="text-white">|</span></a></span>
                                <span> <a href="{{ route('client.profile') }}" class="text-white">Tài khoản của bạn</a></span>
                                <span class="text-white">|</span>
                                <span> <a href="{{ route('client.logout') }}" class="text-white">Đăng xuất</a></span>
                            </div>
                             <a href="{{ route('client.cart.myOrder') }}" class="dropdown-item my-2 text-white">Đơn hàng của bạn</a>
                        </div>

                        <!-- Dropdown Menu for Logged In User -->
                        <div class="dropdown-menu" id="userDropdown">
                            <a href="{{ route('client.profile') }}" class="dropdown-item">Tài khoản của bạn</a>
                            <a href="{{ route('client.cart.myOrder') }}" class="dropdown-item">Đơn hàng của bạn</a>
                            <a href="{{ route('client.logout') }}" class="dropdown-item text-danger">Đăng xuất</a>
                        </div>
                        @endif
                    </div>

                    <div class="wp-icon-cart col d-flex align-items-center">
                        <a href="{{ route('client.cart.show') }}"
                            class="iconCart fs-3 text-white d-flex justify-content-end ">

                            <i class="fas fa-cart-plus text-end m-4"></i>
                            <div class="notifyIcon text-center cartCount">{{Cart::content()->count()}}</div>
                        </a>
                        @if (Cart::content()->count() > 0)
                        <div class="CartDropDown">
                            <p class="text-black mb-2 title">Có <span
                                    class="text-danger fw-bold">{{Cart::content()->count()}}</span> sản phẩm
                                trong
                                giỏ
                                hàng
                            </p>
                            <div id="wp-content" class="px-2">
                                @foreach(Cart::content()->take(2) as $product)
                                <div class="row item">
                                    <div class="col-3 p-0">
                                        <img src="{{asset($product->options ->thumb_main)}}" alt="">
                                    </div>
                                    <div class="col-9 text-black">
                                        {{Str::limit($product->name,
                                        $limit = 40, $end =
                                        '...')}}
                                        <div class="price text-danger my-1">
                                            {{number_format($product ->
                                            total,'0','','.'). ' VNĐ'}}
                                        </div>
                                        <div class="qty">
                                            Số lượng: {{$product ->qty}}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="wp-total text-black d-flex fw-bold py-3">
                                <div class="title">TỔNG: </div>
                                <div class="total text-danger ms-1">{{Cart::total().' VNĐ'}}</div>
                            </div>
                            <div class="wp-btn-cart d-flex justify-content-between">
                                <a href="{{route('client.cart.show')}}" class="btn-cart rounded">GIỎ HÀNG</a>
                                <a href="{{route('client.cart.checkout')}}" class="btn-pay rounded">THANH TOÁN </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
        <section id="myMainMenu" class="text-white d-none d-sm-block">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <nav>
                            <ul class="d-flex float-end">
                                <li><a href="{{ route('home') }}"
                                        class="{{ session('client_module_active') == 'home' ? 'text-danger' : '' }}">Trang
                                        chủ</a></li>
                                <li><a href="{{ route('client.product.show') }}"
                                        class="{{ session('client_module_active') == 'product' ? 'text-danger' : '' }}">Sản
                                        phẩm</a></li>
                                <li><a href="{{ route('client.blog.show') }}"
                                        class="{{ session('client_module_active') == 'blog' ? 'text-danger' : '' }}">Blog</a>
                                </li>
                                @empty(!$dataHeader)
                                @foreach ($dataHeader as $value)
                                <li>
                                    <a href="{{ route('client.page.show', $value->slug) }}" class="{{
                                        session('client_module_active') == $value->slug ? 'text-danger' : '' }}">{{
                                        $value->name}}</a>
                                </li>
                                @endforeach
                                @endempty

                                <li><a href="{{route('client.page.faq')}}"
                                        class="{{ session('client_module_active') == 'faq' ? 'text-danger' : '' }}">FAQ</a>
                                </li>
                                <li><a href="{{route('client.feedback')}}"
                                        class="{{ session('client_module_active') == 'feedback' ? 'text-danger' : '' }}">Phản
                                        hồi khách hàng</a></li>
                                <li><a href="{{route('client.support.index')}}"
                                    class="{{ session('client_module_active') == 'support' ? 'text-danger' : '' }}">Hỗ trợ</a></li>

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div id="headerRespon" class="d-none">
        <div class="container">
            <div class="row d-flex justify-content-between">
                <div class="col-6 py-3">
                    <div class="logo">
                        <a href="{{route('home')}}"><b class="text-white my-3">Cris Store</b></a>
                    </div>
                </div>
                <div class="col-5 d-flex justify-content-end my-3">
                    <a href="{{route('client.login')}}" class="iconHeaderRp iconUser fs-6 me-1">
                        <i class="fa-solid fa-user-tie"></i>
                    </a>
                    <a href="{{route('client.cart.show')}}" class="iconHeaderRp iconCart fs-6">
                        <i class="fas fa-cart-plus"></i>
                        <div class="notifyIcon text-center cartCount">{{Cart::content()->count()}}</div>
                    </a>
                    <nav class="navbar navbar-dark p-0 ms-1">
                        <a data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
                            aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation" class="iconHeaderRp">
                            <i class="fa-solid fa-bars fs-6 iconMenu"></i>
                        </a>
                        <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
                            aria-labelledby="offcanvasDarkNavbarLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">
                                    @if (Auth::check())
                                    <small>{{ Auth::user()->name }}</small> |
                                    <a class="nav-link d-inline-block text-white" href="{{ route('client.profile') }}">
                                        <i class="fas fa-user-cog"></i>
                                        tài khoản
                                    </a>
                                    |
                                    <a class="nav-link d-inline-block text-white" href="{{route('client.logout')}}">
                                        <i class="fas fa-sign-out-alt"></i>
                                        logout
                                    </a>
                                    @else
                                    TQStore
                                    @endif
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                    @if (Auth::check())
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('client.profile') }}">
                                            <i class="fas fa-user-cog me-2"></i>Tài khoản của bạn
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('client.cart.myOrder') }}">
                                            <i class="fas fa-box me-2"></i>Đơn hàng của bạn
                                        </a>
                                    </li>
                                    @endif
                                    <li class="nav-item">
                                        <a class="nav-link {{ session('client_module_active') == 'home' ? 'text-danger' : '' }}"
                                            aria-current="page" href="{{route('home')}}">Trang
                                            chủ</a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Sản phẩm
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-dark">
                                            <li><a class="dropdown-item" href="#">Sản phẩm 1</a></li>
                                            <li><a class="dropdown-item" href="#">Sản phẩm 2</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ session('client_module_active') == 'blog' ? 'text-danger' : '' }}"
                                            href="{{ route('client.blog.show') }}">Blog</a>
                                    </li>
                                    @empty(!$dataHeader)
                                    @foreach ($dataHeader as $value)
                                    <li class="nav-item">
                                        <a href="{{ route('client.page.show', $value->slug) }}"
                                            class="nav-link {{
                                                session('client_module_active') == $value->slug ? 'text-danger' : '' }}">{{
                                            $value->name}}</a>
                                    </li>
                                    @endforeach
                                    @endempty

                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('client.page.faq')}}">
                                            <h3
                                                class="{{ session('client_module_active') == 'faq' ? 'text-danger' : '' }}">
                                                FAQ</h3>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{route('client.feedback')}}">
                                            <h3
                                                class="{{ session('client_module_active') == 'feedback' ? 'text-danger' : '' }}">
                                                Phản
                                                hồi khách hàng</h3>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ session('client_module_active') == 'support' ? 'text-danger' : '' }}" href="{{route('client.support.index')}}">Hỗ trợ</a>
                                    </li>
                                </ul>
                                <form class="d-flex mt-3 d-sm-none" role="search">
                                    <input class="form-control me-2" type="search" placeholder="Search"
                                        aria-label="Search">
                                    <button class="btn btn-success" type="submit">Search</button>
                                </form>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* ===== Chatbox Styles ===== */
        #chatToggle {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            border: none;
            color: white;
            font-size: 22px;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(231, 76, 60, 0.4);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        #chatToggle:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.5);
        }

        #chatbox {
            position: fixed;
            bottom: 90px;
            right: 24px;
            width: 400px;
            height: 560px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
            display: none;
            flex-direction: column;
            z-index: 9998;
            overflow: hidden;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        #chatbox-header {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            padding: 14px 18px;
            font-weight: 600;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }
        #chatbox-header .chat-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }
        #chatbox-header .chat-status {
            margin-left: auto;
            font-size: 11px;
            background: rgba(255,255,255,0.2);
            padding: 2px 8px;
            border-radius: 12px;
        }

        #messages {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            background: #f0f2f5;
            scroll-behavior: smooth;
        }
        #messages::-webkit-scrollbar { width: 6px; }
        #messages::-webkit-scrollbar-track { background: transparent; }
        #messages::-webkit-scrollbar-thumb { background: #cbd5e0; border-radius: 3px; }

        .message {
            max-width: 85%;
            padding: 10px 14px;
            border-radius: 16px;
            font-size: 14px;
            line-height: 1.5;
            word-break: break-word;
            animation: msgIn 0.25s ease;
        }
        @keyframes msgIn {
            from { opacity: 0; transform: translateY(8px) scale(0.96); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        .message.user {
            align-self: flex-end;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            border-bottom-right-radius: 4px;
        }
        .message.ai {
            align-self: flex-start;
            background: white;
            color: #2d3748;
            border-bottom-left-radius: 4px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }
        .message.loading {
            color: #a0aec0;
            font-style: italic;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .message.loading::after {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: #a0aec0;
            animation: blink 1.2s infinite;
        }
        @keyframes blink {
            0%, 80%, 100% { opacity: 0.3; transform: scale(0.8); }
            40% { opacity: 1; transform: scale(1); }
        }

        /* ===== Markdown Styles inside chat ===== */
        .message.ai h1, .message.ai h2, .message.ai h3,
        .message.ai h4, .message.ai h5, .message.ai h6 {
            margin: 0.5em 0 0.3em;
            font-weight: 700;
            color: #1a202c;
        }
        .message.ai h1 { font-size: 18px; }
        .message.ai h2 { font-size: 16px; }
        .message.ai h3 { font-size: 15px; }
        .message.ai h4, .message.ai h5, .message.ai h6 { font-size: 14px; }

        .message.ai p { margin: 0.4em 0; }
        .message.ai p:first-child { margin-top: 0; }
        .message.ai p:last-child { margin-bottom: 0; }

        .message.ai ul, .message.ai ol {
            margin: 0.5em 0;
            padding-left: 20px;
        }
        .message.ai li { margin: 0.2em 0; }
        .message.ai li::marker { color: #e74c3c; }

        .message.ai strong { font-weight: 700; color: #1a202c; }
        .message.ai em { font-style: italic; color: #4a5568; }

        .message.ai a {
            color: #e74c3c;
            text-decoration: none;
            font-weight: 500;
        }
        .message.ai a:hover { text-decoration: underline; }

        .message.ai blockquote {
            margin: 0.6em 0;
            padding: 6px 12px;
            border-left: 3px solid #e74c3c;
            background: #fff5f5;
            border-radius: 0 8px 8px 0;
            color: #4a5568;
            font-style: italic;
        }

        .message.ai code {
            background: #f1f3f5;
            color: #c0392b;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: 'Fira Code', 'Consolas', monospace;
            font-size: 13px;
        }

        .message.ai pre {
            background: #1e293b;
            border-radius: 10px;
            padding: 12px 14px;
            overflow-x: auto;
            margin: 0.6em 0;
            font-size: 13px;
            line-height: 1.6;
        }
        .message.ai pre code {
            background: none;
            color: #e2e8f0;
            padding: 0;
            font-size: 13px;
        }
        .message.ai pre::-webkit-scrollbar { height: 4px; }
        .message.ai pre::-webkit-scrollbar-thumb { background: #475569; border-radius: 2px; }

        .message.ai table {
            border-collapse: collapse;
            width: 100%;
            margin: 0.6em 0;
            font-size: 13px;
            border-radius: 8px;
            overflow: hidden;
        }
        .message.ai table th {
            background: #e74c3c;
            color: white;
            padding: 8px 10px;
            text-align: left;
            font-weight: 600;
        }
        .message.ai table td {
            padding: 7px 10px;
            border-bottom: 1px solid #f1f3f5;
        }
        .message.ai table tr:last-child td { border-bottom: none; }
        .message.ai table tr:nth-child(even) { background: #f8fafc; }
        .message.ai table tr:hover { background: #fef2f2; }

        .message.ai hr {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 0.8em 0;
        }

        .message.ai img {
            max-width: 100%;
            border-radius: 8px;
        }

        #suggestions {
            padding: 10px 14px;
            background: white;
            border-top: 1px solid #f1f3f5;
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            flex-shrink: 0;
        }
        .suggest-btn {
            background: #fff0f0;
            border: 1px solid #fecaca;
            color: #c0392b;
            padding: 5px 10px;
            border-radius: 16px;
            font-size: 12px;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            white-space: nowrap;
        }
        .suggest-btn:hover {
            background: #fee2e2;
            transform: translateY(-1px);
        }

        #inputArea {
            display: flex;
            gap: 8px;
            padding: 12px 14px;
            background: white;
            border-top: 1px solid #f1f3f5;
            flex-shrink: 0;
        }
        #userInput {
            flex: 1;
            padding: 10px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 24px;
            outline: none;
            font-size: 14px;
            transition: border-color 0.2s;
            font-family: inherit;
        }
        #userInput:focus { border-color: #e74c3c; }
        #sendBtn {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            border: none;
            color: white;
            padding: 8px 18px;
            border-radius: 24px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            font-family: inherit;
        }
        #sendBtn:hover { opacity: 0.9; transform: translateY(-1px); }
        #sendBtn:active { transform: translateY(0); }

        /* ===== Zalo Floating Button ===== */
        #zalo-float {
            position: fixed;
            bottom: 90px;
            right: 24px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: transparent;
            border: none;
            cursor: pointer;
            z-index: 9997;
            animation: pulse 2s infinite;
            box-shadow: 0 4px 12px rgba(0, 104, 255, 0.4);
        }
        #zalo-float img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
    <!-- Nút mở chat -->
    <button id="chatToggle">💬</button>

<!-- Zalo Floating Button -->
<a href="https://zalo.me/0325994526" target="_blank" id="zalo-float" title="Liên hệ Zalo">
    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTTJwkLs5Z5zkGFMVetJ3Qmt26gbkOHQM7A5w&s" alt="Zalo" />
</a>

    <!-- Hộp chat -->
    <div id="chatbox">
        <div id="chatbox-header">
            <div class="chat-avatar">🤖</div>
            <div>
                <div>AI TQStore</div>
                <div style="font-size:11px;opacity:0.8;font-weight:400;">Trợ lý thông minh</div>
            </div>
            <div class="chat-status">Online</div>
        </div>
        <div id="messages"></div>
        <div id="suggestions">
            <button class="suggest-btn" onclick="sendSuggestion('Cửa hàng của bạn bán những sản phẩm nào?')">Cửa hàng bạn bán gì?</button>
            <button class="suggest-btn" onclick="sendSuggestion('Cho tôi biết thông tin của shop?')">Thông tin của hàng?</button>
            <button class="suggest-btn" onclick="sendSuggestion('Thời gian mở cửa của cửa hàng là khi nào?')">Giờ mở cửa?</button>
        </div>
        <div id="inputArea">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <input id="userInput" placeholder="Nhập tin nhắn..." />
            <button id="sendBtn" onclick="sendMessage()">Gửi</button>
        </div>
    </div>

    <script>
        // Configure marked.js
        if (typeof marked !== 'undefined') {
            marked.setOptions({
                breaks: true,
                gfm: true,
                headerIds: false,
                mangle: false,
            });
        }

        const chatToggle = document.getElementById("chatToggle");
        const chatbox = document.getElementById("chatbox");
        const input = document.getElementById("userInput");
        const messages = document.getElementById("messages");
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Toggle chatbox
        chatToggle.addEventListener("click", () => {
            const isVisible = chatbox.style.display === "flex";
            chatbox.style.display = isVisible ? "none" : "flex";
            if (!isVisible) input.focus();
        });

        // Enter to send
        input.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                sendMessage();
            }
        });

        let conversationId = null;
        let hasSentFirstMessage = false;

        async function sendMessage() {
            const msg = input.value.trim();
            if (!msg) return;

            if (!hasSentFirstMessage) {
                document.getElementById("suggestions").style.display = "none";
                hasSentFirstMessage = true;
            }
            appendMessage("user", msg);
            input.value = "";
            appendMessage("ai", "⏳ Đang suy nghĩ...", true);

            try {
                const res = await fetch("{{ route('admin.chatbox.ask') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": token
                    },
                    body: JSON.stringify({
                        message: msg,
                        conversation_id: conversationId
                    })
                });

                const data = await res.json().catch(() => ({}));
                if (messages.lastChild) messages.lastChild.remove();

                if (!res.ok) {
                    const errText = data.error || data.message || '⚠️ Lỗi máy chủ.';
                    appendMessage("ai", errText);
                    return;
                }

                const aiReply = data.reply ?? data.answer ?? '';
                appendMessage("ai", aiReply || 'Xin lỗi, máy chủ không trả về câu trả lời.');

                if (!conversationId && data.conversation_id) conversationId = data.conversation_id;

            } catch (err) {
                if (messages.lastChild) messages.lastChild.remove();
                appendMessage("ai", "⚠️ Lỗi kết nối tới máy chủ.");
            }
        }

        function sendSuggestion(text) {
            input.value = text;
            sendMessage();
        }

        function         appendMessage(sender, text, isLoading = false) {
            const msgDiv = document.createElement("div");
            msgDiv.classList.add("message", sender);

            if (isLoading) {
                msgDiv.classList.add("loading");
                msgDiv.textContent = text;
            } else if (sender === 'user') {
                msgDiv.textContent = text;
            } else {
                // Parse markdown for AI messages
                let html;
                if (typeof marked !== 'undefined' && typeof DOMPurify !== 'undefined') {
                    try {
                        const rawHtml = marked.parse(text);
                        html = DOMPurify.sanitize(rawHtml, {
                            ADD_TAGS: ['pre', 'code'],
                            ADD_ATTR: ['target', 'class'],
                        });
                        // Apply syntax highlighting to code blocks
                        msgDiv.innerHTML = html;
                        msgDiv.querySelectorAll('a').forEach((link) => {
                            link.setAttribute('target', '_blank');
                        });
                        msgDiv.querySelectorAll('pre code').forEach((block) => {
                            hljs.highlightElement(block);
                        });
                    } catch (e) {
                        // Fallback: escape HTML
                        msgDiv.textContent = text;
                    }
                } else {
                    // Libraries not loaded, use innerHTML directly
                    msgDiv.innerHTML = text;
                }
            }

            messages.appendChild(msgDiv);
            messages.scrollTop = messages.scrollHeight;
        }

    </script>
</body>
<div id="btn-top"><img src="{{asset('client/images/icon-to-top.png')}}" alt="error" /></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</html>
<div id="wp-content">
    @yield('content')
</div>
<section id="myFooter" class="text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="logo mb-3 d-none d-sm-block">
                    <a href="" class="mb-1 d-block"><b class="text-white fs-2">CRIS Store</b></a>
                    <p>Nâng niu bàn chân Việt</p>
                </div>
                <div class="mb-2"><span class="me-2 mb-1"><i class="fas fa-map-marker-alt"></i></span>Đại học Công
                    nghệ
                    Đông Á</div>
                <div class="mb-2"> <span class="me-2"><i class="fas fa-phone"></i></span>0325994526</div>
                <div class="mb-2"> <span class="me-2"><i class="far fa-envelope"></i></span>quannguyen04082004@gmail.com</div>
            </div>
            <div class="col-md-3 col-sm-12">
                <p class="title1 title">Tư vấn khách hàng <span class="toggle-icon d-sm-none"><i
                            class="fas fa-caret-down"></i></span></p>
                <ul class="collapse1 navbar-collapse">
                    <li><a href="">Bảng giá sản phẩm</a></li>
                    <li><a href="">Người dùng mới</a></li>
                    <li><a href="">Làm thẻ thành viên</a></li>
                    <li><a href="">Chính sách đổi mới</a></li>
                    <li><a href="">Quy trình làm việc</a></li>
                </ul>
            </div>

            <div class="col-md-3 col-sm-12">
                <p class="title2 title">Hỗ trợ / Dịch vụ <span class="toggle-icon d-sm-none"><i
                            class="fas fa-caret-down"></i></span></p>
                <ul class="collapse2 navbar-collapse">
                    <li><a href="">Hướng dẫn chung</a></li>
                    <li><a href="">Hướng dẫn bảo hành</a></li>
                    <li><a href="">Hướng dẫn kích hoạt</a></li>
                    <li><a href="">Hướng dẫn mua hàng</a></li>
                    <li><a href="">Hướng dẫn lắp đặt</a></li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-12">
                <p class="title title3">Tổng đài hỗ trợ <span class="toggle-icon d-sm-none"><i
                            class="fas fa-caret-down"></i></span></p>
                <ul class="collapse3 navbar-collapse">
                    <li>
                        <div class="row my-1">
                            <div class="d-flex">
                                <div class="col-md-3 fs-3 py-2 me-2 me-sm-0">
                                    <i class="fas fa-phone-volume"></i>
                                </div>
                                <div class="col-md-9">
                                    <b class="fs-4 m-0">1900 6750</b>
                                    <p class="m-0">Tư vấn online</p>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="row my-1">
                            <div class="d-flex">
                                <div class="col-md-3 fs-3 py-2 me-2 me-sm-0">
                                    <i class="fas fa-phone-volume"></i>
                                </div>
                                <div class="col-md-9">
                                    <b class="fs-4 m-0">1900 6750</b>
                                    <p class="m-0">Phản ánh chất lượng</p>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <hr>
                <div class="row">
                    <p class="d-flex align-items-center mb-0"><span class="me-2 fs-3"><i
                                class="far fa-envelope"></i></span>quannguyen04082004@gmail.com</p>
                </div>
            </div>
        </div>
        <hr>
        <div class="container">
            <div class="row p-0">
                <div class="col-md-6 col-sm-12 p-0">
                    <p class="mb-0 license">Giao diện thuộc <a href="">Cris Store</a> được thiết kế bởi Văn Quân</p>
                </div>
                <div class="col-md-6 col-sm-12 p-0">
                    <div class="social d-flex float-md-end">
                        <a href="https://www.facebook.com/thaiquymomo/" class="iconFacebook mx-1 text-white"><i
                                class="fab fa-facebook-square"></i></a>
                        <a href="" class="iconYoutobe mx-1 text-white"><i class="fab fa-youtube"></i></a>
                        <a href="" class="iconInsta mx-1 text-white"><i class="fab fa-instagram-square"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(".add-cart-ajax").click(function() {
                var id = $(this).attr("data-id");
                var data = {
                    id: id,
                    _token: '{{ csrf_token() }}'
                };

                // console.log(data);

                $.ajax({
                    url: "{{ url('gio-hang-ajax') }}/" + id,
                    method: "POST",
                    data: data,
                    dataType: "json",
                    success: function(result) {
                        $(".cartCount").text(result.cartCount);
                        // console.log(result);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    },
                });
            });
        });


        $(document).on("click", ".add-cart-ajax", function() {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success m-1",
                    cancelButton: "btn btn-danger m-1",
                },
                buttonsStyling: false,
            });

            swalWithBootstrapButtons
                .fire({
                    title: "Đã thêm sản phẩm vào giỏ hàng",
                    text: "Bạn có muốn đi vào giỏ hàng không?",
                    icon: "success",
                    showCancelButton: true,
                    confirmButtonText: "Vào giỏ hàng",
                    cancelButtonText: "Không,Ở lại đây",
                    reverseButtons: true,
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        window.location = "{{url('gio-hang')}}";
                    }
                });
        });

        // Global AJAX handler for token expiration
        $.ajaxSetup({
            error: function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status === 401) {
                    window.location.href = "{{ route('client.login') }}";
                }
            }
        });
    </script>
    <script src="{{ asset('client/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('client/js/main.js') }}?v={{ time() }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
    </script>
</section>