<?php

namespace App\Services\Payments;


interface PaymentInterface
{
    function atm($amount, $order_id,  $content_order = null);
}