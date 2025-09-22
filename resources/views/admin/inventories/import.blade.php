@extends('admin.layout')

@section('title', 'Phiếu nhập kho')

@section('content')
<div class="admin-card">
    <h3 style="margin-bottom:16px">Danh sách phiếu nhập</h3>
    <div class="table-wrapper">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Ghi chú</th>
                    <th>Ngày nhập</th>
                </tr>
            </thead>
            <tbody>
                @foreach($imports as $imp)
                <tr>
                    <td>{{ $imp->id }}</td>
                    <td>{{ $imp->inventory->product->name ?? 'N/A' }}</td>
                    <td>{{ $imp->quantity }}</td>
                    <td>{{ $imp->note }}</td>
                    <td>{{ $imp->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px">{{ $imports->links('vendor.pagination.bootstrap-4') }}</div>
</div>
@endsection