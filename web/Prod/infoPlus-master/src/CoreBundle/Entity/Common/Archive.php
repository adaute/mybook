<?php
namespace CoreBundle\Entity\Common;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

trait Archive
{
    /**
     * @var boolean $archived
     *
     * @ORM\Column(name="archived", type="boolean", nullable=true)
     */
    protected $archived = false;

    /**
     * @inheritdoc}
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;
        return $this;
    }

    /**
     * @inheritdoc}
     */
    public function getArchived()
    {
        return $this->archived;
    }
}
