<?php

namespace PaymentBundle\Form\Handler\Invoice;

use PaymentBundle\Entity\Manager\Interfaces\InvoiceManagerInterface;
use PaymentBundle\Form\Handler\Invoice\Interfaces\InvoiceFormHandlerStrategy;

use PaymentBundle\Entity\Invoice;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractInvoiceFormHandlerStrategy implements InvoiceFormHandlerStrategy
{

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var InvoiceManagerInterface
     */
    protected $invoiceManager;

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
     * @param InvoiceManagerInterface $invoiceManager
     * @return AbstractInvoiceFormHandlerStrategy
     */
    public function setInvoiceManager(InvoiceManagerInterface $invoiceManager)
    {
        $this->invoiceManager = $invoiceManager;
        return $this;
    }

    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractInvoiceFormHandlerStrategy
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @param RouterInterface $router
     * @return AbstractInvoiceFormHandlerStrategy
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @param TranslatorInterface $translator
     * @return AbstractInvoiceFormHandlerStrategy
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
     * @param Invoice $invoice
     * @return mixed
     */
    abstract public function handleForm(Request $request, Invoice $invoice);

    /**
     * @param Invoice $invoice
     * @return mixed
     */
    abstract public function createForm(Invoice $invoice);


}