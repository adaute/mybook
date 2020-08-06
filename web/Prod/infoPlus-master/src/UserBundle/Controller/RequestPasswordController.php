<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\Type\User\RequestPasswordType;
use UserBundle\Entity\Password\RequestPassword;

/**
 * @Route("/")
 */
class RequestPasswordController extends Controller
{
    /**
     * @param Request $request
     * @Route("/request-password", name="request_password")
     * @Method("GET|POST")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function requestPasswordAction(Request $request)
    {
        $form = $this->createForm(RequestPasswordType::class, new RequestPassword());

        if ($this->getRequestPasswordFormHandler()->handle($form, $request)) {
            $this->addFlash('success', $this->get('translator')->trans('user.reset_password.success', []));
            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('UserBundle:Default:request-password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    protected function getRequestPasswordFormHandler()
    {
        return $this->get('user.user_request_password.handler');
    }
}
