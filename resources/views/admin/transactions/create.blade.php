{{-- resources/views/admin/transactions/create.blade.php --}}
@extends('admin.layout')

@section('content')
<div class="admin-card">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
        <h3 style="margin:0;font-size:1.1rem;color:#222;">
            <i class="fa fa-plus me-2" style="color:#e75480;"></i>
            Tạo phiếu nhập/xuất
        </h3>
        <a href="{{ route('admin.transactions.index', ['type' => request('type', 'import')]) }}" class="btn-history-back">
            <i class="fa fa-arrow-left me-1"></i> Quay lại
        </a>
    </div>

    <form action="{{ route('admin.transactions.store') }}" method="POST" class="transaction-form">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Loại phiếu</label>
                <select name="type" class="form-select">
                    <option value="import" {{ request('type') == 'import' ? 'selected' : '' }}>Nhập kho</option>
                    <option value="export" {{ request('type') == 'export' ? 'selected' : '' }}>Xuất kho</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Ghi chú</label>
                <input type="text" name="note" class="form-control" placeholder="Nhập ghi chú (tùy chọn)">
            </div>
        </div>

        <div class="form-section">
            <h5 style="color:#e75480;margin-bottom:12px;">Chi tiết sản phẩm</h5>
            
            <div id="items" class="items-container">
                <div class="item-row mb-3">
                    <div class="row align-items-end">
                        <div class="col-md-8">
                            <label class="form-label">Sản phẩm</label>
                            <select name="items[0][inventory_id]" class="form-select">
                                @foreach($inventories as $inv)
                                    <option value="{{ $inv->id }}">
                                        {{ $inv->product->name }} (Tồn: {{ $inv->quantity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Số lượng</label>
                            <input type="number" name="items[0][quantity]" class="form-control" placeholder="Số lượng" min="1">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn-remove-item" onclick="removeItem(this)" style="display:none;">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn-add-item mb-3" onclick="addItem()">
                <i class="fa fa-plus me-1"></i> Thêm sản phẩm
            </button>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fa fa-save me-1"></i> Lưu phiếu
            </button>
        </div>
    </form>
</div>

<script>
let itemIndex = 1;
function addItem() {
    const div = document.createElement('div');
    div.classList.add('item-row', 'mb-3');
    div.innerHTML = `
        <div class="row align-items-end">
            <div class="col-md-8">
                <label class="form-label">Sản phẩm</label>
                <select name="items[${itemIndex}][inventory_id]" class="form-select">
                    @foreach($inventories as $inv)
                        <option value="{{ $inv->id }}">
                            {{ $inv->product->name }} (Tồn: {{ $inv->quantity }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Số lượng</label>
                <input type="number" name="items[${itemIndex}][quantity]" class="form-control" placeholder="Số lượng" min="1">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn-remove-item" onclick="removeItem(this)">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    document.getElementById('items').appendChild(div);
    itemIndex++;
    updateRemoveButtons();
}

function removeItem(btn) {
    btn.closest('.item-row').remove();
    updateRemoveButtons();
}

function updateRemoveButtons() {
    const items = document.querySelectorAll('.item-row');
    items.forEach((item, index) => {
        const removeBtn = item.querySelector('.btn-remove-item');
        if (items.length > 1) {
            removeBtn.style.display = 'block';
        } else {
            removeBtn.style.display = 'none';
        }
    });
}
</script>

<style>
    .admin-card {
        background: #fff;
        padding: 18px;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(231,84,128,0.06);
        max-width: 900px;
        margin: 0 auto;
    }
    .transaction-form .form-label {
        font-weight: 500;
        color: #222;
        margin-bottom: 6px;
    }
    .transaction-form .form-control,
    .transaction-form .form-select {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px 12px;
        transition: border-color 0.18s;
    }
    .transaction-form .form-control:focus,
    .transaction-form .form-select:focus {
        border-color: #e75480;
        box-shadow: 0 0 0 0.08rem rgba(231,84,128,0.13);
    }
    .form-section {
        background: #faf7fa;
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 20px;
    }
    .items-container {
        margin-bottom: 16px;
    }
    .btn-add-item {
        background: #1abc9c;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 18px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.18s;
    }
    .btn-add-item:hover {
        background: #16a085;
    }
    .btn-remove-item {
        background: #e74c3c;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 8px 10px;
        cursor: pointer;
        transition: background 0.18s;
    }
    .btn-remove-item:hover {
        background: #c0392b;
    }
    .btn-submit {
        background: #e75480;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 12px 28px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.18s;
    }
    .btn-submit:hover {
        background: #c13c6a;
    }
    .btn-history-back {
        border: 1.5px solid #e75480;
        background: #fff;
        color: #e75480;
        padding: 8px 18px;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.18s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-history-back:hover {
        background: #f9f3f3;
        color: #7a2f3b;
        border-color: #7a2f3b;
    }
</style>
@endsection