<?php

namespace PaymentBundle\Entity\Manager\Interfaces;

use CoreBundle\Entity\Manager\Interfaces\CommonManagerInterface;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

interface InvoiceManagerInterface extends CommonManagerInterface
{
    /**
     * @param $user
     * @param $invoiceId
     */
    public function checkInvoiceUser($user,$invoiceId);

    /**
     * @param $user
     */
    public function getInvoiceByIdUserQueryBuilder($user);

    /**
     * @param array $invoice
     * @param $user
     */
    public function createInvoice(array $invoice ,$user);

    /**
     * @param int $limit
     * @param int $offset
     * @param int $user
     * @return array of invoiceAll
     */
    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0, $user);

    /**
     * @param $requestVal
     * @param int $user
     * @return integer
     */
    public function getResultFilterCount($requestVal,$user);

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
