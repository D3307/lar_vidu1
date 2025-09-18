<?php

namespace App\Services\Payments;


class PaymentVnPay implements PaymentInterface
{
    protected $vnp_url;
    protected $vnp_Returnurl;
    protected $vnp_TmnCode;
    protected $vnp_HashSecret;
    protected  $vnp_TxnRef;
    protected $vnp_OrderInfo;
    protected $amount;
    protected $vnp_IpAddr;
    protected $inputData;
    function __construct($config = null)
    {
        $this->vnp_url = env('VNPAY_URL', "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html");
        $this->vnp_Returnurl = env('VNPAY_RETURN_URL', "");
        $this->vnp_HashSecret = $config['vnp_HashSecret'] ?? env('VNPAY_HASH_SECRET', ""); //Chuỗi bí mật

        $this->inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $config['vnp_TmnCode'] ?? env('VNP_TMN_CODE', ""),
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
            "vnp_Locale" => 'vn',
            "vnp_OrderType" => "billpayment",
            "vnp_ReturnUrl" =>  $config['redirect_url'],
        ];
        if (!empty($req['BankCode'])) {
            $this->inputData['vnp_BankCode'] = $req['BankCode'];
        }
    }
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
    function atm($amount, $order_id, $content_order = null)
    {
        $this->inputData["vnp_OrderInfo"] = $content_order ?? '';
        $this->inputData["vnp_TxnRef"] = $order_id ?? '';
        $this->inputData["vnp_Amount"] = $amount * 100;
        ksort($this->inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($this->inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $this->vnp_url . "?" . $query;
        if (isset($this->vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $this->vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = ['code' => '00', 'message' => 'success', 'payUrl' => $vnp_Url];
        return $returnData;
    }
}