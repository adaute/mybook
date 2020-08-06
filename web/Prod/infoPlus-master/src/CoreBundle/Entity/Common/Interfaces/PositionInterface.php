<?php

namespace CoreBundle\Entity\Common\Interfaces;

interface PositionInterface
{
    /**
     * Set $position
     *
     * @param integer $position
     */
    public function setPosition($position);
    
    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition();
}
