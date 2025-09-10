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

    <!-- Danh mục sản phẩm -->
    <div class="container" style="margin-top: 3rem;">
        <h2 style="text-align: center; font-size: 1.8rem; margin-bottom: 2rem; color: #333; font-weight: 700;">BỘ SƯU TẬP</h2>
        <div class="category-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1.5rem; text-align: center;">
            <div class="category-item">
                <a href="{{ route('customer.products.category', 5) }}">
                    <div style="background: #f8f8f8; padding: 1.5rem; border-radius: 10px; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-shoe-prints" style="font-size: 2rem; color: #ff6b88;"></i>
                    </div>
                </a>
                <p style="font-weight: 600;">Giày Gót Nhọn</p>
            </div>
            <div class="category-item">
                <a href="{{ route('customer.products.category', 7) }}">
                    <div style="background: #f8f8f8; padding: 1.5rem; border-radius: 10px; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-shoe-prints" style="font-size: 2rem; color: #ff6b88;"></i>
                    </div>
                </a>
                <p style="font-weight: 600;">Giày Gót Vuông</p>
            </div>
            <div class="category-item">
                <a href="{{ route('customer.products.category', 9) }}">
                    <div style="background: #f8f8f8; padding: 1.5rem; border-radius: 10px; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-angle-up" style="font-size: 2rem; color: #ff6b88;"></i>
                    </div>
                </a>
                <p style="font-weight: 600;">Giày Gót Đế Xuồng</p>
            </div>
            <div class="category-item">
                <a href="{{ route('customer.products.category', 8) }}">
                    <div style="background: #f8f8f8; padding: 1.5rem; border-radius: 10px; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-cone" style="font-size: 2rem; color: #ff6b88;"></i>
                    </div>
                </a>
                <p style="font-weight: 600;">Giày Gót Cone</p>
            </div>
            <div class="category-item">
                <a href="{{ route('customer.products.category', 6) }}">
                    <div style="background: #f8f8f8; padding: 1.5rem; border-radius: 10px; margin-bottom: 0.5rem;">
                        <i class="fa-solid fa-shoe-prints" style="font-size: 2rem; color: #ff6b88;"></i>
                    </div>
                </a>
                <p style="font-weight: 600;">Giày Gót Kitten</p>
            </div>
        </div>
    </div>

    <!-- Sản phẩm bán chạy -->
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

    <!-- Footer -->
    <div class="promo-banner" style="background: #f8f8f8; padding: 2rem; text-align: center; margin: 3rem 0; border-radius: 10px;">
        <h2 style="color: #ff6b88; margin-bottom: 0.5rem;">GIẢM GIÁ 30% CHO ĐƠN HÀNG ĐẦU TIÊN</h2>
        <p style="color: #666;">Sử dụng mã WELCOME30 khi thanh toán</p>
        <a href="{{ route('customer.products') }}" class="btn" style="display: inline-block; margin-top: 1rem; background: #ff6b88; color: white; padding: 0.8rem 2rem;">Mua sắm ngay</a>
    </div>
@endsection