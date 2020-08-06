<?php
namespace PaymentBundle\Entity\Manager\Interfaces;

use CoreBundle\Entity\Manager\Interfaces\CommonManagerInterface;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

use PaymentBundle\Entity\Product;

interface ProductManagerInterface extends CommonManagerInterface
{

    public function getProductCotisation();
    /**
     * @param int $limit
     * @param int $offset
     * @return array of product
     */
    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    /**
     * @param $requestVal
     * @return integer
     */
    public function getResultFilterCount($requestVal);

    /**
     * @param Product $product
     */
    public function setState(Product $product);

    /**
     * @param string $searchFormType
     * @return ProductManagerInterface
     */
    public function setSearchFormType($searchFormType);

    /**
     * @param FormFactoryInterface $formFactory
     * @return ProductManagerInterface
     */
    public function setFormFactory($formFactory);

    /**
     * @param RouterInterface $router
     * @return ProductManagerInterface
     */
    public function setRouter($router);
}
