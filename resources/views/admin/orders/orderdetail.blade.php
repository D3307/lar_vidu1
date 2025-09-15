@extends('admin.layout')

@section('title', 'Chi tiết đơn hàng')

@section('content')
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
        <h2 style="margin:0;color:#7a2f3b">📝 Đơn hàng #{{ $order->id }}</h2>
        <div>
            <a href="{{ route('admin.orders.orders') }}" class="btn btn-outline">⬅ Quay lại</a>
            <a href="{{ route('admin.orders.invoice', $order->id) }}" class="btn btn-outline" target="_blank">🧾 Xuất hóa đơn</a>
        </div>
    </div>

    <style>
        .card-row {
            background:#fff;
            padding:16px;
            border-radius:12px;
            box-shadow:0 6px 18px rgba(0,0,0,0.04);
            border:1px solid rgba(122,47,59,0.04);
            margin-bottom:20px;
        }
        .card-title { font-weight:700; color:#5b3a3f; margin-bottom:12px; }
        .info-list p { margin-bottom:6px; font-size:0.95rem; color:#444; }
        .badge-status {
            display:inline-block;
            padding:4px 10px;
            border-radius:6px;
            font-size:0.85rem;
            font-weight:600;
            color:#fff;
        }
        .badge-status.pending { background:#f0ad4e; }
        .badge-status.processing { background:#5bc0de; }
        .badge-status.packed { background:#0275d8; }
        .badge-status.shipping { background:#5c80d6; }
        .badge-status.delivered { background:#5cb85c; }
        .badge-status.cancelled { background:#d9534f; }
        .form-select-status {
            padding:6px 10px;
            border:1px solid #e8cbd2;
            border-radius:6px;
            font-size:0.95rem;
            background:#fff;
        }
        .table-custom {
            width:100%;
            border-collapse:collapse;
            margin-top:12px;
        }
        .table-custom th,
        .table-custom td {
            border:1px solid #eee;
            padding:10px;
            text-align:center;
            font-size:0.95rem;
        }
        .table-custom th {
            background:#f7f3f4;
            color:#4b3a3f;
            font-weight:600;
        }
        .btn {
            display:inline-block;
            padding:8px 14px;
            border-radius:8px;
            font-size:0.95rem;
            font-weight:600;
            cursor:pointer;
            text-decoration:none;
            transition: all 0.2s ease;
        }
        .btn-outline {
            background:#fff;
            border:1px solid #f2d6da;
            color:#c03651;
        }
        .btn-outline:hover { background:#f9f0f1; }
    </style>

    {{-- Khối thông tin khách hàng --}}
    <div class="card-row">
        <div class="card-title">👤 Thông tin khách hàng</div>
        <div class="info-list">
            <p><strong>Tên:</strong> {{ $order->name }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
            <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p>
                <strong>Trạng thái:</strong> 
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="d-inline">
                    @csrf
                    <select name="status" class="form-select-status" onchange="this.form.submit()">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Chờ giao hàng</option>
                        <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang vận chuyển</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </form>
            </p>
        </div>
    </div>

    {{-- Khối sản phẩm --}}
    <div class="card-row">
        <div class="card-title">📦 Sản phẩm trong đơn</div>
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Màu</th>
                        <th>Size</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name ?? 'Sản phẩm đã xóa' }}</td>
                            <td>{{ $item->color ?? '-' }}</td>
                            <td>{{ $item->size ?? '-' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                            <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Khối tổng tiền --}}
    <div class="card-row" style="text-align:right">
        <h3 style="color:#7a2f3b;margin:0">Tổng: 
            <span style="color:#c03651">
                {{ number_format($order->final_total, 0, ',', '.') }} đ
            </span>
        </h3>
    </div>
@endsection
