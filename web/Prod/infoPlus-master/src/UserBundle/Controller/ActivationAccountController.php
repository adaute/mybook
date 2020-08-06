<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/")
 */
class ActivationAccountController extends Controller
{
    /**
     * @param Request $request
     * @Route("/activation-account", name="activation_account")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function requestActivationAction(Request $request)
    {
        try {
            $token = $request->query->get('token');

            if (!$token) {
                throw new \Exception('Incorrect Token.');
            }

            $user = $this->getUserManager()->getUserByConfirmationToken($token);

            if (!$user) {
                throw new \Exception('User not identified in our database with this token.');
            }

            $this->getUserManager()->clearConfirmationTokenUser($user);
            $this->getUserManager()->activationAccountUser($user);

            $this->addFlash('success', $this->get('translator')->trans('user.activation.success', [], 'messages'));

            return $this->redirect($this->generateUrl('security_login_register_form'));

        } catch (\Exception $ex) {
            $this->addFlash('error', $ex->getMessage());
            return $this->redirect($this->generateUrl('security_login_register_form'));
        }
    }

    public function getUserManager()
    {
        return $this->get('user.user_manager');
    }

}