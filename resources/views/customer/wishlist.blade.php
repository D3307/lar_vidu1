@extends('layouts.app')

@section('title', 'Danh sách yêu thích')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center" style="color:#e75480;font-weight:700">Sản phẩm yêu thích</h2>
    @if($wishlists->isEmpty())
        <div class="alert alert-info text-center">Bạn chưa có sản phẩm yêu thích nào.</div>
    @else
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th></th>
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Chi tiết</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wishlists as $wishlist)
                        @php $product = $wishlist->product; @endphp
                        <tr>
                            <!-- Xóa -->
                            <td>
                                <form action="{{ route('wishlist.remove', $product->id) }}" method="POST" onsubmit="return confirm('Xóa sản phẩm này khỏi yêu thích?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-link text-danger p-0" title="Xóa khỏi yêu thích">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </form>
                            </td>

                            <!-- Ảnh và tên -->
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if ($product->images->isNotEmpty())
                                        <a href="{{ route('customer.products', $product->id) }}">
                                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                                alt="{{ $product->name }}" 
                                                style="width:70px; height:70px; object-fit:cover; border-radius:8px;">
                                        </a>
                                    @else
                                        <a href="{{ route('customer.products', $product->id) }}">
                                            <img src="/images/no-image.png" 
                                                alt="{{ $product->name }}" 
                                                style="width:70px; height:70px; object-fit:cover; border-radius:8px;">
                                        </a>
                                    @endif
                                    <div>
                                        <a href="{{ route('customer.products', $product->id) }}" 
                                        class="fw-bold text-dark" 
                                        style="text-decoration:none;">
                                            {{ $product->name }}
                                        </a>
                                    </div>
                                </div>
                            </td>

                            <!-- Giá -->
                            <td>
                                <span class="text-danger fw-bold">{{ number_format($product->price, 0, ',', '.') }} đ</span>
                            </td>

                            <!-- Chi tiết: hiển thị những thuộc tính đã lưu trong wishlist (nếu có) -->
                            <td>
                                @php
                                    $wishColor = $wishlist->color ?? $wishlist->selected_color ?? null;
                                    $wishSize  = $wishlist->size  ?? $wishlist->selected_size  ?? null;
                                    $wishMaterial = $wishlist->material ?? $wishlist->selected_material ?? null;
                                @endphp

                                @if($wishColor || $wishSize || $wishMaterial)
                                    <div style="font-size: 0.95rem; color:#555;">
                                        @if($wishColor)
                                            <div style="display:flex; align-items:center; gap:6px;">
                                                <strong>Màu:</strong> 
                                                <span 
                                                    style="display:inline-block;
                                                        width:18px;
                                                        height:18px;
                                                        border:1px solid #ccc;
                                                        border-radius:4px;
                                                        background-color:{{ $wishColor }};
                                                        vertical-align:middle;">
                                                </span>
                                                <span style="font-size:0.9rem; color:#555;">
                                                    {{ $wishColor }}
                                                </span>
                                            </div>
                                        @endif
                                        @if($wishSize)
                                            <div><strong>Size:</strong> {{ $wishSize }}</div>
                                        @endif
                                        @if($wishMaterial)
                                            <div><strong>Chất liệu:</strong> {{ $wishMaterial }}</div>
                                        @endif
                                    </div>
                                @else
                                    <a href="{{ route('customer.product_detail', $product->id) }}" class="btn btn-outline-secondary btn-sm">
                                        Chọn thuộc tính
                                    </a>
                                @endif
                            </td>

                            <!-- Trạng thái -->
                            @php
                                $wishColor = $wishlist->color ?? null;
                                $wishSize  = $wishlist->size ?? null;
                                $wishMaterial = $wishlist->material ?? null;

                                $detail = null;
                                $detailQuantity = 0;

                                if ($wishColor && $wishSize) {
                                    $detail = \App\Models\ProductDetail::where('product_id', $product->id)
                                                ->where('color', $wishColor)
                                                ->where('size', $wishSize)
                                                ->first();
                                    $detailQuantity = $detail?->quantity ?? 0;
                                }
                            @endphp
                            <td>
                                @if($detail && $detailQuantity > 0)
                                    <span class="text-success">Còn hàng ({{ $detailQuantity }})</span>
                                @else
                                    <span class="text-danger">Hết hàng</span>
                                @endif
                            </td>


                            <!-- Nút Add to cart: submit POST kèm các thuộc tính (nếu đã lưu) -->
                            <td>
                                @if(($detail && $detailQuantity > 0) || $product->quantity > 0)
                                    @if($wishColor && $wishSize && $wishMaterial)
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <input type="hidden" name="color" value="{{ $wishColor }}">
                                            <input type="hidden" name="size" value="{{ $wishSize }}">
                                            <input type="hidden" name="material" value="{{ $wishMaterial }}">
                                            <input type="hidden" name="quantity" value="1"> {{-- Mặc định 1 --}}
                                            <button type="submit" class="btn btn-dark btn-sm" style="background-color:#e75480; border: #e75480;">
                                                Thêm vào giỏ
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('customer.product_detail', $product->id) }}" class="btn btn-outline-secondary btn-sm">
                                            Chọn thuộc tính
                                        </a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection