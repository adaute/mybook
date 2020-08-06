<?php

namespace PaymentBundle\Services\Interfaces;


interface PaymentManagerServiceInterface
{
    public function executePayment($paymentId, $token, $payerId);

    public function sendPayment($params = []);

}