<?php

namespace UserBundle\Controller;

use UserBundle\Form\Type\User\ChangePasswordType;
use UserBundle\Entity\Password\ChangePassword;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/account")
 */
class ChangePasswordController extends Controller
{
    /**
     * @param Request $request
     * @Route("/change-password", name="change_password")
     * @Method("GET|POST")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function changePasswordAction(Request $request)
    {
        $data = new ChangePassword($this->getUser());
        $form = $this->createForm(ChangePasswordType::class, $data);

        if ($this->getChangePasswordFormHandler()->handle($form, $request)) {
            $this->addFlash('success', $this->get('translator')->trans('user.change_password.success', [], 'messages'));
            return $this->redirect($this->generateUrl('user_dashboard'));
        }

        return $this->render('UserBundle:Default:change-password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    protected function getChangePasswordFormHandler()
    {
        return $this->get('user.user_change_password.handler');
    }
}
