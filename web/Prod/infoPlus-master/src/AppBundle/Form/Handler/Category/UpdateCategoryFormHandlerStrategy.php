<?php
namespace AppBundle\Form\Handler\Category;

use AppBundle\Form\Type\Category\CategoryType;
use AppBundle\Entity\Category;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UpdateCategoryFormHandlerStrategy extends AbstractCategoryFormHandlerStrategy
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
     * @param Category $category
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Category $category)
    {
        $this->form = $this->formFactory->create(
            CategoryType::class,
            $category,
            [
                'action' => $this->router->generate('category_edit', ['id' => $category->getId()]),
                'method' => 'PUT'
            ]
        );

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return string
     */
    public function handleForm(Request $request, Category $category)
    {

        $this->categoryManager->save($category, false, true);

        return $this->translator
            ->trans('success_modify', array(),'divers');
    }
}
