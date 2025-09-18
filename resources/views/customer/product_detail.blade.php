@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    {{-- Thông báo --}}
    @if(session('success'))
        <div id="alert-box" 
            style="position: fixed; top: 20px; right: 20px; background-color: #ff6b88; color: white; padding: 16px 24px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-weight: 500; z-index: 9999; display: flex; align-items: center; gap: 10px;">
            <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i>
            <span>{{ session('success') }}</span>
            <button onclick="document.getElementById('alert-box').remove();" 
                style="background: transparent; border: none; color: white; font-size: 1.2rem; cursor: pointer; margin-left: 10px;">
                &times;
            </button>
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
        {{-- Cột ảnh sản phẩm + thumbnail --}}
        <div class="col-md-6 d-flex">
            {{-- Ảnh lớn --}}
            <div class="flex-grow-1 text-center">
                <img id="main-product-img" src="{{ asset('storage/'.$product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="img-fluid rounded shadow"
                     style="max-height: 400px; object-fit: contain;">
            </div>
        </div>

        {{-- Thông tin sản phẩm --}}
        <div class="col-md-6">
            <h2 class="fw-bold mb-1" style="color: #222;">{{ $product->name }}</h2>
            <div class="mb-2">
                <span class="text-muted">Danh mục: {{ $product->category->name ?? '---' }}</span>
            </div>
            <div class="mb-2">
                <span class="fw-bold" style="font-size:1.7rem; color:#e75480;">
                    {{ number_format($product->price, 0, ',', '.') }} đ
                </span>
            </div>
            {{-- Đánh giá sao --}}
            <div class="mb-3">
                <span>
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fa{{ $i <= round($product->reviews->avg('rating')) ? ' fa-star' : ' fa-star-o' }}" style="color: #ffc107;"></i>
                    @endfor
                </span>
                <span class="ms-2 text-muted">{{ $product->reviews->count() }} Đánh giá</span>
            </div>
            {{-- Form thêm vào giỏ hàng --}}
            <form action="{{ route('cart.add', $product->id) }}" method="POST" id="add-to-cart-form">
                @csrf
                {{-- Color --}}
                <div class="mb-3">
                    <span class="fw-bold">Màu sắc</span>
                    <div class="d-flex gap-2 mt-1">
                        @foreach($colors as $color)
                            <div class="color-circle" style="width:28px;height:28px;border-radius:50%;border:1.5px solid #ccc;cursor:pointer;background:{{ trim($color) }};" title="{{ trim($color) }}" data-color="{{ trim($color) }}"></div>
                        @endforeach
                    </div>
                    <input type="hidden" name="color" id="selected-color">
                    <span class="ms-2" id="color-code" style="font-size:0.95rem; color:#888;">Chưa chọn</span>
                </div>
                {{-- Size --}}
                <div class="mb-3">
                    <span class="fw-bold">Size</span>
                    <div class="d-flex gap-2 mt-1">
                        @foreach($sizes as $size)
                            <div class="border p-2 text-center size-option" style="width:36px;cursor:pointer;border-radius:6px;" data-size="{{ trim($size) }}">{{ trim($size) }}</div>
                        @endforeach
                    </div>
                    <input type="hidden" name="size" id="selected-size">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#sizeGuideModal" 
                    class="ms-2" style="font-size:0.95rem; color:#e75480;">
                        Hướng dẫn chọn size
                    </a>
                </div>
                {{-- Material --}}
                <div class="mb-3">
                    <span class="fw-bold">Chất liệu</span>
                    <div class="d-flex gap-2 mt-1">
                        @foreach($materials as $material)
                            <div class="px-3 py-1 border rounded-pill material-option"
                                style="cursor:pointer"
                                data-material="{{ trim($material) }}">
                                {{ trim($material) }}
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="material" id="selected-material">
                </div>
                {{-- Quantity --}}
                <div class="mb-3">
                    <span class="fw-bold">Số lượng</span>
                    <input type="number" name="quantity" value="1" min="1" class="form-control d-inline-block" style="width:100px;">
                </div>
                {{-- Nút --}}
                @if($product->quantity > 0)
                <div class="d-flex gap-2 mt-3">
                    <button type="submit" class="btn flex-fill" style="background: #e75480; color: #fff; border-radius: 8px; font-weight:600;">
                        <i class="fa fa-shopping-bag me-2"></i>Thêm vào giỏ
                    </button>
                    <button type="submit" class="btn btn-outline-danger flex-fill" style="border-color: #e75480; color: #e75480; border-radius: 8px; font-weight:600;" formaction="{{ route('buy.now', $product->id) }}">
                        <i class="fa fa-bolt me-2"></i>Mua ngay
                    </button>
                    <button type="submit" class="btn btn-outline-danger flex-fill" style="border-color: #e75480; color: #e75480; border-radius: 8px; font-weight:600;" formaction="{{ route('wishlist.add', $product->id) }}">
                        <i class="fa fa-heart me-2"></i>Yêu thích
                    </button>
                </div>
                @else
                    <div class="alert alert-danger mt-3">
                        Sản phẩm này hiện đã <strong>hết hàng</strong>.
                    </div>
                @endif
            </form>
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
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sizeguide-tab" data-bs-toggle="tab" data-bs-target="#sizeguide" type="button" role="tab">
                    <i class="fa fa-ruler-combined me-1"></i> Hướng dẫn chọn size
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

            {{-- Hướng dẫn chọn size --}}
            <div class="tab-pane fade" id="sizeguide" role="tabpanel" aria-labelledby="sizeguide-tab">
                <div class="p-3">
                    <h6 class="fw-bold mb-3">Các bước đo size giày</h6>
                    <ol class="ps-3">
                        <li class="mb-2">Chuẩn bị một tờ giấy A4, bút và thước kẻ.</li>
                        <li class="mb-2">Đặt bàn chân lên giấy, vẽ khung bàn chân.</li>
                        <li class="mb-2">Dùng thước đo chiều dài lớn nhất của bàn chân.</li>
                        <li class="mb-2">So sánh số đo với bảng size để chọn size phù hợp.</li>
                    </ol>
                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <img src="{{ asset('storage/sizeguide/size_step_01.jpg') }}" alt="Bước 1" class="img-fluid rounded shadow-sm">
                        </div>
                        <div class="col-md-6">
                            <img src="{{ asset('storage/sizeguide/size_step_02.png') }}" alt="Bước 2" class="img-fluid rounded shadow-sm">
                        </div>
                    </div>
                    <h5 class="fw-bold mb-3">Bảng quy đổi size giày</h5>
    <table class="table table-bordered text-center">
        <thead class="table-dark">
        <tr>
            <th>SIZE</th>
            <th>Chiều dài (cm)</th>
            <th>Vòng khớp ngón (Ngồi, cm)</th>
            <th>Vòng khớp ngón (Đứng, cm)</th>
        </tr>
        </thead>
        <tbody>
        <tr><td>34</td><td>21.2</td><td>20.45</td><td>20.65</td></tr>
        <tr><td>35</td><td>21.9</td><td>20.95</td><td>21.15</td></tr>
        <tr><td>36</td><td>22.5</td><td>21.4</td><td>21.6</td></tr>
        <tr><td>37</td><td>23.2</td><td>21.9</td><td>22.1</td></tr>
        <tr><td>38</td><td>23.9</td><td>22.4</td><td>22.6</td></tr>
        <tr><td>39</td><td>24.5</td><td>22.85</td><td>23.05</td></tr>
        <tr><td>40</td><td>25.2</td><td>23.35</td><td>23.55</td></tr>
        </tbody>
    </table>

    <p class="mt-3"><b>Nếu có sự khác biệt về chiều dài của hai bàn chân, quý khách nên chọn cỡ giày ứng với chiều dài bàn chân lớn hơn.</b></p>
    <p><b>Bảng quy đổi kích thước không áp dụng làm tròn số, quý khách vui lòng chọn kích thước gần nhất với chiều dài bàn chân.</b></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Hướng dẫn chọn size -->
    <div class="modal fade" id="sizeGuideModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Hướng dẫn chọn size giày</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <p><b>Bước 1:</b> Đặt bàn chân lên giấy trắng, dùng bút vẽ bo hết bàn chân.</p>
            <img src="{{ asset('storage/sizeguide/size_step_01.jpg') }}" class="img-fluid mb-3" alt="Đo chiều dài">

            <p><b>Bước 2:</b> Dùng thước hoặc dây đo vòng khớp ngón chân rộng nhất.</p>
            <img src="{{ asset('storage/sizeguide/size_step_02.png') }}" class="img-fluid mb-3" alt="Đo vòng khớp ngón">

            <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                <tr>
                    <th>SIZE</th>
                    <th>Chiều dài (cm)</th>
                    <th>Vòng khớp ngón (Ngồi, cm)</th>
                    <th>Vòng khớp ngón (Đứng, cm)</th>
                </tr>
                </thead>
                <tbody>
                <tr><td>34</td><td>21.2</td><td>20.45</td><td>20.65</td></tr>
                <tr><td>35</td><td>21.9</td><td>20.95</td><td>21.15</td></tr>
                <tr><td>36</td><td>22.5</td><td>21.4</td><td>21.6</td></tr>
                <tr><td>37</td><td>23.2</td><td>21.9</td><td>22.1</td></tr>
                <tr><td>38</td><td>23.9</td><td>22.4</td><td>22.6</td></tr>
                <tr><td>39</td><td>24.5</td><td>22.85</td><td>23.05</td></tr>
                <tr><td>40</td><td>25.2</td><td>23.35</td><td>23.55</td></tr>
                </tbody>
            </table>
            </div>
            <p><b>Nếu có sự khác biệt về chiều dài của hai bàn chân, quý khách nên chọn cỡ giày ứng với chiều dài bàn chân lớn hơn.</b></p>
            <p><b>Bảng quy đổi kích thước không áp dụng làm tròn số, quý khách vui lòng chọn kích thước gần nhất với chiều dài bàn chân.</b></p>
        </div>
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
                this.style.outline = '2px solid #e75480';
                let selectedColor = this.dataset.color;
                document.getElementById('selected-color').value = selectedColor;
                document.getElementById('color-code').innerText = selectedColor;
            });
        });
        // chọn size
        document.querySelectorAll('.size-option').forEach(el => {
            el.addEventListener('click', function() {
                document.querySelectorAll('.size-option').forEach(e => e.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('selected-size').value = this.dataset.size;
                this.style.borderColor = '#e75480';
            });
        });
        // chọn material
        document.querySelectorAll('.material-option').forEach(el => {
            el.addEventListener('click', function() {
                document.querySelectorAll('.material-option').forEach(e => e.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('selected-material').value = this.dataset.material;
                this.style.borderColor = '#e75480';
            });
        });
    });
</script>

<style>
.color-circle.selected, .color-circle:hover {
    outline: 2px solid #e75480 !important;
    box-shadow: 0 0 0 2px #fff, 0 0 0 4px #e75480;
}
.size-option.active, .size-option:hover,
.material-option.active, .material-option:hover {
    border: 2px solid #e75480 !important;
    color: #e75480;
    font-weight: 600;
    background: #fff;
}
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
.btn, .btn-outline-danger, .btn-outline-dark, .btn-outline-secondary {
    border-radius: 8px !important;
    font-weight: 600;
}
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
.review-card {
    transition: box-shadow 0.2s;
}
.review-card:hover {
    box-shadow: 0 6px 24px rgba(231,84,128,0.08);
    border-color: #e75480;
}
</style>
@endsection