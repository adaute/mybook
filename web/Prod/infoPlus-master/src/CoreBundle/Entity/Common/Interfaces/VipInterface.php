<?php

namespace CoreBundle\Entity\Common\Interfaces;

interface VipInterface
{
    /**
     * Set vip
     *
     * @param boolean $vip
     */
    public function setVip($vip);

    /**
     * Get vip
     *
     * @return boolean
     */
    public function getVip();
}
