<?php

namespace TicketBundle\Form\Type\Ticket;

use Doctrine\ORM\EntityRepository;
use TicketBundle\Entity\Manager\Interfaces\TicketManagerInterface;
use TicketBundle\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;

class TicketType extends AbstractType
{
    /**
     *
     * @var TicketManagerInterface $handler
     */
    private $handler;

    /**
     * @param TicketManagerInterface $ticketManager
     */
    public function __construct(TicketManagerInterface $ticketManager)
    {
        $this->handler = $ticketManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, array('required' => true, 'label' => 'first_name','translation_domain' => 'divers'))
            ->add('lastName', TextType::class, array('required' => true, 'label' => 'last_name','translation_domain' => 'divers'))
            ->add('cellphone', TextType::class, array('label' => 'phone','translation_domain' => 'divers'))
            ->add('email', EmailType::class, array('required' => true, 'label' => 'email','translation_domain' => 'divers'))
            ->add('token', HiddenType::class, array('label' => 'phone','translation_domain' => 'divers'))
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
            ))
            ->add('subject', TextType::class, array('label' => 'subject','translation_domain' => 'divers'))
            ->add('additionnalInformation', TextareaType::class, array('label' => 'additional_information','translation_domain' => 'divers','attr' => array('rows' => '10')))
            ->add('recaptcha', EWZRecaptchaType::class)
            ->add('envoyer', SubmitType::class, array(
                'attr' => ['class' => 'btn btn-primary btn-lg btn-block'],
                'label' => 'send'
            ,'translation_domain' => 'divers'
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
