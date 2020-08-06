<?php

namespace InternshipBundle\Repository\Interfaces;

interface InternshipRepositoryInterface
{
    /**
     * @param $requestVal
     * @return array of internship
     */
    public function getResultFilterCount($requestVal);

    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    public function getQueryResultFilter($requestVal);

    public function getProductAbout($id);

}
