<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Giày Cao Gót')</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <style>
        :root {
            --bg: #fff9fb; 
            --panel: #fff;
            --muted: #6b6b6b;
            --accent: #eec6d6; 
            --accent-2: #f7e9e9; 
            --primary: #7a2f3b; 
            --text: #2b2b2b;
            --shadow: 0 6px 18px rgba(43,43,43,0.06);
            --btn-primary: #9d3651;    
            --btn-primary-hover: #7a2f3b; 
            --btn-primary-text: white; 
            
            --btn-secondary: #f8e1e8;  
            --btn-secondary-hover: #eec6d6; 
            --btn-secondary-text: #7a2f3b; 
            
            --btn-outline: transparent; 
            --btn-outline-hover: #9d3651; 
            --btn-outline-text: #9d3651; 
            --btn-outline-text-hover: white;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', ui-sans-serif, system-ui, Arial, Helvetica, sans-serif;
        }
        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .site-header {
            background: linear-gradient(90deg, var(--accent) 0%, #f6efef 100%); 
            padding: 1rem 2rem;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary);
            text-decoration: none;
        }
        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        .nav-links a {
            text-decoration: none;
            color: var(--text);
            font-weight: 500;
            transition: color 0.3s;
        }
        .nav-links a:hover {
            color: var(--primary);
        }
        .nav-links a.active {
            color: var(--primary);
            font-weight: 600;
        }

        /* USER MENU */
        .user-menu {
            position: relative;
        }
        .user-icon {
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 50%;
            background: #fff;
            color: var(--primary);
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .user-icon:hover {
            background: var(--accent-2);
        }
        .user-menu .dropdown {
            display: none;
            position: absolute;
            right: 0;
            margin-top: 8px;
            background: #fff;
            min-width: 160px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 8px;
            overflow: hidden;
            z-index: 2000; /* đảm bảo nổi lên */
        }
        .user-menu:hover .dropdown {
            display: block;
        }
        .user-menu .dropdown a,
        .user-menu .dropdown button {
            display: block;
            white-space: nowrap;
            padding: 10px 14px;
            text-align: left;
            width: 100%;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text);
            font-size: 0.95rem;
        }
        .user-menu .dropdown a:hover,
        .user-menu .dropdown button:hover {
            background: var(--accent-2);
            color: var(--primary);
        }

        main {
            flex: 1;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        .hero {
            background-image: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2)), url('/storage/background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            height: 150vh;
            display: flex;
            align-items: center;
            color: white;
            margin-bottom: 2rem;
        }
        .hero-content {
            max-width: 600px;
            padding: 2rem;
        }
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        }
        .hero p {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }
        .section-title {
            text-align: center;
            margin: 2rem 0;
            color: var(--primary);
        }
        .promo-banner {
            background-color: var(--accent-2);
            padding: 2rem;
            text-align: center;
            margin: 2rem 0;
            border-radius: 8px;
            border: 1px solid var(--accent);
        }
        .promo-banner h2 {
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        .size-option {
            border: 1px solid var(--accent);
            color: var(--text);
            transition: all 0.2s ease;
        }
        .size-option:hover {
            background: var(--accent-2);
            border-color: var(--btn-primary);
            color: var(--btn-primary);
        }
        .size-option.active {
            background: var(--btn-primary);
            color: var(--btn-primary-text);
            border-color: var(--btn-primary);
        }

        /* Khung chọn Màu */
        .color-circle {
            box-shadow: 0 0 0 2px #fff inset, 0 0 0 1px #ccc;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .color-circle:hover {
            transform: scale(1.1);
            box-shadow: 0 0 0 2px var(--btn-primary);
        }
        .color-circle.active {
            box-shadow: 0 0 0 3px var(--btn-primary);
        }

        /* Khung chọn Chất liệu */
        .material-option {
            border: 1px solid var(--accent);
            transition: all 0.2s ease;
        }
        .material-option:hover {
            background: var(--accent-2);
            border-color: var(--btn-primary);
            color: var(--btn-primary);
        }
        .material-option.active {
            background: var(--btn-primary);
            color: var(--btn-primary-text);
            border-color: var(--btn-primary);
        }

        /* Nút thêm giỏ hàng */
        #add-to-cart-form button {
            font-weight: 600;
            border-radius: 10px;
            transition: background 0.3s;
        }
        #add-to-cart-form button:hover {
            background: var(--btn-primary-hover);
        }
        .footer {
            background-color: var(--primary);
            color: white;
            padding: 2rem 0;
            margin-top: 2rem;
        }
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            padding: 0 1rem;
        }
        .footer h3 {
            margin-bottom: 1rem;
            color: var(--accent);
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        .product-card {
            background: var(--panel);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.3s;
            border: 1px solid var(--accent);
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(122, 47, 59, 0.1);
        }
        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .product-info {
            padding: 1rem;
        }
        .product-info h3 {
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        #backToTopBtn {
            position: fixed;
            bottom: 100px;
            right: 30px;
            background-color: #7a2f3b;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 20px;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
            z-index: 999;
        }

        #backToTopBtn:hover {
            background-color: #5a1f2b;
            transform: translateY(-6px) scale(1.05);
            box-shadow: 0 8px 18px rgba(0,0,0,0.3);
        }

        #backToTopBtn:hover i {
            animation: bounce 0.6s ease;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-6px); }
            60% { transform: translateY(-3px); }
        }
        /* Footer tinh chỉnh lại */
        .shop-footer {
            background: #fff;
            border-top: 3px solid #f5dbe0; /* nhẹ, hồng nhạt để phân tách với body */
            color: #222;
            font-size: 1rem;
            padding-top: 30px;
            padding-bottom: 20px;
        }

        .shop-footer .container {
            max-width: 1300px; /* Dàn rộng hơn */
            margin: 0 auto;
        }

        .footer-title {
            color: #e75480;
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .footer-desc {
            color: #444;
            font-size: 1.02rem;
            line-height: 1.5;
        }

        .footer-heading {
            color: #e75480;
            font-weight: 600;
            margin-bottom: 12px;
            font-size: 1.08rem;
        }

        .footer-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-list li {
            margin-bottom: 8px;
            color: #222;
            font-size: 1.01rem;
            display: flex;
            align-items: center;
        }

        .footer-list a {
            color: #222;
            text-decoration: none;
            transition: color 0.18s;
        }

        .footer-list a:hover {
            color: #e75480;
            text-decoration: underline;
        }

        .footer-social {
            display: flex;
            gap: 14px;
        }

        .footer-social-link {
            color: #e75480;
            background: #f9f3f3;
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            transition: background 0.18s, color 0.18s, transform 0.25s;
            text-decoration: none;
        }

        .footer-social-link:hover {
            background: #e75480;
            color: #fff;
            transform: translateY(-3px);
        }

        .footer-hr {
            border-top: 1.5px solid #f3e6ea;
        }

        .shop-footer .text-end {
            text-align: center !important; /* Căn giữa thay vì lệch phải */
            margin-top: 10px;
            font-size: 0.95rem;
            color: #555;
        }

        /* Trái tim */
        .shop-footer .heart-icon {
            color: #e75480;
            animation: pulse 1.5s infinite;
        }

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

        /* Responsive */
        @media (max-width: 900px) {
            .shop-footer .container {
                padding-left: 14px;
                padding-right: 14px;
            }
            .footer-title {
                font-size: 1.15rem;
            }
        }
    </style>
    @stack('head')
</head>
<body>
    <!-- Header -->
    <header class="site-header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="brand">Bridal Shop</a>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Trang chủ</a>
                <a href="{{ route('customer.products') }}" class="{{ request()->routeIs('customer.products*') ? 'active' : '' }}">Sản phẩm</a>
                <a href="{{ route('customer.about') }}" class="{{ request()->routeIs('customer.about') ? 'active' : '' }}">Chính sách đổi trả</a>
                <a href="{{ route('customer.contact') }}" class="{{ request()->routeIs('customer.contact') ? 'active' : '' }}">Liên hệ</a>

                {{-- Menu user --}}
                <div class="user-menu">
                    <div class="user-icon" id="userMenuToggle">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="dropdown" id="userDropdown">
                        @auth
                            @php
                                $lastOrder = auth()->user()->orders()->latest()->first();
                            @endphp

                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}">Quản trị</a>
                            @endif

                            <a href="{{ route('accounts.edit') }}">Tài khoản của tôi</a>
                            <a href="{{ route('wishlist') }}">Danh sách yêu thích</a>
                            <a href="{{ route('orders.index') }}">Đơn hàng của tôi</a>

                            @if($lastOrder)
                                <a href="{{ route('orders.show', $lastOrder->id) }}">Đơn hàng gần nhất</a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                                @csrf
                                <button type="submit" style="width:100%; text-align:left; background:none; border:none; padding:10px 14px; cursor:pointer;">
                                    Đăng xuất
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}">Đăng nhập</a>
                            <a href="{{ route('register') }}">Đăng ký</a>
                        @endauth
                    </div>
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        const toggle = document.getElementById("userMenuToggle");
                        const dropdown = document.getElementById("userDropdown");

                        toggle.addEventListener("click", (e) => {
                            e.stopPropagation();
                            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
                        });

                        document.addEventListener("click", () => {
                            dropdown.style.display = "none";
                        });
                    });
                </script>

                <!-- Giỏ hàng -->
                <a href="{{ route('cart.index') }}" class="cart-link position-relative">
                    <i class="fas fa-shopping-cart"></i>
                    <span id="cart-count" 
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
                    </span>
                </a>
            </div>
        </div>
    </header>

    @php
        // Danh sách các route mà bạn muốn ẨN thanh tìm kiếm
        $hiddenRoutes = ['accounts.edit', 'login', 'register', 'customer.cart', 'customer.checkout', 'customer.about', 'customer.contact', 'orders.index', 'orders.show', 'wishlist'];
    @endphp

    @unless(in_array(Route::currentRouteName(), $hiddenRoutes))
        <!-- Thanh tìm kiếm -->
        <div class="search-bar" style="position: sticky; padding: 20px; height: 80px;">
            <div class="container" style="display:flex; justify-content:center;">
                <form action="{{ route('customer.search') }}" method="GET" 
                    style="display:flex; gap:8px; width:100%; max-width:500px;">
                    <input type="text" id="search" name="search" value="{{ request('search') }}" 
                        placeholder="Tìm kiếm sản phẩm..." 
                        style="flex:1; height: 40px; padding:10px 16px; border-radius:8px; border:1px solid #e8cbd2;">
                    <button type="submit" 
                        style="height: 40px; padding:5px 20px; border-radius:8px; background:var(--accent); color:black; border:none; font-weight:600;">
                        🔍 Tìm kiếm
                    </button>
                </form>
            </div>
        </div>
    @endunless

    <!-- Nội dung chính -->
    <main>
        
        @yield('content')
    </main>

    <!-- Nút quay lại đầu trang -->
    <button id="backToTopBtn" title="Lên đầu trang">
        <i class="fa fa-arrow-up"></i>
    </button>
    <script>
        window.onscroll = function() {
            const btn = document.getElementById("backToTopBtn");
            if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                btn.style.display = "flex";
            } else {
                btn.style.display = "none";
            }
        };

        document.getElementById("backToTopBtn").onclick = function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };
    </script>

        <!-- 🧠 Chatbot AI -->
    <div id="chatbot-widget" style="position:fixed; bottom:20px; right:20px; z-index:9999;">

    <!-- 🔘 Nút mở/đóng chatbot -->
    <button id="chatbot-toggle"
        style="background:#c03651; color:white; border:none; border-radius:50%;
        width:55px; height:55px; font-size:1.5rem; cursor:pointer;
        box-shadow:0 4px 8px rgba(0,0,0,0.2);">
        💬
    </button>

    <!-- 💬 Hộp chat -->
    <div id="chatbot-box"
        style="display:none; width:320px; height:420px; background:white;
        border:1px solid #ddd; border-radius:12px;
        box-shadow:0 4px 10px rgba(0,0,0,0.15);
        flex-direction:column; overflow:hidden;">

        <!-- Header -->
        <div style="background:#7a2f3b; color:white; padding:10px;
            font-weight:600; text-align:center;">
            🤖 Trợ lý ảo Bridal Shop
        </div>

        <!-- Nội dung tin nhắn -->
        <div id="chatbot-messages"
            style="flex:1; overflow-y:auto; padding:10px; font-size:0.9rem;
            max-height:320px;"></div>

        <!-- Ô nhập -->
        <form id="chatbot-form" style="display:flex; border-top:1px solid #eee;">
            <input type="text" id="chatbot-input" placeholder="Nhập tin nhắn..."
                style="flex:1; border:none; padding:10px; outline:none;">
            <button type="submit"
                style="background:#c03651; color:white; border:none; padding:0 15px;
                cursor:pointer;">Gửi</button>
        </form>
    </div>
