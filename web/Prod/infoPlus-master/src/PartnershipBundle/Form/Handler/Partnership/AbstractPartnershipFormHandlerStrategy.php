<?php

namespace PartnershipBundle\Form\Handler\Partnership;

use PartnershipBundle\Entity\Manager\Interfaces\PartnershipManagerInterface;
use PartnershipBundle\Form\Handler\Partnership\Interfaces\PartnershipFormHandlerStrategy;

use PartnershipBundle\Entity\Partnership;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractPartnershipFormHandlerStrategy implements PartnershipFormHandlerStrategy
{

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var PartnershipManagerInterface
     */
    protected $partnershipManager;

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
     * @param PartnershipManagerInterface $partnershipManager
     * @return AbstractPartnershipFormHandlerStrategy
     */
    public function setPartnershipManager(PartnershipManagerInterface $partnershipManager)
    {
        $this->partnershipManager = $partnershipManager;
        return $this;
    }

    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractPartnershipFormHandlerStrategy
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @param RouterInterface $router
     * @return AbstractPartnershipFormHandlerStrategy
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @param TranslatorInterface $translator
     * @return AbstractPartnershipFormHandlerStrategy
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
     * @param Partnership $partnership
     * @return mixed
     */
    abstract public function handleForm(Request $request, Partnership $partnership);

    /**
     * @param Partnership $partnership
     * @return mixed
     */
    abstract public function createForm(Partnership $partnership);


}