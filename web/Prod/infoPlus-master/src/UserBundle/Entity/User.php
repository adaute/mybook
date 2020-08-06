<?php

namespace UserBundle\Entity;

use UserBundle\Entity\Interfaces\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Validator\Constraints as Assert;

use CoreBundle\Entity\Common\Interfaces\IndentificatorInterface;
use CoreBundle\Entity\Common\Indentificator;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 * @UniqueEntity(fields="username", message="That username is taken!")
 * @UniqueEntity(fields="email", message="That email is taken!")
 */
class User implements UserInterface, Serializable , IndentificatorInterface
{

    private static $likeFields = ['email','username'];

    private static $objectFields = ['rank'];

    private static $roleFields = ['roles'];


    use Indentificator;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     * @Assert\NotBlank(message="Give us at least 3 characters")
     * @Assert\Length(min=3, minMessage="Give us at least 3 characters!")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="firstName", type="string", length=255)
     * @Assert\NotBlank(message="Give us at least 3 characters")
     * @Assert\Length(min=3, minMessage="Give us at least 3 characters!")
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(name="lastName", type="string", length=255)
     * @Assert\NotBlank(message="Give us at least 3 characters")
     * @Assert\Length(min=3, minMessage="Give us at least 3 characters!")
     */
    private $lastName;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = array();

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isActive = false;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $salt;

    /**
     * @Assert\NotBlank
     * @Assert\Regex(
     *      pattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?!.*\s).*$/",
     *      message="Use 1 upper case letter, 1 lower case letter, and 1 number"
     * )
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $confirmationToken = null;


    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $isAlreadyRequested = false;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $cguRead;

    /**
     * @var \DateTime $lastConnexion
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastConnexion;

    /**
     * persist => when the user form is submitted, the image is persisted
     * remove => if a user is deleted, the attached image is deleted too
     * onDelete SET NULL => if the image is removed from database, the image_id field is set to null
     * @ORM\OneToOne(targetEntity="CoreBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $citation;

    /**
     * persist => when the user form is submitted, the rank is persisted
     * onDelete SET NULL => if the rank is removed from database, the rank_id field is set to null
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Rank" , cascade={"persist"})
     * @ORM\JoinColumn(name="rank_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $rank;


    /**
     * // no cascade remove otherwise if an author would be removed from database, associated movies would be removed too
     * @ORM\OneToMany(targetEntity="TopicBundle\Entity\Topic", mappedBy="author")
     */
    private $topics;

    /**
     * // no cascade remove otherwise if an author would be removed from database, associated movies would be removed too
     * @ORM\OneToMany(targetEntity="PaymentBundle\Entity\Product", mappedBy="author")
     */
    private $products;


    public function __toString()
    {
        return (string) $this->getUsername();
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return boolean
     */
    public function isCguRead()
    {
        return $this->cguRead;
    }

    /**
     * @param boolean $cguRead
     */
    public function setCguRead($cguRead)
    {
        $this->cguRead = $cguRead;
    }

    /**
     * @param PasswordEncoderInterface $encoder
     */
    public function encodePassword(PasswordEncoderInterface $encoder)
    {
        if ($this->plainPassword) {
            $this->salt = sha1(uniqid(mt_rand()));
            $this->password = $encoder->encodePassword(
                $this->plainPassword, $this->salt
            );

            $this->eraseCredentials();
        }
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        // allows for chaining
        return $this;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->setPlainPassword(null);
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param boolean $isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($serialized);
    }



    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }


    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    public function getIsAlreadyRequested()
    {
        return $this->isAlreadyRequested;
    }

    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;
    }

    public function setIsAlreadyRequested($isAlreadyRequested)
    {
        $this->isAlreadyRequested = $isAlreadyRequested;
    }

    /**
     * @return \DateTime
     */
    public function getLastConnexion()
    {
        return $this->lastConnexion;
    }

    /**
     * @param \DateTime $lastConnexion
     */
    public function setLastConnexion(\DateTime $lastConnexion)
    {
        $this->lastConnexion = $lastConnexion;
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
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param mixed $rank
     */
    public function setRank($rank)
    {
        $this->rank = $rank;
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
     * @return array
     */
    public static function getRoleFields()
    {
        return self::$roleFields;
    }

    /**
     * @param array $roleFields
     */
    public static function setRoleFields($roleFields)
    {
        self::$roleFields = $roleFields;
    }

    /**
     * @return mixed
     */
    public function getTopics()
    {
        return $this->topics;
    }

    /**
     * @param mixed $topics
     */
    public function setTopics($topics)
    {
        $this->topics = $topics;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @return mixed
     */
    public function getCitation()
    {
        return $this->citation;
    }

    /**
     * @param mixed $citation
     */
    public function setCitation($citation)
    {
        $this->citation = $citation;
    }

}