@extends('admin.layout')

@section('title', 'Quản lý sản phẩm')

@section('content')
<div class="admin-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <h3 style="margin:0;font-size:1.1rem;color:#4b3a3f">Danh sách sản phẩm</h3>
        <div style="display:flex;gap:10px;align-items:center">
            <a href="{{ route('admin.products.create') }}" class="btn-add">+ Thêm sản phẩm</a>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="styled-table">
            <thead>
                <tr>
                    <th style="width: 20px;">STT</th>
                    <th style="width: 250px;">Tên sản phẩm</th>
                    <th style="width: 100px;">Danh mục</th>
                    <th style="width: 60px;">Giá</th>
                    <th style="width: 60px;">Số lượng</th>
                    <th style="width: 100px;">Màu sắc</th>
                    <th style="width: 70px;">Kích thước</th>
                    <th style="width: 100px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
                    <td>{{ $product->quantity }}</td>
                    <td>
                        @if($product->color)
                            @foreach(explode(',', $product->color) as $c)
                                <span class="color-circle" style="background-color: {{ trim($c) }};" 
                                    title="{{ trim($c) }}"></span>
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $product->size }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-action btn-edit">Sửa</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Xóa sản phẩm này?')" class="btn-action btn-delete">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;color:#999;padding:12px">Không có sản phẩm nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px;display:flex;justify-content:flex-end">
        {{ $products->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>

<style>
    .admin-card { background:#fff; padding:18px; border-radius:14px; box-shadow:0 4px 12px rgba(0,0,0,0.05);}
    .btn-add { background:#f0d4db; color:#7a2f3b; padding:8px 14px; border-radius:8px; border:1px solid #e8cbd2;
               text-decoration:none; font-size:0.95rem; transition:all .2s ease;}
    .btn-add:hover { background:#d64571; color:#fff;}
    .table-wrapper { overflow-x:auto; }
    .styled-table { width:100%; border-collapse:separate; border-spacing:0;
                    border:1px solid rgba(0,0,0,0.06); border-radius:10px; overflow:hidden;}
    .styled-table th { background:#f9f3f3; color:#7a2f3b; font-weight:600; text-align:left;
                       padding:10px 12px; font-size:0.95rem;}
    .styled-table td { padding:10px 12px; border-top:1px solid rgba(0,0,0,0.05); font-size:0.95rem; color:#333;}
    .color-circle {
        display: inline-block;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 1px solid #ccc;
        margin-right: 4px;
        vertical-align: middle;
    }
    .btn-action { border:none; background:transparent; padding:6px 10px; border-radius:6px;
                  font-size:0.85rem; cursor:pointer; text-decoration:none; margin-right:4px; transition:background .2s;}
    .btn-edit { color:#7a2f3b; border:1px solid rgba(122,47,59,0.3);}
    .btn-edit:hover { background:#f9f3f3;}
    .btn-delete { color:#fff; background:#d9534f; border:1px solid #c9302c;}
    .btn-delete:hover { background:#c9302c;}
    .pagination {
        display: flex;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin: 0;
        align-items: center;
    }
    .pagination li { display: inline-block; }
    .pagination li a,
    .pagination li span {
        display: inline-block;
        padding: 6px 10px;
        min-width: 40px;
        text-align: center;
        border-radius: 8px;
        background: #fff;
        color: #333;
        border: 1px solid #eee;
        font-size: 14px;
        line-height: 1;
        box-sizing: border-box;
        white-space: nowrap;
    }
    .pagination li a:hover { background: rgba(231,84,128,0.06); }
    .pagination li.active span {
        background: #e75480;
        color: #fff;
        border-color: #e75480;
    }
    .pagination li.disabled span {
        opacity: 0.6;
        cursor: default;
    }
    .pagination li a .page-icon,
    .pagination li span .page-icon {
        width: 14px;
        height: 14px;
        display: inline-block;
        vertical-align: middle;
    }
</style>
@endsection