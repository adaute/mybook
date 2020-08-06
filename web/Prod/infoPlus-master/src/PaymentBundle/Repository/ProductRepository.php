<?php

namespace PaymentBundle\Repository;

use CoreBundle\Repository\AbstractCommonRepository;
use PaymentBundle\Entity\Product;
use PaymentBundle\Repository\Interfaces\ProductRepositoryInterface;


class ProductRepository extends AbstractCommonRepository implements ProductRepositoryInterface
{

    /**
     * @inheritdoc
     */
    public function getProductCotisation()
    {
        $qb = $this->getBuilder('f');
        $qb->Where("f.slug='cotisation'");
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

        $subQueryBuilder = $this->getEntityManager()->createQueryBuilder();
        $subQuery = $subQueryBuilder
            ->select('IDENTITY(d.product)')
            ->from('DiaryBundle\Entity\Diary', 'd');

        $qb->andwhere($qb->expr()->notIn('f.id',  $subQuery->getDQL()));

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
                    // title, price
                    if (in_array($key, Product::getLikeFields())) {
                        $qb->andWhere(sprintf('f.%s LIKE :%s', $key, $key))
                            ->setParameter($key, "%" . $val . "%");
                    }

                }
            }

        }

        return $qb;
    }
}
