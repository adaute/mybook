<?php

namespace CoreBundle\Services\Interfaces;

use CoreBundle\Services\ManagerContainerService;

interface ManagerServiceInterface
{
    /**
     * @param $classLabel
     * @throws \Exception
     */
    public function getManagerClass($classLabel);

    /**
     * @param ManagerContainerService $managerContainerService
     */
    public function setManagerContainerService(ManagerContainerService $managerContainerService);
}