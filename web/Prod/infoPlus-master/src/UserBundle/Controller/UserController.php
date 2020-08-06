<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/account")
 */
class UserController extends Controller
{
    /**
     * @Route("/payment", name="payment_cotisation")
     */
    public function paymentAction()
    {
        $product = $this->getProductManager()->getProductCotisation();

        if ($product) {

            $price = $product[0]->getPrice();
            $description = 'cotisation:'.$product[0]->getId().':'.$product[0]->getDescription();


        $payment = $this->getPaymentManager();

        $paymentSend = $payment->sendPayment([
            'amount' => $price,
            'description' => $description,
        ]);

        return $this->redirect($paymentSend['redirectPaypalApproval']);

        }
        return $this->redirectToRoute('user_cotisation');

    }

    /**
     * @Route("/dashboard", name="user_dashboard")
     * @Method("GET|POST")
     */
    public function dashboardAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $this->getUserManager()->checkCotisation($user);
        return $this->render('UserBundle:Default:dashboard.html.twig');
    }

    /**
     * @Route("/cotisation", name="user_cotisation")
     * @Template("UserBundle:Default:Setting/cotisation.html.twig")
     * @Method("GET|POST")
     */
    public function cotisationAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $check = $this->getUserManager()->checkCotisation($user);

        return [
            'check' => $check,
        ];
    }

    /**
     * @Route("/usages-conditions", name="usages_conditions")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function usagesConditionAction()
    {
        return $this->render('UserBundle:Default:usages-conditions.html.twig');
    }

    public function getUserManager()
    {
        return $this->get('user.user_manager');
    }

    public function getProductManager()
    {
        return $this->get('payment.product_manager');
    }
    public function getPaymentManager()
    {
        return $this->get('paypal_payment.payment');
    }
}
