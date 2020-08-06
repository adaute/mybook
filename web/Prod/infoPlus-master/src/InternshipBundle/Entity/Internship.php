<?php

namespace InternshipBundle\Entity;

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

use EWZ\Bundle\RecaptchaBundle\Validator\Constraints as Recaptcha;

/**
 * @ORM\Table(name="internship")
 * @ORM\Entity(repositoryClass="InternshipBundle\Repository\InternshipRepository")
 */
class Internship implements TimeLineInterface, IndentificatorInterface , ArchiveInterface , EnabledInterface
{
    use Indentificator;

    use TimeLine;

    use Archive;

    use Enabled;

    private static $likeFields = ['society', 'field', 'diploma', 'enabled','phone'];

    /**
     * @Recaptcha\IsTrue
     */
    public $recaptcha;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, unique=false)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     */
    private $description;
    
    /**
     * @ORM\Column(type="string", length=255, unique=false)
     * @Assert\NotBlank()
     */
    private $society;

    /**
     * @ORM\Column(type="string", length=255 , nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, unique=false)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $field;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $diploma;
    
    
    
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getSociety()
    {
        return $this->society;
    }

    /**
     * @param string $society
     */
    public function setSociety($society)
    {
        $this->society = $society;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param string $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getDiploma()
    {
        return $this->diploma;
    }

    /**
     * @param string $diploma
     */
    public function setDiploma($diploma)
    {
        $this->diploma = $diploma;
    }
}
