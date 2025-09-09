@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    <!-- Thông báo thêm thành công -->
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
            }, 3000); // 3 giây
        </script>
    @endif

    <div class="row g-4">

        {{-- Ảnh sản phẩm --}}
        <div class="col-md-6 text-center">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" 
                     alt="{{ $product->name }}" 
                     class="img-fluid rounded shadow"
                     style="max-height: 400px; object-fit: contain;">
            @else
                <img src="https://via.placeholder.com/400x400?text=No+Image" 
                     alt="No Image" 
                     class="img-fluid rounded shadow">
            @endif
        </div>

        {{-- Thông tin sản phẩm --}}
        <div class="col-md-6">
            <h2 class="fw-bold" style="color: var(--primary)">{{ $product->name }}</h2>
            <p class="text-muted mb-2">Danh mục: {{ $product->category->name ?? 'Chưa phân loại' }}</p>
            <h4 class="fw-bold mb-3" style="color: var(--btn-primary)">
                {{ number_format($product->price, 0, ',', '.') }} đ
            </h4>

            <p class="mb-4">{{ $product->description }}</p>

            {{-- Form thêm vào giỏ hàng --}}
            <form action="{{ route('cart.add', $product->id) }}" method="POST" id="add-to-cart-form" class="d-flex flex-column gap-3">
                @csrf

                {{-- Size (ô vuông) --}}
                <div class="mb-3">
                    <h6>Kích thước</h6>
                    <div class="d-flex gap-2">
                        @foreach($sizes as $size)
                            <div class="border p-2 text-center size-option"
                                style="width:40px;cursor:pointer;border-radius:6px;"
                                data-size="{{ trim($size) }}">
                                {{ trim($size) }}
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="size" id="selected-size">
                    @error('size') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- Color (hình tròn) --}}
                <div class="mb-3">
                    <h6>Màu sắc</h6>
                    <div class="d-flex gap-2">
                        @foreach($colors as $color)
                            <div class="color-circle"
                                style="width:30px;height:30px;border-radius:50%;border:1px solid #ccc;cursor:pointer;background: {{ trim($color) }};"
                                title="{{ trim($color) }}"
                                data-color="{{ trim($color) }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-2">Mã màu: <span id="color-code">Chưa chọn</span></div>
                    <input type="hidden" name="color" id="selected-color">
                    @error('color') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- Material (pill bo tròn) --}}
                <div class="mb-3">
                    <h6>Chất liệu</h6>
                    <div class="d-flex gap-2">
                        @foreach($materials as $material)
                            <div class="px-3 py-1 border rounded-pill material-option"
                                style="cursor:pointer"
                                data-material="{{ trim($material) }}">
                                {{ trim($material) }}
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" name="material" id="selected-material">
                    @error('material') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- Số lượng --}}
                <div class="mb-3">
                    <h6>Số lượng</h6>
                    <input type="number" name="quantity" value="1" min="1" class="form-control" style="width:100px;">
                    @error('quantity') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                {{-- Nút thêm giỏ hàng + mua ngay --}}
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="price" value="{{ $product->price }}">

                <div class="d-flex gap-2">
                    {{-- Thêm vào giỏ --}}
                    <button type="submit" class="btn"
                            style="background: var(--btn-primary); color: var(--btn-primary-text); border:none;">
                        <i class="fa fa-cart-plus me-2"></i> Thêm vào giỏ
                    </button>

                    {{-- Mua ngay --}}
                    <button type="submit" class="btn btn-success"
                            formaction="{{ route('buy.now', $product->id) }}">
                        <i class="fa fa-bolt me-2"></i> Mua ngay
                    </button>
                </div>
            </form>
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
                document.getElementById('color-code').innerText = selectedColor; // hiển thị mã hex
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

        // chọn material
        document.querySelectorAll('.material-option').forEach(el => {
            el.addEventListener('click', function() {
                document.querySelectorAll('.material-option').forEach(e => e.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('selected-material').value = this.dataset.material;
            });
        });
    });
</script>
@endsection
