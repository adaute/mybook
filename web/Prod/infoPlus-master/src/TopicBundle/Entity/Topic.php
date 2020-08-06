<?php

namespace TopicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use CoreBundle\Entity\Common\Indentificator;
use CoreBundle\Entity\Common\TimeLine;
use CoreBundle\Entity\Common\Position;
use CoreBundle\Entity\Common\Enabled;

use CoreBundle\Entity\Common\Interfaces\TimeLineInterface;
use CoreBundle\Entity\Common\Interfaces\IndentificatorInterface;
use CoreBundle\Entity\Common\Interfaces\EnabledInterface;
use CoreBundle\Entity\Common\Interfaces\PositionInterface;

/**
 * @ORM\Table(name="topic")
 * @ORM\Entity(repositoryClass="TopicBundle\Repository\TopicRepository")
 */
class Topic implements IndentificatorInterface,TimeLineInterface, PositionInterface , EnabledInterface
{
    use Indentificator;

    use TimeLine;

    use Enabled;

    use Position;

    private static $likeFields = ['title', 'description','position','enabled'];

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min = 7)
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * persist => when the topic form is submitted, the image is persisted
     * remove => if a topic is deleted, the attached image is deleted too
     * onDelete SET NULL => if the image is removed from database, the image_id field is set to null
     * @ORM\OneToOne(targetEntity="CoreBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $image;

    /**
     * no cascade remove annotation otherwise when a topic is deleted, the author is deleted too from database
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="topics")
     */
    private $author;

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
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

}
