@extends('layouts.app')

@section('title', 'Trang chủ - Giày Cao Gót')

@section('content')
    <!-- Header với hình nền đơn giản -->
    <div class="promo-header" style="
        background: url('{{ asset('/storage/background.jpg') }}') no-repeat center center;
        background-size: cover;
        height: 570px;
        margin: 0 140px;
        border-radius: 12px;
    ">
    </div>

    <!-- Sản phẩm bán chạy -->
    <div class="container" style="margin-top: 4rem;">
        <h2 style="text-align: center; font-size: 1.8rem; margin-bottom: 1rem; color: #333; font-weight: 700;">SẢN PHẨM BÁN CHẠY</h2>
        <div class="swiper product-swiper">
            <div class="swiper-wrapper">
                @foreach($products as $product)
                    <div class="swiper-slide">
                        <a href="{{ route('customer.product_detail', $product->id) }}" style="text-decoration: none; color: inherit;">
                            <div class="product-card" style="background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: transform 0.3s;">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 240px; object-fit: cover;">
                                <div style="padding: 1rem;">
                                    <h3 style="font-size: 1rem; margin-bottom: 0.5rem; color: #333;">{{ $product->name }}</h3>
                                    <p style="font-weight: bold; color: #e75480; font-size: 1.1rem;">
                                        {{ number_format($product->price, 0, ',', '.') }} ₫
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <!-- Nút điều hướng -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <!-- Thanh chỉ số -->
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Footer -->
    <div class="promo-banner" style="background: #f8f8f8; padding: 2rem; text-align: center; margin: 3rem 0; border-radius: 10px;">
        <h2 style="color: #ff6b88; margin-bottom: 0.5rem;">GIẢM GIÁ 30% CHO ĐƠN HÀNG ĐẦU TIÊN</h2>
        <p style="color: #666;">Sử dụng mã WELCOME30 khi thanh toán</p>
        <a href="{{ route('customer.products') }}" class="btn" style="display: inline-block; margin-top: 1rem; background: #ff6b88; color: white; padding: 0.8rem 2rem;">Mua sắm ngay</a>
    </div>

    <!-- SwiperJS khởi tạo -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        new Swiper('.product-swiper', {
            slidesPerView: 4,
            spaceBetween: 24,
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                1200: { slidesPerView: 4 },
                900: { slidesPerView: 3 },
                600: { slidesPerView: 2 },
                0: { slidesPerView: 1 }
            }
        });
    });
    </script>

    <style>
    .product-swiper { padding-bottom: 40px; }
    .swiper-slide { height: auto; }
    .product-card:hover {
        transform: translateY(-6px) scale(1.03);
        box-shadow: 0 8px 24px rgba(231,84,128,0.10);
    }
    .swiper-button-next, .swiper-button-prev { color: #e75480; }
    .swiper-pagination-bullet-active { background: #e75480; }
    </style>
@endsection