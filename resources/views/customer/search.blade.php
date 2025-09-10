@extends('layouts.app') {{-- layout chính của bạn --}}

@section('title', 'Kết quả tìm kiếm')

@section('content')
<div class="container">
    <h2>Kết quả tìm kiếm cho: "{{ $keyword }}"</h2>

    @if($products->isEmpty())
        <p>Không tìm thấy sản phẩm nào.</p>
    @else
        <div class="product-grid">
            @foreach($products as $product)
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    <div class="product-info">
                        <h3>{{ $product->name }}</h3>
                        <p>{{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
                        <a href="{{ route('customer.product_detail', $product->id) }}" 
                           class="btn btn-sm btn-primary">Xem chi tiết</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection