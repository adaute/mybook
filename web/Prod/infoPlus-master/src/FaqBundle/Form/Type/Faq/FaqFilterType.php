<?php

namespace FaqBundle\Form\Type\Faq;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FaqFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('ask', TextType::class, array('label' => 'ask',  'translation_domain' => 'divers'))
                ->add('answer', TextType::class, array(
                    'label' => 'answer',
                    'translation_domain' => 'divers'
                ))
                ->add('askEn', TextType::class, array('label' => 'askEn',  'translation_domain' => 'divers'))
                ->add('answerEn', TextType::class, array(
                'label' => 'answerEn',
                'translation_domain' => 'divers'
                 ))
                ->add('category', EntityType::class, array(
                'class' => 'AppBundle\Entity\Category',
                'multiple' => false,
                'required' => false,
                'label' => 'category',
                'translation_domain' => 'divers',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.title', 'ASC');
                },
              ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'FaqBundle\Entity\Faq',
                'csrf_protection' => false,
        ));
    }
}
