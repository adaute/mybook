<?php

namespace TicketBundle\Repository\Interfaces;

interface TicketRepositoryInterface
{
    /**
     * @param $requestVal
     * @return array of product
     */
    public function getResultFilterCount($requestVal);

    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    public function getQueryResultFilter($requestVal);

}
