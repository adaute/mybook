<?php

namespace AppBundle\Form\Handler\Category;

use AppBundle\Entity\Manager\Interfaces\CategoryManagerInterface;
use AppBundle\Form\Handler\Category\Interfaces\CategoryFormHandlerStrategy;

use AppBundle\Entity\Category;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractCategoryFormHandlerStrategy implements CategoryFormHandlerStrategy
{

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var CategoryManagerInterface
     */
    protected $categoryManager;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var RouterInterface $router
     */
    protected $router;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param CategoryManagerInterface $categoryManager
     * @return AbstractCategoryFormHandlerStrategy
     */
    public function setCategoryManager(CategoryManagerInterface $categoryManager)
    {
        $this->categoryManager = $categoryManager;
        return $this;
    }

    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractCategoryFormHandlerStrategy
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @param RouterInterface $router
     * @return AbstractCategoryFormHandlerStrategy
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @param TranslatorInterface $translator
     * @return AbstractCategoryFormHandlerStrategy
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
        return $this;
    }

    /**
     * @return \Symfony\Component\Form\FormView
     */
    public function createView()
    {
        return $this->form->createView();
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return mixed
     */
    abstract public function handleForm(Request $request, Category $category);

    /**
     * @param Category $category
     * @return mixed
     */
    abstract public function createForm(Category $category);


}