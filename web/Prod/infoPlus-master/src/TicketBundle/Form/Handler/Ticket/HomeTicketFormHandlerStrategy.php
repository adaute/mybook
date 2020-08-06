<?php
namespace TicketBundle\Form\Handler\Ticket;

use TicketBundle\Form\Type\Ticket\TicketType;

use Symfony\Component\HttpFoundation\Request;
use TicketBundle\Entity\Ticket;
use TicketBundle\Entity\Answer;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class HomeTicketFormHandlerStrategy extends AbstractTicketFormHandlerStrategy
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
     * @param Ticket $ticket
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Ticket $ticket)
    {
        $this->form = $this->formFactory->create(TicketType::class, $ticket, array(
            'action' => $this->router->generate('contact'),
            'method' => 'POST',
        ));

        return $this->form;
    }


    /**
     * @param Request $request
     * @param Ticket $ticket
     * @return string
     */
    public function handleForm(Request $request, Ticket $ticket)
    {
        $ticket->setEnabled(1);
        $this->ticketManager->createTicket($ticket);

        return $this->translator
            ->trans('succes_send', array(),'divers');

    }

    public function createAnswerForm(Answer $answer){}

    public function handleAnswerForm(Request $request, Answer $answer, Ticket $ticket){}

}
