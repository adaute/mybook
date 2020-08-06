<?php
namespace PaymentBundle\Form\Handler\Invoice\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use PaymentBundle\Entity\Invoice;

interface InvoiceFormHandlerStrategy
{
    /**
     * @param Request $request
     * @param Invoice $invoice
     * @return mixed
     */
    public function handleForm(Request $request, Invoice $invoice);

    /**
     * @param Invoice $invoice
     * @return mixed
     */
    public function createForm(Invoice $invoice);

    /**
     * @return mixed
     */
    public function createView();
}
