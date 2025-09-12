@extends('admin.layout')

@section('title','Tạo sản phẩm')

@section('content')

    @if ($errors->any())
        <div style="color:#c03651;margin-bottom:8px">
            <ul style="margin:0;padding-left:18px">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="shadow p-4 bg-white rounded">
        @csrf

        <div style="margin-bottom:8px">
            <label>Tên</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required style="width:100%;padding:8px;border-radius:6px">
        </div>

        <div style="display:flex;gap:12px">
            <div style="flex:1">
                <label>Giá</label><br>
                <input type="text" name="price" value="{{ old('price') }}" style="width:100%;padding:8px;border-radius:6px">
            </div>
            <div style="width:140px">
                <label>Số lượng</label><br>
                <input type="number" name="quantity" value="{{ old('quantity',0) }}" min="0" style="width:100%;padding:8px;border-radius:6px">
            </div>
            <div style="width:140px">
                <label>Size</label><br>
                <input type="text" name="size" value="{{ old('size') }}" style="width:100%;padding:8px;border-radius:6px" placeholder="VD: 36, S, M">
            </div>
        </div>

        <div style="display:flex;gap:12px;margin-top:8px">
            <div style="flex:1">
                <label>Chất liệu</label><br>
                <input type="text" name="material" value="{{ old('material') }}" style="width:100%;padding:8px;border-radius:6px" placeholder="Ví dụ: Da tổng hợp">
            </div>
            <div style="width:200px">
                <label>Màu sắc</label><br>
                <input type="text" name="color" value="{{ old('color') }}" style="width:100%;padding:8px;border-radius:6px" placeholder="Ví dụ: Đỏ, Đen">
            </div>
        </div>

        <div style="margin-top:8px">
            <label>Danh mục</label><br>
            <select name="category_id" required style="width:100%;padding:8px;border-radius:6px">
                <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>-- Chọn danh mục --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @if(old('category_id') == $cat->id) selected @endif>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-top:8px">
            <label>Ảnh sản phẩm</label><br>
            <input type="file" name="image" accept="image/*">
        </div>

        <div style="margin-top:8px">
            <label>Mô tả</label><br>
            <textarea name="description" rows="4" style="width:100%;padding:8px;border-radius:6px">{{ old('description') }}</textarea>
        </div>

        <div style="margin-top:16px;display:flex;gap:10px;">
            <button type="submit" class="btn btn-outline" style="background:#f0d4db;color:#7a2f3b;font-weight:600;">➕ Tạo</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline" style="background:#eee;color:#7a2f3b;font-weight:600;">⬅ Hủy</a>
        </div>
    </form>

    <style>
        .btn.btn-outline {
            background:#f0d4db;
            color:#7a2f3b;
            padding:8px 16px;
            border:none;
            border-radius:8px;
            font-weight:600;
            cursor:pointer;
            transition:all .2s;
        }
    </style>
@endsection
