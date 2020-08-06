<?php

namespace AppBundle\Repository\Interfaces;

interface CategoryRepositoryInterface
{
    /**
     * @param $requestVal
     * @return array of category
     */
    public function getResultFilterCount($requestVal);

    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    public function getQueryResultFilter($requestVal);
}