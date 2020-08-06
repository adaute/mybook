<?php

namespace TicketBundle\Form\Type\Ticket;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TicketFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', EmailType::class, array('label' => 'email',
            'translation_domain' => 'divers'))
            ->add('category', EntityType::class, array(
                'class' => 'AppBundle\Entity\Category',
                'multiple' => false,
                'required' => false,
                'label' => 'category',
                'translation_domain' => 'divers',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.slug', 'ASC');
                },
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TicketBundle\Entity\Ticket',
            'csrf_protection' => false,
        ));
    }
}
