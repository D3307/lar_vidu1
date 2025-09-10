@extends('admin.layout')

@section('title', 'Chỉnh sửa tồn kho')

@section('content')
<div class="admin-card">
    <h3 style="margin-bottom:16px;font-size:1.1rem;color:#4b3a3f">
        Chỉnh sửa tồn kho - {{ $inventory->product->name ?? 'Sản phẩm' }}
    </h3>

    <form action="{{ route('admin.inventories.update', $inventory->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div style="margin-bottom:16px">
            <label for="quantity" style="display:block;margin-bottom:6px;font-weight:500;color:#333">
                Số lượng tồn
            </label>
            <input type="number" id="quantity" name="quantity"
                   value="{{ old('quantity', $inventory->quantity) }}"
                   class="form-control"
                   style="width:200px;padding:8px 10px;border:1px solid #ddd;border-radius:8px;">
        </div>

        <div style="margin-top:20px">
            <button type="submit" class="btn-submit">Cập nhật</button>
            <a href="{{ route('admin.inventories.index') }}" class="btn-cancel">Hủy</a>
        </div>
    </form>
</div>

<style>
    .btn-submit {
        background:#7a2f3b;
        color:#fff;
        border:none;
        padding:8px 14px;
        border-radius:8px;
        font-size:0.9rem;
        cursor:pointer;
        transition:background .2s;
    }
    .btn-submit:hover { background:#5a222c; }

    .btn-cancel {
        margin-left:8px;
        color:#333;
        text-decoration:none;
        padding:8px 14px;
        border:1px solid #ddd;
        border-radius:8px;
        font-size:0.9rem;
        transition:background .2s;
    }
    .btn-cancel:hover { background:#f5f5f5; }
</style>
@endsection