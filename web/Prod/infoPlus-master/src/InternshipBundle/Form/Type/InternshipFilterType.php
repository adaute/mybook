<?php

namespace InternshipBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class InternshipFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('society', TextType::class, array(
                    'label' => 'society',
                    'translation_domain' => 'divers'
                ))
                ->add('phone', TextType::class, array(
                    'label' => 'phone',
                    'translation_domain' => 'divers'
                ))
                ->add('email', EmailType::class, array(
                    'label' => 'email',
                    'translation_domain' => 'divers'
                ))
                ->add('field', TextType::class, array(
                    'label' => 'field',
                    'translation_domain' => 'divers'
                ))
                ->add('diploma', TextType::class, array(
                    'label' => 'diploma',
                    'translation_domain' => 'divers'
                ))
                ->add('enabled', CheckboxType::class, array(
                'label' => 'enabled',
                'translation_domain' => 'divers'
                ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'InternshipBundle\Entity\Internship',
                'csrf_protection' => false,
        ));
    }
}
