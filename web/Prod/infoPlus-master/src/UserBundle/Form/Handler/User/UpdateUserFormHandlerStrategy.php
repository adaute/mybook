<?php
namespace UserBundle\Form\Handler\User;

use UserBundle\Form\Type\User\UserType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use UserBundle\Entity\User;

class UpdateUserFormHandlerStrategy extends AbstractUserFormHandlerStrategy
{

    /**
     * @var AuthorizationCheckerInterface
     */
    protected $authorizationChecker;

    /**

     * Constructor.
     *
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct
    (
        AuthorizationCheckerInterface $authorizationChecker
    )
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param User $user
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(User $user)
    {
        // we put image in the UserType constructor to fill value when the form is loaded
        $this->form = $this->formFactory->create(
            UserType::class,
            $user,
            [
                'action' => $this->router->generate('user_edit', ['id' => $user->getId()]),
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

        $this->userManager->removeRank($user);

        $this->userManager->save($user, false, true);

        return $this->translator
            ->trans('success_modify', array(),'divers');
    }
}
