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
        <h2 class="section-title">Sản phẩm nổi bật</h2>
        <div class="product-grid">
            <div class="product-card">
                <img src="{{ asset('storage/giayslingback.jpeg') }}">
                <div class="product-info">
                    <h3>Giày cao gót Sling back</h3>
                    <p>599.000 VNĐ</p>
                </div>
            </div>
            <div class="product-card">
                <img src="/storage/giaycaogotmuinhon.jpeg" alt="Giày cao gót mũi nhọn">
                <div class="product-info">
                    <h3>Giày cao gót mũi nhọn</h3>
                    <p>499.000 VNĐ</p>
                </div>
            </div>
            <div class="product-card">
                <img src="/storage/lPBKPtZiZwmBvwXJX6QEgSNc6Ri9annqsGBvuNlQ.jpg" alt="Giày cao gót mũi nhọn màu be">
                <div class="product-info">
                    <h3>Giày cao gót mũi nhọn màu be</h3>
                    <p>499.000 VNĐ</p>
                </div>
            </div>
        </div>
    </section>
@endsection