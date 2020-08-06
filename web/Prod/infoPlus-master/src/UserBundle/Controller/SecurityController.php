<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Controller used to manage the userlication security.
 * See http://symfony.com/doc/current/cookbook/security/form_login_setup.html.
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 * @author Fabien Potencier <fabien@symfony.com>
 */

class SecurityController extends Controller
{

    /**
     * Permet de gérer la connection et inscription
     * @Route("/access", name="security_login_register_form")
     */
    public function accessAction()
    {
        return $this->render('UserBundle:Security:access.html.twig', []);
    }


    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        return $this->render('UserBundle:Security:login.html.twig',
                array(
                // dernier username taper
                'last_username' => $authenticationUtils->getLastUsername(),
                // derniere erreurs
                'error' => $authenticationUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * Prise en charge par le firewall : config/security.yml
     * @Route("/login_check", name="security_login_check")
     */
    public function loginCheckAction()
    {
        throw new \Exception('Le firewall logincheck non configure');
    }

    /**
     * Prise en charge par le firewall : /config/security.yml
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('Le firewall logout non configure');
    }
}