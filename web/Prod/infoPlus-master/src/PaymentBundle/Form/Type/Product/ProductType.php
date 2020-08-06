<?php

namespace PaymentBundle\Form\Type\Product;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('id', HiddenType::class)
        ->add('title', TextType::class, array('label' => 'title','translation_domain' => 'divers'))
        ->add('description', TextareaType::class, array('label' => 'description','translation_domain' => 'divers','attr' => array('rows' => '10')))
        ->add('price', MoneyType::class, array('label' => false,'translation_domain' => 'divers'));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'PaymentBundle\Entity\Product',
            )
        );
    }
}
