<?php
namespace UserBundle\Form\Handler\User\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

interface UserFormHandlerStrategy
{
    /**
     * @param Request $request
     * @param User $user
     * @param  $flag
     * @return mixed
     */
    public function handleForm(Request $request, User $user , $flag);

    /**
     * @param User $user
     * @return mixed
     */
    public function createForm(User $user);

    /**
     * @return mixed
     */
    public function createView();
}
