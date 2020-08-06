<?php

namespace DiaryBundle\Form\Handler\Diary;

use DiaryBundle\Entity\Manager\Interfaces\DiaryManagerInterface;
use DiaryBundle\Form\Handler\Diary\Interfaces\DiaryFormHandlerStrategy;

use DiaryBundle\Entity\Diary;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractDiaryFormHandlerStrategy implements DiaryFormHandlerStrategy
{

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var DiaryManagerInterface
     */
    protected $diaryManager;

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
     * @param DiaryManagerInterface $diaryManager
     * @return AbstractDiaryFormHandlerStrategy
     */
    public function setDiaryManager(DiaryManagerInterface $diaryManager)
    {
        $this->diaryManager = $diaryManager;
        return $this;
    }

    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractDiaryFormHandlerStrategy
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @param RouterInterface $router
     * @return AbstractDiaryFormHandlerStrategy
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @param TranslatorInterface $translator
     * @return AbstractDiaryFormHandlerStrategy
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
     * @param Diary $diary
     * @return mixed
     */
    abstract public function handleForm(Request $request, Diary $diary);

    /**
     * @param Diary $diary
     * @return mixed
     */
    abstract public function createForm(Diary $diary);


}