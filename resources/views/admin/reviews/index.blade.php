@extends('admin.layout')

@section('title', 'Quản lý đánh giá')

@section('content')
<div class="admin-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <h3 style="margin:0;font-size:1.1rem;color:#4b3a3f">Danh sách đánh giá</h3>
    </div>

    <div class="table-wrapper">
        <table class="styled-table">
            <thead>
                <tr>
                    <th style="width:10px">ID</th>
                    <th style="width:200px">Sản phẩm</th>
                    <th style="width:95px">Người dùng</th>
                    <th style="width:60px">Đơn hàng</th>
                    <th style="width:90px">Rating</th>
                    <th style="width:200px">Bình luận</th>
                    <th style="width:120px">Ngày</th>
                    <th style="width:120px">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td>{{ $review->id }}</td>
                    <td>{{ $review->product->name ?? 'N/A' }}</td>
                    <td>{{ $review->user->name ?? 'N/A' }}</td>
                    <td>#{{ $review->order->id ?? 'N/A' }}</td>
                    <td>
                        @for($i=1; $i<=5; $i++)
                            <span style="color:{{ $i <= $review->rating ? '#f5c518' : '#ddd' }}">★</span>
                        @endfor
                    </td>
                    <td>{{ Str::limit($review->comment, 60) }}</td>
                    <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn-action btn-edit">Sửa</a>
                        <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Xóa đánh giá này?')" class="btn-action btn-delete">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;color:#999;padding:12px">Chưa có đánh giá nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:16px;display:flex;justify-content:flex-end">
        {{ $reviews->links('vendor.pagination.bootstrap-4') }}
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
    }

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
        background:#fff;
        color:#7a2f3b;
        border:1px solid rgba(122,47,59,0.3);
        padding:6px 12px;
        font-weight:600;
    }
    .btn-edit:hover {
        background:#f9f3f3;
    }

    .btn-delete {
        background:#d9534f;
        color:#fff;
        border:1px solid #c9302c;
        padding:6px 12px;
        font-weight:600;
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