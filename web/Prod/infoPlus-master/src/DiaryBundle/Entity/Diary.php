<?php

namespace DiaryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use CoreBundle\Entity\Common\Indentificator;
use CoreBundle\Entity\Common\TimeLine;
use CoreBundle\Entity\Common\Enabled;
use CoreBundle\Entity\Common\Archive;
use CoreBundle\Entity\Common\Vip;

use CoreBundle\Entity\Common\Interfaces\TimeLineInterface;
use CoreBundle\Entity\Common\Interfaces\IndentificatorInterface;
use CoreBundle\Entity\Common\Interfaces\EnabledInterface;
use CoreBundle\Entity\Common\Interfaces\ArchiveInterface;
use CoreBundle\Entity\Common\Interfaces\VipInterface;

/**
 * @ORM\Table(name="diary")
 * @ORM\Entity(repositoryClass="DiaryBundle\Repository\DiaryRepository")
 */
class Diary implements TimeLineInterface, IndentificatorInterface , ArchiveInterface , EnabledInterface ,VipInterface
{
    use Indentificator;

    use TimeLine;

    use Archive;

    use Enabled;

    use Vip;

    private static $likeFields = ['lieu','enabled','vip','remainingSpace','product','dateDiary'];

    /**
     * @var \DateTime $dateDiary
     * @ORM\Column(name="date_Diary", type="datetime", nullable=false)
     */
    private $dateDiary;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     */
    private $lieu;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\GreaterThan(value=0, message="positive_value")
     */
    private $remainingSpace;

    /**
     * persist => when the diary form is submitted, the image is persisted
     * remove => if a diary is deleted, the attached image is deleted too
     * onDelete SET NULL => if the image is removed from database, the image_id field is set to null
     * @ORM\OneToOne(targetEntity="CoreBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $image;

    /**
     * persist => when the diary form is submitted, the product is persisted
     * onDelete SET NULL => if the image is removed from database, the image_id field is set to null
     * @ORM\OneToOne(targetEntity="PaymentBundle\Entity\Product", cascade={"persist"})
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $product;

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
     * @return \DateTime
     */
    public function getDateDiary()
    {
        return $this->dateDiary;
    }

    /**
     * @param \DateTime $dateDiary
     */
    public function setDateDiary($dateDiary)
    {
        $this->dateDiary = $dateDiary;
    }

    /**
     * @return mixed
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param mixed $lieu
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    }

    /**
     * @return mixed
     */
    public function getRemainingSpace()
    {
        return $this->remainingSpace;
    }

    /**
     * @param mixed $remainingSpace
     */
    public function setRemainingSpace($remainingSpace)
    {
        $this->remainingSpace = $remainingSpace;
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
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

}
