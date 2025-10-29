@extends('admin.layout')

@section('title', 'Quản lý sản phẩm')

@section('content')
<div class="admin-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <h3 style="margin:0;font-size:1.1rem;color:#4b3a3f">Danh sách sản phẩm</h3>
        <div style="display:flex;gap:10px;align-items:center">
            <a href="{{ route('admin.products.create') }}" class="btn-add">+ Thêm sản phẩm</a>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="styled-table">
            <thead>
                <tr>
                    <th style="width: 20px;">STT</th>
                    <th style="width: 40px;">Ảnh</th>
                    <th style="width: 250px;">Tên sản phẩm</th>
                    <th style="width: 100px;">Danh mục</th>
                    <th style="width: 60px;">Giá</th>
                    <th style="width: 80px;">Số lượng</th>
                    <th style="width: 200px;">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    {{-- Số thứ tự theo pagination --}}
                    <td>{{ (($products->currentPage()-1) * $products->perPage()) + $loop->iteration }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                        @else
                            <div style="width:50px;height:50px;background:#f0f0f0;color:#999;text-align:center;line-height:50px;border-radius:6px;">N/A</div>
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name ?? '-' }}</td>
                    <td>{{ number_format($product->price ?? 0, 0, ',', '.') }} đ</td>
                    <td>{{ $product->details->sum('quantity') }}</td> {{-- Tổng số lượng từ product_details --}}
                    <td>
                        <button type="button" class="btn-action btn-view" data-bs-toggle="modal" data-bs-target="#detailModal{{ $product->id }}">
                            Xem chi tiết
                        </button>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-action btn-edit">Sửa</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Xóa sản phẩm này?')" class="btn-action btn-delete">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;color:#999;padding:12px">Không có sản phẩm nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div style="margin-top:16px;display:flex;justify-content:flex-end">
        {{ $products->links('vendor.pagination.bootstrap-4') }}
    </div>
</div>

{{-- Modals: để ngoài table để không phá cấu trúc HTML --}}
{{-- Sửa modal trong index.blade.php --}}
@foreach($products as $product)
<div class="modal fade" id="detailModal{{ $product->id }}" tabindex="-1" aria-labelledby="modalTitle{{ $product->id }}" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle{{ $product->id }}">
                    <i class="fa fa-info-circle me-2" style="color:#7a2f3b;"></i>
                    {{ $product->name }} - Chi tiết biến thể
                </h5>
                <button type="button" class="btn-close custom-btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <div class="product-description mb-3">
                    <p><strong style="color:#7a2f3b;">Mô tả:</strong> {{ $product->description ?? 'Không có mô tả' }}</p>
                </div>
                <div class="variants-section">
                    <h6 style="color:#7a2f3b;margin-bottom:12px;">Chi tiết sản phẩm:</h6>

                    @if($product->details->count())
                        <div class="table-wrapper">
                            <table class="modal-table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Màu sắc</th>
                                        <th>Kích thước</th>
                                        <th>Số lượng</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->details as $index => $detail)
                                        <tr id="detail-row-{{ $detail->id }}">
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <div style="display:flex;align-items:center;gap:8px;">
                                                    <span class="color-preview" style="background-color: {{ $detail->color }}"></span>
                                                    <span class="color-name">{{ $detail->color }}</span>
                                                </div>
                                            </td>
                                            <td><span class="size-badge">{{ $detail->size }}</span></td>
                                            <td><span class="quantity-badge">{{ $detail->quantity }}</span></td>
                                            <td>
                                                <button type="button" class="btn-variant btn-variant-edit editDetailBtn" data-id="{{ $detail->id }}" data-color="{{ $detail->color }}" data-size="{{ $detail->size }}" data-quantity="{{ $detail->quantity }}">
                                                    <i class="fa fa-edit"></i> Sửa
                                                </button>
                                                <button type="button" class="btn-variant btn-variant-delete deleteDetailBtn" data-id="{{ $detail->id }}">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="no-variants mb-3">
                            <i class="fa fa-exclamation-triangle" style="color:#f39c12;margin-right:8px;"></i>
                            <span class="text-muted">Chưa có chi tiết sản phẩm.</span>
                        </div>
                    @endif

                    {{-- Form thêm luôn hiển thị --}}
                    <form class="addDetailForm mt-3" data-product-id="{{ $product->id }}">
                        @csrf
                        <div style="display:flex; gap:10px; align-items:center;">
                            <input type="text" name="color" placeholder="Màu sắc" required>
                            <input type="text" name="size" placeholder="Kích thước" required>
                            <input type="number" name="quantity" placeholder="Số lượng" required min="0">
                            <button type="submit" class="btn-variant btn-variant-add">
                                <i class="fa fa-plus"></i> Thêm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-modal-close" data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i> Đóng
                </button>
            </div>
        </div>
    </div>
