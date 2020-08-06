<?php

namespace FaqBundle\Form\Handler\Faq;

use FaqBundle\Entity\Manager\Interfaces\FaqManagerInterface;
use FaqBundle\Form\Handler\Faq\Interfaces\FaqFormHandlerStrategy;
use FaqBundle\Entity\Faq;

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractFaqFormHandlerStrategy implements FaqFormHandlerStrategy
{

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var FaqManagerInterface
     */
    protected $faqManager;

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
     * @param FaqManagerInterface $faqManager
     * @return AbstractFaqFormHandlerStrategy
     */
    public function setFaqManager(FaqManagerInterface $faqManager)
    {
        $this->faqManager = $faqManager;
        return $this;
    }

    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractFaqFormHandlerStrategy
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @param RouterInterface $router
     * @return AbstractFaqFormHandlerStrategy
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @param TranslatorInterface $translator
     * @return AbstractFaqFormHandlerStrategy
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
     * @param Faq $faq
     * @return mixed
     */
    abstract public function handleForm(Request $request, Faq $faq);

    /**
     * @param Faq $faq
     * @return mixed
     */
    abstract public function createForm(Faq $faq);


}