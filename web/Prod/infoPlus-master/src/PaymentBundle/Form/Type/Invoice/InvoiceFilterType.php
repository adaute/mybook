<?php

namespace PaymentBundle\Form\Type\Invoice;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InvoiceFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstNamePayer', TextType::class, array('label' => 'firstName',
            'translation_domain' => 'divers'))
            ->add('LastNamePayer', TextType::class, array('label' => 'lastName',
                'translation_domain' => 'divers'))
            ->add(
                 'dateInvoice', DateType::class, array('label' => 'date',
                'translation_domain' => 'divers',
                'years' => range( (14-(new \DateTime('now'))->format('y')) + (new \DateTime('now'))->format('y'), (new \DateTime('now'))->format('y')),
                 'format' => 'dd MM yyyy'
            ))
        ->add('amountPrice', MoneyType::class, array('label' => 'price',
            'translation_domain' => 'divers'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PaymentBundle\Entity\Invoice',
            'csrf_protection' => false,
        ));
    }
}