</div>
@endforeach

<style>
    .admin-card {background: #fff;padding: 18px;border-radius: 14px;box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);}
    .btn-add {background: #f0d4db;color: #7a2f3b;padding: 8px 14px;border-radius: 8px;border: 1px solid #e8cbd2;text-decoration: none;font-size: 0.95rem;transition: all .2s ease;}
    .btn-add:hover {background: #d64571;color: #fff;}
    .table-wrapper {overflow-x: auto;}
    .styled-table {width: 100%;border-collapse: separate;border-spacing: 0;border: 1px solid rgba(0, 0, 0, 0.06);border-radius: 10px;overflow: hidden;}
    .styled-table th {background: #f9f3f3;color: #7a2f3b;font-weight: 600;text-align: left;padding: 10px 12px;font-size: 0.95rem;}
    .styled-table td {padding: 10px 12px;border-top: 1px solid rgba(0, 0, 0, 0.05);font-size: 0.95rem;color: #333;}
    .color-circle {display: inline-block;width: 18px;height: 18px;border-radius: 50%;border: 1px solid #ccc;margin-right: 4px;vertical-align: middle;}
    .btn-action { border: none; background: transparent; padding: 6px 10px; border-radius: 6px; font-size: 0.85rem; cursor: pointer; text-decoration: none; margin-right: 4px; transition: background .2s; }
    .btn-view { color: #fff; background: #5bc0de; border: 1px solid #46b8da; }
    .btn-view:hover { background: #31b0d5; }
    .btn-edit { color: #7a2f3b; border: 1px solid rgba(122, 47, 59, 0.3); }
    .btn-edit:hover { background: #f9f3f3; }
    .btn-delete { color: #fff; background: #d9534f; border: 1px solid #c9302c; }
    .btn-delete:hover { background: #c9302c; }
    .pagination { display: flex; gap: 6px; list-style: none; padding: 0; margin: 0; align-items: center; }
    .pagination li { display: inline-block; }
    .pagination li a, .pagination li span { display: inline-block; padding: 6px 10px; min-width: 40px; text-align: center; border-radius: 8px; background: #fff; color: #333; border: 1px solid #eee; font-size: 14px; line-height: 1; box-sizing: border-box; white-space: nowrap; }
    .pagination li a:hover { background: rgba(231, 84, 128, 0.06); }
    .pagination li.active span { background: #e75480; color: #fff; border-color: #e75480; }
    .pagination li.disabled span { opacity: 0.6; cursor: default; }
    .pagination li a .page-icon, .pagination li span .page-icon { width: 14px; height: 14px; display: inline-block; vertical-align: middle; }
    .custom-modal { border: none; border-radius: 14px; overflow: hidden; box-shadow: 0 8px 32px rgba(122, 47, 59, 0.15); }
    .custom-modal .modal-header { background: linear-gradient(135deg, #f9f3f3 0%, #f0d4db 100%); color: #7a2f3b; border: none; padding: 18px 24px; border-bottom: 1px solid rgba(122, 47, 59, 0.1); }
    .custom-modal .modal-title { font-weight: 600; font-size: 1.1rem; color: #7a2f3b; display: flex; align-items: center; }
    .custom-btn-close { background: rgba(122, 47, 59, 0.1); border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: none; opacity: 0.8; transition: all 0.2s; }
    .custom-btn-close:hover { background: rgba(122, 47, 59, 0.2); opacity: 1; transform: scale(1.05); }
    .custom-modal .modal-body { padding: 24px; background: #fff; }
    .product-description { background: #fafafa; padding: 14px; border-radius: 8px; border-left: 4px solid #7a2f3b; }
    .variants-section h6 { font-weight: 600; margin-bottom: 12px; }
    .modal-table { width: 100%; border-collapse: separate; border-spacing: 0; border: 1px solid rgba(122, 47, 59, 0.1); border-radius: 10px; overflow: hidden; background: #fff; }
    .modal-table th { background: #f9f3f3; color: #7a2f3b; font-weight: 600; text-align: left; padding: 12px 14px; font-size: 0.95rem; border-bottom: 2px solid rgba(122, 47, 59, 0.1); }
    .modal-table td { padding: 12px 14px; border-top: 1px solid rgba(122, 47, 59, 0.05); font-size: 0.95rem; color: #333; }
    .modal-table tr:hover td { background: rgba(240, 212, 219, 0.3); transition: background 0.2s; }
    .color-circle { display: inline-block; width: 20px; height: 20px; border-radius: 50%; border: 2px solid rgba(122, 47, 59, 0.2); vertical-align: middle; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
    .size-badge { background: rgba(122, 47, 59, 0.1); color: #7a2f3b; padding: 4px 10px; border-radius: 6px; font-size: 0.9rem; font-weight: 500; }
    .quantity-badge { background: #f0d4db; color: #7a2f3b; padding: 4px 12px; border-radius: 6px; font-size: 0.9rem; font-weight: 600; }
    .no-variants { text-align: center; padding: 24px; background: #fafafa; border-radius: 8px; border: 1px dashed rgba(122, 47, 59, 0.2); }
    .custom-modal .modal-footer { background: #fafafa; border: none; padding: 16px 24px; border-top: 1px solid rgba(122, 47, 59, 0.1); }
    .btn-modal-close { background: rgba(122, 47, 59, 0.1); color: #7a2f3b; border: 1px solid rgba(122, 47, 59, 0.2); border-radius: 8px; padding: 8px 20px; font-size: 0.95rem; font-weight: 500; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; }
    .btn-modal-close:hover { background: #f0d4db; color: #7a2f3b; border-color: rgba(122, 47, 59, 0.3); transform: translateY(-1px); }
    .color-preview { display: inline-block; width: 24px; height: 24px; border-radius: 6px; border: 2px solid rgba(122, 47, 59, 0.2); vertical-align: middle; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); flex-shrink: 0; position: relative; }
    .color-preview:hover { transform: scale(1.1); transition: transform 0.2s; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25); }
    .color-name { font-weight: 500; color: #333; text-transform: capitalize; }
    .color-preview[style*="white"], .color-preview[style*="#fff"], .color-preview[style*="#ffffff"] { border: 2px solid #ddd !important; }
    @media (max-width: 768px) { .color-preview { width: 20px; height: 20px; } .color-name { font-size: 0.9rem; } }
    @media (max-width: 768px) { .custom-modal .modal-body { padding: 16px; } .modal-table th, .modal-table td { padding: 8px 10px; font-size: 0.9rem; } }
    .modal-table input, .modal-table select { width: 100%; padding: 8px 12px; border: 1px solid rgba(122, 47, 59, 0.3); border-radius: 6px; font-size: 0.9rem; color: #333; background: #fff; transition: border-color 0.2s, box-shadow 0.2s; }
    .modal-table input:focus, .modal-table select:focus { border-color: #7a2f3b; box-shadow: 0 0 0 2px rgba(122, 47, 59, 0.15); outline: none; }
    .btn-variant { border: none; border-radius: 6px; padding: 6px 12px; font-size: 0.85rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; }
    .addDetailForm {width: 100%;display: flex;align-items: center;gap: 10px;padding: 12px 14px;border-top: 1px solid rgba(122, 47, 59, 0.1);background: #fff;border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;}
    .addDetailForm input[type="text"],
    .addDetailForm input[type="number"],
    .addDetailForm select {flex: 1;padding: 8px 12px;border: 1px solid rgba(122, 47, 59, 0.3);border-radius: 6px;font-size: 0.9rem;color: #333;background: #fff;transition: border-color 0.2s, box-shadow 0.2s;}
    .addDetailForm input:focus {border-color: #7a2f3b;box-shadow: 0 0 0 2px rgba(122, 47, 59, 0.15);outline: none;}
    .addDetailForm .btn-variant-add {background: rgba(122, 47, 59, 0.1);color: #7a2f3b;border: 1px solid rgba(122, 47, 59, 0.3);border-radius: 6px;padding: 8px 14px;font-size: 0.9rem;font-weight: 500;display: inline-flex;align-items: center;gap: 6px;cursor: pointer;transition: all 0.2s;white-space: nowrap;}
    .addDetailForm .btn-variant-add:hover {background: #7a2f3b;color: #fff;border-color: #7a2f3b;}
    @media (max-width: 768px) {.addDetailForm {flex-direction: column;align-items: stretch;}}
    .btn-variant-edit { background: #f0d4db; color: #7a2f3b; }
    .btn-variant-edit:hover { background: #7a2f3b; color: #fff; }
    .btn-variant-delete { background: #fff0f3; color: #a83244; border: 1px solid rgba(168, 50, 68, 0.3); }
    .btn-variant-delete:hover { background: #a83244; color: #fff; }
    .modal-table tr.editing td { background: rgba(240, 212, 219, 0.2); }
    .alert-modal { margin: 10px 0; padding: 10px 14px; border-radius: 6px; font-size: 0.9rem; font-weight: 500; }
    .alert-modal-success { background: #eaf7f1; color: #2d7a4b; border: 1px solid #b6e0c3; }
    .alert-modal-error { background: #fff0f3; color: #a83244; border: 1px solid #f0b6c0; }
    .btn-save-detail { background: rgba(122, 47, 59, 0.1); color: #7a2f3b; border: 1px solid rgba(122, 47, 59, 0.3); border-radius: 6px; padding: 6px 12px; font-size: 0.85rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; margin-right: 4px; }
    .btn-save-detail:hover { background: #7a2f3b; color: #fff; border-color: #7a2f3b; }
    .btn-cancel-detail { background: rgba(108, 117, 125, 0.1); color: #6c757d; border: 1px solid rgba(108, 117, 125, 0.3); border-radius: 6px; padding: 6px 12px; font-size: 0.85rem; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 6px; transition: all 0.2s; margin-right: 4px; }
    .btn-cancel-detail:hover { background: #6c757d; color: #fff; border-color: #6c757d; }
    .modal-table .btn-success { background: rgba(122, 47, 59, 0.1) !important; color: #7a2f3b !important; border: 1px solid rgba(122, 47, 59, 0.3) !important; border-radius: 6px !important; padding: 6px 12px !important; font-size: 0.85rem !important; font-weight: 500 !important; margin-right: 4px !important; transition: all 0.2s !important; }
    .modal-table .btn-success:hover { background: #7a2f3b !important; color: #fff !important; border-color: #7a2f3b !important; }
    .modal-table .btn-secondary { background: rgba(108, 117, 125, 0.1) !important; color: #6c757d !important; border: 1px solid rgba(108, 117, 125, 0.3) !important; border-radius: 6px !important; padding: 6px 12px !important; font-size: 0.85rem !important; font-weight: 500 !important; margin-right: 4px !important; transition: all 0.2s !important; }
    .modal-table .btn-secondary:hover { background: #6c757d !important; color: #fff !important; border-color: #6c757d !important; }
    .modal-table .btn-warning { background: #f0d4db !important; color: #7a2f3b !important; border: 1px solid rgba(122, 47, 59, 0.3) !important; border-radius: 6px !important; padding: 6px 12px !important; font-size: 0.85rem !important; font-weight: 500 !important; margin-right: 4px !important; transition: all 0.2s !important; }
    .modal-table .btn-warning:hover { background: #7a2f3b !important; color: #fff !important; border-color: #7a2f3b !important; }
    .modal-table .btn-danger { background: rgba(220, 53, 69, 0.1) !important; color: #dc3545 !important; border: 1px solid rgba(220, 53, 69, 0.3) !important; border-radius: 6px !important; padding: 6px 12px !important; font-size: 0.85rem !important; font-weight: 500 !important; margin-right: 4px !important; transition: all 0.2s !important; }
    .modal-table .btn-danger:hover { background: #dc3545 !important; color: #fff !important; border-color: #dc3545 !important; }
    .modal-table input.form-control-sm { border: 1px solid rgba(122, 47, 59, 0.3) !important; border-radius: 6px !important; padding: 6px 10px !important; font-size: 0.85rem !important; transition: border-color 0.2s, box-shadow 0.2s !important; }
    .modal-table input.form-control-sm:focus { border-color: #7a2f3b !important; box-shadow: 0 0 0 2px rgba(122, 47, 59, 0.15) !important; outline: none !important; }
</style>


<script>
$(document).ready(function () {
    // Lấy token từ meta và set header cho tất cả AJAX
    const csrfToken = $('meta[name="csrf-token"]').attr('content') || '';
    if (!csrfToken) {
        console.warn('CSRF token not found in meta tag!');
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    // Helper để kèm _token vào data (dùng cho mọi request)
    function withToken(data = {}) {
        return Object.assign({ _token: csrfToken }, data);
    }

    // Thêm chi tiết
    $(document).on('submit', '.addDetailForm', function (e) {
        e.preventDefault();
        const form = $(this);
        const productId = form.data('product-id');
        const color = form.find('input[name="color"]').val();
        const size = form.find('input[name="size"]').val();
        const quantity = form.find('input[name="quantity"]').val();

        if (!color || !size || !quantity) {
            alert('Vui lòng điền đầy đủ thông tin!');
            return;
        }

        $.ajax({
            url: `/admin/products/${productId}/details`,
            method: 'POST',
            data: withToken({ color, size, quantity }),
            success: function(response) {
                location.reload();
            },
            error: function(xhr) {
                const msg = xhr.responseJSON?.message || xhr.responseText || 'Lỗi không xác định';
                alert('Có lỗi xảy ra: ' + msg);
            }
        });
    });

    // Nhấn nút sửa: chuyển hàng sang chế độ chỉnh sửa
    $(document).on('click', '.editDetailBtn', function () {
        const id = $(this).data('id');
        const row = $(`#detail-row-${id}`);
        const color = $(this).data('color');
        const size = $(this).data('size');
        const quantity = $(this).data('quantity');

        row.addClass('editing');
        row.find('td:nth-child(2)').html(`<input type="text" class="form-control-sm edit-color" value="${color}">`);
        row.find('td:nth-child(3)').html(`<input type="text" class="form-control-sm edit-size" value="${size}">`);
        row.find('td:nth-child(4)').html(`<input type="number" class="form-control-sm edit-quantity" value="${quantity}" min="0">`);
        row.find('td:nth-child(5)').html(`
            <button type="button" class="btn-save-detail" data-id="${id}">
                <i class="fa fa-save"></i> Lưu
            </button>
            <button type="button" class="btn-cancel-detail" data-id="${id}">
                <i class="fa fa-times"></i> Hủy
            </button>
        `);
    });

    // Hủy chỉnh sửa
    $(document).on('click', '.btn-cancel-detail', function () {
        location.reload();
    });

    // Lưu thay đổi chi tiết
    $(document).on('click', '.btn-save-detail', function () {
        const id = $(this).data('id');
        const row = $(`#detail-row-${id}`);
        const color = row.find('.edit-color').val().trim();
        const size = row.find('.edit-size').val().trim();
        const quantity = parseInt(row.find('.edit-quantity').val());

        if (!color || !size || isNaN(quantity)) {
            alert('Vui lòng nhập đầy đủ thông tin hợp lệ!');
            return;
        }

        $.ajax({
            url: `/admin/product-details/${id}`,
            method: 'POST', // Laravel nhận PUT qua _method
            data: withToken({
                _method: 'PUT',
                color,
                size,
                quantity
            }),
            success: function (response) {
                alert(response.message || 'Cập nhật thành công!');
                location.reload();
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.message || xhr.responseText || 'Lỗi không xác định';
                alert('Có lỗi xảy ra: ' + msg);
            }
        });
    });

    // Xóa chi tiết
    $(document).on('click', '.deleteDetailBtn', function () {
        if (!confirm('Bạn có chắc muốn xóa chi tiết này không?')) return;

        const id = $(this).data('id');
        $.ajax({
            url: `/admin/product-details/${id}`,
            method: 'POST',
            data: withToken({ _method: 'DELETE' }),
            success: function (response) {
                alert(response.message || 'Đã xóa chi tiết!');
                location.reload();
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.message || xhr.responseText || 'Lỗi không xác định';
                alert('Không thể xóa: ' + msg);
            }
        });
    });
});
</script>
@endsection