<?php

namespace UserBundle\EventListener;

use CoreBundle\Services\Interfaces\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig_Environment;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use UserBundle\Event\UserDataEvent;
use UserBundle\Entity\Manager\Interfaces\UserManagerInterface;

class SendRequestPasswordMailListener
{
    /**
     * @var MailerInterface $mailer
     */
    protected $mailer;

    /**
     * @var \Twig_Environment
     */
    protected $templating;

    /**
     *
     * @var RouterInterface $router
     */
    protected $router;

    /**
     *
     * @var TokenGeneratorInterface $tokenGenerator
     */
    protected $tokenGenerator;

    /**
     * @var UserManagerInterface $userManager
     */
    protected $userManager;

    /**
     * @var array
     */
    protected $template;

    /**
     * @var string $from
     */
    protected $from;

    /**
     * @param MailerInterface $mailer
     * @param Twig_Environment $templating
     * @param $template
     * @param $from
     */
    public function __construct(MailerInterface $mailer, Twig_Environment $templating, RouterInterface $router,
                                TokenGeneratorInterface $tokenGenerator, UserManagerInterface $userManager, $template,
                                $from)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->router = $router;
        $this->tokenGenerator = $tokenGenerator;
        $this->userManager = $userManager;
        $this->template = $template;
        $this->from = $from;
    }

    /**
     * @param UserDataEvent $event
     */
    public function onRequestedPassword(UserDataEvent $event)
    {
        $user = $event->getUser();
        $token = $this->tokenGenerator->generateToken();
        $this->userManager->updateConfirmationTokenUser($user, $token);

        $this->mailer->sendMail(
            $this->from,
            $user->getEmail(),
            $this->templating->loadTemplate($this->template)->renderBlock('subject', []),
            $this->templating->loadTemplate($this->template)->renderBlock('body',
                [
                    'username' => $user->getUsername(),
                    'request_link' => $this->router->generate('reset_password',
                        ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL)
                ])
        );
    }
}