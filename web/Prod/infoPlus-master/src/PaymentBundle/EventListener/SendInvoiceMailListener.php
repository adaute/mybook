<?php

namespace PaymentBundle\EventListener;

use CoreBundle\Services\Interfaces\MailerInterface;
use Twig_Environment;
use PaymentBundle\Entity\Manager\Interfaces\InvoiceManagerInterface;
use UserBundle\Event\UserDataEvent;
use PaymentBundle\Event\PaymentDataEvent;

class SendInvoiceMailListener
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
     * @var InvoiceManagerInterface $invoiceManager
     */
    protected $invoiceManager;

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
                                InvoiceManagerInterface $invoiceManager, $template,
                                $from)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->invoiceManager = $invoiceManager;
        $this->template = $template;
        $this->from = $from;
    }

    /**
     * @param PaymentDataEvent $event
     */
    public function onNewInvoiceCreated(PaymentDataEvent $event)
    {
        $this->mailer->sendMail(
            $this->from,
            $event->getUser()->getEmail(),
            $this->templating->loadTemplate($this->template)->renderBlock('subject', []),
            $this->templating->loadTemplate($this->template)->renderBlock('body', [
                'invoice' => $event->getInvoice()
            ])
        );
    }
}