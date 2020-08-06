<?php

namespace TopicBundle\Repository\Interfaces;

interface TopicRepositoryInterface
{
    /**
     * @param $requestVal
     * @return array of topic
     */
    public function getResultFilterCount($requestVal);

    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    public function getQueryResultFilter($requestVal);

    public function getEnableTopic();

}
