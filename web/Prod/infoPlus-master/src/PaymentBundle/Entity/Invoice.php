<?php

namespace PaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

use CoreBundle\Entity\Common\Indentificator;
use CoreBundle\Entity\Common\Interfaces\IndentificatorInterface;

/**
 * @ORM\Table(name="invoice")
 * @ORM\Entity(repositoryClass="PaymentBundle\Repository\InvoiceRepository")
 */
class Invoice implements IndentificatorInterface
{
    use Indentificator;

    private static $likeFields = ['amountPrice', 'dateInvoice','firstNamePayer','LastNamePayer'];

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $payId;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $cartId;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $payerID;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $emailPayer;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $firstNamePayer;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $LastNamePayer;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $recipient_name;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $line1;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $state;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $postal_code;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $country_code;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $merchant_id;


    /**
     * @ORM\Column(type="string",length=255)
     */
    private $merchant_email;

    /**
     * @var \DateTime $dateInvoice
     * @ORM\Column(name="date_Invoice", type="datetime", nullable=false)
     */
    private $dateInvoice;

    /**
     * @ORM\Column(type="float", scale=2)
     */
    protected $amountPrice;

    /**
     * onDelete SET NULL => if the user is removed from database, the user_id field is set to null
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $user;

    /**
     * onDelete SET NULL => if the user is removed from database, the product_id field is set to null
     * @ORM\ManyToOne(targetEntity="PaymentBundle\Entity\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $product;

    /**
     * @return mixed
     */
    public function getPayId()
    {
        return $this->payId;
    }

    /**
     * @param mixed $payId
     */
    public function setPayId($payId)
    {
        $this->payId = $payId;
    }

    /**
     * @return mixed
     */
    public function getCartId()
    {
        return $this->cartId;
    }

    /**
     * @param mixed $cartId
     */
    public function setCartId($cartId)
    {
        $this->cartId = $cartId;
    }

    /**
     * @return mixed
     */
    public function getPayerID()
    {
        return $this->payerID;
    }

    /**
     * @param mixed $payerID
     */
    public function setPayerID($payerID)
    {
        $this->payerID = $payerID;
    }

    /**
     * @return mixed
     */
    public function getEmailPayer()
    {
        return $this->emailPayer;
    }

    /**
     * @param mixed $emailPayer
     */
    public function setEmailPayer($emailPayer)
    {
        $this->emailPayer = $emailPayer;
    }

    /**
     * @return mixed
     */
    public function getFirstNamePayer()
    {
        return $this->firstNamePayer;
    }

    /**
     * @param mixed $firstNamePayer
     */
    public function setFirstNamePayer($firstNamePayer)
    {
        $this->firstNamePayer = $firstNamePayer;
    }

    /**
     * @return mixed
     */
    public function getLastNamePayer()
    {
        return $this->LastNamePayer;
    }

    /**
     * @param mixed $LastNamePayer
     */
    public function setLastNamePayer($LastNamePayer)
    {
        $this->LastNamePayer = $LastNamePayer;
    }

    /**
     * @return mixed
     */
    public function getRecipientName()
    {
        return $this->recipient_name;
    }

    /**
     * @param mixed $recipient_name
     */
    public function setRecipientName($recipient_name)
    {
        $this->recipient_name = $recipient_name;
    }

    /**
     * @return mixed
     */
    public function getLine1()
    {
        return $this->line1;
    }

    /**
     * @param mixed $line1
     */
    public function setLine1($line1)
    {
        $this->line1 = $line1;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * @param mixed $postal_code
     */
    public function setPostalCode($postal_code)
    {
        $this->postal_code = $postal_code;
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->country_code;
    }

    /**
     * @param mixed $country_code
     */
    public function setCountryCode($country_code)
    {
        $this->country_code = $country_code;
    }

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->merchant_id;
    }

    /**
     * @param mixed $merchant_id
     */
    public function setMerchantId($merchant_id)
    {
        $this->merchant_id = $merchant_id;
    }

    /**
     * @return mixed
     */
    public function getMerchantEmail()
    {
        return $this->merchant_email;
    }

    /**
     * @param mixed $merchant_email
     */
    public function setMerchantEmail($merchant_email)
    {
        $this->merchant_email = $merchant_email;
    }

    /**
     * @return \DateTime
     */
    public function getDateInvoice()
    {
        return $this->dateInvoice;
    }

    /**
     * @param \DateTime $dateInvoice
     */
    public function setDateInvoice($dateInvoice)
    {
        $this->dateInvoice = $dateInvoice;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
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


    /**
     * @return mixed
     */
    public function getAmountPrice()
    {
        return $this->amountPrice;
    }

    /**
     * @param mixed $amountPrice
     */
    public function setAmountPrice($amountPrice)
    {
        $this->amountPrice = $amountPrice;
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
