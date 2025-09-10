@extends('admin.layout')

@section('title', 'Danh sách đơn hàng')

@section('content')
<div class="admin-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <h3 style="margin:0;font-size:1.1rem;color:#4b3a3f">📋 Danh sách đơn hàng</h3>
    </div>

    <div class="table-wrapper">
        <table class="styled-table">
            <thead>
                <tr>
                    <th style="width:10px;">STT</th>
                    <th style="width:95px;">Khách hàng</th>
                    <th style="width:80px;">SĐT</th>
                    <th style="width:180px;">Địa chỉ</th>
                    <th style="width:220px;">Phương thức thanh toán</th>
                    <th style="width:85px;">Tổng tiền</th>
                    <th style="width:70px;">Trạng thái</th>
                    <th style="width:80px;">Ngày đặt</th>
                    <th style="width:130px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $orders->firstItem() + $loop->index }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->address }}</td>
                    <td>
                        {{ $order->payment_method == 'cod' ? 'Thanh toán khi nhận hàng' : 'Chuyển khoản' }}
                    </td>
                    <td>{{ number_format($order->total, 0, ',', '.') }} đ</td>
                    <td>
                        <span class="status-badge {{ $order->status }}">
                            {{ $order->status == 'pending' ? 'Pending' : '' }}
                            {{ $order->status == 'processing' ? 'Processing' : '' }}
                            {{ $order->status == 'shipping' ? 'Shipping' : '' }}
                            {{ $order->status == 'delivered' ? 'Delivered' : '' }}
                            {{ $order->status == 'cancelled' ? 'Cancelled' : '' }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.orderdetail', $order->id) }}" class="btn-action btn-edit">Xem</a>
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này không?')" class="btn-action btn-delete">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center">Chưa có đơn hàng nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top: 30px;">
            {{ $orders->links('vendor.pagination.bootstrap-4') }}
        </div>
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
        text-align:left;
    }

    /* Trạng thái đơn hàng */
    .status-badge {
        display:inline-block;
        padding:4px 10px;
        font-size:0.85rem;
        border-radius:6px;
        font-weight:600;
        color:#fff;
    }
    .status-badge.pending { background:#f0ad4e; }       /* vàng */
    .status-badge.processing { background:#5bc0de; }    /* xanh dương nhạt */
    .status-badge.shipping { background:#5c80d6; }      /* xanh lam */
    .status-badge.delivered { background:#5cb85c; }     /* xanh lá */
    .status-badge.cancelled { background:#d9534f; }     /* đỏ */

    /* Nút hành động */
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
    .btn-delete {
        color:#fff;
        background:#d9534f;
        border:1px solid #c9302c;
    }
    .btn-delete:hover {
        background:#c9302c;
    }
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