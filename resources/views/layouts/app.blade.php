<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', 'Giày Cao Gót')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
    </style>
    @stack('head')
</head>
<body>
    <header class="site-header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="brand">Bridal Shop</a>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Trang chủ</a>
                <a href="{{ route('customer.products') }}" class="{{ request()->routeIs('customer.products*') ? 'active' : '' }}">Sản phẩm</a>
                <a href="{{ route('customer.about') }}" class="{{ request()->routeIs('customer.about') ? 'active' : '' }}">Giới thiệu</a>
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

    <main>
        
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div>
                <h3>Về chúng tôi</h3>
                <p>Thương hiệu giày cao gót hàng đầu Việt Nam</p>
            </div>
            <div>
                <h3>Liên hệ</h3>
                <p><i class="fas fa-envelope"></i> info@giaycaogot.com</p>
                <p><i class="fas fa-phone"></i> 0123 456 789</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>