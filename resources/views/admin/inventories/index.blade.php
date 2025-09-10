@extends('admin.layout')

@section('title', 'Quản lý tồn kho')

@section('content')
<div class="admin-card">
    <h3 style="margin-bottom:16px">Danh sách tồn kho</h3>

    <a href="{{ route('admin.inventories.create') }}" class="btn btn-primary" style="margin-bottom:12px">+ Thêm tồn kho</a>

    <table class="styled-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Sản phẩm</th>
                <th>Số lượng tồn</th>
                <th>Cập nhật</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inventories as $inv)
            <tr>
                <td>{{ $inv->id }}</td>
                <td>{{ $inv->product->name ?? 'N/A' }}</td>
                <td>{{ $inv->quantity }}</td>
                <td>
                    <a href="{{ route('admin.inventories.edit', $inv->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                    <form action="{{ route('admin.inventories.destroy', $inv->id) }}" method="POST" style="display:inline">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Xóa tồn kho này?')" class="btn btn-sm btn-danger">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:12px">
        {{ $inventories->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>
@endsection