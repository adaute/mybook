<?php

namespace DiaryBundle\Repository;

use CoreBundle\Repository\AbstractCommonRepository;
use DiaryBundle\Entity\Diary;
use DiaryBundle\Repository\Interfaces\DiaryRepositoryInterface;

class DiaryRepository extends AbstractCommonRepository implements DiaryRepositoryInterface
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

        $qb->orderBy('f.dateDiary', 'ASC');

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

                    // enabled, vip , state , ...
                    if (in_array($key, Diary::getLikeFields())) {
                        if ($key == "product") {

                            $price = $val["price"];
                            $title  = $val["title"];

                            $qb
                                ->select('f')
                                ->join('PaymentBundle\Entity\Product', 'p')
                                ->where('f.product = p.id');

                            if(!empty($title)){
                                $qb->andWhere('p.title = :title')
                                    ->setParameter('title', $title);
                            }

                            if(!empty($price)){
                                $qb->andWhere('p.price = :price')
                                    ->setParameter('price', $price);
                            }

                        } else {
                            if($key == "dateDiary"){
                                $date = '20'.($val["year"] < 10 ? '0'. $val["year"] : $val["year"]) . '-'
                                    . ($val["month"] < 10 ? '0'. $val["month"] : $val["month"]). '-'
                                    . ($val["day"] < 10 ? '0'. $val["day"] : $val["day"]);

                                if($date != "2014-01-01"){
                                    $qb->andWhere(sprintf('f.%s LIKE :%s', $key, $key))
                                        ->setParameter($key, "%" . $date . "%");
                                }

                                 continue;
                            }

                            $qb->andWhere(sprintf('f.%s LIKE :%s', $key, $key))
                                ->setParameter($key, "%" . $val . "%");
                        }

                    }

                }
            }

        }

       return $qb;
    }
}
