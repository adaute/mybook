<?php

namespace PartnershipBundle\Repository;

use CoreBundle\Repository\AbstractCommonRepository;
use PartnershipBundle\Entity\Partnership;
use PartnershipBundle\Repository\Interfaces\PartnershipRepositoryInterface;

class PartnershipRepository extends AbstractCommonRepository implements PartnershipRepositoryInterface
{

    /**
     * @inheritdoc
     */
    public function getProductAbout($id)
    {
        $qb = $this->getBuilder('f');
        $qb->Where("f.id = $id");
        return $qb->getQuery()->getResult();
    }

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

        $qb->orderBy('f.badge', 'ASC');

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

                    if (in_array($key, Partnership::getLikeFields())) {
                        $qb->andWhere(sprintf('f.%s LIKE :%s', $key, $key))
                            ->setParameter($key, "%" . $val . "%");
                    }

                    // Badge
                    if (in_array($key, Partnership::getBadgeFields())) {
                        if($val == 1)
                            $badge = 'Or';
                        if($val == 2)
                            $badge = 'Argent';
                        if($val == 3)
                            $badge = 'Bronze';

                        $qb->andWhere(sprintf('f.%s = :%s', $key, $key))
                            ->setParameter($key, $badge);
                    }

                }
            }

        }

        return $qb;
    }
}
