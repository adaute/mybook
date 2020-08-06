<?php

namespace DiaryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use PaymentBundle\Form\Type\Product\ProductFilterType;

class DiaryFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', ProductFilterType::class)
            ->add('lieu', TextType::class, array(
                'label' => 'place',
                'translation_domain' => 'divers'))
            ->add('dateDiary', DateType::class, array(
                'label' => 'date',
                'translation_domain' => 'divers',
                'years' => range( (14-(new \DateTime('now'))->format('y')) + (new \DateTime('now'))->format('y'), (new \DateTime('now'))->format('y')),
                'format' => 'dd MM yyyy'))
            ->add('remainingSpace', TextType::class, array(
                'label' => 'remainingSpace',
                'translation_domain' => 'divers'))
            ->add('vip', CheckboxType::class, array(
                'label' => 'vip',
                'translation_domain' => 'divers'))
            ->add('enabled', CheckboxType::class, array(
            'label' => 'enabled',
             'translation_domain' => 'divers'));


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'DiaryBundle\Entity\Diary',
                'csrf_protection' => false,
        ));
    }
}
