<?php

namespace InternshipBundle\Repository;

use CoreBundle\Repository\AbstractCommonRepository;
use InternshipBundle\Entity\Internship;
use InternshipBundle\Repository\Interfaces\InternshipRepositoryInterface;

class InternshipRepository extends AbstractCommonRepository implements InternshipRepositoryInterface
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

        $qb->orderBy('f.createdAt', 'DESC');

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
                    // title, description
                    if (in_array($key, Internship::getLikeFields())) {
                        $qb->andWhere(sprintf('f.%s LIKE :%s', $key, $key))
                            ->setParameter($key, "%" . $val . "%");
                    }

                }
            }

        }

        return $qb;
    }
}
