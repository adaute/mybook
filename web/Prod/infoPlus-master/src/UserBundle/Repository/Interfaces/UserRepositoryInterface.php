<?php

namespace UserBundle\Repository\Interfaces;

use UserBundle\Repository\UserRepository;
use Doctrine\ORM\QueryBuilder;

interface UserRepositoryInterface
{
    /**
     * @return mixed
     */
    public function checkCotisation($user);

    /**
     * @param $id
     * @return mixed
     */
    public function getUserByIdRankQueryBuilder($id);

    /**
     * @param QueryBuilder $qb
     * @param $identifier
     * @return UserRepository
     */
    public function getUserByIdentifierQueryBuilder(QueryBuilder &$qb, $identifier);

    /**
     * @param $identifier
     * @return mixed
     */
    public function getUserByEmailOrUsername($identifier);

    /**
     * @param $requestVal
     * @return array of user
     */
    public function getResultFilterCount($requestVal);

    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    public function getQueryResultFilter($requestVal);
}
