<?php

namespace CoreBundle\Entity\Common\Interfaces;

interface IndentificatorInterface
{
    /**
     * Set id
     *
     * @return integer
     */
    public function setId($id);

    /**
     * Get id
     *
     * @return integer
     */
    public function getId();
}
