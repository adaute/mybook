<?php

namespace InternshipBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use InternshipBundle\Entity\Manager\Interfaces\InternshipManagerInterface;
use InternshipBundle\Entity\Internship;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;

class InternshipType extends AbstractType
{
    /**
     *
     * @var InternshipManagerInterface $handler
     */
    private $handler;

    /**
     * @param InternshipManagerInterface $internshipManager
     */
    public function __construct(InternshipManagerInterface $internshipManager)
    {
        $this->handler = $internshipManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('title', TextType::class, array('label' => 'title',  'translation_domain' => 'divers'))
            ->add('description', TextareaType::class, array('label' => 'description', 'translation_domain' => 'divers','attr' => array('rows' => '10')))
            ->add('society', TextType::class, array('label' => 'society','translation_domain' => 'divers'))
            ->add('phone',TextType::class, array('label' => 'phone', 'translation_domain' => 'divers'))
            ->add('email',EmailType::class, array('label' => 'phone', 'translation_domain' => 'divers'))
            ->add('field',TextType::class, array('label' => 'field', 'translation_domain' => 'divers'))
            ->add('diploma',TextType::class, array('label' => 'phone', 'translation_domain' => 'divers'))
            ->add('enabled',CheckboxType::class, array('label' => 'enabled', 'translation_domain' => 'divers'))
            ->add('recaptcha', EWZRecaptchaType::class)
            ->add('envoyer', SubmitType::class, array(
            'attr' => ['class' => 'btn btn-primary btn-lg btn-block'],
            'label' => 'send',
           'translation_domain' => 'divers'
    ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'InternshipBundle\Entity\Internship'
        ));
    }
}
