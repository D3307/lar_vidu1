@extends('layouts.app')

@section('title', 'Danh sách yêu thích')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center" style="color:#e75480;font-weight:700">Sản phẩm yêu thích</h2>
    @if($wishlists->isEmpty())
        <div class="alert alert-info text-center">Bạn chưa có sản phẩm yêu thích nào.</div>
    @else
        <div class="row">
            @foreach($wishlists as $wishlist)
                @php $product = $wishlist->product; @endphp
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <a href="{{ route('products.show', $product->id) }}">
                            <img src="{{ $product->image_url ?? '/images/no-image.png' }}" class="card-img-top" alt="{{ $product->name }}">
                        </a>
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-danger">{{ number_format($product->price, 0, ',', '.') }} đ</p>
                            <form action="{{ route('wishlist.remove', $product->id) }}" method="POST" onsubmit="return confirm('Xóa sản phẩm này khỏi yêu thích?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> Xóa</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection