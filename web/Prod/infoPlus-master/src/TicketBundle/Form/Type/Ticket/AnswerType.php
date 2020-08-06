<?php

namespace TicketBundle\Form\Type\Ticket;

use Doctrine\ORM\EntityRepository;
use TicketBundle\Entity\Manager\Interfaces\TicketManagerInterface;
use TicketBundle\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType
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
            ->add('answer', TextareaType::class, array('label' => 'additional_information','translation_domain' => 'divers','attr' => array('rows' => '10')))
            ->add('envoyer', SubmitType::class, array(
                'attr' => ['class' => 'btn btn-primary btn-lg btn-block'],
                'label' => 'send'
            ,'translation_domain' => 'divers'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TicketBundle\Entity\Answer',
            'csrf_protection' => false,
        ));
    }
}
