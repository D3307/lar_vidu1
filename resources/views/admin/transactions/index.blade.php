{{-- resources/views/admin/transactions/index.blade.php --}}
@extends('admin.layout')

@section('content')
<div class="admin-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <h3 style="margin:0;font-size:1.1rem;color:#222;">
            @if($type == 'import')
                <i class="fa fa-plus-circle me-2" style="color:#1abc9c;"></i>Danh sách phiếu nhập
            @else
                <i class="fa fa-minus-circle me-2" style="color:#e75480;"></i>Danh sách phiếu xuất
            @endif
        </h3>
        <a href="{{ route('admin.transactions.create', ['type' => $type]) }}" class="btn-action btn-{{ $type == 'import' ? 'import' : 'export' }}">
            <i class="fa fa-plus me-1"></i>
            Tạo {{ $type == 'import' ? 'phiếu nhập' : 'phiếu xuất' }} mới
        </a>
    </div>

    <div class="table-wrapper">
        <table class="styled-table">
            <thead>
                <tr>
                    <th style="width:100px;">Mã phiếu</th>
                    <th style="width:120px;">Loại phiếu</th>
                    <th>Ghi chú</th>
                    <th style="width:150px;">Ngày tạo</th>
                    <th style="width:120px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tran)
                <tr>
                    <td class="fw-bold">
                        #{{ str_pad($tran->id, 4, '0', STR_PAD_LEFT) }}
                    </td>
                    <td>
                        @if($tran->type == 'import')
                            <span class="badge-inventory badge-import">Phiếu nhập</span>
                        @else
                            <span class="badge-inventory badge-export">Phiếu xuất</span>
                        @endif
                    </td>
                    <td>{{ $tran->note ?? '-' }}</td>
                    <td>{{ $tran->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.transactions.show', $tran->id) }}" class="btn-action btn-view">
                            <i class="fa fa-eye me-1"></i> Chi tiết
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-3">
                        Chưa có {{ $type == 'import' ? 'phiếu nhập' : 'phiếu xuất' }} nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px;">
        {{ $transactions->links('vendor.pagination.bootstrap-4') }}
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
    .btn-action {
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.95rem;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.18s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }
    .btn-import {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .btn-import:hover {
        background: #f1b0b7;
        color: #721c24;
        border-color: #f1b0b7;
    }
    .btn-export {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .btn-export:hover {
        background: #f1b0b7;
        color: #721c24;
        border-color: #f1b0b7;
    }
    .btn-view {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 6px 12px;
        font-size: 0.9rem;
    }
    .btn-view:hover {
        background: #f1b0b7;
        color: #721c24;
        border-color: #f1b0b7;
    }
    .btn-submit {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 10px 24px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.18s;
    }
    .btn-submit:hover {
        background: #f1b0b7;
        color: #721c24;
    }
    .btn-add-item {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 6px;
        padding: 6px 16px;
        font-size: 0.95rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.18s;
    }
    .btn-add-item:hover {
        background: #f1b0b7;
        color: #721c24;
    }
    .btn-history-back {
        border: 1px solid #f5c6cb;
        background: #f8d7da;
        color: #721c24;
        padding: 6px 16px;
        border-radius: 6px;
        font-size: 0.95rem;
        cursor: pointer;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.18s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-history-back:hover {
        background: #f1b0b7;
        color: #721c24;
        border-color: #f1b0b7;
    }
</style>
@endsection