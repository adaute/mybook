<?php
namespace TopicBundle\Entity\Manager\Interfaces;

use CoreBundle\Entity\Manager\Interfaces\CommonManagerInterface;
use TopicBundle\Entity\Topic;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

interface TopicManagerInterface extends CommonManagerInterface
{
    /**
     * @param int $limit
     * @param int $offset
     * @return array of topical
     */
    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0 );

    /**
     * @param $requestVal
     * @return integer
     */
    public function getResultFilterCount($requestVal);

    /**
     * @param Topic $topic
     * @return FormInterface
     */
    public function getTopicSearchForm(Topic $topic);

    public function getEnableTopic();

    /**
     * @param int $position
     */
    public function removePosition($position);

    /**
     * @param Topic $topic
     */
    public function setState(Topic $topic);

    /**
     * @param string $searchFormType
     * @return TopicManagerInterface
     */
    public function setSearchFormType($searchFormType);

    /**
     * @param FormFactoryInterface $formFactory
     * @return TopicManagerInterface
     */
    public function setFormFactory($formFactory);

    /**
     * @param RouterInterface $router
     * @return TopicManagerInterface
     */
    public function setRouter($router);
}
