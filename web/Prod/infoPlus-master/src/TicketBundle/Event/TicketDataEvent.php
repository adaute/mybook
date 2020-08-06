<?php

namespace TicketBundle\Event;

use TicketBundle\Entity\Ticket;

use Symfony\Component\EventDispatcher\Event;

class TicketDataEvent extends Event
{
    /**
     * @var Ticket
     */
    protected $ticket;

    /**
     * @param Ticket $ticket
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * @return Ticket
     */
    public function getTicket()
    {
        return $this->ticket;
    }
}
