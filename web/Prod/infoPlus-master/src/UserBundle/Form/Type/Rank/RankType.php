<?php

namespace UserBundle\Form\Type\Rank;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use UserBundle\Entity\Manager\Interfaces\RankManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RankType extends AbstractType
{
    /**
     *
     * @var RankManagerInterface $handler
     */
    private $handler;

    /**
     * @param RankManagerInterface $rankManager
     */
    public function __construct(RankManagerInterface $rankManager)
    {
        $this->handler = $rankManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)

            ->add('title', TextType::class, array(
                'label' => 'titre',
                'translation_domain' => 'divers'))

            ->add('position', ChoiceType::class, [
                    'choices' => ['1' => '1','2' => '2', '3' => '3', '4' => '4', '5' => '5','6' => '6','7' => '7','8' => '8','9' => '9','10' => '10'],
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                ])

             ->add('enabled', CheckboxType::class, array(
            'label' => 'enabled',
            'translation_domain' => 'divers')
    );

        $builder->add('Valider', SubmitType::class, array(
            'attr' => ['class' => 'btn btn-primary btn-lg btn-block'],
            'label' => 'valider',
            'translation_domain' => 'divers'
        ));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'UserBundle\Entity\Rank',
            )
        );
    }
}
