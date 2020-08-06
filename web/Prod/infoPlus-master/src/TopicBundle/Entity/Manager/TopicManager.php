<?php
namespace TopicBundle\Entity\Manager;

use CoreBundle\Entity\Manager\AbstractCommonManager;
use CoreBundle\Repository\AbstractCommonRepository;

use TopicBundle\Entity\Manager\Interfaces\TopicManagerInterface;
use TopicBundle\Entity\Topic;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Routing\RouterInterface;


class TopicManager extends AbstractCommonManager implements TopicManagerInterface
{
    /**
     * @var FormTypeInterface
     */
    protected $searchFormType;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var RouterInterface $router
     */
    protected $router;

    /**
     * @inheritdoc
     */
    public function __construct(AbstractCommonRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @inheritdoc
     */
    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0 )
    {
        return $this->repository->getResultFilterPaginated($requestVal, $limit, $offset);
    }

    /**
     * @inheritdoc
     */
    public function getResultFilterCount($requestVal)
    {
        return $this->repository->getResultFilterCount($requestVal);
    }

    /**
     * @inheritdoc
     */
    public function getEnableTopic()
    {
        return $this->repository->getEnableTopic();
    }


    /**
     * @inheritdoc
     */
    public function removePosition($position)
    {
        $topic = $this->repository->findOneByPosition($position);
        if($topic != null && $topic->getEnabled == true){
            $topic->setPosition(null);
            $this->save($topic, false, true);
        }
    }

    /**
     * @inheritdoc
     */
    public function getTopicSearchForm(Topic $topic)
    {
        return $this->formFactory->create(
            $this->searchFormType,
            $topic,
            [
                'action' => $this->router->generate('topic_list'),
                'method' => 'GET',
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function setSearchFormType($searchFormType)
    {
        $this->searchFormType = $searchFormType;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setState(Topic $topic)
    {
        if($topic->getEnabled() == 0){
           $topic->setEnabled(1);
           $topic->setPublishedAt(new \DateTime());
        } else {
            $topic->setEnabled(0);
            $topic->setPosition(false);
            $topic->setUpdatedAt(new \DateTime());
        }
        $this->save($topic, false, true);
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return 'topicManager';
    }
}
