@extends('admin.layout')

@section('content')
<div class="admin-card">
    <!-- Header -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <h3 style="margin:0;font-size:1.1rem;color:#222;">
            <i class="fa fa-history me-2"></i> Lịch sử nhập/xuất kho - {{ $inventory->product->name }}
        </h3>
        <div style="display:flex;gap:10px;">
            <a href="{{ route('admin.inventories.exportExcel') }}" class="btn-action btn-excel">
                <i class="fa fa-file-excel me-1"></i> Xuất Excel
            </a>
        </div>
    </div>

    <!-- Bảng lịch sử -->
    <div class="table-wrapper">
        <table class="styled-table">
            <thead>
                <tr>
                    <th style="width:120px;">Loại</th>
                    <th style="width:120px;">Số lượng</th>
                    <th>Ghi chú</th>
                    <th style="width:180px;">Ngày</th>
                </tr>
            </thead>
            <tbody>
                @forelse($movements as $m)
                    <tr>
                        <td>
                            @if($m->type === 'import')
                                <span class="badge-inventory badge-import">Nhập</span>
                            @elseif($m->type === 'export')
                                <span class="badge-inventory badge-export">Xuất</span>
                            @else
                                <span class="badge-inventory badge-adjust">Điều chỉnh</span>
                            @endif
                        </td>
                        <td class="fw-bold fs-6">
                            {{ $m->quantity }}
                        </td>
                        <td>
                            {{ $m->note ?? '-' }}
                        </td>
                        <td>
                            <span class="text-muted">
                                {{ $m->created_at->format('d/m/Y H:i') }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-3">
                            Chưa có lịch sử nhập/xuất kho.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination + Back -->
    <div style="margin-top:16px;display:flex;justify-content:space-between;align-items:center">
        <div>
            {{ $movements->links('vendor.pagination.bootstrap-4') }}
        </div>
        <a href="{{ route('admin.inventories.index') }}" class="btn-history-back">
            <i class="fa fa-arrow-left me-1"></i> Quay lại
        </a>
    </div>
</div>

<style>
    .admin-card {
        background: #fff;
        padding: 18px;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(231,84,128,0.06);
    }
    .table-wrapper {
        overflow-x: auto;
    }
    .styled-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border: 1px solid #f3e6ea;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
    }
    .styled-table th {
        background: #f9f3f3;
        color: #e75480;
        font-weight: 700;
        text-align: left;
        padding: 12px 14px;
        font-size: 1rem;
        border-bottom: 2px solid #f3e6ea;
    }
    .styled-table td {
        padding: 12px 14px;
        border-top: 1px solid #f3e6ea;
        font-size: 1rem;
        color: #222;
        background: #fff;
    }
    .styled-table tr:hover td {
        background: #fdf6f8;
        transition: background 0.2s;
    }
    /* Badge nhập/xuất/điều chỉnh */
    .badge-inventory {
        display: inline-block;
        padding: 6px 18px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.98rem;
        letter-spacing: 0.5px;
        border: none;
        transition: background .2s, color .2s;
    }
    .badge-import {
        background: #e6f9f0;
        color: #1abc9c;
        border: 1.5px solid #1abc9c;
    }
    .badge-export {
        background: #fff0f0;
        color: #e75480;
        border: 1.5px solid #e75480;
    }
    .badge-adjust {
        background: #f3f3f3;
        color: #7a2f3b;
        border: 1.5px solid #7a2f3b;
    }
    /* Nút xuất excel, nhập/xuất */
    .btn-action {
        padding: 9px 20px;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.18s;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(231,84,128,0.04);
    }
    .btn-excel {
        background: #27c46b;
        color: #fff;
        border: 1.5px solid #27c46b;
    }
    .btn-excel:hover {
        background: #1abc9c;
        color: #fff;
        border-color: #1abc9c;
    }
    .btn-movement {
        background: #e75480;
        color: #fff;
        border: 1.5px solid #e75480;
    }
    .btn-movement:hover {
        background: #fff;
        color: #e75480;
        border-color: #e75480;
    }
    .btn-history-back {
        border: 1.5px solid #e75480;
        background: #fff;
        color: #e75480;
        padding: 8px 18px;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.18s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-history-back:hover {
        background: #f9f3f3;
        color: #7a2f3b;
        border-color: #7a2f3b;
    }
</style>
@endsection