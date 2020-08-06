<?php

namespace PaymentBundle\Entity\Manager;

use CoreBundle\Entity\Manager\AbstractCommonManager;
use CoreBundle\Repository\AbstractCommonRepository;

use PaymentBundle\Repository\InvoiceRepository;
use PaymentBundle\Repository\ProductRepository;
use DiaryBundle\Repository\DiaryRepository;
use UserBundle\Repository\RankRepository;

use PaymentBundle\Entity\Manager\Interfaces\InvoiceManagerInterface;
use PaymentBundle\Entity\Invoice;
use UserBundle\Entity\Rank;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Routing\RouterInterface;

use PaymentBundle\PaymentEvents;
use PaymentBundle\Event\PaymentDataEvent;
use UserBundle\Entity\Interfaces\UserInterface;
use UserBundle\Event\UserDataEvent;


class InvoiceManager extends AbstractCommonManager implements InvoiceManagerInterface
{

    /**
     * @var FormTypeInterface
     */
    protected $searchFormType;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var RouterInterface $router
     */
    protected $router;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    protected $dispatcher;

    protected $invoiceRepository;

    protected $diaryRepository;

    protected $productRepository;

    protected $rankRepository;


    /**
     * @param EventDispatcherInterface      $dispatcher
     * @param InvoiceRepository             $invoiceRepository
     * @param DiaryRepository             $diaryRepository
     * @param ProductRepository             $productRepository
     * @param RankRepository             $rankRepository
     */
    public function __construct(
        AbstractCommonRepository $repository,
        EventDispatcherInterface $dispatcher,
        InvoiceRepository        $invoiceRepository,
        DiaryRepository          $diaryRepository,
        ProductRepository        $productRepository,
        RankRepository           $rankRepository

    )
    {
        parent::__construct($repository);
        $this->dispatcher = $dispatcher;
        $this->invoiceRepository = $invoiceRepository;
        $this->diaryRepository = $diaryRepository;
        $this->productRepository = $productRepository;
        $this->rankRepository = $rankRepository;

    }

    public function checkInvoiceUser($user,$invoice){
        return $this->invoiceRepository->checkInvoiceUser($user,$invoice);
    }

    public function getInvoiceByIdUserQueryBuilder($user){
      return $this->invoiceRepository->getInvoiceByIdUserQueryBuilder($user);
    }

    /**
     * @inheritdoc
     */
    public function createInvoice(array $donnees ,$user)
    {
        $invoice = new Invoice();

        $invoice->setPayId($donnees["id"]);
        $invoice->setCartId($donnees["cart"]);
        $invoice->setEmailPayer($donnees["payer"]["payer_info"]["email"]);
        $invoice->setFirstNamePayer($donnees["payer"]["payer_info"]["first_name"]);
        $invoice->setLastNamePayer($donnees["payer"]["payer_info"]["last_name"]);
        $invoice->setPayerID($donnees["payer"]["payer_info"]["payer_id"]);
        $invoice->setRecipientName($donnees["payer"]["payer_info"]["shipping_address"]["recipient_name"]);
        $invoice->setLine1($donnees["payer"]["payer_info"]["shipping_address"]["line1"]);
        $invoice->setCity($donnees["payer"]["payer_info"]["shipping_address"]["city"]);
        $invoice->setState($donnees["payer"]["payer_info"]["shipping_address"]["state"]);
        $invoice->setPostalCode($donnees["payer"]["payer_info"]["shipping_address"]["postal_code"]);
        $invoice->setCountryCode($donnees["payer"]["payer_info"]["shipping_address"]["country_code"]);
        $invoice->setDateInvoice(new \DateTime());
        $invoice->setAmountPrice($donnees["transactions"][0]["amount"]["total"]);
        $invoice->setMerchantId($donnees["transactions"][0]["payee"]["merchant_id"]);
        $invoice->setMerchantEmail($donnees["transactions"][0]["payee"]["email"]);

        $invoice->setUser($user);

        $id = explode(":", $donnees["transactions"][0]["description"]);

        if($id[0] != 'cotisation'){
            if($id != null){
                $diary = $this->diaryRepository->findOneBy(array('id' => $id[0]));
                $product = $this->productRepository->findOneBy(array('id' => $diary->getProduct()));
                $invoice->setProduct($product);

                $diary->setRemainingSpace($diary->getRemainingSpace() - 1);
                $this->save($diary, true, true);
            }
        }else{
            $product = $this->productRepository->findOneBy(array('id' => $id[1]));
            $invoice->setProduct($product);

            $rank = $this->rankRepository->findOneBy(array('slug' => 'membre'));
            $user->setRank($rank);
            $this->save($user, false, true);

        }

        $this->save($invoice, true, true);

        $this->dispatcher->dispatch(
            PaymentEvents::PAYMENT_SUCESS , new PaymentDataEvent($invoice,$user)
        );
    }

    /**
     * @inheritdoc
     */
    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0 , $user)
    {
        return $this->invoiceRepository->getResultFilterPaginated($requestVal, $limit, $offset ,$user);
    }

    /**
     * @inheritdoc
     */
    public function getResultFilterCount($requestVal,$user)
    {
        return $this->invoiceRepository->getResultFilterCount($requestVal,$user);
    }

    /**
     * @inheritdoc
     */
    public function getInvoiceSearchForm(Invoice $invoice)
    {
        return $this->formFactory->create(
            $this->searchFormType,
            $invoice,
            [
                'action' => $this->router->generate('invoice_list'),
                'method' => 'GET',
            ]
        );
    }
    /**
     * @inheritdoc
     */
    public function setSearchFormType($searchFormType)
    {
        $this->searchFormType = $searchFormType;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return 'InvoiceManager';
    }
}