<?php

namespace UserBundle\Entity\Manager;

use UserBundle\Entity\Manager\Interfaces\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use CoreBundle\Entity\Manager\AbstractCommonManager;
use UserBundle\UserEvents;
use UserBundle\Entity\Interfaces\UserInterface;
use UserBundle\Event\UserDataEvent;
use UserBundle\Repository\UserRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\RouterInterface;

class UserManager extends AbstractCommonManager implements UserManagerInterface
{
    /**
     * @var FormTypeInterface
     */
    protected $searchFormType;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var EncoderFactoryInterface $encoderFactory
     */
    protected $encoderFactory;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    protected $dispatcher;

    /**
     * @var UserPasswordEncoderInterface $encoder
     */
    protected $encoder;

    /**
     *
     * @var UserRepository $repository
     */
    protected $repository;

    /**
     * @var RouterInterface $router
     */
    protected $router;

    /**
     * @param EncoderFactoryInterface       $encoderFactory
     * @param EventDispatcherInterface      $dispatcher
     * @param UserPasswordEncoderInterface  $encoder
     * @param UserRepository                $userRepository
     */
    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        EventDispatcherInterface $dispatcher,
        UserPasswordEncoderInterface $encoder,
        UserRepository $userRepository
    )
    {
        $this->encoderFactory = $encoderFactory;
        $this->dispatcher = $dispatcher;
        $this->encoder = $encoder;
        $this->repository = $userRepository;
    }

    /**
     * @inheritdoc
     */
    public function checkCotisation($user){
        $invoice = $this->repository->checkCotisation($user);
       if($invoice  != null){
           $dateTime = new \DateTime();
           $invoiceTime = $invoice[0]->getDateInvoice();

           $interval = $dateTime->diff($invoiceTime);

           if($interval->y > 0){
               $user->setRank(null);
               $this->save($user, false, true);
               return false;
           }
       }else{
           return false;
       }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function getUserAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @inheritdoc
     */
    public function getUserByIdRank($id)
    {
        return $this->repository->getUserByIdRankQueryBuilder($id);
    }

    /**
     * @inheritdoc
     */
    public function removeRank($user)
    {
        $rank = $user->getRank();

        if($user->getRank()->getSlug() != "membre"){
            $userFind = $this->repository->findOneByRank($user->getRank());
            if($userFind != null){
                $userFind->setRank(null);
                $this->save($userFind, false, true);

                $user->setRank($rank);
            }
        }
        $this->save($user, false, true);
    }

    /**
     * @inheritdoc
     */
    public function createUser(UserInterface $user)
    {
        $user->setRoles(['ROLE_VISITOR']);
        $user->encodePassword($this->encoderFactory->getEncoder($user));
        $this->save($user, true, true);

        $this->dispatcher->dispatch(
            UserEvents::NEW_ACCOUNT_CREATED, new UserDataEvent($user)
        );
    }

    /**
     * @inheritdoc
     */
    public function updateCredentials(UserInterface $user, $newPassword)
    {
        $user->setPlainPassword($newPassword);
        $user->encodePassword($this->encoderFactory->getEncoder($user));
        $this->save($user, false, true);
    }

    /**
     * @inheritdoc
     */
    public function isPasswordValid(UserInterface $user, $plainPassword)
    {
        return $this->encoder->isPasswordValid($user, $plainPassword);
    }

    /**
     * @inheritdoc
     */
    public function getUserByIdentifier($identifier)
    {
        return $this->repository->getUserByEmailOrUsername($identifier);
    }

    /**
     * @inheritdoc
     */
    public function sendRequestPassword($user)
    {
        $this->dispatcher->dispatch(
            UserEvents::NEW_PASSWORD_REQUESTED, new UserDataEvent($user)
        );
    }

    /**
     * @inheritdoc
     */
    public function updateConfirmationTokenUser(UserInterface $user, $token) {
        $user->setConfirmationToken($token);
        $user->setIsAlreadyRequested(true);
        $this->save($user, false, true);
    }

    /**
     * @inheritdoc
     */
    public function getUserByConfirmationToken($token)
    {
        return $this->repository->findOneByConfirmationToken($token);
    }

    /**
     * @inheritdoc
     */
    public function clearConfirmationTokenUser(UserInterface $user) {
        $user->setConfirmationToken(null);
        $user->setIsAlreadyRequested(false);
    }

    /**
     * @inheritdoc
     */
    public function activationAccountUser(UserInterface $user) {
        $user->setIsActive(true);
        $this->save($user, false, true);
    }

    /**
     * @inheritdoc
     */
    public function setLastConnexion(UserInterface $user, \DateTime $lastConnexion)
    {
        $user->setLastConnexion($lastConnexion);
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
    public function getUserSearchForm(UserInterface $user)
    {
        return $this->formFactory->create(
            $this->searchFormType,
            $user,
            [
                'action' => $this->router->generate('user_list'),
                'method' => 'GET',
            ]
        );
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
        return 'UserManager';
    }
}