<?php

namespace FaqBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use CoreBundle\Entity\Common\Indentificator;
use CoreBundle\Entity\Common\Interfaces\IndentificatorInterface;

use AppBundle\Entity\Category;

/**
 * @ORM\Table(name="faq")
 * @ORM\Entity(repositoryClass="FaqBundle\Repository\FaqRepository")
 */
class Faq implements IndentificatorInterface
{
    use Indentificator;

    private static $likeFields = ['ask', 'answer' , 'askEn','answerEn'];
    private static $objectFields = ['category'];

    /**
     * @ORM\Column(type="string",length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     */
    private $ask;

    /**
     * @Gedmo\Slug(fields={"ask"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min = 3)
     */
    private $answer;

    /**
     * nullable=false to prevent a faq from not having a category
     * notBlank forces the validation form to raise an exception if no category is selected
     * no remove annotation otherwise if a category would be deleted, all associated faqs would be deleted too
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $category;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $askEn;

    /**
     * @ORM\Column(type="text",nullable=true)
     */
    private $answerEn;

    /**
     * Set ask
     *
     * @param string $ask
     * @return Faq
     */
    public function setAsk($ask)
    {
        $this->ask = $ask;

        return $this;
    }

    /**
     * Get ask
     *
     * @return string
     */
    public function getAsk()
    {
        return $this->ask;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Faq
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set answer
     *
     * @param string $answer
     * @return Faq
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;
        return $this;
    }

    /**
     * Set category
     *
     * @param Category $category
     * @return Faq
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
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

    /**
     * @return mixed
     */
    public function getAskEn()
    {
        return $this->askEn;
    }

    /**
     * @param mixed $askEn
     */
    public function setAskEn($askEn)
    {
        $this->askEn = $askEn;
    }

    /**
     * @return mixed
     */
    public function getAnswerEn()
    {
        return $this->answerEn;
    }

    /**
     * @param mixed $answerEn
     */
    public function setAnswerEn($answerEn)
    {
        $this->answerEn = $answerEn;
    }
}
