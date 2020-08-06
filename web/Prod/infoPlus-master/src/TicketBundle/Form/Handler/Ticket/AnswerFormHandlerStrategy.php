<?php
namespace TicketBundle\Form\Handler\Ticket;

use TicketBundle\Form\Type\Ticket\AnswerType;

use Symfony\Component\HttpFoundation\Request;
use TicketBundle\Entity\Answer;
use TicketBundle\Entity\Ticket;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AnswerFormHandlerStrategy extends AbstractTicketFormHandlerStrategy
{

    /**
     * @var TokenStorageInterface
     */
    protected $securityTokenStorage;

    /**
     * Constructor.
     *
     * @param TokenStorageInterface $securityTokenStorage
     */
    public function __construct(TokenStorageInterface $securityTokenStorage)
    {
        $this->securityTokenStorage = $securityTokenStorage;
    }


    /**
     * @param Answer $answer
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createAnswerForm(Answer $answer)
    {
        $this->form = $this->formFactory->create(AnswerType::class, $answer, array(
            'method' => 'POST',
        ));
        return $this->form;
    }


    /**
     * @param Request $request
     * @param Answer $answer
     * @param Ticket $ticket
     * @return string
     */
    public function handleAnswerForm(Request $request, Answer $answer , Ticket $ticket )
    {
        $this->ticketManager->createAnswer($answer,$this->securityTokenStorage->getToken()->getUser(),$ticket);

        return $this->translator
            ->trans('succes', array(),'divers');

    }

    /**
     * @param Ticket $ticket
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Ticket $ticket)
    {

    }


    /**
     * @param Request $request
     * @param Ticket $ticket
     * @return string
     */
    public function handleForm(Request $request, Ticket $ticket)
    {

    }


}
