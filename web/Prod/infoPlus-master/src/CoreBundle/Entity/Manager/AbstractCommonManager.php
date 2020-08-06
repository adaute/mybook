<?php

namespace CoreBundle\Entity\Manager;

use CoreBundle\Entity\Manager\Interfaces\CommonManagerInterface;
use CoreBundle\Repository\AbstractCommonRepository;

abstract class AbstractCommonManager implements CommonManagerInterface
{
    /**
     * @var AbstractCommonRepository $repository
     */
    protected $repository;

    /**
     * @inheritdoc
     */
    public function __construct(AbstractCommonRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritdoc
     */
    public function count($enabled = false) 
    {
        return $this->repository->count($enabled);
    }
    
    /**
     * @inheritdoc
     */
    public function remove($entity)
    {
        $this->repository->remove($entity);
    }

    /**
     * @inheritdoc
     */
    public function all($result = "object", $maxResults = null, $orderby = '', $dir = 'ASC')
    {
        return $this->repository->findAllByEntity($result, $maxResults, $orderby, $dir);
    }

    /**
     * @inheritdoc
     */
    public function find($entity)
    {
        return $this->repository->find($entity);

    }

    /**
     * @inheritdoc
     */
    public function save($entity, $persist = false, $flush = true)
    {
        return $this->repository->save($entity, $persist, $flush);
    }

    /**
     * @inheritdoc
     */
    public function isTypeMatch($labelClass)
    {
        return $labelClass === $this->getLabel();
    }

    /**
     * @inheritdoc
     */
    abstract public function getLabel();

    public function getPagination($request, $page, $route, $maxPerPage, $count = null)
    {
        $pageCount = null === $count ? ceil($this->count() / $maxPerPage) : ceil($count / $maxPerPage);
        return array(
            'page' => $page,
            'route' => $route,
            'pages_count' => $pageCount,
            'route_params' => $request,
        );
    }
}