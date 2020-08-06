<?php

namespace TicketBundle\Entity\Manager\Interfaces;
use CoreBundle\Entity\Manager\Interfaces\CommonManagerInterface;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

use TicketBundle\Entity\Ticket;
use TicketBundle\Entity\Answer;

interface TicketManagerInterface extends CommonManagerInterface
{

    /**
     * @param $token
     */
    public function getTicketByToken($token);

    /**
     * @param Ticket $data
     */
    public function createTicket(Ticket $data);

    /**
     * @param Answer $answer
     */
    public function createAnswer(Answer $answer,$user, Ticket $ticket);

    /**
     * @param int $limit
     * @param int $offset
     * @return array of product
     */
    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    /**
     * @param $requestVal
     * @return integer
     */
    public function getResultFilterCount($requestVal);

    /**
     * @param Ticket $ticket
     */
    public function setState(Ticket $ticket);

    /**
     * @param string $searchFormType
     * @return TicketManagerInterface
     */
    public function setSearchFormType($searchFormType);

    /**
     * @param FormFactoryInterface $formFactory
     * @return TicketManagerInterface
     */
    public function setFormFactory($formFactory);

    /**
     * @param RouterInterface $router
     * @return TicketManagerInterface
     */
    public function setRouter($router);
}
