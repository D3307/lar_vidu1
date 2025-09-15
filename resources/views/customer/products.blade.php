@extends('layouts.app')

@section('title', isset($category) ? $category : 'Danh sách sản phẩm')

@section('content')
<div class="container py-4" style="max-width: 1200px; display: flex; gap: 20px;">
    
    <!-- Sidebar danh mục -->
    <div style="width: 180px; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.08); align-self: flex-start;">
        <h3 style="font-size: 1.2rem; margin-bottom: 0.8rem; display: flex; align-items: center; color: #333; font-weight: 700; border-bottom: 1px solid #e0e0e0; padding-bottom: 8px;">
            <i class="fa-solid fa-list" style="margin-right: 10px; color: #000000;"></i> 
            Danh mục
        </h3>
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="margin: 10px 0;">
                <a href="{{ route('customer.products') }}" 
                style="text-decoration: none; color: {{ !isset($category) ? '#ff6b88' : '#333' }}; font-weight: {{ !isset($category) ? '600' : 'normal' }}; transition: color 0.3s;">
                    Tất cả sản phẩm
                </a>
            </li>
            @foreach($categories as $cat)
                <li style="margin: 10px 0;">
                    <a href="{{ route('customer.products.category', $cat->id) }}"
                    style="text-decoration: none; color: {{ (isset($category) && $category->id == $cat->id) ? '#ff6b88' : '#333' }}; font-weight: {{ (isset($category) && $category->id == $cat->id) ? '600' : 'normal' }}; transition: color 0.3s;">
                        {{ $cat->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Danh sách sản phẩm -->
    <div style="flex: 1; padding-left: 20px;">
        <h1 class="mb-4" style="font-weight: 600;">
            {{ isset($category) ? $category->name : 'Tất cả sản phẩm' }}
        </h1>

        @if($products->count() > 0)
            <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
                @foreach($products as $product)
                    <div class="product-card" style="background: white; border-radius: 8px; overflow: hidden;">
                        <a href="{{ route('customer.product_detail', $product->id) }}">
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 320px; object-fit: cover;">
                        </a>
                        <div style="padding: 12px;">
                            <h3 style="margin: 0 0 8px 0; font-size: 1rem; font-weight: 500;">
                                <a href="{{ route('customer.product_detail', $product->id) }}" style="color: #333; text-decoration: none;">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            <!-- Giá và sao trên cùng 1 dòng -->
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <p style="margin: 0; color: #d70018; font-weight: 600;">
                                    {{ number_format($product->price, 0, ',', '.') }} ₫
                                </p>

                                <div>
                                    @php
                                        $averageRating = $product->reviews->avg('rating') ?? 5;
                                        $averageRating = round($averageRating); 
                                    @endphp

                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $averageRating)
                                            <i class="fa-solid fa-star" style="color:#d70018;"></i>
                                        @else
                                            <i class="fa-regular fa-star" style="color:#d70018;"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>

                            <!-- Thông báo hết hàng -->
                            @if($product->quantity == 0)
                                <p style="margin-top: 8px; color: #888; font-size: 0.9rem; font-weight: 500;">
                                    <i class="fa-solid fa-triangle-exclamation" style="color:#ff6b88; margin-right: 6px;"></i>
                                    Sản phẩm này hiện đã hết hàng
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>Không có sản phẩm nào</p>
        @endif

        <div style="margin-top: 30px;">
            {{ $products->links('vendor.pagination.bootstrap-4') }}

            <style>
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
                    color: #ff6b88;
                    background: #fff;
                    transition: all 0.2s ease;
                }

                .pagination li a:hover {
                    background: #ffebf0;
                    color: #ff3b67;
                    border-color: #ffb2c1;
                }

                .pagination li.active span {
                    background: #ff6b88;
                    border-color: #ff6b88;
                    color: #fff;
                }

                .pagination li.disabled span {
                    color: #ccc;
                    background: #f9f9f9;
                    border-color: #eee;
                    cursor: not-allowed;
                }
            </style>
        </div>
    </div>
</div>
@endsection