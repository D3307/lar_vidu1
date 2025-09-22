{{-- resources/views/admin/transactions/index.blade.php --}}
@extends('admin.layout')

@section('title', 'Quản lý phiếu ' . ($type == 'import' ? 'nhập' : 'xuất'))

@section('content')
<div class="admin-card">
    <!-- Header -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <h3 style="margin:0;font-size:1.1rem;color:#4b3a3f">
            Danh sách {{ $type == 'import' ? 'phiếu nhập' : 'phiếu xuất' }}
        </h3>
        <a href="{{ route('admin.transactions.create', ['type' => $type]) }}" class="btn-add">
            + Tạo {{ $type == 'import' ? 'phiếu nhập' : 'phiếu xuất' }}
        </a>
    </div>

    <!-- Table -->
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
                    <td>#{{ str_pad($tran->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        @if($tran->type == 'import')
                            <span class="badge-import">Phiếu nhập</span>
                        @else
                            <span class="badge-export">Phiếu xuất</span>
                        @endif
                    </td>
                    <td>{{ $tran->note ?? '-' }}</td>
                    <td>{{ $tran->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.transactions.show', $tran->id) }}" class="btn-action btn-edit">Chi tiết</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:#999;padding:12px">
                        Chưa có {{ $type == 'import' ? 'phiếu nhập' : 'phiếu xuất' }} nào.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top:16px;display:flex;justify-content:flex-end">
        {{ $transactions->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>

<style>
    .admin-card { 
        background:#fff; 
        padding:18px; 
        border-radius:14px; 
        box-shadow:0 4px 12px rgba(0,0,0,0.05);
    }
    .btn-add { 
        background:#f0d4db; 
        color:#7a2f3b; 
        padding:8px 14px; 
        border-radius:8px; 
        border:1px solid #e8cbd2;
        text-decoration:none; 
        font-size:0.95rem; 
        transition:all .2s ease;
    }
    .btn-add:hover { 
        background:#d64571; 
        color:#fff;
    }
    .table-wrapper { 
        overflow-x:auto; 
    }
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
    .styled-table tr:hover td {
        background:#fdf6f8;
    }
    .badge-import, .badge-export {
        display:inline-block;
        padding:4px 10px;
        border-radius:12px;
        font-size:0.85rem;
        font-weight:500;
    }
    .badge-import {
        background:#e6f9f0;
        color:#1abc9c;
        border:1px solid #1abc9c;
    }
    .badge-export {
        background:#fff0f0;
        color:#e75480;
        border:1px solid #e75480;
    }
    .btn-action { 
        border:none; 
        background:transparent; 
        padding:6px 10px; 
        border-radius:6px;
        font-size:0.85rem; 
        cursor:pointer; 
        text-decoration:none; 
        transition:background .2s;
    }
    .btn-edit { 
        color:#7a2f3b; 
        border:1px solid rgba(122,47,59,0.3);
    }
    .btn-edit:hover { 
        background:#f9f3f3;
    }
    .pagination {
        display: flex;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin: 0;
        align-items: center;
    }
    .pagination li { 
        display: inline-block; 
    }
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
    .pagination li a:hover { 
        background: rgba(231,84,128,0.06); 
    }
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