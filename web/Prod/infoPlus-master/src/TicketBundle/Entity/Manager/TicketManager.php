<?php
namespace TicketBundle\Entity\Manager;

use CoreBundle\Services\Interfaces\MailerInterface ;
use CoreBundle\Entity\Manager\AbstractCommonManager;
use CoreBundle\Repository\AbstractCommonRepository;

use TicketBundle\Entity\Ticket;
use TicketBundle\Entity\Answer;
use TicketBundle\Entity\Manager\Interfaces\TicketManagerInterface;

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Routing\RouterInterface;
use UserBundle\Entity\Manager\Interfaces\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use TicketBundle\TicketEvents;
use TicketBundle\Event\TicketDataEvent;

class TicketManager extends AbstractCommonManager implements TicketManagerInterface
{

    /**
     * @var AbstractCommonRepository
     */
    protected $answerRepository;

    /**
     * @var FormTypeInterface
     */
    protected $answerFormType;

    /**
     * @var FormTypeInterface
     */
    protected $searchFormType;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var RouterInterface $router
     */
    protected $router;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    protected $dispatcher;

    /**
     * @inheritdoc
     */
    public function __construct(AbstractCommonRepository $repository ,
                                EventDispatcherInterface $dispatcher)
    {
        parent::__construct($repository);
        $this->dispatcher = $dispatcher;
    }


    /**
     * @inheritdoc
     */
    public function getTicketByToken($token)
    {
        return $this->repository->findBy(array('Token' => $token));
    }


    /**
     * @inheritdoc
     */
    public function getAnswerByTicketID($id)
    {
        return $this->answerRepository->findBy(array('ticket'=> $id));
    }

    public function createAnswer(Answer $answer,$user, Ticket $ticket)
    {
        if($user == "anon."){
            $user = null;
        }else {
            if(is_bool(array_search('ROLE_ADMIN', $user->getRoles()))){
                if (is_bool(array_search('ROLE_EDITOR', $user->getRoles()))) {
                    $user = null;
                }
            }
        }

        $ticket = $this->repository->findOneBy(array('id' => $ticket->getId()));

        $ticket->setUpdatedAt(new \DateTime());
        $this->save($ticket, false, true);

        $answer->setTicket($ticket);
        $answer->setAuthor($user);

        $this->save($answer, true, true);

       if($user != null){
           $objectTicket = new Ticket();
           $objectTicket->setEmail($ticket->getEmail());
           $objectTicket->setToken($ticket->getToken());

           $this->dispatcher->dispatch(
               TicketEvents::ANSWER_SEND , new TicketDataEvent($objectTicket)
           );
       }

    }

    public function createTicket(Ticket $ticket)
    {
        // rtrim supprime espaces
        $ticket->setToken(rtrim(strtr(base64_encode(random_bytes(256/8)), '+/', '-_'), '='));

        $this->save($ticket, true, true);

        $objectTicket = new Ticket();
        $objectTicket->setEmail($ticket->getEmail());
        $objectTicket->setToken($ticket->getToken());

        $this->dispatcher->dispatch(
            TicketEvents::NEW_TICKET , new TicketDataEvent($objectTicket)
        );
    }

    /**
     * @inheritdoc
     */
    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0)
    {
        return $this->repository->getResultFilterPaginated($requestVal, $limit, $offset);
    }

    /**
     * @inheritdoc
     */
    public function getResultFilterCount($requestVal)
    {
        return $this->repository->getResultFilterCount($requestVal);
    }

    /**
     * @inheritdoc
     */
    public function getTicketSearchForm(Ticket $ticket)
    {
        return $this->formFactory->create(
            $this->searchFormType,
            $ticket,
            [
                'action' => $this->router->generate('ticket_list'),
                'method' => 'GET',
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getAnswerForm(Answer $answer)
    {
        return $this->formFactory->create(
            $this->answerFormType,
            $answer
        );
    }

    /**
     * @inheritdoc
     */
    public function setState(Ticket $ticket)
    {
        if($ticket->getEnabled() == 0){
            $ticket->setEnabled(1);
            $ticket->setArchived(0);
            $ticket->setArchiveAt(null);
        } else {
            $ticket->setEnabled(0);
            $ticket->setArchived(1);
            $ticket->setArchiveAt(new \DateTime());
        }
        $this->save($ticket, false, true);
    }

    /**
     * @inheritdoc
     */
    public function setAnswerRepository($answerRepository)
    {
        $this->answerRepository = $answerRepository;
        return $this;
    }


    /**
     * @inheritdoc
     */
    public function setSearchFormType($searchFormType)
    {
        $this->searchFormType = $searchFormType;
        return $this;
    }

    /**
     * @param FormTypeInterface $answerFormType
     */
    public function setAnswerFormType($answerFormType)
    {
        $this->answerFormType = $answerFormType;
    }

    /**
     * @inheritdoc
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return 'TicketManager';
    }

}
