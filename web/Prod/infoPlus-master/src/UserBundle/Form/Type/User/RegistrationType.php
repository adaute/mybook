<?php

namespace UserBundle\Form\Type\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;

class RegistrationType extends AbstractType
{
    /* champs du formulaire d'inscription */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, array('label' => 'user.registration.username'));
        $builder->add('email', EmailType::class);
        $builder->add('firstName', TextType::class, array('label' => 'user.registration.firstname'));
        $builder->add('lastName', TextType::class, array('label' => 'user.registration.lastname'));
        $builder->add('password', RepeatedType::class, array(
            'first_name' => 'password',
            'second_name' => 'confirm',
            'type' => PasswordType::class,
            'first_options' => array('label' => 'user.registration.password'),
            'second_options' => array('label' => 'user.registration.confirm'),
        ));
        $builder->add('cguRead', CheckboxType::class, array('label' => 'user.registration.cguRead'));
        $builder->add('recaptcha', EWZRecaptchaType::class);

        $builder->add('register', SubmitType::class, array(
            'attr' => ['class' => 'btn btn-primary btn-lg btn-block'],
            'label' => 'user.registration.label'
        ));
    }

    /* entité lié aux champs du formulaire */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'UserBundle\Entity\Registration\Registration',
        ]);
    }
}


