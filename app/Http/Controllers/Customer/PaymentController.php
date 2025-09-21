<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Tạo thanh toán MoMo
     */
    public function payWithMomo(Order $order)
    {
        $order->update(['payment_method' => 'momo', 'payment_status' => 'unpaid']);

        $endpoint    = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = env("MOMO_PARTNER_CODE");
        $accessKey   = env("MOMO_ACCESS_KEY");
        $secretKey   = env("MOMO_SECRET_KEY");

        // Tạo momo_order_id để mapping khi callback
        $orderIdMomo = 'ORDER_' . $order->id . '_' . time();
        $orderInfo   = "Thanh toán đơn hàng #" . $order->id;
        $amount      = (int) round($order->total);
        $requestId   = (string) time();
        $requestType = "payWithATM";

        // Các url callback
        $redirectUrl = route('payment.momo.return');
        $ipnUrl      = route('payment.momo.notify');

        $extraData = (string) $order->id;

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
            return back()->with('error', $jsonResult['message'] ?? 'MoMo error');
        }

        // Lưu lại thông tin mapping MoMo
        $order->update([
            'momo_order_id'  => $orderIdMomo,
            'momo_request_id'=> $requestId,
        ]);

        return redirect()->away($jsonResult['payUrl']);
    }

    /**
     * Xử lý return từ MoMo (user quay lại sau khi thanh toán)
     */
    public function momoReturn(Request $request)
    {
        Log::info('MoMo Return Data:', $request->all());

        $resultCode = $request->resultCode;
        $orderId = $request->orderId;

        if ($resultCode == 0) {
            // Thanh toán thành công
            $order = Order::where('momo_order_id', $orderId)->first();

            if ($order) {
                $order->update([
                    'payment_status' => 'paid',
                    'status'         => 'processing',
                    'momo_trans_id'  => $request->transId,
                    'payment_method' => 'momo',
                    'paid_at'        => now(),
                ]);
                // Xóa giỏ hàng nếu cần
                // Cart::where('user_id', $order->user_id)->delete();

                return redirect()->route('customer.success', ['order_id' => $order->id])
                                 ->with('success', 'Thanh toán thành công!');
            }
        }

        // Thanh toán thất bại
        return redirect()->route('user.cart.index')
                         ->with('error', 'Thanh toán thất bại. Vui lòng thử lại.');
    }

    /**
     * Xử lý notify (IPN) từ MoMo
     */
    public function momoNotify(Request $request)
    {
        Log::info('MoMo IPN Data:', $request->all());

        $orderId = $request->orderId;
        $order = Order::where('momo_order_id', $orderId)->first();

        if (!$order) {
            Log::error('MoMo IPN: Order not found - ' . $orderId);
            return response('Order not found', 404);
        }

        if ((int)$request->resultCode === 0) {
            $order->update([
                'payment_status' => 'paid',
                'status'         => 'processing',
                'momo_trans_id'  => $request->transId,
                'payment_method' => 'momo',
                'paid_at'        => now(),
            ]);
            Log::info('MoMo IPN: Order paid successfully - ' . $orderId);
        } else {
            $order->update([
                'payment_status' => 'failed',
                'status'         => 'failed',
                'payment_method' => 'momo'
            ]);
            Log::info('MoMo IPN: Order payment failed - ' . $orderId);
        }

        return response('OK', 200);
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