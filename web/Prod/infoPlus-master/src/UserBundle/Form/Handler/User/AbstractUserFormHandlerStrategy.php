<?php

namespace UserBundle\Form\Handler\User;

use UserBundle\Entity\Manager\Interfaces\UserManagerInterface;
use UserBundle\Form\Handler\User\Interfaces\UserFormHandlerStrategy;
use UserBundle\Entity\User;

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractUserFormHandlerStrategy implements UserFormHandlerStrategy
{

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var UserManagerInterface
     */
    protected $userManager;

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
     * @param UserManagerInterface $userManager
     * @return AbstractUserFormHandlerStrategy
     */
    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
        return $this;
    }

    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractUserFormHandlerStrategy
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @param RouterInterface $router
     * @return AbstractUserFormHandlerStrategy
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @param TranslatorInterface $translator
     * @return AbstractUserFormHandlerStrategy
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
     * @param User $user
     * @param $flag
     * @return mixed
     */
    abstract public function handleForm(Request $request, User $user ,$flag);

    /**
     * @param User $user
     * @return mixed
     */
    abstract public function createForm(User $user);


}