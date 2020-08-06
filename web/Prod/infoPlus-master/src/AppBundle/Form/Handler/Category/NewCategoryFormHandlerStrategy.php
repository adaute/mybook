<?php
namespace AppBundle\Form\Handler\Category;

use AppBundle\Form\Type\Category\CategoryType;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Category;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NewCategoryFormHandlerStrategy extends AbstractCategoryFormHandlerStrategy
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
     * @param Category $category
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Category $category)
    {
        $this->form = $this->formFactory->create(CategoryType::class, $category, array(
            'action' => $this->router->generate('category_new'),
            'method' => 'POST',
        ));

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return string
     */
    public function handleForm(Request $request, Category $category)
    {
        $this->categoryManager->save($category, true, true);

        return $this->translator
            ->trans('succes', array(),'divers');
    }


}
