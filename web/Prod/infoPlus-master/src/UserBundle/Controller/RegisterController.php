<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\Type\User\RegistrationType;
use UserBundle\Entity\Registration\Registration;

/**
 * Controller used to manage the userlication security.
 * See http://symfony.com/doc/current/cookbook/security/form_login_setup.html.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class RegisterController extends Controller
{

    /**
     * @param Request $request
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $form = $this->createForm(RegistrationType::class, new Registration());

        if ($this->getRegistrationFormHandler()->handle($form, $request)) {

            $form = $this->createForm(RegistrationType::class, new Registration());

            return $this->render('UserBundle:Security:register.html.twig', [
                'form' => $form->createView(),
                'success' => 'user.registration.success'
            ]);
        }

        return $this->render('UserBundle:Security:register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    protected function getRegistrationFormHandler()
    {
        return $this->get('user.user_registration.handler');
    }
}