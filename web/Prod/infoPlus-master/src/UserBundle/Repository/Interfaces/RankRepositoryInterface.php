<?php

namespace UserBundle\Repository\Interfaces;

interface RankRepositoryInterface
{
    /**
     * @param $requestVal
     * @return array of rank
     */
    public function getResultFilterCount($requestVal);

    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    public function getQueryResultFilter($requestVal);
}
