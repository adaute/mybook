<?php

namespace PaymentBundle\Repository\Interfaces;

interface InvoiceRepositoryInterface
{

    public function checkInvoiceUser($user,$invoice);
    /**
     * @param $user
     * @return mixed
     */
    public function getInvoiceByIdUserQueryBuilder($user);

    public function getResultFilterCount($requestVal,$user);

    public function getResultFilterPaginated($requestVal , $limit = 20, $offset = 0 , $user);

    public function getQueryResultFilter($user,$requestVal = null);

}
