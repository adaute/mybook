<?php

namespace PaymentBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use PaymentBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @Route("/admin/product/list/{page}", name="product_list", defaults={"page" = 1})
     * @Template("PaymentBundle:Default:Product/list.html.twig")
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

        $limit = $this->getParameter('payment.max_product_per_page');

        $product = $this->getProductManager()->getResultFilterPaginated(current($requestVal), $limit, ($page - 1) * $limit);
        $nbFilteredProduct = $this->getProductManager()->getResultFilterCount(current($requestVal));
        $pagination = $this->getProductManager()->getPagination($requestVal, $page, 'product_list', $limit, $nbFilteredProduct);

        return [
            'product' => $product,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/product/{id}/show", name="product_show")
     * @ParamConverter("product", class="PaymentBundle:Product")
     * @param Product $product
     * @return Response
     * @Cache(smaxage=600)
     */
    public function showAction(Product $product)
    {
        return $this->render('PaymentBundle:Default:Product/show.html.twig', [ 'product' => $product]);
    }

    /**
     * @Route("/admin/product/new", name="product_new")
     * @Route("/admin/product/{id}/edit", name="product_edit")
     * @Template("PaymentBundle:Default:Product/edit.html.twig")
     * @param Request $request
     * @param Product|null $product
     * @return array|RedirectResponse
     * @ParamConverter("product", class="PaymentBundle:Product")
     * @Security("has_role('ROLE_EDITOR')")
     */
    public function newEditAction(Request $request, Product $product = null)
    {
        $entityToProcess = $this->getProductFormHandler()->processForm($product);

        if ($this->getProductFormHandler()->handleForm($this->getProductFormHandler()->getForm(), $entityToProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getProductFormHandler()->getMessage());

            return $this->redirectToRoute('product_edit', array('id' => $entityToProcess->getId()));
        }

        return [
            'form' => $this->getProductFormHandler()->createView(),
            'product' => $entityToProcess,
        ];
    }

    /**
     * @Route("/admin/product/{id}/state", name="product_state")
     * @ParamConverter("product", class="PaymentBundle:Product")
     * @param Product $product
     * @return RedirectResponse
     */
    public function stateAction(Product $product)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }

        $this->getProductManager()->setState($product);

        $this->addFlash('success', $this->get('translator')->trans('%title% : state modify', ['%title%' => $product->getTitle()], 'divers'));

        return new RedirectResponse($this->get('router')->generate('product_list'));
    }

    /**
     * @Route("/admin/product/{id}/delete", name="product_delete")
     * @ParamConverter("product", class="PaymentBundle:Product")
     * @param Product $product
     * @return RedirectResponse
     */
    public function deleteAction(Product $product)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        $this->getProductManager()->remove($product);
        $this->addFlash('success', $this->get('translator')->trans('%title% : supprimer', ['%title%' => $product->getTitle()], 'divers'));

        return new RedirectResponse($this->get('router')->generate('product_list'));
    }

    /**
     * @Template("PaymentBundle:Partials:Product/formFilter.html.twig")
     * @return Response
     */
    public function formFilterAction()
    {
        $form = $this->getProductManager()->getProductSearchForm(new Product());
        return $this->render('PaymentBundle:Partials:Product/formFilter.html.twig', ['form' => $form->createView()]);
    }

    public function getProductFormHandler()
    {
        return $this->get('payment.product.form.handler');
    }

    public function getProductManager()
    {
        return $this->get('payment.product_manager');
    }

}
