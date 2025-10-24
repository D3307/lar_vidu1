@extends('layouts.app')

@section('title', 'Tài khoản của tôi')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="row g-4">
                <!-- Cột Thông tin cá nhân -->
                <div class="col-md-5">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-4">
                                <div class="me-3">
                                    <span class="bg-light rounded-circle p-3">
                                        <i class="fa-solid fa-user fa-2x text-brand"></i>
                                    </span>
                                </div>
                                <h4 class="mb-0 fw-bold text-brand">Thông tin cá nhân</h4>
                            </div>

                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('accounts.update') }}" method="POST" autocomplete="off">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">Tên</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control rounded-3"
                                        value="{{ old('name', $user->name) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control rounded-3"
                                        value="{{ old('email', $user->email) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-semibold">Số điện thoại</label>
                                    <input type="text" name="phone" id="phone"
                                        class="form-control rounded-3"
                                        value="{{ old('phone', $user->phone) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label fw-semibold">Địa chỉ</label>
                                    <input type="text" name="address" id="address"
                                        class="form-control rounded-3"
                                        value="{{ old('address', $user->address) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Mật khẩu (để trống nếu không đổi)</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control rounded-3">
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label fw-semibold">Xác nhận mật khẩu</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control rounded-3">
                                </div>

                                <button type="submit" class="btn btn-brand w-100 py-2 fw-bold">
                                    <i class="fa-solid fa-floppy-disk me-2"></i> Lưu thay đổi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Cột Lịch sử -->
                <div class="col-md-7">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-brand mb-3">
                                <i class="fa-solid fa-clock-rotate-left me-2"></i> Lịch sử đơn hàng / khuyến mãi
                            </h4>

                            @if($histories->count())
                                <div class="history-list">
                                    @foreach($histories as $history)
                                        <div class="history-item d-flex justify-content-between align-items-center mb-3 p-3 rounded-3 shadow-sm">
                                            <div>
                                                <div class="fw-semibold text-brand">
                                                    <i class="fa-solid fa-receipt me-2"></i> Đơn #{{ $history->order?->id ?? '-' }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($history->used_at)->format('d/m/Y H:i') }}
                                                </small>
                                            </div>
                                            <div class="text-end">
                                                <div>
                                                    <span class="badge bg-brand text-white px-3 py-2">
                                                        {{ $history->coupon?->code ?? 'Không có mã' }}
                                                    </span>
                                                </div>
                                                <div class="fw-bold mt-1 text-brand">
                                                    @if($history->discount)
                                                        -{{ number_format($history->discount, 0, ',', '.') }} đ
                                                    @else
                                                        0 đ
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-3" style="display: flex; justify-content: end;">
                                    {{ $histories->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            @else
                                <p class="text-muted">Bạn chưa có lịch sử giao dịch nào.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Thanh trượt gợi ý sản phẩm -->
            <div class="suggestion-container">
                <h3>Gợi ý dành riêng cho bạn 💖</h3>

                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        @foreach ($suggestedProducts as $product)
                            <div class="swiper-slide">
                                <div class="product-card">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                    <h4>{{ $product->name }}</h4>
                                    <p class="price">{{ number_format($product->price, 0, ',', '.') }}đ</p>
                                    <a href="{{ route('customer.product_detail', $product->id) }}" class="btn-detail">Xem chi tiết</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Nút điều hướng -->
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* === MÀU CHỦ ĐẠO === */
    :root {
        --brand-color: #7a2f3b;   /* rượu vang */
        --brand-hover: #b14d63;   /* hồng nhạt */
    }

    /* Text và icon */
    .text-brand {
        color: var(--brand-color) !important;
    }

    /* Button custom */
    .btn-brand {
        background-color: var(--brand-color);
        border: none;
        color: #fff;
        border-radius: 8px;
        transition: 0.3s;
    }
    .btn-brand:hover {
        background-color: var(--brand-hover);
        color: #fff;
    }

    /* Override Bootstrap primary */
    .btn-primary {
        background-color: var(--brand-color) !important;
        border-color: var(--brand-color) !important;
    }
    .btn-primary:hover {
        background-color: var(--brand-hover) !important;
        border-color: var(--brand-hover) !important;
    }

    /* Input */
    .form-control {
        border: 1px solid #e3a1b2;
    }
    .form-control:focus {
        border-color: var(--brand-hover);
        box-shadow: 0 0 5px rgba(177, 77, 99, 0.4);
    }

    /* Bảng lịch sử */
    .history-item {
        background: #fff;
        border: 1px solid #f2d7dd;
        transition: all 0.3s ease;
    }
    .history-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(122, 47, 59, 0.15);
        border-color: var(--brand-color);
    }

    /* Badge màu chủ đạo */
    .bg-brand {
        background-color: var(--brand-color) !important;
    }
    .pagination li {
        display: inline-block;
        margin: 0 4px;
    }
    .pagination li a,
    .pagination li span {
        display: inline-block;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 600;
        text-decoration: none;
        border: 1px solid #ffd1dc;
        color: #7a2f3b;
        background: #fff;
        transition: all 0.2s ease;
    }
    .pagination li a:hover {
        background: #ffebf0;
        color: #ff3b67;
        border-color: #ffb2c1;
    }
    .pagination li.active span {
        background: #7a2f3b;
        border-color: #ff6b88;
        color: #fff;
    }
    .pagination li.disabled span {
        color: #ccc;
        background: #f9f9f9;
        border-color: #eee;
        cursor: not-allowed;
    }
    /* Khối chứa phần gợi ý */
    .suggestion-container {
        background: #fff;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        margin-top: 50px;
    }

    /* Tiêu đề */
    .suggestion-container h3 {
        font-weight: 700;
        color: #d6336c;
        margin-bottom: 20px;
    }

    /* Swiper */
    .swiper {
        width: 100%;
        padding-bottom: 20px;
        position: relative;
    }

    .swiper-slide {
        display: flex;
        justify-content: center;
    }

    /* --- CARD SẢN PHẨM --- */
    .product-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        text-align: center;
        padding: 15px;
        width: 240px;
        height: 360px; /* 🔹 Cố định chiều cao đồng đều */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: transform 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
    }

    /* Ảnh */
    .product-card img {
        width: 100%;
        height: 180px; /* 🔹 Giữ tỷ lệ ảnh đều nhau */
        object-fit: cover;
        border-radius: 12px;
    }

    /* Tên sản phẩm */
    .product-card h4 {
        font-size: 0.9rem; /* 🔹 Chữ nhỏ hơn */
        font-weight: 600;
        margin: 8px 0 4px;
        color: #333;
        line-height: 1.3;
        flex-grow: 1; /* 🔹 Đảm bảo phần chữ co giãn để các card cao bằng nhau */
    }

    /* Giá */
    .product-card .price {
        color: #ff3366;
        font-weight: bold;
        font-size: 0.9rem; /* 🔹 Giảm nhẹ */
        margin-bottom: 8px;
    }

    /* Nút chi tiết */
    .btn-detail {
        display: inline-block;
        border: 1px solid #ff3366;
        color: #ff3366;
        border-radius: 8px;
        padding: 5px 12px;
        font-size: 0.85rem;
        text-decoration: none;
        transition: 0.3s;
    }
    .btn-detail:hover {
        background-color: #ff3366;
        color: #fff;
    }

    /* Nút điều hướng */
    .swiper-button-next,
    .swiper-button-prev {
        color: #ff3366;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 0 5px rgba(0,0,0,0.1);
        width: 40px;
        height: 40px;
        top: 45%;
        z-index: 10;
    }
    .swiper-button-next::after,
    .swiper-button-prev::after {
        font-size: 16px;
    }

    /* Ẩn thanh cuộn ngang */
    ::-webkit-scrollbar {
        display: none;
    }
</style>

<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 4,
        spaceBetween: 20,
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            0: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 4 }
        }
    });
</script>
@endsection