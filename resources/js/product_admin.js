$(document).ready(function () {
    // Setup CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Thêm chi tiết
    $(document).on('submit', '.addDetailForm', function (e) {
        e.preventDefault();
        let form = $(this);
        let productId = form.data('product-id');
        let color = form.find('input[name="color"]').val();
        let size = form.find('input[name="size"]').val();
        let quantity = form.find('input[name="quantity"]').val();

        if (!color || !size || !quantity) {
            alert('Vui lòng điền đầy đủ thông tin!');
            return;
        }

        $.ajax({
            url: `/admin/products/${productId}/details`,
            method: 'POST',
            data: { color, size, quantity },
            success: function(response) {
                location.reload(); // Reload để hiển thị dữ liệu mới
            },
            error: function(xhr) {
                alert('Có lỗi xảy ra: ' + xhr.responseText);
            }
        });
    });

    // Sửa chi tiết - GỬI LÊN SERVER
    $(document).on('click', '.editDetailBtn', function () {
        let id = $(this).data('id');
        let row = $(`#detail-row-${id}`);
        
        // Lấy giá trị hiện tại
        let currentColor = row.find('.color-name').text() || row.find('input[name*="[color]"]').val();
        let currentSize = row.find('.size-badge').text() || row.find('input[name*="[size]"]').val();  
        let currentQuantity = row.find('.quantity-badge').text() || row.find('input[name*="[quantity]"]').val();

        // Lưu HTML gốc
        row.data('original-html', row.html());

        // Hiển thị form edit
        row.html(`
            <td>•</td>
            <td><input type="text" class="form-control form-control-sm edit-color" value="${currentColor.trim()}" data-original="${currentColor}"></td>
            <td><input type="text" class="form-control form-control-sm edit-size" value="${currentSize.trim()}" data-original="${currentSize}"></td>
            <td><input type="number" class="form-control form-control-sm edit-quantity" value="${currentQuantity.trim()}" min="0" data-original="${currentQuantity}"></td>
            <td>
                <button type="button" class="btn btn-sm btn-success saveDetailBtn" data-id="${id}">
                    <i class="fa fa-save me-1"></i>Lưu
                </button>
                <button type="button" class="btn btn-sm btn-secondary cancelEditBtn" data-id="${id}">
                    <i class="fa fa-times me-1"></i>Hủy
                </button>
            </td>
        `);
    });

    // Lưu thay đổi - GỬI LÊN SERVER
    $(document).on('click', '.saveDetailBtn', function () {
        let id = $(this).data('id');
        let row = $(`#detail-row-${id}`);
        let color = row.find('.edit-color').val().trim();
        let size = row.find('.edit-size').val().trim();
        let quantity = parseInt(row.find('.edit-quantity').val());

        if (!color || !size || isNaN(quantity)) {
            alert('Vui lòng điền đầy đủ thông tin hợp lệ!');
            return;
        }

        // Disable nút để tránh click nhiều lần
        $(this).prop('disabled', true).text('Đang lưu...');

        $.ajax({
            url: `/admin/product-details/${id}`,
            method: 'PUT',
            data: {
                color: color,
                size: size,
                quantity: quantity,
                _method: 'PUT'
            },
            success: function(response) {
                // Cập nhật hiển thị với dữ liệu mới
                row.html(`
                    <td>•</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span class="color-preview" style="background-color:${color};"></span>
                            <span class="color-name">${color}</span>
                        </div>
                    </td>
                    <td><span class="size-badge">${size}</span></td>
                    <td><span class="quantity-badge">${quantity}</span></td>
                    <td>
                        <button type="button" class="btn btn-sm btn-warning editDetailBtn" data-id="${id}">
                            <i class="fa fa-edit me-1"></i>Sửa
                        </button>
                        <button type="button" class="btn btn-sm btn-danger deleteDetailBtn" data-id="${id}">
                            <i class="fa fa-trash me-1"></i>Xóa
                        </button>
                    </td>
                `);
                
                alert('Cập nhật thành công!');
                location.reload();
            },
            error: function(xhr) {
                console.error('Update error:', xhr);
                alert('Có lỗi xảy ra khi cập nhật: ' + (xhr.responseJSON?.message || 'Lỗi không xác định'));
                
                // Khôi phục nút
                row.find('.saveDetailBtn').prop('disabled', false).html('<i class="fa fa-save me-1"></i>Lưu');
            }
        });
    });

    // Hủy sửa
    $(document).on('click', '.cancelEditBtn', function () {
        let id = $(this).data('id');
        let row = $(`#detail-row-${id}`);
        let originalHtml = row.data('original-html');
        
        if (originalHtml) {
            row.html(originalHtml);
        }
    });

    // Xóa chi tiết - GỬI LÊN SERVER
    $(document).on('click', '.deleteDetailBtn', function () {
        let id = $(this).data('id');
        
        if (!confirm("Bạn có chắc muốn xóa chi tiết này không?\nHành động này không thể hoàn tác!")) {
            return;
        }

        // Disable nút
        $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>Xóa...');

        $.ajax({
            url: `/admin/product-details/${id}`,
            method: 'DELETE',
            data: {
                _method: 'DELETE'
            },
            success: function(response) {
                $(`#detail-row-${id}`).fadeOut(300, function() {
                    $(this).remove();
                });
                alert('Xóa thành công!');
            },
            error: function(xhr) {
                console.error('Delete error:', xhr);
                alert('Có lỗi xảy ra khi xóa: ' + (xhr.responseJSON?.message || 'Lỗi không xác định'));
                
                // Khôi phục nút
                $(`#detail-row-${id}`).find('.deleteDetailBtn')
                    .prop('disabled', false)
                    .html('<i class="fa fa-trash me-1"></i>Xóa');
            }
        });
    });
});