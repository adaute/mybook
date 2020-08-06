<?php
namespace TicketBundle\Form\Handler\Ticket\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use TicketBundle\Entity\Ticket;
use TicketBundle\Entity\Answer;
use UserBundle\Entity\Manager\Interfaces\UserManagerInterface;

interface TicketFormHandlerStrategy
{
    /**
     * @param Request $request
     * @param Ticket $ticket
     * @return mixed
     */
    public function handleForm(Request $request, Ticket $ticket);

    /**
     * @param Ticket $ticket
     * @return mixed
     */
    public function createForm(Ticket $ticket);

    /**
     * @return mixed
     */
    public function createView();

    /**
     * @param Request $request
     * @param Answer $answer
     * @param Ticket $ticket
     * @return mixed
     */
    public function handleAnswerForm(Request $request, Answer $answer,Ticket $ticket);

    /**
     * @param Answer $answer
     * @return mixed
     */
     public function createAnswerForm(Answer $answer);
}
