@extends('admin.layout')

@section('title', 'Quản lý danh mục')

@section('content')
<div class="admin-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <h3 style="margin:0;font-size:1.1rem;color:#4b3a3f">Danh sách danh mục</h3>
        <a href="{{ route('admin.categories.create') }}" class="btn-add">+ Thêm danh mục</a>
    </div>

    <div class="table-wrapper">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $c)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $c->name }}</td>
                    <td>{{ Str::limit($c->description, 100) }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $c->id) }}" class="btn-action btn-edit">Sửa</a>
                        <form action="{{ route('admin.categories.destroy', $c->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Xóa danh mục này?')" class="btn-action btn-delete">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center;color:#999;padding:12px">Chưa có danh mục nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
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
        background:#f0d4db; /* Hồng */
        color:#7a2f3b;
        padding:8px 14px;
        border-radius:8px;
        border:1px solid #e8cbd2;
        text-decoration:none;
        font-size:0.95rem;
        transition:all .2s ease;
    }
    .btn-add:hover { background:#d64571; color:#fff; }

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
