<?php
namespace PaymentBundle\Form\Handler\Product;

use PaymentBundle\Form\Type\Product\ProductType;
use PaymentBundle\Entity\Product;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UpdateProductFormHandlerStrategy extends AbstractProductFormHandlerStrategy
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
     * @param Product $product
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Product $product)
    {
        $this->form = $this->formFactory->create(
            ProductType::class,
            $product,
            [
                'action' => $this->router->generate('product_edit', ['id' => $product->getId()]),
                'method' => 'PUT'
            ]
        );

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return string
     */
    public function handleForm(Request $request, Product $product)
    {

        $this->productManager->save($product, false, true);

        return $this->translator
            ->trans('success_modify', array(),'divers');
    }
}
