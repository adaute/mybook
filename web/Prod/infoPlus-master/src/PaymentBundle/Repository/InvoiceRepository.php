<?php

namespace PaymentBundle\Repository;

use CoreBundle\Repository\AbstractCommonRepository;
use PaymentBundle\Entity\Invoice;
use PaymentBundle\Repository\Interfaces\InvoiceRepositoryInterface;

class InvoiceRepository extends AbstractCommonRepository implements InvoiceRepositoryInterface
{

    /**
     * @inheritdoc
     */
    public function checkInvoiceUser($user,$invoice)
    {
        $qb = $this->getBuilder('u');
        $qb
            ->select('COUNT(u.id)')
            ->where('u.user = :user and u.id =:invoice')
            ->setParameter('user', $user)
            ->setParameter('invoice', $invoice);

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @inheritdoc
     */
    public function getInvoiceByIdUserQueryBuilder($user)
    {
        $qb = $this->getQueryResultFilter($user);
        return $qb->getQuery()->getResult();
    }

    /**
     * @inheritdoc
     */
    public function getResultFilterCount($requestVal , $user)
    {
        $qb = $this->getQueryResultFilter($user,$requestVal);
        $qb->select('COUNT(u.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @inheritdoc
     */
    public function getResultFilterPaginated($requestVal , $limit = 20, $offset = 0 , $user)
    {
        $qb = $this->getQueryResultFilter($user,$requestVal);

        $qb->orderBy('u.id', 'DESC');

        $qb->setFirstResult($offset)
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    public function getQueryResultFilter($user,$requestVal = null)
    {
        if($user == null){
            $qb = $this->getBuilder('u');

            if (!empty($requestVal)) {

                foreach ($requestVal as $key => $val) {
                    if (!empty($requestVal[$key])) {
                        // price,...
                        if (in_array($key, Invoice::getLikeFields())) {

                            if($key == "dateInvoice"){
                                $date = '20'.($val["year"] < 10 ? '0'. $val["year"] : $val["year"]) . '-'
                                    . ($val["month"] < 10 ? '0'. $val["month"] : $val["month"]). '-'
                                    . ($val["day"] < 10 ? '0'. $val["day"] : $val["day"]);

                                if($date != "2014-01-01"){
                                    $qb->andWhere(sprintf('u.%s LIKE :%s', $key, $key))
                                        ->setParameter($key, "%" . $date . "%");
                                }
                                continue;
                            }

                            $qb->andWhere(sprintf('u.%s LIKE :%s', $key, $key))
                                ->setParameter($key, "%" . $val . "%");
                        }

                    }
                }

            }

            return $qb;
        }

        $qb = $this->getBuilder('u');
        $qb
            ->where('u.user = :user')
            ->setParameter('user', $user);

        return $qb;
    }
}
