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

        $cartTotal = session('cart_total', 0);

        if ($coupon->min_order_value && $cartTotal < $coupon->min_order_value) {
            return redirect()->back()->with('error', 'Đơn hàng chưa đạt giá trị tối thiểu!');
        }

        $discount = $coupon->type === 'percent'
            ? $cartTotal * ($coupon->value / 100)
            : $coupon->value;

        // Lưu vào session
        session([
            'applied_coupon' => $coupon->code,
            'discount' => $discount
        ]);

        // Tăng số lần sử dụng
        $coupon->increment('used_count');

        return redirect()->back()->with('success', 'Áp dụng mã giảm giá thành công!');
    }
}