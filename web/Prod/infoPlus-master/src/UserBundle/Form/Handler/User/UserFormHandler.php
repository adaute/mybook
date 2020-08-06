<?php
namespace UserBundle\Form\Handler\User;

use UserBundle\Entity\Manager\Interfaces\UserManagerInterface;
use CoreBundle\Services\ManagerService;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\User;
use UserBundle\Form\Handler\User\Interfaces\UserFormHandlerStrategy;

class UserFormHandler
{
    /**
     * @var string
     */
    private $message = "";

    /**
     * @var FormInterface $form
     */
    protected $form;

    /**
     * @var ManagerService $managerService
     */
    private $managerService;

    /**
     * @var UserFormHandlerStrategy $userFormHandlerStrategy
     */
    private $userFormHandlerStrategy;

    /**
     * @var UserFormHandlerStrategy $newUserFormHandlerStrategy
     */
    protected $newUserFormHandlerStrategy;

    /**
     * @var UserFormHandlerStrategy $updateUserFormHandlerStrategy
     */
    protected $updateUserFormHandlerStrategy;

    /**
     * @var UserFormHandlerStrategy $profilUserFormHandlerStrategy
     */
    protected $profilUserFormHandlerStrategy;

    /**
     * @var UserManagerInterface $userManager
     */
    protected $userManager;

    /**
     * @param UserFormHandlerStrategy $nafhs
     */
    public function setNewUserFormHandlerStrategy(UserFormHandlerStrategy $nafhs) {
        $this->newUserFormHandlerStrategy = $nafhs;
    }

    /**
     * @param UserFormHandlerStrategy $uafhs
     */
    public function setUpdateUserFormHandlerStrategy(UserFormHandlerStrategy $uafhs) {
        $this->updateUserFormHandlerStrategy = $uafhs;
    }

    /**
     * @param UserFormHandlerStrategy $pfhs
     */
    public function setProfilUserFormHandlerStrategy(UserFormHandlerStrategy $pfhs) {
        $this->profilUserFormHandlerStrategy = $pfhs;
    }

    /**
     * @param ManagerService $managerService
     */
    public function setManagerService(ManagerService $managerService)
    {
        $this->managerService = $managerService;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param User|null $user
     * @return User
     */
    public function processForm(User $user = null , $flag)
    {
        if (is_null($user)) {
            $user = new User();
            $this->userFormHandlerStrategy = $this->newUserFormHandlerStrategy;
        } else {
            if($flag == true)
                $this->userFormHandlerStrategy = $this->profilUserFormHandlerStrategy;
            else
                $this->userFormHandlerStrategy = $this->updateUserFormHandlerStrategy;
        }

        $this->form = $this->createForm($user);

        return $user;
    }

    /**
     * @param User $user
     * @return FormInterface
     */
    public function createForm(User $user)
    {
        return $this->userFormHandlerStrategy->createForm($user);
    }

    /**
     * @param FormInterface $form
     * @param User $user
     * @param Request $request
     * @return bool
     */
    public function handleForm(FormInterface $form, User $user, Request $request)
    {
        if (
            (null === $user->getId() && $request->isMethod('POST'))
            || (null !== $user->getId() && $request->isMethod('PUT'))
        ) {

            $user->setPlainPassword($user->getPassword());

            $form->handleRequest($request);

            if (!$form->isValid()) {
                return false;
            }

            $this->message = $this->userFormHandlerStrategy->handleForm($request, $user,$flag = false);

            return true;
        }
    }

    /**
     * @param FormInterface $form
     * @param Request $request
     * @throws \Exception
     */
    public function handleSearchForm(FormInterface $form, Request $request)
    {
        $attributes = $request->attributes->all();

        foreach ($attributes as $key => $val) {
            if (!empty($val)) {
                // category
                if (in_array($key, User::getObjectFields())) {
                    $objectManager = $this->managerService->getManagerClass($key . 'Manager');
                    $object = $objectManager->find($val);
                    $form->get($key)->setData($object);
                    continue;
                }
            }
        }
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return mixed
     */
    public function createView()
    {
        return $this->userFormHandlerStrategy->createView();
    }
}
