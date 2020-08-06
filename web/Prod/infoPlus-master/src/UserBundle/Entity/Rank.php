<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use CoreBundle\Entity\Common\Indentificator;
use CoreBundle\Entity\Common\Enabled;
use CoreBundle\Entity\Common\Position;

use CoreBundle\Entity\Common\Interfaces\IndentificatorInterface;
use CoreBundle\Entity\Common\Interfaces\EnabledInterface;
use CoreBundle\Entity\Common\Interfaces\PositionInterface;

/**
 * @ORM\Table(name="rank")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\RankRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Rank implements IndentificatorInterface , EnabledInterface , PositionInterface
{

    use Indentificator;

    use Enabled;

    use Position;

    private static $likeFields = ['title','position','enabled'];

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3, minMessage = "erreur.title.minlength")
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @return mixed
     */

    public function __toString()
    {
        return $this->title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return array
     */
    public static function getLikeFields()
    {
        return self::$likeFields;
    }

    /**
     * @param array $likeFields
     */
    public static function setLikeFields($likeFields)
    {
        self::$likeFields = $likeFields;
    }

}
