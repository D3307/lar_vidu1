@extends('admin.layout')

@section('title','Chỉnh sửa danh mục')

@section('content')
<div class="admin-card">
    @if ($errors->any())
        <div style="color:#c03651;margin-bottom:12px">
            <ul style="margin:0;padding-left:18px">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" style="max-width:600px;margin:auto">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Tên danh mục</label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea name="description" id="description" rows="4">{{ old('description', $category->description) }}</textarea>
        </div>

        <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:18px">
            <a href="{{ route('admin.categories.index') }}" class="btn-cancel">⬅ Hủy</a>
            <button type="submit" class="btn-save">💾 Lưu</button>
        </div>
    </form>
</div>

<style>
    .form-group {
        margin-bottom:14px;
        display:flex;
        flex-direction:column;
    }
    .form-group label {
        font-weight:600;
        margin-bottom:6px;
        color:#4b3a3f;
    }
    .form-group input,
    .form-group textarea {
        padding:8px 10px;
        border:1px solid #ccc;
        border-radius:8px;
        font-size:0.95rem;
    }
    .form-group input:focus,
    .form-group textarea:focus {
        border-color:#d64571;
        outline:none;
        box-shadow:0 0 0 2px rgba(214,69,113,0.2);
    }

    .btn-save {
        background:#f0d4db;
        color:#7a2f3b;
        padding:8px 16px;
        border:none;
        border-radius:8px;
        font-weight:600;
        cursor:pointer;
        transition:all .2s;
    }
    .btn-save:hover { background:#d64571; color:#fff; }

    .btn-cancel {
        background:#eee;
        color:#333;
        padding:8px 16px;
        border-radius:8px;
        text-decoration:none;
        font-weight:600;
        transition:all .2s;
    }
    .btn-cancel:hover { background:#ddd; }
</style>
@endsection
