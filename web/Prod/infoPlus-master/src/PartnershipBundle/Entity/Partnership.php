<?php

namespace PartnershipBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use CoreBundle\Entity\Common\Indentificator;
use CoreBundle\Entity\Common\TimeLine;
use CoreBundle\Entity\Common\Enabled;
use CoreBundle\Entity\Common\Archive;

use CoreBundle\Entity\Common\Interfaces\TimeLineInterface;
use CoreBundle\Entity\Common\Interfaces\IndentificatorInterface;
use CoreBundle\Entity\Common\Interfaces\EnabledInterface;
use CoreBundle\Entity\Common\Interfaces\ArchiveInterface;

/**
 * @ORM\Table(name="partnership")
 * @ORM\Entity(repositoryClass="PartnershipBundle\Repository\PartnershipRepository")
 */
class Partnership implements TimeLineInterface, IndentificatorInterface , ArchiveInterface , EnabledInterface
{
    use Indentificator;

    use TimeLine;

    use Archive;

    use Enabled;

    private static $likeFields = ['name','adress'];
    private static $badgeFields = ['badge'];

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     */
    private $adress;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min = 200)
     */
    private $description;

    /**
     * @ORM\Column(type="string",columnDefinition="enum('Or', 'Argent', 'Bronze')")
     * @Assert\NotBlank()
     */
    private $badge;

    /**
     * persist => when the partnership form is submitted, the image is persisted
     * remove => if a partnership is deleted, the attached image is deleted too
     * onDelete SET NULL => if the image is removed from database, the image_id field is set to null
     * @ORM\OneToOne(targetEntity="CoreBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $image;

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

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return mixed
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * @param mixed $adress
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getBadge()
    {
        return $this->badge;
    }

    /**
     * @param mixed $badge
     */
    public function setBadge($badge)
    {
        $this->badge = $badge;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return array
     */
    public static function getBadgeFields()
    {
        return self::$badgeFields;
    }

    /**
     * @param array $badgeFields
     */
    public static function setBadgeFields($badgeFields)
    {
        self::$badgeFields = $badgeFields;
    }

}
