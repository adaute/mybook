<?php
namespace CoreBundle\Entity\Common;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

trait Vip
{
    /**
     * @var boolean $vip
     *
     * @ORM\Column(name="vip", type="boolean", nullable=false)
     */
    protected $vip = false;

    /**
     * @inheritdoc}
     */
    public function setVip($vip)
    {
        $this->vip= $vip;
        return $this;
    }

    /**
     * @inheritdoc}
     */
    public function getVip()
    {
        return $this->vip;
    }
}
