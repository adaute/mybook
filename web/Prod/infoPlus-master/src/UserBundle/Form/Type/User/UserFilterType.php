<?php

namespace UserBundle\Form\Type\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;

class UserFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('username', TextType::class, array(
                    'label' => 'username',
                    'translation_domain' => 'divers'))
               
                ->add('email', TextType::class, array(
                    'label' => 'email',
                    'translation_domain' => 'divers'))

                ->add('rank', EntityType::class, array(
                'class' => 'UserBundle\Entity\Rank',
                'multiple' => false,
                'required' => false,
                'label' => 'rank',
                'translation_domain' => 'divers',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.slug', 'ASC');
                }))
                ->add('roles', ChoiceType::class, array(
                        'choices'  => array(
                            '' => null,
                            'ROLE_ADMIN' => '["ROLE_ADMIN"]',
                            'ROLE_EDITOR' => '["ROLE_EDITOR"]',
                            'ROLE_VISITOR' => '["ROLE_VISITOR"]',
                        ),
                    ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'UserBundle\Entity\User',
                'csrf_protection' => false,
        ));
    }
}
