@extends('admin.layout')

@section('title', 'Quản lý tồn kho')

@section('content')
<div class="admin-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <h3 style="margin:0;font-size:1.1rem;color:#4b3a3f">Danh sách tồn kho</h3>
    </div>

    <div class="table-wrapper">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng tồn</th>
                    <th>Ngày cập nhật</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventories as $inventory)
                <tr>
                    <td>{{ $inventory->id }}</td>
                    <td>{{ $inventory->product->name ?? 'N/A' }}</td>
                    <td>{{ $inventory->quantity }}</td>
                    <td>{{ $inventory->updated_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.inventories.edit', $inventory->id) }}" class="btn-action btn-edit">Sửa</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:#999;padding:12px">Chưa có dữ liệu tồn kho</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px">
        {{ $inventories->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>

<style>
    .admin-card {
        background:#fff;
        padding:18px;
        border-radius:14px;
        box-shadow:0 4px 12px rgba(0,0,0,0.05);
    }
    .table-wrapper { overflow-x:auto; }
    .styled-table {
        width:100%;
        border-collapse:separate;
        border-spacing:0;
        border:1px solid rgba(0,0,0,0.06);
        border-radius:10px;
        overflow:hidden;
    }
    .styled-table th {
        background:#f9f3f3;
        color:#7a2f3b;
        font-weight:600;
        text-align:left;
        padding:10px 12px;
        font-size:0.95rem;
    }
    .styled-table td {
        padding:10px 12px;
        border-top:1px solid rgba(0,0,0,0.05);
        font-size:0.95rem;
        color:#333;
    }
    .btn-action {
        border:none;
        background:transparent;
        padding:6px 10px;
        border-radius:6px;
        font-size:0.85rem;
        cursor:pointer;
        text-decoration:none;
        margin-right:4px;
        transition:background .2s;
    }
    .btn-edit {
        color:#7a2f3b;
        border:1px solid rgba(122,47,59,0.3);
    }
    .btn-edit:hover {
        background:#f9f3f3;
    }
</style>
@endsection