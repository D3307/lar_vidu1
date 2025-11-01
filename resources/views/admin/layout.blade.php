<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>@yield('title','Admin')</title>

    <style>
        body {font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; background:#fbf7f6; color:#222; margin:0;}
        .admin-header {padding:18px 24px; background:linear-gradient(90deg,#f1d6db,#f9f3f2); box-shadow:0 4px 12px rgba(0,0,0,0.04); display:flex; align-items:center; justify-content:space-between; }
        .admin-wrap {display:flex;gap:20px;padding:16px 18px;max-width:1400px;margin:0 auto; box-sizing:border-box;}
        .notification-menu {position: relative;}
        #notifDropdown {display: none;position: absolute;right: 0;top: 40px;width: 300px;background: #fff;box-shadow: 0 4px 12px rgba(0,0,0,0.1);border-radius: 8px;overflow: hidden;z-index: 100;}
        .chat-notif { position: relative; display: inline-block; }
        .chat-icon { font-size: 20px; color: #5a1f1f; cursor: pointer; position: relative; }
        .chat-badge { position: absolute; top: -6px; right: -8px; background: #e75480; color: #fff; border-radius: 50%; padding: 2px 6px; font-size: 12px; }
        .chat-dropdown { display: none; position: absolute; top: 30px; right: 0; background: #fff; border: 1px solid #f1d1d1; border-radius: 10px; width: 220px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); z-index: 1000; }
        .chat-dropdown h6 { margin: 10px; font-size: 14px; color: #a04444; font-weight: 600; }
        .chat-dropdown ul { list-style: none; margin: 0; padding: 0; max-height: 200px; overflow-y: auto; }
        .chat-dropdown li { padding: 8px 12px; border-bottom: 1px solid #f6d9d9; cursor: pointer; transition: background 0.2s; }
        .chat-dropdown li:hover { background: #ffe4ec; }
        .chat-popup { display: none; position: fixed; bottom: 20px; right: 20px; width: 360px; max-height: 520px; background: #fff; border-radius: 14px; box-shadow: 0 6px 16px rgba(0,0,0,0.2); z-index: 2000; overflow: hidden; display: flex; flex-direction: column; }
        .chat-popup-header { background: linear-gradient(90deg, #ffb6c1, #ffc1cc); padding: 10px 14px; color: #5a1f1f; font-weight: 600; display: flex; justify-content: space-between; align-items: center; }
        #chat-popup-close { background: none; border: none; font-size: 20px; color: #5a1f1f; cursor: pointer; }
        .chat-popup-body { flex: 1; padding: 10px 12px; overflow-y: auto; background: #f9f9fb; }
        .chat-input { padding: 10px; border-top: 1px solid #eee; background: #fff; }
        .chat-input input[type="text"] { flex: 1; border: 1px solid #ccc; border-radius: 20px; padding: 8px 12px; outline: none; }
        #attachBtn { background: #fff; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; color: #a04444; transition: background 0.2s; }
        #attachBtn:hover { background: #ffe6ec; }
        #sendMessageBtn { background: #e75480; border: none; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; transition: background 0.2s; }
        #sendMessageBtn:hover { background: #d64d73; }
        .admin-sidebar { width:220px; }
        .admin-main { flex:1; }
        .dash-icon {flex-shrink: 0;}
        .dash-toggle {display:flex;align-items:center;gap:10px;padding:8px 10px;border-radius:8px;background:transparent;border:1px solid transparent;cursor:pointer;user-select:none;}
        .dash-toggle:hover {background:rgba(238,198,214,0.06); border-color:rgba(0,0,0,0.03);}
        .dash-toggle .hamburger { width:26px; height:16px; }
        .dash-toggle .hamburger span { height:2px; border-radius:2px;background:#7a2f3b; }
        .dash-toggle .hamburger span:nth-child(1){ top:1px; }
        .dash-toggle .hamburger span:nth-child(2){ top:7px; }
        .dash-toggle .hamburger span:nth-child(3){ top:13px; }
        .dash-title { font-weight:700; color:#7a2f3b; font-size:0.95rem; }
        .dash-list {margin-top:10px;border-radius:10px;padding:6px;max-height:0;opacity:0;transition:max-height .28s ease, opacity .28s ease;background:#fff;box-shadow:0 8px 20px rgba(0,0,0,0.04);border:1px solid rgba(122,47,59,0.05);}
        .dash-list.open { max-height:600px; opacity:1;}
        .dash-list a {display:block;padding:8px 10px;margin:6px 4px;border-radius:8px;color:#4b3a3f;text-decoration:none;font-size:0.95rem;}
        .dash-list a:last-child{ border-bottom:none; }
        .dash-list a:hover { background:#f9f3f3; }
        .nav-item-active { background: rgba(238,198,214,0.12); color:#7a2f3b; font-weight:700; }
        .submenu-toggle {display: flex;align-items: center;gap: 10px;padding: 8px 10px;margin: 6px 4px;border-radius: 8px;color: #4b3a3f;text-decoration: none;font-size: 0.95rem;cursor: pointer;}
        .submenu-toggle i,
        .submenu-toggle .emoji {flex-shrink: 0;width: 20px;text-align: center;display: inline-block;}
        .submenu-toggle:hover {background: #f9f3f3;}
        .submenu-list {display: none;padding-left: 34px;}
        .submenu.open .submenu-list { display: block; }
        .submenu-list a {display: block;padding: 6px 10px;border-radius: 6px;font-size: 0.9rem;color: #555;}
        .submenu-list a:hover { background:#f9f3f3; }
        #backToTopBtn {position: fixed;bottom: 30px;right: 30px;background-color: #7a2f3b;color: #fff;border: none;border-radius: 50%;width: 40px;height: 40px;font-size: 20px;cursor: pointer;display: none;align-items: center;justify-content: center;box-shadow: 0 4px 12px rgba(0,0,0,0.2);transition: all 0.3s ease;z-index: 999;}
        #backToTopBtn:hover {background-color: #5a1f2b;transform: translateY(-6px) scale(1.05);box-shadow: 0 8px 18px rgba(0,0,0,0.3);}
        #backToTopBtn:hover i {animation: bounce 0.6s ease;}
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-6px);
            }
            60% {
                transform: translateY(-3px);
            }
        }
        .admin-footer {background: #ffffff;border-top: 2px solid #e8cbd2;color: #6c4a57;font-size: 14px;letter-spacing: 0.3px;padding-right: 30px;box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.03);}
        .admin-footer .heart-icon {color: #e75480;animation: pulse 1.5s infinite;}
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.9;
            }
            50% {
                transform: scale(1.3);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="admin-header">
        <!-- Logo bên trái -->
        <div style="display:flex;align-items:center;gap:12px">
            <div style="font-weight:800;color:#7a2f3b">Bridal Shop - Trang quản trị của Admin</div>
        </div>

        <!-- Cụm bên phải: thông báo + user -->
        <div style="display:flex;align-items:center;gap:20px;margin-right:20px;">
            <!-- Thông báo -->
            <div class="notification-menu">
                <button type="button" id="notifBtn" style="background:transparent;border:none;cursor:pointer;position:relative;">
                    <i class="fa-solid fa-bell" style="color:#7a2f3b;font-size:1.4rem;"></i>
                    @if($lowStockItems->count() > 0)
                        <span style="position:absolute;top:-6px;right:-6px;background:#c03651;color:#fff;
                                    font-size:0.7rem;padding:2px 6px;border-radius:50%;">
                            {{ $lowStockItems->count() }}
                        </span>
                    @endif
                </button>
            <!-- dropdown -->
            <div id="notifDropdown">
                <div style="padding:10px;font-weight:600;color:#7a2f3b;border-bottom:1px solid #eee;">
                    🔔 Thông báo kho
                    </div>
                    <div style="max-height:250px;overflow-y:auto;">
                        @forelse($lowStockItems as $item)
                            <div style="padding:8px 12px;border-bottom:1px solid #f1f1f1;font-size:0.9rem;">
                                <strong>{{ $item->product->name }}</strong><br>
                                <span style="color:#c03651">Còn {{ $item->quantity }} / Min {{ $item->min_quantity }}</span>
                            </div>
                        @empty
                            <div style="padding:12px;text-align:center;color:#666;">
                                ✅ Không có sản phẩm sắp hết hàng
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Icon tin nhắn + dropdown người dùng -->
            <div class="chat-notif" style="position: relative;">
                <div id="chat-icon" class="chat-icon">
                    <i class="fa-solid fa-comments"></i>
                    @php
                        $unreadCount = \App\Models\Message::where('is_admin', false)->whereNull('read_at')->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="chat-badge">{{ $unreadCount }}</span>
                    @endif
                </div>

                <!-- Dropdown danh sách người dùng -->
                <div id="chat-dropdown" class="chat-dropdown">
                    <h6>Khách hàng nhắn tin</h6>
                    <ul id="chat-user-list">
                        @php
                            $users = \App\Models\Message::where('is_admin', false)
                                ->select('user_id')
                                ->distinct()
                                ->get();
                        @endphp
                        @forelse($users as $u)
                            @php
                                $lastMsg = \App\Models\Message::where('user_id', $u->user_id)
                                    ->orderByDesc('created_at')
                                    ->first();
                                $user = \App\Models\User::find($u->user_id);
                            @endphp
                            <li class="chat-user" data-id="{{ $u->user_id }}">
                                <strong>{{ $user?->name ?? 'Người dùng #' . $u->user_id }}</strong><br>
                                <small>{{ $lastMsg?->message ?? '[Ảnh]' }}</small>
                            </li>
                        @empty
                            <li>Chưa có tin nhắn</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Popup khung chat -->
                <div id="chat-popup" class="chat-popup">
                    <div class="chat-popup-header">
                        <span id="chat-popup-title">Chat với khách</span>
                        <button id="chat-popup-close">&times;</button>
                    </div>
                    <div id="chat-popup-body" class="chat-popup-body"></div>
                    <div class="chat-input d-flex align-items-center gap-2 mt-3">
                        <input type="file" id="chatImage" accept="image/*" style="display:none;">
                        <button type="button" id="attachBtn" class="btn btn-light border">
                            <i class="fa fa-paperclip"></i>
                        </button>

                        <input type="text" id="chatMessage" class="form-control" placeholder="Nhập tin nhắn...">

                        <button type="button" id="sendMessageBtn" class="btn btn-danger" style="background:#e75480;border:none;">
                            <i class="fa fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- User menu -->
            <div class="user-menu" style="position:relative;">
                <button type="button" style="background:transparent;border:none;display:flex;align-items:center;gap:10px;cursor:pointer;">
                    <span style="display:inline-block;width:38px;height:38px;background:#f0d4db;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-user" style="color:#7a2f3b;font-size:1.4rem;"></i>
                    </span>
                    <span style="font-weight:600;color:#7a2f3b;">{{ Auth::user()->name ?? 'Admin' }}</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Body chính -->
    <div class="admin-wrap">
        <aside class="admin-sidebar">
            <!-- Collapsible Dashboard -->
            <div class="dash-toggle" id="dashToggle" role="button" aria-expanded="false" tabindex="0">
                <div class="hamburger" aria-hidden="true">
                    <span></span><span></span><span></span>
                </div>
                <svg class="dash-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#7a2f3b" width="20" height="20" aria-hidden="true">
                    <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z"/>
                </svg>
                <div class="dash-title">Dashboard</div>
            </div>

            <nav class="dash-list" id="dashList" aria-hidden="true">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'nav-item-active' : '' }}">Dashboard</a>

                <!-- Báo cáo thống kê -->
                <div class="submenu">
                    <a href="javascript:void(0)" 
                    class="submenu-toggle {{ request()->is('admin/reports*') ? 'nav-item-active' : '' }}">
                        <span class="emoji">📑</span>
                        <span>Báo cáo thống kê</span>
                    </a>
                    <div class="submenu-list">
                        <a href="{{ route('admin.reports.summary') }}" class="{{ request()->routeIs('admin.reports.summary') ? 'nav-item-active' : '' }}">
                            <i class="fa-regular fa-file-lines"></i> Báo cáo
                        </a>
                        <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.index') ? 'nav-item-active' : '' }}">
                            <i class="fa-solid fa-chart-column"></i> Biểu đồ
                        </a>
                    </div>
                </div>

                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'nav-item-active' : '' }}">📂 Quản lý danh mục</a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'nav-item-active' : '' }}">👠 Quản lý sản phẩm</a>

                <!-- Quản lý kho -->
                <div class="submenu">
                    <a href="javascript:void(0)" 
                    class="submenu-toggle {{ request()->is('admin/inventories*') || request()->is('admin/transactions*') ? 'nav-item-active' : '' }}">
                        <span class="emoji">📦</span>
                        <span>Quản lý kho</span>
                    </a>
                    <div class="submenu-list">
                        <a href="{{ route('admin.inventories.index') }}" class="{{ request()->routeIs('admin.inventories.*') ? 'nav-item-active' : '' }}">
                        <i class="fa-solid fa-boxes-stacked"></i> Tồn kho
                        </a>
                        <a href="{{ route('admin.transactions.index', ['type' => 'import']) }}" class="{{ request()->fullUrlIs(route('admin.transactions.index', ['type'=>'import'])) ? 'nav-item-active' : '' }}">
                        <i class="fa-solid fa-circle-arrow-down"></i> Phiếu nhập
                        </a>
                        <a href="{{ route('admin.transactions.index', ['type' => 'export']) }}" class="{{ request()->fullUrlIs(route('admin.transactions.index', ['type'=>'export'])) ? 'nav-item-active' : '' }}">
                        <i class="fa-solid fa-circle-arrow-up"></i> Phiếu xuất
                        </a>
                    </div>
                </div>

                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'nav-item-active' : '' }}">👤 Quản lý người dùng</a>
                <a href="{{ route('admin.orders.orders') }}" class="{{ request()->routeIs('admin.orders.*') ? 'nav-item-active' : '' }}">📋 Quản lý đơn hàng</a>
                <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'nav-item-active' : '' }}">⭐ Quản lý đánh giá</a>
                <a href="{{ route('admin.coupons.index') }}" class="{{ request()->routeIs('admin.coupons.*') ? 'nav-item-active' : '' }}">🏷️ Quản lý mã giảm giá</a>
            </nav>

            <!-- other sidebar items (đăng xuất...) -->
            <div style="margin-top:16px">
                <form action="{{ route('logout') }}" method="POST">@csrf
                    <button type="submit" style="padding:8px 12px;border-radius:8px;background:#f0d4db;border:1px solid #e8cbd2;color:#7a2f3b;cursor:pointer">Đăng xuất</button>
                </form>
            </div>
        </aside>

        <main class="admin-main">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
                <h2 style="margin:0;color:#7a2f3b">
                    @yield('title', 'Quản trị hệ thống')
                </h2>
                <form action="{{ url()->current() }}" method="GET" style="display:flex;align-items:center;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm..." 
                        style="padding:8px 16px; border-radius:8px; border:1px solid #e8cbd2; width:220px; margin-right:8px;">
                    <button type="submit" style="padding:8px 16px; border-radius:8px; background:#c03651; color:#fff; border:none;">
                        🔍 Tìm kiếm
                    </button>
                    <script>
                    $(document).ready(function(){
                        $('#search').on('keyup', function(){
                            let keyword = $(this).val();

                            $.ajax({
                                url: "{{ route('admin.products.index') }}",
                                type: "GET",
                                data: { search: keyword },
                                success: function(data){
                                    $('.styled-table tbody').html(data);
                                }
                            });
                        });
                    });
                    </script>
                </form>
            </div>
            <div style="margin-bottom:18px">@yield('page-header')</div>
            <div>
                @yield('content')
            </div>

        </main>
    </div>

    <!-- Nút quay lại đầu trang -->
    <button id="backToTopBtn" title="Lên đầu trang">
        <i class="fa fa-arrow-up"></i>
    </button>

    <!-- Footer -->
    <footer class="admin-footer text-center py-3 mt-auto">
        <div class="container text-end">
            <small>© {{ date('Y') }} - Hệ thống quản lý cửa hàng được thiết kế bởi D3307 <i class="fa-solid fa-heart heart-icon"></i></small>
        </div>
    </footer>

    <!-- Side Bar -->
    <script>
        (function(){
            var toggle = document.getElementById('dashToggle');
            var list = document.getElementById('dashList');
            function setOpen(open){
                if(open){
                    list.classList.add('open');
                    toggle.setAttribute('aria-expanded','true');
                    list.setAttribute('aria-hidden','false');
                } else {
                    list.classList.remove('open');
                    toggle.setAttribute('aria-expanded','false');
                    list.setAttribute('aria-hidden','true');
                }
                // save state in localStorage so stays consistent
                try { localStorage.setItem('adminDashOpen', open ? '1' : '0'); } catch(e){}
            }
            toggle.addEventListener('click', function(){ setOpen(!list.classList.contains('open')); });
            toggle.addEventListener('keydown', function(e){ if(e.key === 'Enter' || e.key === ' ') { e.preventDefault(); setOpen(!list.classList.contains('open')); }});
            // restore
            try { if(localStorage.getItem('adminDashOpen') === '1') setOpen(true); } catch(e){}
        })();
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function(){
            document.querySelectorAll('.submenu-toggle').forEach(function(btn){
                btn.addEventListener('click', function(){
                    const parent = btn.closest('.submenu');
                    parent.classList.toggle('open');
                });
            });
        });
    </script>

    <!-- Notification -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('notifBtn');
            const dropdown = document.getElementById('notifDropdown');

            if (btn) {
                btn.addEventListener('click', function() {
                    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                });
            }

            // Ẩn dropdown khi click ra ngoài
            document.addEventListener('click', function(e) {
                if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.style.display = 'none';
                }
            });
        });
    </script>

    <!-- Back to Top Button -->
    <script>
        // Hiện nút khi cuộn xuống 200px
        window.onscroll = function() {
            const btn = document.getElementById("backToTopBtn");
            if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                btn.style.display = "flex";
            } else {
                btn.style.display = "none";
            }
        };

        // Cuộn mượt lên đầu trang khi click
        document.getElementById("backToTopBtn").onclick = function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };
    </script>

    <!-- Chat Script -->
    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const chatIcon = document.getElementById("chat-icon");
        const chatDropdown = document.getElementById("chat-dropdown");
        const chatPopup = document.getElementById("chat-popup");
        const chatClose = document.getElementById("chat-popup-close");
        const chatBody = document.getElementById("chat-popup-body");
        const chatSend = document.getElementById("sendMessageBtn");
        const chatInput = document.getElementById("chatMessage");
        const chatTitle = document.getElementById("chat-popup-title");
        const chatFileInput = document.getElementById("chatImage");
        const chatAttachBtn = document.getElementById("attachBtn");

        let activeUserId = null;

        // Toggle dropdown
        chatIcon.addEventListener("click", () => {
            chatDropdown.style.display = chatDropdown.style.display === "block" ? "none" : "block";
        });

        // Mở popup khi chọn user
        document.querySelectorAll(".chat-user").forEach(user => {
            user.addEventListener("click", () => {
                activeUserId = user.dataset.id;
                chatDropdown.style.display = "none";
                chatPopup.style.display = "flex";
                chatTitle.innerText = `Chat với khách #${activeUserId}`;
                loadMessages(activeUserId);
            });
        });

        // Đóng popup
        chatClose.addEventListener("click", () => {
            chatPopup.style.display = "none";
            activeUserId = null;
        });

        // Gắn sự kiện mở file
        document.getElementById('attachBtn').onclick = () => {
            document.getElementById('chatImage').click();
        };

        // Gửi tin nhắn (văn bản + ảnh)
        document.getElementById('sendMessageBtn').onclick = async () => {
            const message = document.getElementById('chatMessage').value.trim();
            const fileInput = document.getElementById('chatImage');
            const file = fileInput.files[0];
            const userId = document.getElementById('chat-popup').getAttribute('data-user-id');

            if (!message && !file) return;

            const formData = new FormData();
            formData.append('message', message);
            formData.append('is_admin', true);
            formData.append('user_id', userId);
            if (file) formData.append('image', file);

            const response = await fetch('/admin/chat/send', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            if (response.ok) {
                document.getElementById('chatMessage').value = '';
                document.getElementById('chatImage').value = '';
            }
        };

        // Tải tin nhắn
        function loadMessages(userId) {
            fetch(`/admin/chat/fetch/${userId}`)
                .then(res => res.json())
                .then(data => {
                    chatBody.innerHTML = "";
                    data.forEach(msg => {
                        const div = document.createElement("div");
                        div.className = msg.is_admin ? "msg admin" : "msg user";

                        let html = "";
                        if (msg.message) html += `<p>${msg.message}</p>`;
                        if (msg.image_url) html += `<img src="${msg.image_url}" style="max-width:150px; border-radius:8px; margin-top:4px;">`;
                        div.innerHTML = html;

                        chatBody.appendChild(div);
                    });
                    chatBody.scrollTop = chatBody.scrollHeight;
                });
        }

        // Refresh mỗi 3 giây
        setInterval(() => {
            if (activeUserId) loadMessages(activeUserId);
        }, 3000);
    });
    </script>
</body>
</html>