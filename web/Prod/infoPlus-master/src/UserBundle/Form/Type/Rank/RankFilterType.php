<?php

namespace UserBundle\Form\Type\Rank;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RankFilterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'title',
            'translation_domain' => 'divers'))

            ->add('position', ChoiceType::class, [
                    'label' => 'position',
                    'translation_domain' => 'divers',
                    'choices' => ['1' => '1','2' => '2', '3' => '3', '4' => '4', '5' => '5','6' => '6','7' => '7','8' => '8','9' => '9','10' => '10'],
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                ]
            )
            ->add('enabled', CheckboxType::class, array(
                'label' => 'enabled',
                'translation_domain' => 'divers'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\Rank',
            'csrf_protection' => false,
        ));
    }
}
