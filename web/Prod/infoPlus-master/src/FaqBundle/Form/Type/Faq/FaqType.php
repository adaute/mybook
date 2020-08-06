<?php

namespace FaqBundle\Form\Type\Faq;

use Doctrine\ORM\EntityRepository;

use FaqBundle\Entity\Manager\Interfaces\FaqManagerInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class FaqType extends AbstractType
{
    /**
     *
     * @var FaqManagerInterface $handler
     */
    private $handler;

    /**
     * @param FaqManagerInterface $faqManager
     */
    public function __construct(FaqManagerInterface $faqManager)
    {
        $this->handler = $faqManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('ask', TextType::class, array('label' => 'ask',  'translation_domain' => 'divers'))
            ->add('answer', TextareaType::class, array('label' => 'answer',  'translation_domain' => 'divers','attr' => array('rows' => '10')))
            ->add('askEn', TextType::class, array('label' => 'ask',  'translation_domain' => 'divers'))
            ->add('answerEn', TextareaType::class, array('label' => 'answer',  'translation_domain' => 'divers','attr' => array('rows' => '10')))
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
	        ))
            ->add('Valider', SubmitType::class, array(
            'attr' => ['class' => 'btn btn-primary btn-lg btn-block'],
            'label' => 'valider',
             'translation_domain' => 'divers'
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'FaqBundle\Entity\Faq',
        ));
    }
}
