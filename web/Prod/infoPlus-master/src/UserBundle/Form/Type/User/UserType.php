<?php

namespace UserBundle\Form\Type\User;

use Doctrine\ORM\EntityRepository;
use CoreBundle\Form\Type\ImageType;
use UserBundle\Entity\Manager\Interfaces\UserManagerInterface;
use UserBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType
{
    /**
     *
     * @var UserManagerInterface $handler
     */
    private $handler;

    /**
     * @param UserManagerInterface $userManager
     */
    public function __construct(UserManagerInterface $userManager)
    {
        $this->handler = $userManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', HiddenType::class)
            ->add('rank', EntityType::class, array(
                'class' => 'UserBundle\Entity\Rank',
                'multiple' => false,
                'required' => false,
                'label' => 'rank',
                'translation_domain' => 'divers',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.title', 'ASC');
                }))

            ->add('roles', ChoiceType::class, [
                    'choices' => ['ROLE_USER' => 'ROLE_USER','ROLE_ADMIN' => 'ROLE_ADMIN', 'ROLE_EDITOR' => 'ROLE_EDITOR', 'ROLE_VISITOR' => 'ROLE_VISITOR'],
                    'expanded' => true,
                    'multiple' => true,
                    'required' => true,
                ]
            )

            // if an image has previously been uploaded, we populate the user object with database values
            ->add('image', ImageType::class, array('data' => $options['image'],'label' => 'image','translation_domain' => 'divers'));

        $builder->add('Valider', SubmitType::class, array(
            'attr' => ['class' => 'btn btn-primary btn-lg btn-block'],
            'label' => 'valider',
            'translation_domain' => 'divers'
        ));

       $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                // object user data from the form
                $data = $event->getData();

                if (!$data instanceof User) {
                    throw new \RuntimeException('User instance required.');
                }

                $dbUser = null;
                if (null !== $data->getId()) {
                    $dbUser = $this->handler->find($data->getId());
                }

                // if user creation or no image in database for updated user AND no file uploaded, we set image attribute to null
                if ((null === $dbUser || null === $dbUser->getImage()->getId()) &&
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
                'data_class' => 'UserBundle\Entity\User',
                'image' => null,
        ));
    }
}
