<?php
namespace UserBundle\Form\Handler\User;

use UserBundle\Form\Type\User\UserType;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NewUserFormHandlerStrategy extends AbstractUserFormHandlerStrategy
{
    /**
     * @var TokenStorageInterface
     */
    protected $securityTokenStorage;

    /**
     * Constructor.
     *
     * @param TokenStorageInterface $securityTokenStorage
     */
    public function __construct(TokenStorageInterface $securityTokenStorage)
    {
        $this->securityTokenStorage = $securityTokenStorage;
    }

    /**
     * @param User $user
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(User $user)
    {
        $this->form = $this->formFactory->create(UserType::class, $user, array(
            'action' => $this->router->generate('user_new'),
            'method' => 'POST',
            'image' => null,
        ));

        return $this->form;
    }

    /**
     * @param Request $request
     * @param User $user
     * @return string
     */
    public function handleForm(Request $request, User $user , $flag)
    {
        $this->userManager->save($user, true, true);

        return $this->translator
            ->trans('succes', array(),'divers');
    }


}
