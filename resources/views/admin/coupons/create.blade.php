@extends('admin.layout')

@section('title', 'Thêm mã khuyến mãi')

@section('content')
<div class="admin-card">
    <form action="{{ route('admin.coupons.store') }}" method="POST" class="styled-form">
        @csrf

        {{-- Mã khuyến mãi --}}
        <div class="form-group">
            <label for="code">Mã khuyến mãi</label>
            <input type="text" name="code" id="code" value="{{ old('code') }}" required>
        </div>

        {{-- Loại giảm --}}
        <div class="form-group">
            <label for="discount_type">Loại giảm</label>
            <select name="discount_type" id="discount_type" required>
                <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>Phần trăm (%)</option>
                <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Giảm cố định (VNĐ)</option>
            </select>
        </div>

        {{-- Giá trị giảm --}}
        <div class="form-group">
            <label for="discount">Giá trị giảm</label>
            <input type="number" name="discount" id="discount" value="{{ old('discount') }}" required>
        </div>

        {{-- Phạm vi áp dụng --}}
        <div class="form-group">
            <label for="scope">Áp dụng cho</label>
            <select name="scope" id="scope" required onchange="toggleProductSelect()">
                <option value="order" {{ old('scope') == 'order' ? 'selected' : '' }}>Toàn đơn hàng</option>
                <option value="product" {{ old('scope') == 'product' ? 'selected' : '' }}>Sản phẩm cụ thể</option>
            </select>
        </div>

        {{-- Sản phẩm áp dụng --}}
        <div class="form-group" id="product_select_box" style="display:none;">
            <label for="product_id">Sản phẩm áp dụng</label>
            <select name="product_id" id="product_id" class="select2" style="width: 100%;">
                <option value="">-- Chọn sản phẩm --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Giá trị đơn hàng tối thiểu --}}
        <div class="form-group">
            <label for="min_order_value">Giá trị đơn hàng tối thiểu</label>
            <input type="number" name="min_order_value" id="min_order_value" value="{{ old('min_order_value') }}">
        </div>

        {{-- Ngày bắt đầu & kết thúc --}}
        <div class="form-group">
            <label for="start_date">Ngày bắt đầu</label>
            <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required>
        </div>

        <div class="form-group">
            <label for="end_date">Ngày kết thúc</label>
            <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required>
        </div>

        {{-- Nút hành động --}}
        <div class="form-actions">
            <button type="submit" class="btn-add">Lưu</button>
            <a href="{{ route('admin.coupons.index') }}" class="btn-edit">Quay lại</a>
        </div>
    </form>
</div>

<style>
    .styled-form .form-group { margin-bottom:16px; }
    .styled-form label { display:block; margin-bottom:6px; font-weight:600; color:#7a2f3b; }
    .styled-form input, .styled-form select {width:100%; padding:10px; border:1px solid #ddd; border-radius:8px;font-size:0.95rem; transition:border-color .2s;}
    .styled-form input:focus, .styled-form select:focus {border-color:#c03651; outline:none;}
    .form-actions {margin-top: 20px; display: flex; gap: 12px;}
    .btn-add {background-color: #c03651; color: #fff; border: none;padding: 10px 18px; border-radius: 8px; cursor: pointer;font-weight: 600; transition: all 0.2s ease;}
    .btn-add:hover { background-color: #a72d44; transform: translateY(-1px); }
    .btn-edit {background-color: #fff; color: #c03651; border: 1px solid #c03651;padding: 10px 18px; border-radius: 8px; font-weight: 600;text-decoration: none; transition: all 0.2s ease;}
    .btn-edit:hover { background-color: #f9e6ea; color: #a72d44; transform: translateY(-1px); }
    .select2-container .select2-selection--single {height: 42px;border-radius: 8px;border: 1px solid #ddd;display: flex;align-items: center;padding-left: 8px;}
    .select2-selection__rendered {font-size: 0.95rem;color: #333;}
    .select2-selection__arrow {height: 60px;right: 30px;}
    .select2-container .select2-dropdown { border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.08); }
    .select2-container .select2-search--dropdown { padding: 8px; background-color: #fafafa; border-bottom: 1px solid #eee; }
    .select2-container .select2-search__field { width: 100%; padding: 8px 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 0.95rem; outline: none; }
    .select2-container .select2-search__field:focus { border-color: #c03651; box-shadow: 0 0 0 2px rgba(192, 54, 81, 0.15); }
    .select2-results__options { max-height: 240px; overflow-y: auto; }
    .select2-results__option { padding: 10px 12px; font-size: 0.95rem; transition: background-color 0.15s; color: #333; }
    .select2-results__option--highlighted { background-color: #f9e6ea !important; color: #a72d44 !important; font-weight: 600; }
    .select2-results__option[aria-selected="true"] { background-color: #c03651 !important; color: #fff !important; font-weight: 600; }
</style>

<script>
    function toggleProductSelect() {
        const scope = document.getElementById('scope').value;
        const box = document.getElementById('product_select_box');
        box.style.display = (scope === 'product') ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        toggleProductSelect();

        $('#product_id').select2({
            placeholder: "Tìm sản phẩm...",
            allowClear: true,
            language: {
                noResults: function () {
                    return "Không tìm thấy sản phẩm";
                }
            }
        });
    });
</script>
@endsection