<?php

namespace UserBundle\Entity\Interfaces;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface as SecurityInterface;

interface UserInterface extends SecurityInterface
{
    public function encodePassword(PasswordEncoderInterface $encoder);

    public function setPlainPassword($plainPassword);

    public function setConfirmationToken($confirmationToken);

    public function setIsAlreadyRequested($isAlreadyRequested);

    public function setRoles(array $roles);

    public function setIsActive($isActive);

    public function setLastConnexion(\DateTime $lastConnexion);
} 
