<?php

namespace DiaryBundle\Form\Type;

use CoreBundle\Form\Type\ImageType;
use DiaryBundle\Entity\Manager\Interfaces\DiaryManagerInterface;
use DiaryBundle\Entity\Diary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use PaymentBundle\Form\Type\Product\ProductType;

class DiaryType extends AbstractType
{
    /**
     *
     * @var DiaryManagerInterface $handler
     */
    private $handler;

    /**
     * @param DiaryManagerInterface $diaryManager
     */
    public function __construct(DiaryManagerInterface $diaryManager)
    {
        $this->handler = $diaryManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('product', ProductType::class, array('label' => false))
            ->add('dateDiary', DateTimeType::class, array('label' => 'date','translation_domain' => 'divers',
                'years' => range( (15-(new \DateTime('now'))->format('y')) + (new \DateTime('now'))->format('y'), (new \DateTime('now'))->format('y')),
            ))
            ->add('lieu', TextType::class, array('label' => 'place','translation_domain' => 'divers'))
            ->add('remainingSpace', IntegerType::class, array('label' => 'remainingSpace','translation_domain' => 'divers'))
            ->add('vip',CheckboxType::class, array('label' => 'vip','translation_domain' => 'divers'))
            ->add('enabled',CheckboxType::class, array('label' => 'enabled','translation_domain' => 'divers'))

            // if an image has previously been uploaded, we populate the diary object with database values
            ->add('image', ImageType::class, array('data' => $options['image'],'label' => 'image','translation_domain' => 'divers'));

        $builder->add('valider', SubmitType::class, array(
            'attr' => ['class' => 'btn btn-primary btn-lg btn-block'],
            'label' => 'valider',
            'translation_domain' => 'divers'
        ));

       $builder->addEventListener(

            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                // object diary data from the form
                $data = $event->getData();

                if (!$data instanceof Diary) {
                    throw new \RuntimeException('Diary instance required.');
                }

                $dbDiary = null;
                if (null !== $data->getId()) {
                    $dbDiary = $this->handler->find($data->getId());
                }

                // if diary creation or no image in database for updated diary AND no file uploaded, we set image attribute to null
                if ((null === $dbDiary || null === $dbDiary->getImage()->getId()) &&
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
                'data_class' => 'DiaryBundle\Entity\Diary',
                'image' => null,
        ));
    }
}
