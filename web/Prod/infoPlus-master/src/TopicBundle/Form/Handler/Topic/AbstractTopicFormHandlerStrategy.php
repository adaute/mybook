<?php

namespace TopicBundle\Form\Handler\Topic;

use TopicBundle\Entity\Manager\Interfaces\TopicManagerInterface;
use TopicBundle\Form\Handler\Topic\Interfaces\TopicFormHandlerStrategy;

use TopicBundle\Entity\Topic;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractTopicFormHandlerStrategy implements TopicFormHandlerStrategy
{

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var TopicManagerInterface
     */
    protected $topicManager;

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
     * @param TopicManagerInterface $topicManager
     * @return AbstractTopicFormHandlerStrategy
     */
    public function setTopicManager(TopicManagerInterface $topicManager)
    {
        $this->topicManager = $topicManager;
        return $this;
    }

    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractTopicFormHandlerStrategy
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @param RouterInterface $router
     * @return AbstractTopicFormHandlerStrategy
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @param TranslatorInterface $translator
     * @return AbstractTopicFormHandlerStrategy
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
     * @param Topic $topic
     * @return mixed
     */
    abstract public function handleForm(Request $request, Topic $topic);

    /**
     * @param Topic $topic
     * @return mixed
     */
    abstract public function createForm(Topic $topic);


}