@extends('layouts.app')

@section('title', 'Kết quả tìm kiếm')

@section('content')
<div class="container">
    <h2 style="color:#7a2f3b; font-weight:600; margin-bottom:20px; font-size:1.7rem;">
        Kết quả tìm kiếm cho: "{{ $keyword }}"
    </h2>

    @if($products->isEmpty())
        <p style="color:#555;">Không tìm thấy sản phẩm nào.</p>
    @else
        <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
            @foreach($products as $product)
                <div class="product-card" style="border:1px solid #eee; border-radius:10px; overflow:hidden; background:#fff; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width:100%; height:300px; object-fit:cover;">
                    <div class="product-info" style="padding:15px;">
                        <h3 style="font-size:1rem; color:#7a2f3b; font-weight:600; min-height:50px;">
                            {{ $product->name }}
                        </h3>
                        <p style="color:#444; margin:5px 0 15px; font-weight:500;">
                            {{ number_format($product->price, 0, ',', '.') }} VNĐ
                        </p>
                        <a href="{{ route('customer.product_detail', $product->id) }}" 
                           class="btn"
                           style="background:#7a2f3b; color:#fff; font-size:0.9rem; padding:8px 14px; border-radius:6px; text-decoration:none;">
                           Xem chi tiết
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection