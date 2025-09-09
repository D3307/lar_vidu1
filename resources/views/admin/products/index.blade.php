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
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
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
                    <td>{{ $product->status == 'active' ? 'Hiển thị' : 'Ẩn' }}</td>
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
                    <td colspan="7" style="text-align:center;color:#999;padding:12px">Không có sản phẩm nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

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
    .btn-action { border:none; background:transparent; padding:6px 10px; border-radius:6px;
                  font-size:0.85rem; cursor:pointer; text-decoration:none; margin-right:4px; transition:background .2s;}
    .btn-edit { color:#7a2f3b; border:1px solid rgba(122,47,59,0.3);}
    .btn-edit:hover { background:#f9f3f3;}
    .btn-delete { color:#fff; background:#d9534f; border:1px solid #c9302c;}
    .btn-delete:hover { background:#c9302c;}
</style>
@endsection
