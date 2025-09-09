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
                    <th>STT</th>
                    <th>Khách hàng</th>
                    <th>SĐT</th>
                    <th>Địa chỉ</th>
                    <th>Phương thức thanh toán</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt</th>
                    <th>Hành động</th>
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
                            {{ ucfirst($order->status) }}
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

    .status-badge {
        display:inline-block;
        padding:3px 8px;
        font-size:0.85rem;
        border-radius:6px;
        font-weight:600;
        color:#fff;
    }
    .status-badge.pending { background:#f0ad4e; }
    .status-badge.processing { background:#5bc0de; }
    .status-badge.completed { background:#5cb85c; }
    .status-badge.cancelled { background:#d9534f; }

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
</style>
@endsection
