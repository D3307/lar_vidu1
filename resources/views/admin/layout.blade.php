<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Admin')</title>

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

        /* thu nhỏ sidebar */
        .admin-sidebar { width:240px; } /* hoặc 260px nếu muốn rộng hơn */
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

        /* responsive small screen */
        @media (max-width:900px){
            .admin-wrap { padding:12px; max-width:100%; }
            .admin-sidebar { width:100%; }
            .dash-toggle .hamburger { width:22px; height:14px; }
            .dash-title { font-size:0.95rem; }
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div style="display:flex;align-items:center;gap:12px">
            <div style="font-weight:800;color:#7a2f3b">Bridal Shop - Trang quản trị của Admin</div>
        </div>
        <div style="color:#7a2f3b">Xin chào, {{ Auth::user()->name ?? 'Admin' }}</div>
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
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'nav-item-active' : '' }}">Tổng quan</a>
                <a href="{{ route('admin.reports.summary') }}" class="{{ request()->routeIs('admin.reports.summary') ? 'nav-item-active' : '' }}">📑 Báo cáo</a>
                <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.index') ? 'nav-item-active' : '' }}">📊 Biểu đồ</a>
                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'nav-item-active' : '' }}">📂 Quản lý danh mục</a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'nav-item-active' : '' }}">📦 Quản lý sản phẩm</a>
                <a href="{{ route('admin.inventories.index') }}" class="{{ request()->routeIs('admin.inventories.*') ? 'nav-item-active' : '' }}">📬 Quản lý kho</a>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'nav-item-active' : '' }}">👤 Quản lý người dùng</a>
                <a href="{{ route('admin.orders.orders') }}" class="{{ request()->routeIs('admin.orders.*') ? 'nav-item-active' : '' }}">📋 Quản lý đơn hàng</a>
                <a href="{{ route('admin.reviews.index') }}" class="{{ request()->routeIs('admin.reviews.*') ? 'nav-item-active' : '' }}">⭐ Quản lý đánh giá</a>
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
</body>
</html>