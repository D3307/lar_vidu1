@extends('admin.layout')

@section('title', 'Phiếu xuất kho')

@section('content')
<div class="admin-card">
    <h3 style="margin-bottom:16px">Danh sách phiếu xuất</h3>
    <div class="table-wrapper">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Ghi chú</th>
                    <th>Ngày xuất</th>
                </tr>
            </thead>
            <tbody>
                @forelse($exports as $exp)
                <tr>
                    <td>{{ $exp->id }}</td>
                    <td>{{ $exp->inventory->product->name ?? 'N/A' }}</td>
                    <td style="color:#c0392b;font-weight:600">-{{ $exp->quantity }}</td>
                    <td>{{ $exp->note }}</td>
                    <td>{{ $exp->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:#999;padding:12px">
                        Chưa có phiếu xuất nào
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px">
        {{ $exports->links('vendor.pagination.bootstrap-4') }}
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
        background:#f3f9f7;
        color:#0c4a6e;
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
</style>
@endsection