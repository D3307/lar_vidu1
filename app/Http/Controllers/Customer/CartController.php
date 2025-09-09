<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

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
        $request->validate([
            'size' => 'required',
            'color' => 'required',
            'material' => 'required',
            'quantity' => 'required|integer|min:1',
        ], [
            'size.required' => 'Vui lòng chọn kích thước',
            'color.required' => 'Vui lòng chọn màu sắc',
            'material.required' => 'Vui lòng chọn chất liệu',
            'quantity.required' => 'Vui lòng nhập số lượng',
        ]);

        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);
        $key = $id.'_'.$request->input('size').'_'.$request->input('color').'_'.$request->input('material');

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $request->input('quantity', 1);
        } else {
            $cart[$key] = [
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'image'    => $product->image,
                'size'     => $request->input('size'),
                'color'    => $request->input('color'),
                'material' => $request->input('material'),
                'quantity' => $request->input('quantity', 1),
            ];
        }

        session()->put('cart', $cart);

        // ⬇️ Ở nguyên trang chi tiết sản phẩm + hiện thông báo
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