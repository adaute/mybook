<?php

namespace UserBundle\Repository;

use CoreBundle\Repository\AbstractCommonRepository;
use UserBundle\Repository\Interfaces\UserRepositoryInterface;
use Doctrine\ORM\QueryBuilder;
use UserBundle\entity\User;

class UserRepository extends AbstractCommonRepository implements UserRepositoryInterface
{

    /**
     * @inheritdoc
     */
    public function checkCotisation($user)
    {
        $q1 = $this->getEntityManager()->createQueryBuilder();
            $q1
            ->select('p.id')
            ->from('PaymentBundle\Entity\Product', 'p')
            ->where("p.slug='cotisation'");

        $q2 = $this->getEntityManager()->createQueryBuilder();
        $q2
            ->select('i')
            ->from('PaymentBundle\Entity\Invoice', 'i')
            ->where('IDENTITY(i.user)=:user and IDENTITY(i.product)=:product ')
            ->orderBy('i.id','DESC')
            ->setParameter('user', $user)
            ->setParameter('product', $q1->getQuery()->getResult()[0]["id"]);

        return $q2->getQuery()->getResult();
    }

    /**
     * @inheritdoc
     */
    public function getUserByIdRankQueryBuilder($id)
    {
        $qb = $this->getBuilder('u');
        $qb
            ->select('IDENTITY(u.rank)')
            ->where('u.id = :id')
            ->setParameter('id', $id);
        return $qb->getQuery()->getResult();
    }

    /**
     * @inheritdoc
     */
    public function getUserByIdentifierQueryBuilder(QueryBuilder &$qb, $identifier)
    {
        $qb->andWhere(
            $qb->expr()->orX(
                'u.username = :identifier', 'u.email = :identifier'
            )
        )
            ->setParameter('identifier', $identifier);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getUserByEmailOrUsername($identifier)
    {
        $qb = $this->getBuilder();
        $this->getUserByIdentifierQueryBuilder($qb, $identifier);

        return $qb->getQuery()->getOneOrNullResult();
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

        $qb->orderBy('f.username', 'ASC');

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

                    if (in_array($key, User::getLikeFields())) {
                        $qb->andWhere(sprintf('f.%s LIKE :%s', $key, $key))
                            ->setParameter($key, "%" . $val . "%");
                    }

                    // Rank
                    if (in_array($key, User::getObjectFields())) {
                        $qb->andWhere(sprintf('f.%s = :%s', $key, $key))
                            ->setParameter($key, $val);
                    }

                    // Role
                    if (in_array($key, User::getRoleFields())) {
                        if($val == 1)
                            $role = '["ROLE_ADMIN"]';
                        if($val == 2)
                            $role = '["ROLE_EDITOR"]';
                        if($val == 3)
                            $role = '["ROLE_VISITOR"]';

                                $qb->andWhere(sprintf('f.%s = :%s', $key, $key))
                            ->setParameter($key, $role);
                    }

                }
            }

        }

        return $qb;
    }
}