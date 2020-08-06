<?php
namespace AppBundle\Form\Handler\Category;

use AppBundle\Entity\Manager\Interfaces\CategoryManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Handler\Category\Interfaces\CategoryFormHandlerStrategy;

use AppBundle\Entity\Category;

class CategoryFormHandler
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
     * @var CategoryFormHandlerStrategy $categoryFormHandlerStrategy
     */
    private $categoryFormHandlerStrategy;

    /**
     * @var CategoryFormHandlerStrategy $newActorFormHandlerStrategy
     */
    protected $newCategoryFormHandlerStrategy;

    /**
     * @var CategoryFormHandlerStrategy $updateActorFormHandlerStrategy
     */
    protected $updateCategoryFormHandlerStrategy;

    /**
     * @var CategoryManagerInterface $categoryManager
     */
    protected $categoryManager;

    /**
     * @param CategoryFormHandlerStrategy $nafhs
     */
    public function setNewCategoryFormHandlerStrategy(CategoryFormHandlerStrategy $nafhs) {
        $this->newCategoryFormHandlerStrategy = $nafhs;
    }

    /**
     * @param CategoryFormHandlerStrategy $uafhs
     */
    public function setUpdateCategoryFormHandlerStrategy(CategoryFormHandlerStrategy $uafhs) {
        $this->updateCategoryFormHandlerStrategy = $uafhs;
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param Category|null $category
     * @return Category
     */
    public function processForm(Category $category = null)
    {
        if (is_null($category)) {
            $category = new Category();
            $this->categoryFormHandlerStrategy = $this->newCategoryFormHandlerStrategy;
        } else {
            $this->categoryFormHandlerStrategy = $this->updateCategoryFormHandlerStrategy;
        }

        $this->form = $this->createForm($category);

        return $category;
    }

    /**
     * @param Category $category
     * @return FormInterface
     */
    public function createForm(Category $category)
    {
        return $this->categoryFormHandlerStrategy->createForm($category);
    }

    /**
     * @param FormInterface $form
     * @param Category $category
     * @param Request $request
     * @return bool
     */
    public function handleForm(FormInterface $form, Category $category, Request $request)
    {
        if (
            (null === $category->getId() && $request->isMethod('POST'))
            || (null !== $category->getId() && $request->isMethod('PUT'))
        ) {

            $form->handleRequest($request);

            if (!$form->isValid()) {
                return false;
            }

            $this->message = $this->categoryFormHandlerStrategy->handleForm($request, $category);

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
                // title
                if (in_array($key, Category::getLikeFields())) {
                    $form->get($key)->setData($val);
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
        return $this->categoryFormHandlerStrategy->createView();
    }
}
