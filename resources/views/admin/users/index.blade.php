@extends('admin.layout')

@section('title', 'Quản lý người dùng')

@section('content')
<div class="admin-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <h3 style="margin:0;font-size:1.1rem;color:#4b3a3f">👤 Danh sách người dùng</h3>
        <a href="{{ route('admin.users.create') }}" class="btn-add">+ Thêm người dùng</a>
    </div>

    <div class="table-wrapper">
        <table class="styled-table">
            <thead>
                <tr>
                    <th style="width:15px;">STT</th>
                    <th style="width:50px;">Tên</th>
                    <th style="width:250px;">Email</th>
                    <th style="width:100px;">Số điện thoại</th>
                    <th style="width:250px;">Địa chỉ</th>
                    <th style="width:70px;">Vai trò</th>
                    <th style="width:100px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    {{-- Dùng số thứ tự thay cho ID DB --}}
                    <td>{{ $users->firstItem() + $loop->index }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? 'N/A' }}</td>
                    <td>{{ $user->address ?? 'N/A' }}</td>
                    <td>
                        <span class="role-badge {{ $user->role == 'admin' ? 'role-admin' : 'role-user' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn-action btn-edit">Sửa</a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Xóa người dùng này?')" class="btn-action btn-delete">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:12px">
            {{ $users->links() }}
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
    .btn-add:hover { background:#d64571; } /* Hồng đậm hơn khi hover */

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
    .role-badge {
        display:inline-block;
        padding:3px 8px;
        font-size:0.85rem;
        border-radius:6px;
        font-weight:600;
    }
    .role-admin { background:#f0d4db; color:#7a2f3b; }
    .role-user { background:#e6f5f2; color:#1b6d5a; }

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
