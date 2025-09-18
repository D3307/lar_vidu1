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
                                <a href="{{ route('customer.products', $product->id) }}">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : '/images/no-image.png' }}" alt="{{ $product->name }}" style="width:70px; height:70px; object-fit:cover; border-radius:8px;">
                                </a>
                                <div>
                                    <a href="{{ route('customer.products', $product->id) }}" class="fw-bold text-dark" style="text-decoration:none;">
                                        {{ $product->name }}
                                    </a>
                                </div>
                            </div>
                        </td>
                        <!-- Giá -->
                        <td>
                            <span class="text-danger fw-bold">{{ number_format($product->price, 0, ',', '.') }} đ</span>
                        </td>
                        <!-- Trạng thái -->
                        <td>
                            @if($product->quantity > 0)
                                <span class="text-success">Còn hàng</span>
                            @else
                                <span class="text-danger">Hết hàng</span>
                            @endif
                        </td>
                        <!-- Nút Add to cart -->
                        <td>
                            @if($product->quantity > 0)
                                <a href="{{ route('customer.product_detail', $product->id) }}" class="btn btn-dark btn-sm">
                                    ADD TO CART
                                </a>
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