<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://cdn.haitrieu.com/wp-content/uploads/2021/10/Logo-DH-Cong-Nghe-Dong-A-EAUT.png"
        type="image/gif" sizes="16x16">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400;1,500;1,700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css" crossorigin="anonymous">
    <style>
        body, html, div, section, nav, header, footer, main, aside, ul, li, p, span, a, button, input, textarea, select, label, h1, h2, h3, h4, h5, h6, small, strong, b, em, table, th, td {
            font-family: 'Roboto', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', sans-serif;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
    <script src="https://cdn.tiny.cloud/1/9zvlmm63vtiuu9i3wnr44t7ploxgrkb6fclj3ilmsfqvi1c4/tinymce/4/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        var editor_config = {
              path_absolute : "http://localhost/LaravelPro/DevChampion_TQStore/",
              selector: "textarea.edit",
              
              plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern textcolor colorpicker"
              ],
              toolbar: "fontselect | formatselect |forecolor backcolor |insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
              relative_urls: false,
              file_browser_callback : function(field_name, url, type, win) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
          
                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
                if (type == 'image') {
                  cmsURL = cmsURL + "&type=Images";
                } else {
                  cmsURL = cmsURL + "&type=Files";
                }
          
                tinyMCE.activeEditor.windowManager.open({
                  file : cmsURL,
                  title : 'Filemanager',
                  width : x * 0.8,
                  height : y * 0.8,
                  resizable : "yes",
                  close_previous : "no"
                });
              }
            };
          
            tinymce.init(editor_config);
    </script>
    <link rel="stylesheet" href="{{ asset('admin_assets/css/style.css') }}">
    <title>AdminTQ</title>
    <!-- Markdown rendering libs -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dompurify@3.0.6/dist/purify.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/highlight.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/styles/github.min.css" media="(prefers-color-scheme: light), (prefers-color-scheme: no-query)" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/styles/github-dark.min.css" media="(prefers-color-scheme: dark)" />
</head>

