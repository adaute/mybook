<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\Type\User\ResetPasswordType;
use UserBundle\Entity\Password\ResetPassword;

/**
 * @Route("/")
 */
class ResetPasswordController extends Controller
{
    /**
     * @param Request $request
     * @Route("/reset-password", name="reset_password")
     * @Method("GET|POST")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function requestPasswordAction(Request $request)
    {
        try {
            $form = $this->createForm(ResetPasswordType::class, new ResetPassword());

            if ($this->getResetPasswordFormHandler()->handle($form, $request)) {
                $this->addFlash('success', $this->get('translator')->trans('user.reset_password.successful_reset', []));
                return $this->redirect($this->generateUrl('homepage'));
            }

            return $this->render('UserBundle:Default:reset-password.html.twig',
                    [
                    'form' => $form->createView(),
            ]);
        } catch (\Exception $ex) {
            $this->addFlash('error', $ex->getMessage());
            return $this->redirect($this->generateUrl('security_login_register_form'));
        }
    }

    protected function getResetPasswordFormHandler()
    {
        return $this->get('user.user_reset_password.handler');
    }
}