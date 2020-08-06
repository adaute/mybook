<?php

namespace TicketBundle\Repository;

use CoreBundle\Repository\AbstractCommonRepository;
use TicketBundle\Entity\Ticket;
use TicketBundle\Repository\Interfaces\TicketRepositoryInterface;

class TicketRepository extends AbstractCommonRepository implements TicketRepositoryInterface
{

    /**
     * @inheritdoc
     */
    public function getResultFilterCount($requestVal)
    {
        $qb = $this->getQueryResultFilter($requestVal);
        $qb->select('COUNT(f.id)');

        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @inheritdoc
     */
    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0)
    {
        $qb = $this->getQueryResultFilter($requestVal);

        $qb->orderBy('f.updatedAt', 'ASC');
        $qb->where('f.archived = 0');

        $qb->setFirstResult($offset)
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    public function getQueryResultFilter($requestVal)
    {
        $qb = $this->getBuilder('f');

        if (!empty($requestVal)) {

            foreach ($requestVal as $key => $val) {
                if (!empty($requestVal[$key])) {
                    // email
                    if (in_array($key, Ticket::getLikeFields())) {
                        $qb->andWhere(sprintf('f.%s LIKE :%s', $key, $key))
                            ->setParameter($key, "%" . $val . "%");
                    }
                }
                // category
                if (in_array($key, Ticket::getObjectFields())) {
                    if(!empty($val)){
                        $qb->andWhere(sprintf('f.%s = :%s', $key, $key))
                            ->setParameter($key, $val);
                    }
                }
            }

        }

        return $qb;
    }
}
