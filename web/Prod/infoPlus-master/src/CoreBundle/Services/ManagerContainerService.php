<?php

namespace CoreBundle\Services;

use CoreBundle\Services\Interfaces\ManagerInterface;

class ManagerContainerService
{
    private $managers;

    public function __construct()
    {
        $this->managers = array();
    }

    public function addManager(ManagerInterface $manager)
    {
        array_push($this->managers, $manager);
    }

    public function getManagers()
    {
        return $this->managers;
    }

}