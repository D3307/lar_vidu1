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

        <!-- Bộ lọc và sắp xếp -->
        <div class="filter-sort-bar mb-4">
            <form method="GET" action="{{ route('customer.products') }}" class="filter-form">
                <!-- Lọc giá -->
                <input type="number" name="min_price" placeholder="Giá từ" value="{{ request('min_price') }}">
                <input type="number" name="max_price" placeholder="Đến" value="{{ request('max_price') }}">

                <!-- Nút lọc -->
                <button type="submit">
                    <i class="fa fa-filter"></i> Lọc
                </button>
            </form>

            <form method="GET" action="{{ route('customer.products') }}" class="sort-form">
                <select name="sort" onchange="this.form.submit()">
                    <option value="">-- Sắp xếp --</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên A → Z</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên Z → A</option>
                </select>
            </form>
        </div>

        @if($products->count() > 0)
            <div class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px;">
                @foreach($products as $product)
                    <div class="product-card" style="position: relative; background: white; border-radius: 8px; overflow: hidden;">
                        @if ($product->coupon)
                            <div style="
                                position: absolute;
                                top: 8px;
                                left: 8px;
                                background: #ff3b67;
                                color: #fff;
                                font-weight: 600;
                                font-size: 0.8rem;
                                padding: 5px 10px;
                                border-radius: 8px;
                                z-index: 10;
                                box-shadow: 0 2px 6px rgba(0,0,0,0.15);
                            ">
                                @if($product->coupon->discount_type === 'percent')
                                    -{{ $product->coupon->discount }}%
                                @else
                                    -{{ number_format($product->coupon->discount, 0, ',', '.') }} ₫
                                @endif
                            </div>
                        @endif

                        <a href="{{ route('customer.product_detail', $product->id) }}">
                            @if ($product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                    alt="{{ $product->name }}" 
                                    style="width: 100%; height: 320px; object-fit: cover;">
                            @else
                                <div style="width: 100%; height: 320px; background: #f7f7f7; display: flex; align-items: center; justify-content: center; color: #888;">
                                    Không có ảnh
                                </div>
                            @endif
                        </a>
                        <div style="padding: 12px;">
                            <h3 style="margin: 0 0 8px 0; font-size: 1rem; font-weight: 500;">
                                <a href="{{ route('customer.product_detail', $product->id) }}" style="color: #333; text-decoration: none;">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            <!-- Giá và sao trên cùng 1 dòng -->
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    @php
                                        $discountedPrice = $product->price;
                                        if ($product->coupon) {
                                            $coupon = $product->coupon;
                                            if ($coupon->discount_type === 'percent') {
                                                $discountedPrice -= $product->price * ($coupon->discount / 100);
                                            } else {
                                                $discountedPrice -= $coupon->discount;
                                            }
                                            if ($discountedPrice < 0) $discountedPrice = 0; // tránh âm giá
                                        }
                                    @endphp

                                    @if($product->coupon)
                                        <p style="margin: 0; color: #d70018; font-weight: 700; font-size: 1rem;">
                                            {{ number_format($discountedPrice, 0, ',', '.') }} ₫
                                            <span style="text-decoration: line-through; color: #888; font-size: 0.8rem; margin-left: 6px;">
                                                {{ number_format($product->price, 0, ',', '.') }} ₫
                                            </span>
                                        </p>
                                    @else
                                        <p style="margin: 0; color: #d70018; font-weight: 700;">
                                            {{ number_format($product->price, 0, ',', '.') }} ₫
                                        </p>
                                    @endif
                                </div>

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
                            @if($product->details->sum('quantity') == 0)
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
        </div>
    </div>
</div>

<script>
    // Lọc và sắp xếp sản phẩm bằng JavaScript
    const filterPrice = document.getElementById("filterPrice");
    const sortBy = document.getElementById("sortBy");
    const productList = document.getElementById("productList");
    const products = Array.from(productList.querySelectorAll(".product"));

    function renderProducts(filteredProducts) {
        productList.innerHTML = "";
        filteredProducts.forEach(p => productList.appendChild(p));
    }

    function applyFilterAndSort() {
        let filtered = [...products];

        // --- LỌC ---
        const priceFilter = filterPrice.value;
        if (priceFilter) {
            filtered = filtered.filter(p => {
                const price = parseInt(p.dataset.price);
                if (priceFilter === "0-500") return price < 500;
                if (priceFilter === "500-1000") return price >= 500 && price <= 1000;
                if (priceFilter === "1000+") return price > 1000;
                return true;
            });
        }

        // --- SẮP XẾP ---
        const sortValue = sortBy.value;
        if (sortValue === "price-asc") {
            filtered.sort((a, b) => a.dataset.price - b.dataset.price);
        } else if (sortValue === "price-desc") {
            filtered.sort((a, b) => b.dataset.price - a.dataset.price);
        }

        renderProducts(filtered);
    }

    // Gắn sự kiện
    filterPrice.addEventListener("change", applyFilterAndSort);
    sortBy.addEventListener("change", applyFilterAndSort);

    // Hiển thị mặc định
    applyFilterAndSort();
</script>

<style>
    .pagination li {display: inline-block;margin: 0 4px;}
    .pagination li a,
    .pagination li span {display: inline-block;padding: 8px 14px;border-radius: 8px;font-size: 0.95rem;font-weight: 600;text-decoration: none;border: 1px solid #ffd1dc;color: #ff6b88;background: #fff;transition: all 0.2s ease;}
    .pagination li a:hover {background: #ffebf0;color: #ff3b67;border-color: #ffb2c1;}
    .pagination li.active span {background: #ff6b88;border-color: #ff6b88;color: #fff;}
    .pagination li.disabled span {color: #ccc;background: #f9f9f9;border-color: #eee;cursor: not-allowed;}
    .filter-sort-bar {display: flex;justify-content: space-between;align-items: center;gap: 15px;padding: 15px 20px;background: #fff;border-radius: 10px;box-shadow: 0 4px 12px rgba(0,0,0,0.08);flex-wrap: wrap;}
    .filter-form {display: flex;gap: 10px;align-items: center;}
    .filter-form input {width: 120px;padding: 8px 10px;border: 1px solid #ffd1dc;border-radius: 6px;font-size: 0.95rem;transition: 0.2s;}
    .filter-form input:focus {outline: none;border-color: #ff6b88;box-shadow: 0 0 0 2px rgba(255,107,136,0.15);}
    .filter-form button {background: #ff6b88;color: #fff;border: none;padding: 8px 14px;border-radius: 6px;font-weight: 600;font-size: 0.9rem;cursor: pointer;transition: 0.2s;}
    .filter-form button:hover {background: #ff3b67;}
    .sort-form select {padding: 8px 12px;border-radius: 6px;border: 1px solid #ffd1dc;font-size: 0.95rem;cursor: pointer;transition: 0.2s;}
    .sort-form select:focus {outline: none;border-color: #ff6b88;box-shadow: 0 0 0 2px rgba(255,107,136,0.15);}
</style>
@endsection