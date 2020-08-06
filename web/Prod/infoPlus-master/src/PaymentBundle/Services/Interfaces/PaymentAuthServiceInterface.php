<?php

namespace PaymentBundle\Services\Interfaces;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Config\Definition\Exception\Exception;


interface PaymentAuthServiceInterface
{
    /**
     * Get the token
     * @return JsonResponse
     */
    public function getToken();

}