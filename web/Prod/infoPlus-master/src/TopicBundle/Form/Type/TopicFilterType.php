<?php

namespace TopicBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TopicFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title', TextType::class, array(
                    'label' => 'title',
                    'translation_domain' => 'divers'))
               
                ->add('description', TextType::class, array(
                    'label' => 'description',
                    'translation_domain' => 'divers'))

                ->add('position', ChoiceType::class, [
                    'label' => 'position',
                    'translation_domain' => 'divers',
                    'choices' => ['1' => '1','2' => '2', '3' => '3', '4' => '4', '5' => '5','6' => '6','7' => '7'],
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
                'data_class' => 'TopicBundle\Entity\Topic',
                'csrf_protection' => false,
        ));
    }
}
