<?php

namespace TopicBundle\Repository;

use CoreBundle\Repository\AbstractCommonRepository;
use TopicBundle\Entity\Topic;
use TopicBundle\Repository\Interfaces\TopicRepositoryInterface;

class TopicRepository extends AbstractCommonRepository implements TopicRepositoryInterface
{

    /**
     * @inheritdoc
     */
    public function getEnableTopic()
    {
        $qb = $this->getBuilder('f');
        $qb
            ->where('f.enabled = true and f.position > 0');
        $qb->orderBy('f.position ','ASC');
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

        $qb->orderBy('f.position ','ASC');

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
                    if (in_array($key, Topic::getLikeFields())) {
                        $qb->andWhere(sprintf('f.%s LIKE :%s', $key, $key))
                            ->setParameter($key, "%" . $val . "%");
                    }

                }
            }

        }

        return $qb;
    }
}
