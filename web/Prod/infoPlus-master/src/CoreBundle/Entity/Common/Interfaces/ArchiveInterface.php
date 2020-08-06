<?php

namespace CoreBundle\Entity\Common\Interfaces;

interface ArchiveInterface
{
    /**
     * Set archived
     *
     * @param boolean $archived
     */
    public function setArchived($archived);

    /**
     * Get archived
     *
     * @return boolean
     */
    public function getArchived();
}
