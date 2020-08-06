<?php

namespace PaymentBundle\Event;

use PaymentBundle\Entity\Invoice;
use UserBundle\Entity\User;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

class PaymentDataEvent extends Event
{
    /**
     * @var Invoice
     */
    protected $invoice;

    /**
     * @var User
     */
    protected $user;


    /**
     * @param Invoice $invoice
     * @param UserInterface $user
     */
    public function __construct(Invoice $invoice , UserInterface $user)
    {
        $this->invoice = $invoice;
        $this->user = $user;
    }

    /**
     * @return Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
