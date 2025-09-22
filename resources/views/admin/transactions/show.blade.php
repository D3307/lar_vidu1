{{-- resources/views/admin/transactions/show.blade.php --}}
@extends('admin.layout')

@section('content')
<div class="admin-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <h3 style="margin:0;font-size:1.1rem;color:#222;">
            @if($transaction->type == 'import')
                <i class="fa fa-plus-circle me-2" style="color:#1abc9c;"></i>
                Chi tiết phiếu nhập
            @else
                <i class="fa fa-minus-circle me-2" style="color:#e75480;"></i>
                Chi tiết phiếu xuất
            @endif
            - #{{ str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }}
        </h3>
        <a href="{{ route('admin.transactions.index', ['type' => $transaction->type]) }}" class="btn-history-back">
            <i class="fa fa-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    <!-- Thông tin phiếu -->
    <div class="transaction-info-card mb-4">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Mã phiếu:</strong> 
                    <span class="fw-bold">
                        #{{ str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }}
                    </span>
                </p>
                <p><strong>Loại phiếu:</strong>
                    @if($transaction->type == 'import')
                        <span class="badge-inventory badge-import">Phiếu nhập</span>
                    @else
                        <span class="badge-inventory badge-export">Phiếu xuất</span>
                    @endif
                </p>
            </div>
            <div class="col-md-6">
                <p><strong>Ngày tạo:</strong> {{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Số loại sản phẩm:</strong> 
                    <span class="fw-bold">{{ $transaction->details->count() }} loại</span>
                </p>
            </div>
        </div>
        @if($transaction->note)
        <p><strong>Ghi chú:</strong> {{ $transaction->note }}</p>
        @endif
    </div>

    <!-- Chi tiết sản phẩm -->
    <h5 style="color:{{ $transaction->type == 'import' ? '#000000' : '#e75480' }};margin-bottom:12px;">
        Chi tiết sản phẩm {{ $transaction->type == 'import' ? 'nhập' : 'xuất' }}
    </h5>
    <div class="table-wrapper">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th style="width:150px;">Số lượng</th>
                    <th style="width:150px;">Tồn kho hiện tại</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->details as $detail)
                <tr>
                    <td>{{ $detail->inventory->product->name }}</td>
                    <td class="fw-bold {{ $transaction->type == 'import' ? 'text-success' : 'text-danger' }}">
                        {{ $transaction->type == 'import' ? '+' : '-' }}{{ $detail->quantity }}
                    </td>
                    <td class="fw-bold">{{ $detail->inventory->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background:{{ $transaction->type == 'import' ? '#e8f5e8' : '#fff0f0' }};font-weight:bold;">
                    <td>Tổng cộng</td>
                    <td style="color:{{ $transaction->type == 'import' ? '#1abc9c' : '#e75480' }};">
                        {{ $transaction->type == 'import' ? '+' : '-' }}{{ $totalQuantity }}
                    </td>
                    <td>-</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<style>
    .admin-card {
        background: #fff;
        padding: 18px;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(231,84,128,0.06);
    }
    .transaction-info-card {
        background: #f8fcff;
        border: 1px solid #e3f2fd;
        border-radius: 12px;
        padding: 18px;
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