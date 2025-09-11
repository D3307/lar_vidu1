@extends('admin.layout')

@section('title', 'Quản lý mã khuyến mãi')

@section('content')
<div class="admin-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <h3 style="margin:0;font-size:1.1rem;color:#4b3a3f">Danh sách mã khuyến mãi</h3>
        <div style="display:flex;gap:10px;align-items:center">
            <a href="{{ route('admin.coupons.create') }}" class="btn-add">+ Thêm mã khuyến mãi</a>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Mã</th>
                    <th>Loại</th>
                    <th>Giá trị</th>
                    <th>Giá trị tối thiểu</th>
                    <th>Số lần dùng / Giới hạn</th>
                    <th>Thời gian</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $coupon->code }}</td>
                    <td>{{ $coupon->type == 'percent' ? 'Phần trăm' : 'Cố định' }}</td>
                    <td>
                        @if($coupon->type == 'percent')
                            {{ $coupon->value }} %
                        @else
                            {{ number_format($coupon->value, 0, ',', '.') }} đ
                        @endif
                    </td>
                    <td>{{ number_format($coupon->min_order_value, 0, ',', '.') }} đ</td>
                    <td>{{ $coupon->used_count }} / {{ $coupon->usage_limit ?? '∞' }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($coupon->start_date)->format('d/m/Y') }}
                        -
                        {{ \Carbon\Carbon::parse($coupon->end_date)->format('d/m/Y') }}
                    </td>
                    <td>
                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn-action btn-edit">Sửa</a>
                        <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Xóa mã này?')" class="btn-action btn-delete">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;color:#999;padding:12px">Chưa có mã khuyến mãi nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px;display:flex;justify-content:flex-end">
        {{ $coupons->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>

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
        color: #7a2f3b;
        border: 1px solid #e8cbd2;
    }

    .pagination li a:hover {
        background-color: #f0d4db;
    }

    .pagination li.active span {
        background-color: #c03651;
        color: #fff;
        border-color: #c03651;
    }
    .admin-card { background:#fff; padding:18px; border-radius:14px; box-shadow:0 4px 12px rgba(0,0,0,0.05);}
    .btn-add { background:#f0d4db; color:#7a2f3b; padding:8px 14px; border-radius:8px; border:1px solid #e8cbd2;
               text-decoration:none; font-size:0.95rem; transition:all .2s ease;}
    .btn-add:hover { background:#d64571; color:#fff;}
    .table-wrapper { overflow-x:auto; }
    .styled-table { width:100%; border-collapse:separate; border-spacing:0;
                    border:1px solid rgba(0,0,0,0.06); border-radius:10px; overflow:hidden;}
    .styled-table th { background:#f9f3f3; color:#7a2f3b; font-weight:600; text-align:left;
                       padding:10px 12px; font-size:0.95rem;}
    .styled-table td { padding:10px 12px; border-top:1px solid rgba(0,0,0,0.05); font-size:0.95rem; color:#333;}
    .btn-action { border:none; background:transparent; padding:6px 10px; border-radius:6px;
                  font-size:0.85rem; cursor:pointer; text-decoration:none; margin-right:4px; transition:background .2s;}
    .btn-edit { color:#7a2f3b; border:1px solid rgba(122,47,59,0.3);}
    .btn-edit:hover { background:#f9f3f3;}
    .btn-delete { color:#fff; background:#d9534f; border:1px solid #c9302c;}
    .btn-delete:hover { background:#c9302c;}
</style>
@endsection