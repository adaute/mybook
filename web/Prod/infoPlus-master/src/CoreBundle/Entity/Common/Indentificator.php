<?php
namespace CoreBundle\Entity\Common;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

trait Indentificator
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @inheritdoc}
     */
    public function setId($id)
    {
        $this->id = (int) $id;
    }

    /**
     * @inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

}
