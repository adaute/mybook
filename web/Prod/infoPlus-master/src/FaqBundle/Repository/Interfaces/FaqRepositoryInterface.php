<?php

namespace FaqBundle\Repository\Interfaces;


interface FaqRepositoryInterface
{
    /**
     * @param $requestVal
     * @return array of faq
     */
    public function getResultFilterCount($requestVal);

    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    public function getQueryResultFilter($requestVal);
}
