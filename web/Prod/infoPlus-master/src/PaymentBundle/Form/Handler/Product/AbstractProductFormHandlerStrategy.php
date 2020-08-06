<?php

namespace PaymentBundle\Form\Handler\Product;

use PaymentBundle\Entity\Manager\Interfaces\ProductManagerInterface;
use PaymentBundle\Form\Handler\Product\Interfaces\ProductFormHandlerStrategy;

use PaymentBundle\Entity\Product;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractProductFormHandlerStrategy implements ProductFormHandlerStrategy
{

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var ProductManagerInterface
     */
    protected $productManager;

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
     * @param ProductManagerInterface $productManager
     * @return AbstractProductFormHandlerStrategy
     */
    public function setProductManager(ProductManagerInterface $productManager)
    {
        $this->productManager = $productManager;
        return $this;
    }

    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractProductFormHandlerStrategy
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @param RouterInterface $router
     * @return AbstractProductFormHandlerStrategy
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @param TranslatorInterface $translator
     * @return AbstractProductFormHandlerStrategy
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
     * @param Product $product
     * @return mixed
     */
    abstract public function handleForm(Request $request, Product $product);

    /**
     * @param Product $product
     * @return mixed
     */
    abstract public function createForm(Product $product);


}