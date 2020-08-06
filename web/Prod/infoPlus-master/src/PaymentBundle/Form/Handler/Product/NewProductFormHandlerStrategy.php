<?php
namespace PaymentBundle\Form\Handler\Product;

use PaymentBundle\Form\Type\Product\ProductType;

use Symfony\Component\HttpFoundation\Request;
use PaymentBundle\Entity\Product;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NewProductFormHandlerStrategy extends AbstractProductFormHandlerStrategy
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
     * @param Product $product
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Product $product)
    {
        $this->form = $this->formFactory->create(ProductType::class, $product, array(
            'action' => $this->router->generate('product_new'),
            'method' => 'POST',
        ));

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return string
     */
    public function handleForm(Request $request, Product $product)
    {
        $product->setAuthor($this->securityTokenStorage->getToken()->getUser());
        $product->setEnabled(0);
        $this->productManager->save($product, true, true);

        return $this->translator
            ->trans('succes', array(),'divers');

    }


}
