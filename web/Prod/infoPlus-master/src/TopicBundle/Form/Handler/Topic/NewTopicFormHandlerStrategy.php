<?php
namespace TopicBundle\Form\Handler\Topic;

use TopicBundle\Form\Type\TopicType;

use Symfony\Component\HttpFoundation\Request;
use TopicBundle\Entity\Topic;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NewTopicFormHandlerStrategy extends AbstractTopicFormHandlerStrategy
{
    /**
     * @var TokenStorageInterface
     */
    protected $securityTokenStorage;

    /**
     * Constructor.
     *
     * @param TokenStorageInterface $securityTokenStorage
     */
    public function __construct(TokenStorageInterface $securityTokenStorage)
    {
        $this->securityTokenStorage = $securityTokenStorage;
    }

    /**
     * @param Topic $topic
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Topic $topic)
    {
        $this->form = $this->formFactory->create(TopicType::class, $topic, array(
            'action' => $this->router->generate('topic_new'),
            'method' => 'POST',
            'image' => null,
        ));

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Topic $topic
     * @return string
     */
    public function handleForm(Request $request, Topic $topic)
    {
        $topic->setAuthor($this->securityTokenStorage->getToken()->getUser());
        $topic->setEnabled(0);
        $topic->setPosition(0);

        $this->topicManager->save($topic, true, true);

        return $this->translator
            ->trans('succes', array(),'divers');
    }


}
