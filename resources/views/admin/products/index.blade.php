@extends('admin.layout')

@section('title', 'Quản lý sản phẩm')

@push('styles')
    @vite(['resources/css/admin/products/index.css', 'resources/js/app.js'])
@endpush

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
                @if($product->details->count())
                    <div class="variants-section">
                        <h6 style="color:#7a2f3b;margin-bottom:12px;">Chi tiết sản phẩm:</h6>
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
                                            <input type="hidden" name="details[{{ $detail->id }}][color]" value="{{ $detail->color }}">
                                        </td>
                                        <td>
                                            <span class="size-badge">{{ $detail->size }}</span>
                                            <input type="hidden" name="details[{{ $detail->id }}][size]" value="{{ $detail->size }}">
                                        </td>
                                        <td>
                                            <span class="quantity-badge">{{ $detail->quantity }}</span>
                                            <input type="hidden" name="details[{{ $detail->id }}][quantity]" value="{{ $detail->quantity }}">
                                        </td>
                                        <td>
                                            <button type="button" class="btn-variant btn-variant-edit editDetailBtn"
                                                    data-id="{{ $detail->id }}"
                                                    data-color="{{ $detail->color }}"
                                                    data-size="{{ $detail->size }}"
                                                    data-quantity="{{ $detail->quantity }}">
                                                <i class="fa fa-edit"></i> Sửa
                                            </button>
                                            <button type="button" class="btn-variant btn-variant-delete deleteDetailBtn" 
                                                    data-id="{{ $detail->id }}">
                                                <i class="fa fa-trash"></i> Xóa
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5">
                                            <form class="addDetailForm" data-product-id="{{ $product->id }}">
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
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="no-variants">
                        <i class="fa fa-exclamation-triangle" style="color:#f39c12;margin-right:8px;"></i>
                        <span class="text-muted">Chưa có chi tiết sản phẩm.</span>
                    </div>
                @endif
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
@endsection