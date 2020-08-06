<?php

namespace PartnershipBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnershipFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', TextType::class, array('label' => 'name',
                    'translation_domain' => 'divers'))
            ->add('adress', TextType::class, array(
                'label' => 'adress',
                'translation_domain' => 'divers'))
                ->add('badge', ChoiceType::class, array(
                'label' => 'badge',
                'translation_domain' => 'divers',
                    'choices'  => array(
                        '' => null,
                        'Or' => "Or",
                        'Argent' => "Argent",
                        'Bronze' => "Bronze",
                    ),
                ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'PartnershipBundle\Entity\Partnership',
                'csrf_protection' => false,
        ));
    }
}
