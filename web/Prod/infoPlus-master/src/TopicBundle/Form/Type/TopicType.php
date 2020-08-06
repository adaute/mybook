<?php

namespace TopicBundle\Form\Type;

use CoreBundle\Form\Type\ImageType;
use TopicBundle\Entity\Manager\Interfaces\TopicManagerInterface;
use TopicBundle\Entity\Topic;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TopicType extends AbstractType
{
    /**
     *
     * @var TopicManagerInterface $handler
     */
    private $handler;

    /**
     * @param TopicManagerInterface $topicManager
     */
    public function __construct(TopicManagerInterface $topicManager)
    {
        $this->handler = $topicManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)

            ->add('title', TextType::class, array(
                'label' => 'titre',
                'translation_domain' => 'divers'))

            ->add('description', TextareaType::class, array(
                'label' => 'description',
                'translation_domain' => 'divers'
            ,'attr' => array('rows' => '10')))

            // if an image has previously been uploaded, we populate the topic object with database values
            ->add('image', ImageType::class, array('data' => $options['image'],'label' => 'image','translation_domain' => 'divers'))

            ->add('position', ChoiceType::class, [
                    'choices' => ['1' => '1','2' => '2', '3' => '3', '4' => '4', '5' => '5','6' => '6','7' => '7'],
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false,
                ]
            );

        $builder->add('Valider', SubmitType::class, array(
            'attr' => ['class' => 'btn btn-primary btn-lg btn-block'],
            'label' => 'valider',
            'translation_domain' => 'divers'
        ));

       $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                // object topic data from the form
                $data = $event->getData();

                if (!$data instanceof Topic) {
                    throw new \RuntimeException('Topic instance required.');
                }

                $dbTopic = null;
                if (null !== $data->getId()) {
                    $dbTopic = $this->handler->find($data->getId());
                }

                // if topic creation or no image in database for updated topic AND no file uploaded, we set image attribute to null
                if ((null === $dbTopic || null === $dbTopic->getImage()->getId()) &&
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
                'data_class' => 'TopicBundle\Entity\Topic',
                'image' => null,
        ));
    }
}
