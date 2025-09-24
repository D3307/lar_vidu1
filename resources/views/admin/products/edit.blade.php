@extends('admin.layout')

@section('title','Chỉnh sửa sản phẩm')

@section('content')
    <div class="container">

        @if ($errors->any())
            <div style="color:#c03651;margin-bottom:8px">
                <ul style="margin:0;padding-left:18px">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="shadow p-4 bg-white rounded">
            @csrf
            @method('PUT')

            <div style="margin-bottom:8px">
                <label>Tên</label><br>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required style="width:100%;padding:8px;border-radius:6px">
            </div>

            <div style="display:flex;gap:12px">
                <div style="flex:1">
                    <label>Giá</label><br>
                    <input type="text" name="price" value="{{ old('price', $product->price) }}" style="width:100%;padding:8px;border-radius:6px">
                </div>
                <div style="flex:1">
                    <label>Chất liệu</label><br>
                    <input type="text" name="material" value="{{ old('material', $product->material) }}" style="width:100%;padding:8px;border-radius:6px" placeholder="Ví dụ: Da tổng hợp">
                </div>
            </div>

            <div style="margin-top:8px">
                <label>Ảnh hiện tại</label><br>
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="Ảnh" style="height:80px;border-radius:6px"><br><br>
                @else
                    <p class="muted">Chưa có ảnh</p>
                @endif
                <label>Thay ảnh</label><br>
                <input type="file" name="image" accept="image/*">
            </div>

            <div style="margin-top:8px">
                <label>Danh mục</label><br>
                <select name="category_id" style="width:100%;padding:8px;border-radius:6px">
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @if(old('category_id', $product->category_id) == $cat->id) selected @endif>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-top:16px;display:flex;gap:10px;">
                <button type="submit" class="btn btn-outline" style="background:#f0d4db;color:#7a2f3b;font-weight:600;">💾 Lưu</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline" style="background:#eee;color:#7a2f3b;font-weight:600;">⬅ Quay lại</a>
            </div>
        </form>
    </div>

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
