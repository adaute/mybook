<?php

namespace DiaryBundle\Repository\Interfaces;

interface DiaryRepositoryInterface
{
    /**
     * @param $requestVal
     * @return array of diary
     */
    public function getResultFilterCount($requestVal);

    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    public function getQueryResultFilter($requestVal);

    public function getProductAbout($id);

}
