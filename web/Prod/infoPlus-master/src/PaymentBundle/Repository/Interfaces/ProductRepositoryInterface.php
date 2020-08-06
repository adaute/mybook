<?php

namespace PaymentBundle\Repository\Interfaces;

interface ProductRepositoryInterface
{
    /**
     * @param $requestVal
     * @return array of product
     */
    public function getResultFilterCount($requestVal);

    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    public function getQueryResultFilter($requestVal);

    public function getProductCotisation();

}
