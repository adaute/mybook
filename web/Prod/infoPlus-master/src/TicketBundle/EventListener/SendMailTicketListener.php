<?php

namespace TicketBundle\EventListener;

use CoreBundle\Services\Interfaces\MailerInterface;
use Twig_Environment;
use Symfony\Component\Routing\RouterInterface;
use TicketBundle\Entity\Manager\Interfaces\TicketManagerInterface;
use TicketBundle\event\TicketDataEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SendMailTicketListener
{
    /**
     * @var MailerInterface $mailerService
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
     * @var TicketManagerInterface $ticketManager
     */
    protected $ticketManager;

    /**
     * @var array
     */
    protected $template;

    /**
     * @var string $from
     */
    protected $from;

    /**
     * @param MailerInterface $mailerService
     * @param Twig_Environment $templating
     * @param $template
     * @param $from
     */
    public function __construct(MailerInterface $mailer, Twig_Environment $templating,
                                RouterInterface $router,
                                TicketManagerInterface $ticketManager, $template,
                                $from)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->router = $router;
        $this->ticketManager = $ticketManager;
        $this->template = $template;
        $this->from = $from;
    }

    /**
     * @param TicketDataEvent $event
     */
    public function onNewAnswerCreated(TicketDataEvent $event)
    {
        $this->mailer->sendMail(
            $this->from,
            $event->getTicket()->getEmail(),
            $this->templating->loadTemplate($this->template)->renderBlock('subject', []),
            $this->templating->loadTemplate($this->template)->renderBlock('body', [
                'ticket' => $event->getTicket(),
                'request_link' => $this->router->generate('ticket_show',
                    ['token' => $event->getTicket()->getToken()], UrlGeneratorInterface::ABSOLUTE_URL),
                'new' => 0
            ])
        );
    }

    /**
     * @param TicketDataEvent $event
     */
    public function onNewTicketCreated(TicketDataEvent $event)
    {
        $this->mailer->sendMail(
            $this->from,
            $event->getTicket()->getEmail(),
            $this->templating->loadTemplate($this->template)->renderBlock('subject', []),
            $this->templating->loadTemplate($this->template)->renderBlock('body', [
                'ticket' => $event->getTicket(),
                'request_link' => $this->router->generate('ticket_show',
                    ['token' => $event->getTicket()->getToken()], UrlGeneratorInterface::ABSOLUTE_URL),
                'new' => 1
            ])
        );
    }
}