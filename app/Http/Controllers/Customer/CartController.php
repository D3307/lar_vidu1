<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductDetail;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('customer.cart.index', compact('cart'));
    }

    // Thêm sản phẩm vào giỏ
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $detail = ProductDetail::where('product_id', $id)
            ->when($request->size, fn($q) => $q->where('size', $request->size))
            ->when($request->color, fn($q) => $q->where('color', $request->color))
            ->first();

        if (!$detail) {
            return back()->with('error', 'Không tìm thấy chi tiết sản phẩm.');
        }

        $cart = session()->get('cart', []);
        $key = $detail->id; // dùng product_detail_id làm key

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $request->quantity;
        } else {
            $cart[$key] = [
                'id' => $product->id,
                'product_detail_id' => $detail->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'size' => $detail->size,
                'color' => $detail->color,
                'image' => $product->image,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', '🎉 Sản phẩm đã được thêm vào giỏ hàng!');
    }

    // Cập nhật số lượng sản phẩm trong giỏ
    public function update(Request $request, $key)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = max(1, (int) $request->input('quantity', 1)); // tránh số lượng < 1
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cập nhật giỏ hàng thành công');
    }

    // Xóa một sản phẩm khỏi giỏ
    public function remove($key)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng');
    }

    // Xóa toàn bộ giỏ hàng
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Đã xóa toàn bộ giỏ hàng');
    }

    public function removeSelected(Request $request)
    {
        $selectedKeys = $request->input('selected', []); // Danh sách sản phẩm đã chọn

        $cart = session()->get('cart', []);

        foreach ($selectedKeys as $key) {
            if (isset($cart[$key])) {
                unset($cart[$key]);
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm đã chọn khỏi giỏ hàng');
    }
}