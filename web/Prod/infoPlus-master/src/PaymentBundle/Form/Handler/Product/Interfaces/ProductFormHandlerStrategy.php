<?php
namespace PaymentBundle\Form\Handler\Product\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use PaymentBundle\Entity\Product;

interface ProductFormHandlerStrategy
{
    /**
     * @param Request $request
     * @param Product $product
     * @return mixed
     */
    public function handleForm(Request $request, Product $product);

    /**
     * @param Product $product
     * @return mixed
     */
    public function createForm(Product $product);

    /**
     * @return mixed
     */
    public function createView();
}
