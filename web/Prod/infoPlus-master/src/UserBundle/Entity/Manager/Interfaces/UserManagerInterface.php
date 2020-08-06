<?php

namespace UserBundle\Entity\Manager\Interfaces;

use CoreBundle\Entity\Manager\Interfaces\CommonManagerInterface;
use UserBundle\Entity\Interfaces\UserInterface;

use UserBundle\Entity\User;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

interface UserManagerInterface extends CommonManagerInterface
{
    /**
     * @param UserInterface $user
     */
    public function checkCotisation($user);

    /**
     * @param UserInterface $user
     */
    public function removeRank($user);

    /**
     * @return mixed
     */
    public function getUserAll();

    /**
     * @param $id
     * @return mixed
     */
    public function getUserByIdRank($id);

    /**
     * @param UserInterface $user
     *
     * @return void
     */
    public function createUser(UserInterface $user);

    /**
     * @param UserInterface $user
     * @param $newPassword
     * @return mixed
     */
    public function updateCredentials(UserInterface $user, $newPassword);

    /**
     * @param UserInterface $user
     * @param $plainPassword
     * @return mixed
     */
    public function isPasswordValid(UserInterface $user, $plainPassword);

    /**
     * @param $identifier
     * @return mixed
     */
    public function getUserByIdentifier($identifier);

    /**
     * @param $user
     * @return mixed
     */
    public function sendRequestPassword($user);

    /**
     * @param UserInterface $user
     * @param $token
     * @return mixed
     */
    public function updateConfirmationTokenUser(UserInterface $user, $token);

    /**
     * @param $token
     * @return mixed
     */
    public function getUserByConfirmationToken($token);

    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function clearConfirmationTokenUser(UserInterface $user);

    /**
     * @param UserInterface $user
     * @return mixed
     */
    public function activationAccountUser(UserInterface $user);

    /**
     * @param UserInterface $user
     * @param \Datetime $lastConnexion
     */
    public function setLastConnexion(UserInterface $user, \Datetime $lastConnexion);

    /**
     * @param int $limit
     * @param int $offset
     * @return array of user
     */
    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    /**
     * @param $requestVal
     * @return integer
     */
    public function getResultFilterCount($requestVal);

    /**
     * @param UserInterface $user
     * @return FormInterface
     */
    public function getUserSearchForm(UserInterface $user);

    /**
     * @param string $searchFormType
     * @return UserManagerInterface
     */
    public function setSearchFormType($searchFormType);

    /**
     * @param FormFactoryInterface $formFactory
     * @return UserManagerInterface
     */
    public function setFormFactory($formFactory);

    /**
     * @param RouterInterface $router
     * @return UserManagerInterface
     */
    public function setRouter($router);
} 
