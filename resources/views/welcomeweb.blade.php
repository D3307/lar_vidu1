@extends('layouts.app')

@section('title', 'Chào mừng - Giày Cao Gót')

@section('content')
    <!-- Hero section -->
    <section class="hero" style="height:70vh; display:flex; align-items:center; margin: 0 80px;">
        <div class="hero-content" style="color:white;">
            <h1>Chào mừng bạn đến với cửa hàng của chúng tôi</h1>
            <p>Khám phá bộ sưu tập giày cao gót sang trọng, tinh tế và thời thượng.</p>
            <div style="display:flex; gap:1rem; flex-wrap:wrap;">
                @guest
                    <a href="{{ route('register') }}" class="btn">Đăng ký</a>
                    <a href="{{ route('login') }}" class="btn btn-secondary">Đăng nhập</a>
                @else
                    <a href="{{ route('home') }}" class="btn">Trang chủ</a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary">Đăng xuất</button>
                    </form>
                @endguest
            </div>
        </div>
    </section>

    <!-- Promo / giới thiệu ngắn -->
    <section class="promo-banner">
        <h2>Bộ sưu tập nổi bật</h2>
        <p>Những mẫu giày mới nhất, sang trọng và thoải mái cho mọi dịp.</p>
    </section>

    <!-- Sản phẩm nổi bật (có thể hiển thị 3-4 sản phẩm mẫu) -->
    <section class="container">
        <div class="container" style="margin-top: 4rem;">
            <h2 style="text-align: center; font-size: 1.8rem; margin-bottom: 1rem; color: #333; font-weight: 700;">SẢN PHẨM BÁN CHẠY</h2>
            <p style="text-align: center; color: #666; margin-bottom: 2rem;">Top những sản phẩm được mua nhiều nhất</p>
            
            <div class="product-grid">
                @foreach($products as $product)
                    <a href="{{ route('customer.product_detail', $product->id) }}" 
                    style="text-decoration: none; color: inherit;">
                        <div class="product-card" 
                            style="background: white; border-radius: 10px; overflow: hidden; 
                                box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: transform 0.3s;">
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                alt="{{ $product->name }}" 
                                style="width: 100%; height: 300px; object-fit: cover;">
                            <div style="padding: 1rem;">
                                <h3 style="font-size: 1rem; margin-bottom: 0.5rem; color: #333;">
                                    {{ $product->name }}
                                </h3>
                                <p style="font-weight: bold; color: #ff6b88; font-size: 1.1rem;">
                                    {{ number_format($product->price, 0, ',', '.') }} ₫
                                </p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection