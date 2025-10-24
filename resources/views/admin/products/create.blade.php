@extends('admin.layout')

@section('title','Tạo sản phẩm')

@section('content')

    @if ($errors->any())
        <div style="color:#c03651;margin-bottom:8px">
            <ul style="margin:0;padding-left:18px">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="shadow p-4 bg-white rounded">
        @csrf

        <div style="margin-bottom:8px">
            <label>Tên</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required style="width:100%;padding:8px;border-radius:6px">
        </div>

        <div style="display:flex;gap:12px">
            <div style="flex:1">
                <label>Giá</label><br>
                <input type="text" name="price" value="{{ old('price') }}" style="width:100%;padding:8px;border-radius:6px">
            </div>
            <div style="flex:1">
                <label>Chất liệu</label><br>
                <input type="text" name="material" value="{{ old('material') }}" style="width:100%;padding:8px;border-radius:6px" placeholder="Ví dụ: Da tổng hợp">
            </div>
        </div>

        <div style="display:flex;gap:12px;margin-top:8px">
            <div style="margin-top:20px">
                <label style="font-weight:600; font-size:16px; color:#333;">Chi tiết sản phẩm</label>
                <div class="card shadow-sm border-0 rounded-3 mt-2">
                    <div class="card-body p-3">
                        {{-- Sửa lại phần table trong create.blade.php --}}
                        <table class="table align-middle" id="details-table">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:30%">Màu</th>
                                    <th style="width:30%">Size</th>
                                    <th style="width:25%">Số lượng</th>
                                    <th style="width:15%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="details[0][color]" class="form-control" placeholder="VD: Đỏ"></td>
                                    <td><input type="text" name="details[0][size]" class="form-control" placeholder="VD: 41"></td>
                                    <td><input type="number" name="details[0][quantity]" class="form-control" min="0" value="0"></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-detail">
                                            <i class="fa fa-trash" style="color:#dc3545;"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" id="add-detail" class="btn btn-sm btn-success mt-2">
                            ➕ Thêm chi tiết
                        </button>
                    </div>
                </div>
            </div>

            <script>
            document.addEventListener("DOMContentLoaded", function () {
                let index = 1;
                document.getElementById('add-detail').addEventListener('click', function () {
                    let table = document.querySelector('#details-table tbody');
                    let newRow = `
                        <tr>
                            <td><input type="text" name="details[${index}][color]" class="form-control" placeholder="VD: Đỏ"></td>
                            <td><input type="text" name="details[${index}][size]" class="form-control" placeholder="VD: 41"></td>
                            <td><input type="number" name="details[${index}][quantity]" class="form-control" min="0" value="0"></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-outline-danger remove-detail">
                                    <i class="fa fa-trash" style="color:#dc3545;"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    table.insertAdjacentHTML('beforeend', newRow);
                    index++;
                });

                // remove row
                document.addEventListener('click', function (e) {
                    if (e.target.classList.contains('remove-detail')) {
                        e.target.closest('tr').remove();
                    }
                });
            });
            </script>
        </div>

        <div style="margin-top:8px">
            <label>Danh mục</label><br>
            <select name="category_id" required style="width:100%;padding:8px;border-radius:6px">
                <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>-- Chọn danh mục --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" @if(old('category_id') == $cat->id) selected @endif>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div style="margin-top:8px">
            <label>Ảnh sản phẩm</label><br>
            <input type="file" name="image" accept="image/*">
        </div>

        <div style="margin-top:8px">
            <label>Mô tả</label><br>
            <textarea name="description" rows="4" style="width:100%;padding:8px;border-radius:6px">{{ old('description') }}</textarea>
        </div>

        <div style="margin-top:16px;display:flex;gap:10px;">
            <button type="submit" class="btn btn-outline" style="background:#f0d4db;color:#7a2f3b;font-weight:600;">➕ Tạo</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline" style="background:#eee;color:#7a2f3b;font-weight:600;">⬅ Hủy</a>
        </div>
    </form>

    <style>
        .btn.btn-outline {
            background: #f0d4db;
            color: #7a2f3b;
            padding: 8px 16px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
        }
        /* Chỉ áp dụng style mới khi nằm trong .product-create-form */
        #details-table th {
            background: #f9f3f3 !important;
            color: #7a2f3b !important;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            border-bottom: 2px solid rgba(122, 47, 59, 0.1);
        }

        #details-table td {
            border-top: 1px solid rgba(122, 47, 59, 0.05);
        }

        #details-table td input {
            border: 1px solid rgba(122, 47, 59, 0.2);
            border-radius: 8px;
            padding: 8px 10px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        #details-table td input:focus {
            border-color: #7a2f3b;
            box-shadow: 0 0 0 0.1rem rgba(122, 47, 59, 0.15);
            outline: none;
        }

        /* Nút xoá */
        #details-table .btn-outline-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
            border-radius: 6px;
            padding: 6px 10px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        #details-table .btn-outline-danger:hover {
            background: #dc3545;
            color: #fff !important;
            border-color: #dc3545;
            transform: scale(1.05);
        }

        #details-table .btn-outline-danger:hover i {
            color: #fff !important;
        }

        #details-table .btn-outline-danger i {
            color: #dc3545;
            font-size: 14px;
        }

        /* Nút thêm */
        #add-detail {
            background: rgba(122, 47, 59, 0.1);
            color: #7a2f3b;
            border: 1px solid rgba(122, 47, 59, 0.3);
            border-radius: 8px;
            font-weight: 600;
            padding: 6px 14px;
            font-size: 14px;
            transition: all 0.2s;
        }

        #add-detail:hover {
            background: #7a2f3b;
            color: #fff;
            border-color: #7a2f3b;
            transform: translateY(-1px);
        }
    </style>
@endsection
