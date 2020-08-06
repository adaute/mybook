<?php

namespace PaymentBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use PaymentBundle\Entity\Invoice;


class InvoiceController extends Controller
{
    /**
     * @Route("/account/invoice", name="user_invoice", defaults={"page" = 1})
     * @Template("PaymentBundle:Default:dashboardInvoice.html.twig")
     * @param Request $request
     * @param integer $page
     * @return array of invoice and pagination
     */
    public function invoiceAction(Request $request, $page)
    {
        if ($page < 1) {
            $page = 1;
        }

        $requestVal = $request->query->all();

        $user = $this->get('security.token_storage')->getToken()->getUser();

        $limit = $this->getParameter('payment.max_invoice_per_page');

        $invoice = $this->getInvoiceManager()->getResultFilterPaginated(current($requestVal), $limit, ($page - 1) * $limit , $user);

        $nbFilteredInvoice = $this->getInvoiceManager()->getResultFilterCount(current($requestVal),$user);
        $pagination = $this->getInvoiceManager()->getPagination($requestVal, $page, 'user_invoice', $limit, $nbFilteredInvoice);

        return [
            'invoice' => $invoice,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/account/invoice/{id}/show", name="invoice_show")
     * @ParamConverter("invoice", class="PaymentBundle:Invoice")
     * @param Invoice $invoice
     * @return Response
     * @Cache(smaxage=600)
     */
    public function showInvoiceAction(Invoice $invoice)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($this->getInvoiceManager()->checkInvoiceUser($user,$invoice) || $this->get('security.authorization_checker')->isGranted('ROLE_EDITOR')){
            return $this->render('PaymentBundle:Default:Invoice/show.html.twig', ['invoice' => $invoice]);
        }else
            return new RedirectResponse($this->get('router')->generate('user_invoice'));
    }

    /**
     * @Route("/account/invoice/{id}/show/pdf", name="invoice_pdf")
     */
    public function InvoiceToPdfAction(Invoice $invoice)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($this->getInvoiceManager()->checkInvoiceUser($user,$invoice)|| $this->get('security.authorization_checker')->isGranted('ROLE_EDITOR')){
            $html = $this->get('templating')->render('PaymentBundle:Default:Invoice/templateInvoicePdf.html.twig',
                array('invoice' => $invoice));

            $html2pdf = new \HTML2PDF('P','A4','fr');
            $html2pdf->pdf->SetAuthor('InfoPlus');
            $html2pdf->pdf->SetTitle('Facture ');
            $html2pdf->pdf->SetSubject('Facture InfoPlus');
            $html2pdf->pdf->SetKeywords('facture,infoplus');
            $html2pdf->pdf->SetDisplayMode('real');
            $html2pdf->writeHTML($html);
            $html2pdf->Output('Facture.pdf');
        }else
            return new RedirectResponse($this->get('router')->generate('user_invoice'));
    }


    /**
     * @Route("/admin/invoice/list/{page}", name="invoice_list", defaults={"page" = 1})
     * @Template("PaymentBundle:Default:Invoice/list.html.twig")
     * @param Request $request
     * @param integer $page
     * @return array of product and pagination
     */
    public function listAction(Request $request, $page)
    {
        if ($page < 1) {
            $page = 1;
        }

        $requestVal = $request->query->all();

        $limit = $this->getParameter('payment.max_invoice_per_page');

        $invoice = $this->getInvoiceManager()->getResultFilterPaginated(current($requestVal), $limit, ($page - 1) * $limit ,null);
        $nbFilteredInvoice = $this->getInvoiceManager()->getResultFilterCount(current($requestVal),null);
        $pagination = $this->getInvoiceManager()->getPagination($requestVal, $page, 'invoice_list', $limit, $nbFilteredInvoice);

        return [
            'invoice' => $invoice,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Template("PaymentBundle:Partials:Invoice/formFilter.html.twig")
     * @return Response
     */
    public function formFilterAction()
    {
        $form = $this->getInvoiceManager()->getInvoiceSearchForm(new Invoice());
        return $this->render('PaymentBundle:Partials:Invoice/formFilter.html.twig', ['form' => $form->createView()]);
    }


    public function getInvoiceManager()
    {
        return $this->get('payment.payment_manager');
    }
}
