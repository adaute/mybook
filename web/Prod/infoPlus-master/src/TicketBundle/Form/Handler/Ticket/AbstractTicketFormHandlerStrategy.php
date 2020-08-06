<?php

namespace TicketBundle\Form\Handler\Ticket;

use TicketBundle\Entity\Manager\Interfaces\TicketManagerInterface;
use TicketBundle\Form\Handler\Ticket\Interfaces\TicketFormHandlerStrategy;

use TicketBundle\Entity\Ticket;

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractTicketFormHandlerStrategy implements TicketFormHandlerStrategy
{

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var TicketManagerInterface
     */
    protected $ticketManager;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var RouterInterface $router
     */
    protected $router;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param TicketManagerInterface $ticketManager
     * @return AbstractTicketFormHandlerStrategy
     */
    public function setTicketManager(TicketManagerInterface $ticketManager)
    {
        $this->ticketManager = $ticketManager;
        return $this;
    }

    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractTicketFormHandlerStrategy
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @param RouterInterface $router
     * @return AbstractTicketFormHandlerStrategy
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @param TranslatorInterface $translator
     * @return AbstractTicketFormHandlerStrategy
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
        return $this;
    }

    /**
     * @return \Symfony\Component\Form\FormView
     */
    public function createView()
    {
        return $this->form->createView();
    }

    /**
     * @param Request $request
     * @param Ticket $ticket
     * @return mixed
     */
    abstract public function handleForm(Request $request, Ticket $ticket);

    /**
     * @param Ticket $ticket
     * @return mixed
     */
    abstract public function createForm(Ticket $ticket);

}