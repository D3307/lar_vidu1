<?php

namespace App\Services\Payments;

use App\Models\Setting;
use Exception;

class Payment
{
    function initialize($payment = null, $config = null)
    {
        $config = [...$config];
        $setting = Setting::where('key', 'payment')->first();
        $setting = !empty($setting->value) ? json_decode($setting->value, true) : [];
        switch ($payment) {
            case 'MOMO':
                $settingMoMo = [...($setting['momo'] ?? []), ...$config];
                return new PaymentMoMo($settingMoMo);
            case 'VN_PAY':
                $settingVnpay = [...($setting['vnpay'] ?? []), ...$config];
                return  new PaymentVnPay($settingVnpay);
            default:
                return [
                    'type' => 'thanh toán khi nhận hàng',
                ];
        }
    }
    function checkout($payment, $amount, $order_id, $content_order = null)
    {
        if ($payment != null) {
            $jsonResult = $payment->atm($amount, $order_id, $content_order);
            return $jsonResult;
        } else {
            throw new Exception('không có phương thức thanh toán');
        }
    }
}