<body>
    <div id="warpper" class="nav-fixed">
        <nav class="topnav shadow navbar-light bg-white d-flex">
            <div class="navbar-brand"><a href="{{ url('admin/order/show') }}"><i class="fas fa-user-shield text-primary mr-2" style="font-size: 20px;"></i>
                    Admin</a></div>
            <div class="nav-right ">
                <div class="btn-group mr-auto">
                    <button type="button" class="btn dropdown" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="plus-icon fas fa-plus-circle"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('admin.page.add') }}">Thêm trang</a>
                        <a class="dropdown-item" href="{{ route('admin.post.add') }}">Thêm bài viết</a>
                        <a class="dropdown-item" href="{{ route('product.add') }}">Thêm sản phẩm</a>
                        <a class="dropdown-item" href="{{ route('admin.banner.add') }}">Thêm banner</a>
                        <a class="dropdown-item" href="{{ route('admin.slider.add') }}">Thêm slider</a>
                        <a class="dropdown-item" href="{{ route('admin.user.add') }}">Thêm quản trị</a>
                        <a class="dropdown-item" href="{{ route('admin.role.add') }}">Thêm quyền</a>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        {{ session('username') }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('admin.account.profile') }}">Tài khoản</a>
                        <a class="dropdown-item" href="{{ url('logout') }}">Đăng xuất</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end nav  -->
        <div id="page-body" class="d-flex">
            <div id="sidebar" class="bg-white">
                <ul id="sidebar-menu">
                    {{-- <li class="nav-link {{ session('module_active') == 'dashboard' ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Dashboard
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                    </li> --}}
                    <li class="nav-link {{ session('module_active') == 'page' ? 'active' : '' }}">
                        <a href="{{ route('admin.page.show') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Trang
                        </a>
                        <i class="arrow fas fa-angle-right"></i>

                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/page/add') }}">Thêm mới</a></li>
                            <li><a href="{{ route('admin.page.show') }}">Danh sách trang</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ session('module_active') == 'blog' ? 'active' : '' }}">
                        <a href="{{ url('admin/post/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Bài viết
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/post/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/post/list') }}">Danh sách</a></li>
                            <li><a href="{{ url('admin/post/cat') }}">Danh mục</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ session('module_active') == 'product' ? 'active' : '' }}">
                        <a href="{{ url('admin/product/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Sản phẩm
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/product/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/product/list') }}">Danh sách</a></li>
                            <li><a href="{{ url('admin/product/cat') }}">Danh mục</a></li>
                            <li><a href="{{ url('admin/product/color') }}">Màu sắc</a></li>
                            <li><a href="{{ url('admin/product/config') }}">Size giày</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ session('module_active') == 'order' ? 'active' : '' }}">
                        <a href="{{ url('admin/order/show') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Bán hàng
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/order/show') }}">Danh sách đơn hàng</a></li>
                            <li><a href="{{ route('admin.order.report') }}">Báo cáo bán hàng</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ session('module_active') == 'banner' ? 'active' : '' }} ">
                        <a href="{{ url('admin/banner/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Banner
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/banner/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/banner/list') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ session('module_active') == 'promotion' ? 'active' : '' }}">
                        <a href="{{ url('admin/promotion/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Khuyến mãi
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/promotion/create') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/promotion/list') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ session('module_active') == 'slider' ? 'active' : '' }}">
                        <a href="{{ url('admin/slider/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Slider
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/slider/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/slider/list') }}">Danh sách</a></li>
                        </ul>
                    </li>
                    @if (\App\Helpers\PermissionHelper::hasPermission(['user.add', 'user.view']))
                    <li class="nav-link {{ session('module_active') == 'user' ? 'active' : '' }}">
                        <a href="{{ url('admin/user/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Users
                        </a>
                        <i class="arrow fas fa-angle-right"></i>

                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/user/add') }}">Thêm mới</a></li>
                            <li><a href="{{ url('admin/user/list') }}">Danh sách quản trị</a></li>
                        </ul>
                    </li>
                    @endif

                    <li class="nav-link {{ session('module_active') == 'account' ? 'active' : '' }}">
                        <a href="{{ route('admin.account.profile') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-user"></i>
                            </div>
                            Tài khoản cá nhân
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                    </li>
                    <li class="nav-link {{ session('module_active') == 'chatbox' ? 'active' : '' }}">
                        <a href="{{ url('admin/chatbox/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Chatbox AI
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/chatbox/list') }}">Training</a></li>
                            <li><a href="{{ url('admin/chatbox/conversation') }}">Lịch sử hội thoại</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ session('module_active') == 'feedback' ? 'active' : '' }}">
                        <a href="{{ url('admin/feedback/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Đánh giá
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/feedback/list') }}">Danh sách đánh giá</a></li>
                        </ul>
                    </li>
                    <li class="nav-link {{ session('module_active') == 'customer' ? 'active' : '' }}">
                        <a href="{{ url('admin/customer/list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Khách hàng
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ url('admin/customer/list') }}">Danh sách khách hàng</a></li>
                            <li><a href="{{ url('admin/subscriber/list') }}">Yêu cầu hỗ trợ</a></li>
                        </ul>
                    </li>
                    @if (\App\Helpers\PermissionHelper::hasPermission(['permission.add', 'role.add', 'role.view']))
                    <li class="nav-link {{ session('module_active') == 'role' ? 'active' : '' }}">
                        <a href="{{ url('admin/permission/add') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Phân quyền
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            @if (\App\Helpers\PermissionHelper::hasPermission(['permission.add']))
                            <li><a href="{{ url('admin/permission/add') }}">Quyền</a></li>
                            @endif
                            <li><a href="{{ url('admin/role/add') }}">Thêm vai trò</a></li>
                            <li><a href="{{ url('admin/role/list') }}">Danh sách vai trò</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
            <div id="wp-content">
                @yield('content')
            </div>
        </div>
    </div>
       <button id="chatToggle">💬</button>

    <!-- Hộp chat -->
    <div id="chatbox">
        <div id="chatHeader">🤖 Cris Store AI</div>
        <div id="messages"></div>
        <div id="suggestions">
            <button class="suggest-btn" onclick="sendSuggestion('Cửa hàng của bạn bán những sản phẩm nào?')">Cửa hàng bạn bán gì?</button>
            <button class="suggest-btn" onclick="sendSuggestion('Bạn có giao hàng tận nơi không?')">Giao hàng tận nơi?</button>
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

        // Ẩn/hiện chatbox khi bấm icon 💬
        chatToggle.addEventListener("click", () => {
            const isVisible = chatbox.style.display === "flex";
            chatbox.style.display = isVisible ? "none" : "flex";
            if (!isVisible) input.focus();
        });

        // Nhấn Enter để gửi
        input.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                sendMessage();
            }
        });

        let conversationId = null;
        let hasSentFirstMessage = false; // đánh dấu gửi tin đầu tiên

        async function sendMessage() {
            const msg = input.value.trim();
            if (!msg) return;
            // Ẩn gợi ý ngay khi gửi tin đầu tiên
            if (!hasSentFirstMessage) {
                const suggestions = document.getElementById("suggestions");
                if (suggestions) {
                    suggestions.style.display = "none";
                }
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
                        conversation_id: conversationId, // gửi kèm
                        is_admin: true
                    })
                });

                const data = await res.json().catch(() => ({}));
                if (messages.lastChild) {
                    messages.lastChild.remove();
                }

                if (!res.ok) {
                    if (res.status === 401) {
                        window.location.href = "{{ route('login') }}";
                        return;
                    }
                    const errText = data.error || data.message || '⚠️ Lỗi máy chủ.';
                    appendMessage("ai", errText);
                    return;
                }

                const aiReply = data.reply ?? data.answer ?? '';
                appendMessage("ai", aiReply || 'Xin lỗi, máy chủ không trả về câu trả lời.');

                // lưu conversation_id nếu lần đầu
                if (!conversationId && data.conversation_id) {
                    conversationId = data.conversation_id;
                }

            } catch (err) {
                if (messages.lastChild) {
                    messages.lastChild.remove();
                }
                appendMessage("ai", "⚠️ Lỗi kết nối tới máy chủ.");
            }
        }

        // Gửi câu hỏi gợi ý
        function sendSuggestion(text) {
            input.value = text;
            sendMessage();
        }

        function appendMessage(sender, text, isLoading = false) {
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
                        msgDiv.innerHTML = html;
                        // Configure links to open in a new tab or trigger downloads
                        msgDiv.querySelectorAll('a').forEach((link) => {
                            link.setAttribute('target', '_blank');
                            if (link.href.includes('/chatbox/export/')) {
                                link.setAttribute('download', '');
                            }
                        });
                        // Apply syntax highlighting to code blocks
                        if (typeof hljs !== 'undefined') {
                            msgDiv.querySelectorAll('pre code').forEach((block) => {
                                hljs.highlightElement(block);
                            });
                        }
                    } catch (e) {
                        msgDiv.textContent = text;
                    }
                } else {
                    msgDiv.innerHTML = text;
                }
            }

            messages.appendChild(msgDiv);
            messages.scrollTop = messages.scrollHeight;
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js">
    </script>
    <script src="{{asset('admin_assets/js/app.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>