<?php

namespace CoreBundle\Entity\Common\Interfaces;

interface EnabledInterface
{
    /**
     * Set enabled
     *
     * @param boolean $enabled
     */
    public function setEnabled($enabled);
    
    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled();
}
