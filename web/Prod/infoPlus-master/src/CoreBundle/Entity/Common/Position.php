<?php
namespace CoreBundle\Entity\Common;

use Doctrine\ORM\Mapping as ORM;

trait Position
{
    /**
     * @ORM\Column(name="position", type="integer", options={"default": 0})
     */
    protected $position;

    /**
     * @inheritdoc}
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }
    
    /**
     * @inheritdoc}
     */
    public function getPosition()
    {
        return $this->position;
    }
}
