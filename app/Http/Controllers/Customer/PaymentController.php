<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{
    /**
     * Tạo thanh toán MoMo
     */
    public function payWithMomo(Order $order)
    {
        $order->update(['payment_method' => 'momo']);

        $endpoint    = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = env("MOMO_PARTNER_CODE");
        $accessKey   = env("MOMO_ACCESS_KEY");
        $secretKey   = env("MOMO_SECRET_KEY");

        $orderIdMomo = (string) time();
        $orderInfo   = "Thanh toán đơn hàng #" . $order->id;
        $amount      = (int) round($order->total);
        $requestId   = (string) time();
        $requestType = "payWithATM";

        // Lấy base ngrok nếu có
        $ngrok = env('NGROK_URL');

        $redirectRelative = route('customer.success', ['order_id' => $order->id], false);
        $ipnRelative      = route('payment.momo.callback', [], false);

        $redirectUrl = $ngrok ? rtrim($ngrok, '/') . $redirectRelative : route('customer.success', ['order_id' => $order->id]);
        $ipnUrl      = $ngrok ? rtrim($ngrok, '/') . $ipnRelative : route('payment.momo.callback');

        $extraData = (string) $order->id; // truyền id đơn hàng để callback nhận diện

        // Tạo signature
        $rawHash = "accessKey=" . $accessKey .
            "&amount=" . $amount .
            "&extraData=" . $extraData .
            "&ipnUrl=" . $ipnUrl .
            "&orderId=" . $orderIdMomo .
            "&orderInfo=" . $orderInfo .
            "&partnerCode=" . $partnerCode .
            "&redirectUrl=" . $redirectUrl .
            "&requestId=" . $requestId .
            "&requestType=" . $requestType;

        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            'storeId'     => "MomoTestStore",
            'requestId'   => $requestId,
            'amount'      => $amount,
            'orderId'     => $orderIdMomo,
            'orderInfo'   => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl'      => $ipnUrl,
            'lang'        => 'vi',
            'extraData'   => $extraData,
            'requestType' => $requestType,
            'signature'   => $signature
        ];

        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $result = curl_exec($ch);
        curl_close($ch);

        $jsonResult = json_decode($result, true);

        if (!isset($jsonResult['payUrl'])) {
            \Log::error('MoMo không trả về payUrl', ['response' => $jsonResult]);
            return response()->json([
                'error'    => 'MoMo không trả về payUrl',
                'response' => $jsonResult
            ], 400);
        }

        return redirect()->away($jsonResult['payUrl']);
    }

    /**
     * Callback từ MoMo (IPN)
     */
    public function momoCallback(Request $request)
    {
        \Log::info('MoMo callback', $request->all());

        // Ưu tiên extraData, fallback sang orderId nếu cần
        $orderId = $request->extraData ?? null;

        $order = Order::find($orderId);
        if ($order) {
            if ((int)$request->resultCode === 0) {
                $order->update([
                    'payment_status' => 'paid',
                    'payment_method' => 'momo'
                ]);
            } else {
                $order->update([
                    'payment_status' => 'failed',
                    'payment_method' => 'momo'
                ]);
            }
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Fake callback để test nhanh không cần gọi MoMo http://127.0.0.1:8000/payment/momo/fake-callback/{id đơn hàng vừa tạo}
     */
    public function fakeMomoCallback($orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->update([
                'payment_status' => 'paid',
                'payment_method' => 'momo'
            ]);
        }
        return view('customer.success', compact('order'));
    }

    /**
     * Trang success hiển thị cho user sau khi thanh toán
     */
    public function success(Request $request)
    {
        $orderId = $request->order_id ?? $request->orderId ?? null;

        if ($orderId) {
            $order = Order::find($orderId);
        } else {
            $order = Order::latest()->first();
        }

        return view('customer.success', compact('order'));
    }
}