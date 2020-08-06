<?php

namespace PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


class PaymentController extends Controller
{
    /**
     * @Route("/success", name="success")
     */
    public function successAction(Request $request)
    {
        $paymentId = $request->get('paymentId');
        $token     = $request->get('token');
        $payerId   = $request->get('PayerID');
        $user = NULL;

        if (empty($paymentId) || empty($token) || empty($payerId)) {
            return $this->redirectToRoute('homepage');
        }

        $payment = $this->get('paypal_payment.payment');
        // Validate the payment (execution)

        if($this->isGranted('IS_AUTHENTICATED_FULLY'))
            $user = $this->get('security.token_storage')->getToken()->getUser();

        // création de la facture
        $this->getPaymentManager()->createInvoice($payment->executePayment($paymentId, $token, $payerId),$user);

        return $this->redirectToRoute('user_invoice');
    }

    /**
     * @Route("/error", name="error")
     */
    public function errorAction()
    {
        die('Payment error');
    }

    public function getPaymentManager()
    {
        return $this->get('payment.payment_manager');
    }

    public function getUserManager()
    {
        return $this->get('user.user_manager');
    }
}
