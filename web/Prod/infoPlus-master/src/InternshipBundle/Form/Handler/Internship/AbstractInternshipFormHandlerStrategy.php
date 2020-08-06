<?php

namespace InternshipBundle\Form\Handler\Internship;

use InternshipBundle\Entity\Manager\Interfaces\InternshipManagerInterface;
use InternshipBundle\Form\Handler\Internship\Interfaces\InternshipFormHandlerStrategy;

use InternshipBundle\Entity\Internship;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractInternshipFormHandlerStrategy implements InternshipFormHandlerStrategy
{

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var InternshipManagerInterface
     */
    protected $internshipManager;

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
     * @param InternshipManagerInterface $internshipManager
     * @return AbstractInternshipFormHandlerStrategy
     */
    public function setInternshipManager(InternshipManagerInterface $internshipManager)
    {
        $this->internshipManager = $internshipManager;
        return $this;
    }

    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractInternshipFormHandlerStrategy
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @param RouterInterface $router
     * @return AbstractInternshipFormHandlerStrategy
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @param TranslatorInterface $translator
     * @return AbstractInternshipFormHandlerStrategy
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
     * @param Internship $internship
     * @return mixed
     */
    abstract public function handleForm(Request $request, Internship $internship);

    /**
     * @param Internship $internship
     * @return mixed
     */
    abstract public function createForm(Internship $internship);


}