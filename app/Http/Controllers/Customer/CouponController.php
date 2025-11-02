<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $code = $request->input('coupon_code');
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return redirect()->back()->with('error', 'Mã giảm giá không hợp lệ!');
        }

        $cart = session('cart', []);
        $cartTotal = session('cart_total', 0);

        if ($coupon->min_order_value && $cartTotal < $coupon->min_order_value) {
            return redirect()->back()->with('error', 'Đơn hàng chưa đạt giá trị tối thiểu!');
        }

        $discount = 0;

        // 🔹 Nếu là mã áp dụng cho toàn đơn hàng
        if ($coupon->scope === 'order') {
            $discount = $coupon->type === 'percent'
                ? $cartTotal * ($coupon->value / 100)
                : $coupon->value;

            session([
                'applied_coupon' => $coupon->code,
                'discount' => $discount
            ]);
        }

        // 🔹 Nếu là mã áp dụng cho sản phẩm cụ thể
        elseif ($coupon->scope === 'product' && $coupon->product_id) {
            foreach ($cart as &$item) {
                if ($item['product_id'] == $coupon->product_id) {
                    $productPrice = $item['price'] * $item['quantity'];
                    $discount = $coupon->type === 'percent'
                        ? $productPrice * ($coupon->value / 100)
                        : $coupon->value;
                    $item['discount'] = $discount;
                    break;
                }
            }

            session(['cart' => $cart]);
            session([
                'applied_coupon' => $coupon->code,
                'discount' => $discount,
                'coupon_product_id' => $coupon->product_id
            ]);
        }

        // 🔹 Tăng số lần sử dụng
        $coupon->increment('used_count');

        return redirect()->back()->with('success', 'Áp dụng mã giảm giá thành công!');
    }
}