<?php
namespace TopicBundle\Form\Handler\Topic;

use TopicBundle\Entity\Manager\Interfaces\TopicManagerInterface;
use TopicBundle\Form\Handler\Topic\Interfaces\TopicFormHandlerStrategy;
use TopicBundle\Entity\Topic;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;


class TopicFormHandler
{
    /**
     * @var string
     */
    private $message = "";

    /**
     * @var FormInterface $form
     */
    protected $form;

    /**
     * @var TopicFormHandlerStrategy $topicFormHandlerStrategy
     */
    private $topicFormHandlerStrategy;

    /**
     * @var TopicFormHandlerStrategy $newActorFormHandlerStrategy
     */
    protected $newTopicFormHandlerStrategy;

    /**
     * @var TopicFormHandlerStrategy $updateActorFormHandlerStrategy
     */
    protected $updateTopicFormHandlerStrategy;

    /**
     * @var TopicManagerInterface $topicManager
     */
    protected $topicManager;

    /**
     * @param TopicFormHandlerStrategy $nafhs
     */
    public function setNewTopicFormHandlerStrategy(TopicFormHandlerStrategy $nafhs) {
        $this->newTopicFormHandlerStrategy = $nafhs;
    }

    /**
     * @param TopicFormHandlerStrategy $uafhs
     */
    public function setUpdateTopicFormHandlerStrategy(TopicFormHandlerStrategy $uafhs) {
        $this->updateTopicFormHandlerStrategy = $uafhs;
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param Topic|null $topic
     * @return Topic
     */
    public function processForm(Topic $topic = null)
    {
        if (is_null($topic)) {
            $topic = new Topic();
            $this->topicFormHandlerStrategy = $this->newTopicFormHandlerStrategy;
        } else {
            $this->topicFormHandlerStrategy = $this->updateTopicFormHandlerStrategy;
        }

        $this->form = $this->createForm($topic);

        return $topic;
    }

    /**
     * @param Topic $topic
     * @return FormInterface
     */
    public function createForm(Topic $topic)
    {
        return $this->topicFormHandlerStrategy->createForm($topic);
    }

    /**
     * @param FormInterface $form
     * @param Topic $topic
     * @param Request $request
     * @return bool
     */
    public function handleForm(FormInterface $form, Topic $topic, Request $request)
    {
        if (
            (null === $topic->getId() && $request->isMethod('POST'))
            || (null !== $topic->getId() && $request->isMethod('PUT'))
        ) {

            $form->handleRequest($request);

            if (!$form->isValid()) {
                return false;
            }

            $this->message = $this->topicFormHandlerStrategy->handleForm($request, $topic);

            return true;
        }
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return mixed
     */
    public function createView()
    {
        return $this->topicFormHandlerStrategy->createView();
    }
}
