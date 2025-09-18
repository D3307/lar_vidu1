@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    {{-- Thông báo --}}
    @if(session('success'))
        <div id="alert-box" style="position: fixed; top: 20px; right: 20px; background-color: #ff6b88; color: white; padding: 16px 24px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-weight: 500; z-index: 9999; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i>
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('alert-box').remove();" style="background: transparent; border: none; color: white; font-size: 1.2rem; cursor: pointer; margin-left: 10px;">&times;</button>
        </div>
        <script>
            setTimeout(function () {
                let alertBox = document.getElementById('alert-box');
                if (alertBox) {
                    alertBox.style.transition = 'opacity 0.5s ease';
                    alertBox.style.opacity = '0';
                    setTimeout(() => alertBox.remove(), 500);
                }
            }, 3000);
        </script>
    @endif

    <div class="row g-4">
        {{-- Cột ảnh sản phẩm --}}
        <div class="col-md-6 d-flex">
            {{-- Ảnh lớn --}}
            <div class="flex-grow-1 text-center">
                <img id="main-product-img" src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow" style="max-height: 400px; object-fit: contain;">
            </div>
        </div>

        {{-- Cột thông tin sản phẩm --}}
        <div class="col-md-6">
            <h2 class="fw-bold" style="color: var(--primary)">{{ $product->name }}</h2>
            <div class="mb-2">
                <span class="text-muted">Danh mục: {{ $product->category->name ?? '---' }}</span>
            </div>
            <h4 class="fw-bold mb-3" style="color: var(--btn-primary)">
                {{ number_format($product->price, 0, ',', '.') }} đ
            </h4>
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-fill" id="add-to-cart-form">
                @csrf
                <input type="hidden" name="color" id="selected-color">
                <input type="hidden" name="size" id="selected-size">
                <div class="mb-2">
                    <span class="fw-bold">Màu sắc</span>
                    <div class="d-flex gap-2 mt-1">
                        @foreach($colors as $color)
                            <div class="color-circle" style="width:28px;height:28px;border-radius:50%;border:1px solid #ccc;cursor:pointer;background:{{ trim($color) }};" title="{{ trim($color) }}" data-color="{{ trim($color) }}"></div>
                        @endforeach
                    </div>
                </div>
                <div class="mb-2">
                    <span class="fw-bold">Kích thước</span>
                    <div class="d-flex gap-2 mt-1">
                        @foreach($sizes as $size)
                            <div class="border p-2 text-center size-option" style="width:36px;cursor:pointer;border-radius:6px;" data-size="{{ trim($size) }}">{{ trim($size) }}</div>
                        @endforeach
                    </div>
                </div>
                <div class="mb-2">
                    <span class="fw-bold">Số lượng</span>
                    <input type="number" name="quantity" value="1" min="1" class="form-control d-inline-block" style="width:90px;">
                </div>
                <button type="submit" class="btn" style="background: #e75480; color: #fff; width: 100%; border-radius: 8px;">
                    <i class="fa fa-shopping-bag me-2"></i>Thêm vào giỏ
                </button>
            </form>
            <div class="d-flex gap-2 mt-3">
                <form action="{{ route('buy.now', $product->id) }}" method="POST" class="flex-fill">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger" style="border-color: #e75480; color: #e75480; width: 100%;">
                        <i class="fa fa-bolt me-2"></i>Mua ngay
                    </button>
                </form>
                <form action="{{ route('wishlist.add', $product->id) }}" method="POST" class="flex-fill">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger" style="border-color: #e75480; color: #e75480; width: 100%;">
                        <i class="fa fa-heart me-2"></i>Yêu thích
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="mt-5">
        <ul class="nav nav-tabs" id="productTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab">
                    <i class="fa fa-info-circle me-1"></i> Mô tả
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab">
                    <i class="fa fa-star me-1"></i> Đánh giá ({{ $product->reviews->count() }})
                </button>
            </li>
        </ul>
        <div class="tab-content p-4 border border-top-0 bg-white rounded-bottom shadow-sm" id="productTabContent">
            {{-- Mô tả --}}
            <div class="tab-pane fade show active" id="desc" role="tabpanel">
                <div class="row">
                    <div class="col-md-8">
                        <h5 class="fw-bold mb-3" style="color:#222;">Thông tin sản phẩm</h5>
                        <div style="font-size:1.08rem; line-height:1.7; color:#222;">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="bg-light rounded p-3 mb-3">
                            <h6 class="fw-bold mb-2"><i class="fa fa-truck me-2"></i>Vận chuyển & Đổi trả</h6>
                            <ul class="mb-0" style="font-size:0.97rem;">
                                <li>Giao hàng toàn quốc, kiểm tra trước khi nhận</li>
                                <li>Đổi trả trong 7 ngày nếu lỗi nhà sản xuất</li>
                                <li>Hỗ trợ khách hàng 24/7</li>
                            </ul>
                        </div>
                        <div class="bg-light rounded p-3">
                            <h6 class="fw-bold mb-2"><i class="fa fa-check-circle me-2"></i>Cam kết</h6>
                            <ul class="mb-0" style="font-size:0.97rem;">
                                <li>Sản phẩm chính hãng 100%</li>
                                <li>Bảo hành theo chính sách hãng</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Đánh giá --}}
            <div class="tab-pane fade" id="review" role="tabpanel">
                <h5 class="fw-bold mb-4" style="color:#222;">
                    <i class="fa fa-star"></i> Đánh giá sản phẩm
                </h5>
                @if($product->reviews->count() > 0)
                    <div class="d-flex flex-column gap-4">
                        @foreach($product->reviews as $review)
                            <div class="review-card p-4 mb-4 bg-light rounded shadow-sm" style="border: 1.5px solid #f0f0f0;">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                                         style="width:56px;height:56px;background: #f5f5f5; font-weight: 700; color:#222; font-size:1.5rem; box-shadow:0 2px 8px rgba(0,0,0,0.04);">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold" style="font-size:1.1rem; color:#222;">{{ $review->user->name }}</div>
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <div>
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa{{ $i <= $review->rating ? ' fa-star' : ' fa-star-o' }}" style="color: #ffc107; font-size:1.1rem;"></i>
                                                @endfor
                                            </div>
                                            <span class="text-muted small" style="font-size:0.98rem;">{{ $review->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2" style="font-size:1.08rem; color:#222; line-height:1.7;">
                                    {{ $review->comment }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info text-center mb-0" style="border-radius: 8px;">Chưa có đánh giá nào cho sản phẩm này.</div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Script chọn option --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        //Chọn color
        document.querySelectorAll('.color-circle').forEach(el => {
            el.addEventListener('click', function() {
                document.querySelectorAll('.color-circle').forEach(e => e.style.outline = 'none');
                this.style.outline = '2px solid black';
                let selectedColor = this.dataset.color;
                document.getElementById('selected-color').value = selectedColor;
            });
        });
        // chọn size
        document.querySelectorAll('.size-option').forEach(el => {
            el.addEventListener('click', function() {
                document.querySelectorAll('.size-option').forEach(e => e.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('selected-size').value = this.dataset.size;
            });
        });
    });
</script>

<style>
.btn-outline-danger,
.btn-outline-danger:focus {
    border-color: #e75480;
    color: #e75480;
    background: #fff;
}
.btn-outline-danger:hover {
    background: #e75480;
    color: #fff !important;
    border-color: #e75480;
}
.d-flex { display: flex; gap: 12px; }
.flex-fill { flex: 1; }
.btn { height: 38px; font-weight: 600; font-size: 1rem; border-radius: 8px; }
.nav-tabs .nav-link.active {
    color: #e75480;
    border-color: #e75480 #e75480 #fff;
    background: #fff;
    font-weight: 600;
}
.nav-tabs .nav-link {
    color: #222;
    font-weight: 500;
}
</style>
@endsection
