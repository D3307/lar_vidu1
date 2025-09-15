<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{
    public function payWithMomo(Order $order)
    {
        $order->update(['payment_method' => 'momo']);

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = env("MOMO_PARTNER_CODE");
        $accessKey   = env("MOMO_ACCESS_KEY");
        $secretKey   = env("MOMO_SECRET_KEY");

        $orderIdMomo   = time() . "";   // Mã đơn hàng MoMo
        $orderInfo     = "Thanh toán đơn hàng #" . $order->id;
        $amount = (int) round($order->total);   // đảm bảo thành số nguyên hợp lệ
        $redirectUrl   = route('customer.success', ['order_id' => $order->id]); // Sau khi thanh toán xong
        $ipnUrl        = "https://bd38a3633997.ngrok-free.app/payment/momo/callback";
        $requestId     = time() . "";
        $requestType   = "payWithATM";

        // Gửi thêm extraData = id đơn hàng để callback biết cập nhật đơn nào
        $extraData     = (string) $order->id;

        // Tạo chữ ký (signature)
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

        // ✅ Kiểm tra xem MoMo có trả về payUrl không
        if (!isset($jsonResult['payUrl'])) {
            // Debug lỗi trả về từ MoMo
            return response()->json([
                'error' => 'MoMo không trả về payUrl',
                'response' => $jsonResult
            ]);
        }

        // Redirect sang trang thanh toán MoMo
        return redirect()->away($jsonResult['payUrl']);
    }

    public function momoCallback(Request $request)
    {
        \Log::info('MoMo callback', $request->all());

        $order = Order::find($request->extraData);
        if ($order) {
            if ($request->resultCode == 0) {
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

        // Trả về JSON cho MoMo, không redirect
        return response()->json(['status' => 'ok']);
    }


    // filepath: http://127.0.0.1:8000/payment/momo/fake-callback/{id đơn hàng vừa tạo}
    public function fakeMomoCallback($orderId)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->update(['payment_status' => 'paid', 'payment_method' => 'momo']);
        }
        // Truyền biến $order về view success
        return view('customer.success', compact('order'));
    }

    //Thông báo thanh toán thành công
    public function success(Request $request)
    {
        // MoMo redirect về có thể có ?order_id=xxx
        $orderId = $request->order_id ?? $request->orderId ?? null;

        if ($orderId) {
            $order = Order::find($orderId);
        } else {
            // fallback: lấy đơn hàng mới nhất
            $order = Order::latest()->first();
        }

        return view('customer.success', compact('order'));
    }
}