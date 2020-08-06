<?php
namespace TopicBundle\Form\Handler\Topic;

use TopicBundle\Form\Type\TopicType;
use TopicBundle\Entity\Topic;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UpdateTopicFormHandlerStrategy extends AbstractTopicFormHandlerStrategy
{
    /**
     * @var AuthorizationCheckerInterface
     */
    protected $authorizationChecker;

    /**

     * Constructor.
     *
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct
    (
        AuthorizationCheckerInterface $authorizationChecker
    )
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param Topic $topic
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Topic $topic)
    {
        // we put image in the TopicType constructor to fill value when the form is loaded
        $this->form = $this->formFactory->create(
            TopicType::class,
            $topic,
            [
                'action' => $this->router->generate('topic_edit', ['id' => $topic->getId()]),
                'method' => 'PUT',
                'image' => $topic->getImage()
            ]
        );

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Topic $topic
     * @return string
     */
    public function handleForm(Request $request, Topic $topic)
    {
        if($topic->getPosition() != 0)
           $this->topicManager->removePosition($topic->getPosition());

        $this->topicManager->save($topic, false, true);

        return $this->translator
            ->trans('success_modify', array(),'divers');
    }
}