</div>

<!-- CSRF token cho Laravel -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // 🛠 Thiết lập CSRF token cho mọi request AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // 🔘 Bật/tắt khung chat
    $('#chatbot-toggle').on('click', function() {
        $('#chatbot-box').toggle();
    });

    // 📩 Xử lý gửi tin nhắn
    $('#chatbot-form').on('submit', function(e) {
        e.preventDefault();
        const msg = $('#chatbot-input').val().trim();
        if (!msg) return;

        // Hiển thị tin nhắn người dùng
        $('#chatbot-messages').append(`
            <div style="margin:8px 0;">
                <strong>Bạn:</strong> ${$('<div>').text(msg).html()}
            </div>
        `);
        $('#chatbot-input').val('');

        // Gửi tin nhắn đến backend
        $.ajax({
            url: "{{ route('chatbot.send') }}",
            method: 'POST',
            data: { message: msg },
            success: function(res) {
                $('#chatbot-messages').append(`
                    <div style="margin:8px 0; color:#7a2f3b;">
                        <strong>AI:</strong> ${$('<div>').text(res.reply).html()}
                    </div>
                `);
                $('#chatbot-messages').scrollTop($('#chatbot-messages')[0].scrollHeight);
            },
            error: function(xhr) {
                $('#chatbot-messages').append(`
                    <div style="margin:8px 0; color:red;">
                        <strong>Lỗi:</strong> Không thể kết nối đến máy chủ (mã ${xhr.status})
                    </div>
                `);
            }
        });
    });
});
</script>

    <!-- Footer -->
    <footer class="shop-footer mt-5">
        <div class="container py-4">
            <div class="row gy-4">
                <div class="col-md-3">
                    <h5 class="footer-title mb-3">
                        Bridal Shop
                    </h5>
                    <p class="footer-desc">
                        Chuyên giày cao gót nữ thời trang, chất lượng, giá tốt. Đổi trả dễ dàng, giao hàng toàn quốc.
                    </p>
                    <div class="footer-social mt-3">
                        <a href="#" class="footer-social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="footer-social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="footer-social-link"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <h6 class="footer-heading">Liên hệ</h6>
                    <ul class="footer-list">
                        <li><i class="fa fa-map-marker-alt me-2"></i>41A Phú Diễn, Bắc Từ Liêm, Hà Nội</li>
                        <li><i class="fa fa-phone me-2"></i>0123 456 789</li>
                        <li><i class="fa fa-envelope me-2"></i>info@giaycaogot.com</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="footer-heading">Hỗ trợ khách hàng</h6>
                    <ul class="footer-list">
                        <li><a href="{{ route('customer.about') }}">Chính sách đổi trả</a></li>
                        <li><a href="{{ route('customer.contact') }}">Liên hệ</a></li>
                        <li><a href="{{ route('customer.chat') }}">FAQs</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6 class="footer-heading">Địa chỉ cửa hàng</h6>
                    <div class="footer-map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3873.7765318273246!2d105.7617326108948!3d21.0534854868478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454dc7ef09531%3A0x814cc26d6bf2aa49!2zNDFBIMSQLiBQaMO6IERp4buFbiwgUGjDuiBEaeG7hW4sIELhuq9jIFThu6sgTGnDqm0sIEjDoCBO4buZaSwgVmnhu4d0IE5hbQ!5e1!3m2!1svi!2s!4v1757502007239!5m2!1svi!2s"
                            allowfullscreen
                            loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
            <hr class="footer-hr my-4">
            <div class="text-end text-muted small">
                &copy; {{ date('Y') }} - Hệ thống quản lý cửa hàng được thiết kế bởi D3307 <i class="fa-solid fa-heart heart-icon"></i>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>