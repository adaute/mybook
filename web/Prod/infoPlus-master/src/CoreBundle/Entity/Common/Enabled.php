<?php
namespace CoreBundle\Entity\Common;

use Doctrine\ORM\Mapping as ORM;

trait Enabled
{
    /**
     * @var boolean $enabled
     * @ORM\Column(name="enabled", type="boolean", options={"default":0})
     */
    protected $enabled;
    
    /**
     * @inheritdoc}
     */
    public function setEnabled($enabled)
    {
        $this->enabled = (Boolean) $enabled;

        return $this;
    }
    
    /**
     * @inheritdoc}
     */
    public function getEnabled()
    {
        return $this->enabled;
    }
}
