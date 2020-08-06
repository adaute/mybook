<?php

namespace PartnershipBundle\Repository\Interfaces;

interface PartnershipRepositoryInterface
{
    /**
     * @param $requestVal
     * @return array of partnership
     */
    public function getResultFilterCount($requestVal);

    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    public function getQueryResultFilter($requestVal);

    public function getProductAbout($id);

}
