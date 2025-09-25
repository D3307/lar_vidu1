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

        // Validate: bắt buộc chọn size, color, quantity
        $request->validate([
            'size'     => 'required|string',
            'color'    => 'required|string',
            'quantity' => 'required|integer|min:1',
            'material' => 'nullable|string',
        ]);

        // Tìm đúng ProductDetail theo size + color
        $detail = ProductDetail::where('product_id', $id)
            ->where('size', $request->size)
            ->where('color', $request->color)
            ->first();

        if (!$detail) {
            return back()->with('error', 'Vui lòng chọn đúng size và màu sắc.');
        }

        $cart = session()->get('cart', []);
        $key = $detail->id;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $request->quantity;
        } else {
            $cart[$key] = [
                'id'                => $product->id,
                'product_detail_id' => $detail->id,
                'name'              => $product->name,
                'price'             => $product->price,
                'quantity'          => $request->quantity,
                'size'              => $detail->size,
                'color'             => $detail->color,
                'material'          => $product->material,
                'image'             => $product->image,
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