<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>@yield('title','Admin')</title>

    @stack('styles')
    <style>
        /* cơ bản layout admin */
        body { font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; background:#fbf7f6; color:#222; margin:0; }
        .admin-header { padding:18px 24px; background:linear-gradient(90deg,#f1d6db,#f9f3f2); box-shadow:0 4px 12px rgba(0,0,0,0.04); display:flex; align-items:center; justify-content:space-between; }
        .admin-wrap {
            display:flex;
            gap:20px;
            padding:16px 18px;      
            max-width:1400px;        
            margin:0 auto; 
            box-sizing:border-box;
        }
        .notification-menu {
            position: relative; /* để dropdown bám vào ô này */
        }

        #notifDropdown {
            display: none;
            position: absolute;
            right: 0;    /* sát bên phải icon chuông */
            top: 40px;   /* xuống dưới icon chuông một chút */
            width: 300px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
            z-index: 100;
        }

        /* thu nhỏ sidebar */
        .admin-sidebar { width:220px; } /* hoặc 260px nếu muốn rộng hơn */
        .admin-main { flex:1; }

        /* Dashboard collapsible block */
        .dash-icon {
            flex-shrink: 0;
        }
        .dash-toggle {
            display:flex;
            align-items:center;
            gap:10px;
            padding:8px 10px;           
            border-radius:8px;
            background:transparent;
            border:1px solid transparent;
            cursor:pointer;
            user-select:none;
        }
        .dash-toggle:hover { background:rgba(238,198,214,0.06); border-color:rgba(0,0,0,0.03); }
        .dash-toggle .hamburger { width:26px; height:16px; }
        .dash-toggle .hamburger span { height:2px; border-radius:2px; background:#7a2f3b; }
        .dash-toggle .hamburger span:nth-child(1){ top:1px; }
        .dash-toggle .hamburger span:nth-child(2){ top:7px; }
        .dash-toggle .hamburger span:nth-child(3){ top:13px; }

        .dash-title { font-weight:700; color:#7a2f3b; font-size:0.95rem; } /* nhỏ hơn 1rem */

        .dash-list {
            margin-top:10px;
            border-radius:10px;
            padding:6px;
            max-height:0;
            opacity:0;
            transition:max-height .28s ease, opacity .28s ease;
            background:#fff;
            box-shadow:0 8px 20px rgba(0,0,0,0.04);
            border:1px solid rgba(122,47,59,0.05);
        }
        .dash-list.open { max-height:600px; opacity:1;}

        .dash-list a {
            display:block;
            padding:8px 10px;
            margin:6px 4px;
            border-radius:8px;
            color:#4b3a3f;
            text-decoration:none;
            font-size:0.95rem;
        }
        .dash-list a:last-child{ border-bottom:none; }
        .dash-list a:hover { background:#f9f3f3; }

        /* Active/selected */
        .nav-item-active { background: rgba(238,198,214,0.12); color:#7a2f3b; font-weight:700; }
        /* đồng nhất style submenu-toggle với các link khác */
        .submenu-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            margin: 6px 4px;
            border-radius: 8px;
            color: #4b3a3f;
            text-decoration: none;
            font-size: 0.95rem;
            cursor: pointer;
        }

        /* icon (emoji hoặc fa) đều nằm trong ô rộng 20px để thẳng hàng */
        .submenu-toggle i,
        .submenu-toggle .emoji {
            flex-shrink: 0;
            width: 20px;
            text-align: center;
            display: inline-block;
        }

        /* hover giống các link khác */
        .submenu-toggle:hover {
            background: #f9f3f3;
        }

        /* submenu-list bên trong nhỏ hơn chút */
        .submenu-list {
            display: none;
            padding-left: 34px; /* lùi vào để phân cấp */
        }
        .submenu.open .submenu-list { display: block; }
        .submenu-list a {
            display: block;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 0.9rem;
            color: #555;
        }
        .submenu-list a:hover { background:#f9f3f3; }
    </style>
</head>
<body>
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
                        ✅ Tồn kho ổn định
                    </div>
                @endforelse
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
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
</body>
</html>