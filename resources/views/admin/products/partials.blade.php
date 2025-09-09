<!-- Bảng hiển thị kết quả của phần tìm kiếm -->
<tbody>
    @forelse($products as $product)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->category->name ?? '-' }}</td>
        <td>{{ number_format($product->price, 0, ',', '.') }} đ</td>
        <td>{{ $product->quantity }}</td>
        <td>{{ $product->status == 'active' ? 'Hiển thị' : 'Ẩn' }}</td>
        <td>
            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-action btn-edit">Sửa</a>
            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline">
                @csrf @method('DELETE')
                <button type="submit" onclick="return confirm('Xóa sản phẩm này?')" class="btn-action btn-delete">Xóa</button>
            </form>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="7" style="text-align:center;color:#999;padding:12px">Không có sản phẩm nào</td>
    </tr>
    @endforelse
</tbody>