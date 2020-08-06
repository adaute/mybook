<?php

namespace PartnershipBundle\Form\Type;

use CoreBundle\Form\Type\ImageType;
use PartnershipBundle\Entity\Manager\Interfaces\PartnershipManagerInterface;
use PartnershipBundle\Entity\Partnership;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnershipType extends AbstractType
{
    /**
     *
     * @var PartnershipManagerInterface $handler
     */
    private $handler;

    /**
     * @param PartnershipManagerInterface $partnershipManager
     */
    public function __construct(PartnershipManagerInterface $partnershipManager)
    {
        $this->handler = $partnershipManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('name', TextType::class, array('label' => 'name','translation_domain' => 'divers'))
            ->add('adress', TextType::class, array('label' => 'adress','translation_domain' => 'divers'))
            ->add('description', TextareaType::class, array('label' => 'description','translation_domain' => 'divers','attr' => array('rows' => '10')))
            ->add('badge',ChoiceType::class, array('label' => 'badge','translation_domain' => 'divers', 'choices'  => array(
                '' => null,
                'Or' => "Or",
                'Argent' => "Argent",
                'Bronze' => "Bronze",
            ),))

            // if an image has previously been uploaded, we populate the partnership object with database values
            ->add('image', ImageType::class, array('data' => $options['image'],'label' => 'image','translation_domain' => 'divers'))
            ->add('enabled',CheckboxType::class, array('label' => 'enabled','translation_domain' => 'divers'));
        $builder->add('Valider', SubmitType::class, array(
            'attr' => ['class' => 'btn btn-primary btn-lg btn-block'],
            'label' => 'valider',
            'translation_domain' => 'divers'
        ));

       $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                // object partnership data from the form
                $data = $event->getData();

                if (!$data instanceof Partnership) {
                    throw new \RuntimeException('Partnership instance required.');
                }

                $dbPartnership = null;
                if (null !== $data->getId()) {
                    $dbPartnership = $this->handler->find($data->getId());
                }

                // if partnership creation or no image in database for updated partnership AND no file uploaded, we set image attribute to null
                if ((null === $dbPartnership || null === $dbPartnership->getImage()->getId()) &&
                    null === $event->getForm()->getData()->getImage()->getFile()
                ) {
                    $data->setImage(null);
                }


            }
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'PartnershipBundle\Entity\Partnership',
                'image' => null,
        ));
    }
}
