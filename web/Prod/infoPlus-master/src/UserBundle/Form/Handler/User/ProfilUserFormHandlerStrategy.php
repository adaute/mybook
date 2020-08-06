<?php
namespace UserBundle\Form\Handler\User;

use UserBundle\Form\Type\User\UserOnlineType;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;

class ProfilUserFormHandlerStrategy extends AbstractUserFormHandlerStrategy
{
    /**
     * @param User $user
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(User $user)
    {
        // we put image in the UserType constructor to fill value when the form is loaded
        $this->form = $this->formFactory->create(
            UserOnlineType::class,
            $user,
            [
                'action' => $this->router->generate('userOnline_edit', ['id' => $user->getId()]),
                'method' => 'PUT',
                'image' => $user->getImage(),
            ]
        );

        return $this->form;
    }

    /**
     * @param Request $request
     * @param User $user
     * @return string
     */
    public function handleForm(Request $request, User $user , $flag)
    {

        $this->userManager->save($user, false, true);

        return $this->translator
            ->trans('succes', array(),'divers');
    }


}
