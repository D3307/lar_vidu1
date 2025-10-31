@extends('layouts.app')

@section('title', 'Đánh giá đơn hàng #' . $order->id)

@section('content')
<div class="container py-5">
    <h3 class="mb-4" style="color:#e75480">Đánh giá đơn hàng #{{ $order->id }}</h3>

    <form action="{{ route('reviews.store', $order->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        @foreach($items as $item)
            <div class="review-item">
                <div class="product-info">
                    <!-- ✅ Hiển thị ảnh sản phẩm -->
                    @php
                        $productFolder = storage_path('app/public/products/' . $item->product->name);
                        $productImage = 'default.jpg';
                        if (is_dir($productFolder)) {
                            $files = glob($productFolder . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
                            if (!empty($files)) {
                                $productImage = 'products/' . $item->product->name . '/' . basename($files[0]);
                            }
                        }
                    @endphp

                    <img src="{{ asset('storage/' . $productImage) }}" 
                        alt="{{ $item->product->name }}" 
                        class="product-img">

                    <div>
                        <h5>{{ $item->product->name }}</h5>

                        <!-- ✅ Hiển thị màu có ô tròn -->
                        @if($item->color)
                            <small>
                                Màu: 
                                <span class="color-circle" style="background-color: {{ $item->color }}"></span>
                                {{ $item->color }}
                            </small><br>
                        @endif

                        @if($item->size)
                            <small>Size: {{ $item->size }}</small>
                        @endif
                    </div>
                </div>

                <!-- Đánh giá sao -->
                <div class="rating-block">
                    <label>Số sao:</label>
                    <div class="star-rating" data-product="{{ $item->product_id }}">
                        @for($i=1;$i<=5;$i++)
                            <span class="star" data-value="{{ $i }}">★</span>
                        @endfor
                        <input type="hidden" name="reviews[{{ $item->product_id }}][rating]" value="0">
                    </div>
                </div>

                <!-- Bình luận -->
                <div class="comment-block">
                    <label for="comment">Bình luận:</label>
                    <textarea name="reviews[{{ $item->product_id }}][comment]" class="form-control" rows="3" placeholder="Hãy chia sẻ cảm nhận về sản phẩm..."></textarea>
                </div>

                <!-- ✅ Upload ảnh & video -->
                <div class="media-upload mt-3">
                    <label>Thêm ảnh hoặc video (tuỳ chọn):</label>
                    <input type="file" name="reviews[{{ $item->product_id }}][media][]" multiple accept="image/*,video/*" class="form-control">
                </div>
            </div>
        @endforeach

        <div class="text-end mt-4">
            <a href="{{ route('orders.show', $order->id) }}" class="btn" style="background:#f6e8ea;color:#7a2130;border:1px solid #e8cbd2;">‹ Hủy đánh giá</a>
            <button type="submit" class="btn-submit">Gửi đánh giá</button>
        </div>
    </form>
</div>

<style>
.review-item {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.05);
    padding: 20px;
    margin-bottom: 24px;
    transition: transform .2s ease;
}
.review-item:hover { transform: translateY(-2px); }

.product-info {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 12px;
}
.product-img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #eee;
}

/* ✅ Ô tròn hiển thị màu */
.color-circle {
    display: inline-block;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    margin-right: 6px;
    border: 1px solid #bbb;
    vertical-align: middle;
    box-shadow: 0 0 2px rgba(0,0,0,0.2);
}

.star-rating {
    font-size: 26px;
    color: #ddd;
    cursor: pointer;
}
.star.selected, .star.hover { color: #e75480; }

.rating-block { margin: 10px 0; }

.comment-block textarea {
    border-radius: 8px;
    border: 1px solid #ddd;
    padding: 8px;
    width: 100%;
}

.btn-submit {
    background: linear-gradient(135deg, #e75480, #ff9bb5);
    border: none;
    border-radius: 8px;
    padding: 10px 22px;
    font-weight: 600;
    color: #fff;
    font-size: 15px;
    transition: all .3s ease;
    box-shadow: 0 4px 12px rgba(231,84,128,0.3);
}
.btn-submit:hover {
    background: linear-gradient(135deg, #d43d6c, #ff7b9c);
    transform: translateY(-2px);
}
</style>

<script>
document.querySelectorAll('.star-rating').forEach(block => {
    const stars = block.querySelectorAll('.star');
    const input = block.querySelector('input[type="hidden"]');
    let selected = 0;

    stars.forEach(star => {
        star.addEventListener('mouseover', () => {
            const val = star.dataset.value;
            stars.forEach(s => s.classList.toggle('hover', s.dataset.value <= val));
        });
        star.addEventListener('mouseout', () => stars.forEach(s => s.classList.remove('hover')));
        star.addEventListener('click', () => {
            selected = star.dataset.value;
            input.value = selected;
            stars.forEach(s => s.classList.toggle('selected', s.dataset.value <= selected));
        });
    });
});
</script>
@endsection