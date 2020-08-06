<?php

namespace TicketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use CoreBundle\Entity\Common\Indentificator;
use CoreBundle\Entity\Common\TimeLine;
use CoreBundle\Entity\Common\Enabled;
use CoreBundle\Entity\Common\Archive;
use CoreBundle\Validator\Constraints as UserAssert;

use CoreBundle\Entity\Common\Interfaces\TimeLineInterface;
use CoreBundle\Entity\Common\Interfaces\IndentificatorInterface;
use CoreBundle\Entity\Common\Interfaces\EnabledInterface;
use CoreBundle\Entity\Common\Interfaces\ArchiveInterface;

use AppBundle\Entity\Category;

use EWZ\Bundle\RecaptchaBundle\Validator\Constraints as Recaptcha;


/**
 * @ORM\Table(name="ticket")})
 * @ORM\Entity(repositoryClass="TicketBundle\Repository\TicketRepository")
 */
class Ticket implements TimeLineInterface, IndentificatorInterface , ArchiveInterface , EnabledInterface
{
    use Indentificator;

    use TimeLine;

    use Archive;

    use Enabled;

    private static $likeFields = ['email'];

    private static $objectFields = ['category'];

    /**
     * @Recaptcha\IsTrue
     */
    public $recaptcha;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\Length(min = 10)
     */
    private $cellphone;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     * @Assert\Length(min = 5)
     * @UserAssert\EmailBlackList()
     */
    private $email;

    /**
     * nullable=false to prevent a ticket from not having a category
     * notBlank forces the validation form to raise an exception if no category is selected
     * no remove annotation otherwise if a category would be deleted, all associated faqs would be deleted too
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $category;

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min = 5)
     */
    private $subject;

    /**
     * @ORM\Column(type="string",length=500)
     * @Assert\NotBlank()
     * @Assert\Length(min = 5)
     */
    private $additionnalInformation;

    /**
     * @ORM\Column(type="string",length=255,name="Token")
     */
    private $Token = null;

    public function __toString()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getCellphone()
    {
        return $this->cellphone;
    }

    /**
     * @param mixed $cellphone
     */
    public function setCellphone($cellphone)
    {
        $this->cellphone = $cellphone;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getAdditionnalInformation()
    {
        return $this->additionnalInformation;
    }

    /**
     * @param mixed $additionnalInformation
     */
    public function setAdditionnalInformation($additionnalInformation)
    {
        $this->additionnalInformation = $additionnalInformation;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->Token;
    }

    /**
     * @param mixed $Token
     */
    public function setToken($Token)
    {
        $this->Token = $Token;
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

    /**
     * @return array
     */
    public static function getObjectFields()
    {
        return self::$objectFields;
    }

    /**
     * @param array $objectFields
     */
    public static function setObjectFields($objectFields)
    {
        self::$objectFields = $objectFields;
    }

}
