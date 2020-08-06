<?php

namespace UserBundle\Entity\Registration;

use Symfony\Component\Validator\Constraints as Assert;
use CoreBundle\Validator\Constraints as CoreAssert;
use CoreBundle\Validator\Constraints as UserAssert;
use UserBundle\Entity\User;

use EWZ\Bundle\RecaptchaBundle\Validator\Constraints as Recaptcha;

class Registration
{

    /**
     * @Recaptcha\IsTrue
     */
    public $recaptcha;


    /**
     * @Assert\NotBlank()
     * @CoreAssert\UniqueAttribute(
     *      repository="UserBundle\Entity\User",
     *      property="username"
     * )
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=8, minMessage = "registration.password.minlength")
     */
    private $password;

    /**
     * @Assert\NotBlank(message = "registration.email.notblank")
     * @Assert\Email()
     * @CoreAssert\UniqueAttribute(
     *      repository="UserBundle\Entity\User",
     *      property="email"
     * )
     * @UserAssert\EmailBlackList()
     */
    private $email;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, minMessage = "registration.firstName.minlength")
     */
    private $firstName;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=3, minMessage = "registration.lastName.minlength")
     */
    private $lastName;

    /**
     * @Assert\IsTrue(message = "registration.cguRead")
     */
    private $cguRead;

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param bool $cguRead
     */
    public function setCguRead($cguRead)
    {
        $this->cguRead = $cguRead;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return bool
     */
    public function getCguRead()
    {
        return $this->cguRead;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        $user = new User();
        $user->setUsername($this->username);
        $user->setFirstName($this->firstName);
        $user->setLastName($this->lastName);
        $user->setEmail($this->email);
        $user->setPlainPassword($this->password);
        $user->setCguRead(true);
        $user->setIsActive(false);

        return $user;
    }
}
