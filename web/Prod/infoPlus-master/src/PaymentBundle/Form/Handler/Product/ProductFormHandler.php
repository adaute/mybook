<?php
namespace PaymentBundle\Form\Handler\Product;

use PaymentBundle\Entity\Manager\Interfaces\ProductManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use PaymentBundle\Form\Handler\Product\Interfaces\ProductFormHandlerStrategy;

use PaymentBundle\Entity\Product;

class ProductFormHandler
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
     * @var ProductFormHandlerStrategy $productFormHandlerStrategy
     */
    private $productFormHandlerStrategy;

    /**
     * @var ProductFormHandlerStrategy $newActorFormHandlerStrategy
     */
    protected $newProductFormHandlerStrategy;

    /**
     * @var ProductFormHandlerStrategy $updateActorFormHandlerStrategy
     */
    protected $updateProductFormHandlerStrategy;

    /**
     * @var ProductManagerInterface $productManager
     */
    protected $productManager;

    /**
     * @param ProductFormHandlerStrategy $nafhs
     */
    public function setNewProductFormHandlerStrategy(ProductFormHandlerStrategy $nafhs) {
        $this->newProductFormHandlerStrategy = $nafhs;
    }

    /**
     * @param ProductFormHandlerStrategy $uafhs
     */
    public function setUpdateProductFormHandlerStrategy(ProductFormHandlerStrategy $uafhs) {
        $this->updateProductFormHandlerStrategy = $uafhs;
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param Product|null $product
     * @return Product
     */
    public function processForm(Product $product = null)
    {
        if (is_null($product)) {
            $product = new Product();
            $this->productFormHandlerStrategy = $this->newProductFormHandlerStrategy;
        } else {
            $this->productFormHandlerStrategy = $this->updateProductFormHandlerStrategy;
        }

        $this->form = $this->createForm($product);

        return $product;
    }

    /**
     * @param Product $product
     * @return FormInterface
     */
    public function createForm(Product $product)
    {
        return $this->productFormHandlerStrategy->createForm($product);
    }

    /**
     * @param FormInterface $form
     * @param Product $product
     * @param Request $request
     * @return bool
     */
    public function handleForm(FormInterface $form, Product $product, Request $request)
    {
        if (
            (null === $product->getId() && $request->isMethod('POST'))
            || (null !== $product->getId() && $request->isMethod('PUT'))
        ) {

            $form->handleRequest($request);

            if (!$form->isValid()) {
                return false;
            }

            $this->message = $this->productFormHandlerStrategy->handleForm($request, $product);

            return true;
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
        return $this->productFormHandlerStrategy->createView();
    }
}
