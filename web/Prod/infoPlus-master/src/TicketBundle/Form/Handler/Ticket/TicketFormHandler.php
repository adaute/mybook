<?php
namespace TicketBundle\Form\Handler\Ticket;

use TicketBundle\Entity\Manager\Interfaces\TicketManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use TicketBundle\Form\Handler\Ticket\Interfaces\TicketFormHandlerStrategy;

use TicketBundle\Entity\Ticket;
use TicketBundle\Entity\Answer;

class TicketFormHandler
{
    /**
     * @var string
     */
    private $message = "";

    /**
     * @var FormInterface $form
     */
    protected $form;


    /**
     * @var TicketFormHandlerStrategy $ticketFormHandlerStrategy
     */
    private $ticketFormHandlerStrategy;

    /**
     * @var TicketFormHandlerStrategy $homeTicketFormHandlerStrategy
     */
    protected $homeTicketFormHandlerStrategy;

    /**
     * @var AnswerFormHandlerStrategy $answerFormHandlerStrategy
     */
    protected $answerFormHandlerStrategy;

    /**
     * @var TicketManagerInterface $ticketManager
     */
    protected $ticketManager;

    /**
     * @param TicketFormHandlerStrategy $hafs
     */
    public function setHomeTicketFormHandlerStrategy(TicketFormHandlerStrategy $hafs) {
        $this->homeTicketFormHandlerStrategy = $hafs;
    }

    /**
     * @param TicketFormHandlerStrategy $aafs
     */
    public function setAnswerFormHandlerStrategy(TicketFormHandlerStrategy $aafs)
    {
        $this->answerFormHandlerStrategy = $aafs;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * @param Answer|null $answer
     * @return Answer
     */
    public function processAnswerForm(Answer $answer = null)
    {
        if (is_null($answer)) {
            $answer = new Answer();
            $this->ticketFormHandlerStrategy = $this->answerFormHandlerStrategy;
        }

        $this->form = $this->createAnswerForm($answer);

        return $answer;
    }


    /**
     * @param Ticket|null $ticket
     * @return Ticket
     */
    public function processHomeForm(Ticket $ticket = null)
    {
        if (is_null($ticket)) {
            $ticket = new Ticket();
            $this->ticketFormHandlerStrategy = $this->homeTicketFormHandlerStrategy;
        }

        $this->form = $this->createForm($ticket);

        return $ticket;
    }

    /**
     * @param Answer $answer
     * @return FormInterface
     */
    public function createAnswerForm(Answer $answer)
    {
        return $this->ticketFormHandlerStrategy->createAnswerForm($answer);
    }

    /**
     * @param Ticket $ticket
     * @return FormInterface
     */
    public function createForm(Ticket $ticket)
    {
        return $this->ticketFormHandlerStrategy->createForm($ticket);
    }

    /**
     * @param FormInterface $form
     * @param Answer $answer
     * @param Request $request
     *  @param Ticket $ticket
     * @return bool
     */
    public function handleAnswerForm(FormInterface $form, Answer $answer, Request $request,Ticket $ticket)
    {
        if (
            (null === $answer->getId() && $request->isMethod('POST'))
            || (null !== $answer->getId() && $request->isMethod('PUT'))
        ) {

            $form->handleRequest($request);

            if (!$form->isValid()) {
                return false;
            }

            $this->message = $this->ticketFormHandlerStrategy->handleAnswerForm($request, $answer,$ticket);

            return true;
        }
    }

    /**
     * @param FormInterface $form
     * @param Ticket $ticket
     * @param Request $request
     * @return bool
     */
    public function handleForm(FormInterface $form, Ticket $ticket, Request $request)
    {
        if (
            (null === $ticket->getId() && $request->isMethod('POST'))
            || (null !== $ticket->getId() && $request->isMethod('PUT'))
        ) {

            $form->handleRequest($request);

            if (!$form->isValid()) {
                return false;
            }

            $this->message = $this->ticketFormHandlerStrategy->handleForm($request, $ticket);

            return true;
        }
    }


    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return mixed
     */
    public function createView()
    {
        return $this->ticketFormHandlerStrategy->createView();
    }
}
