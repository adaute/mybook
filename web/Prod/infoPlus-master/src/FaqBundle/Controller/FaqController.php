<?php

namespace FaqBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FaqBundle\Entity\Faq;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class FaqController extends Controller
{
    /**
     * @Route("/faq", name="faq")
     * @Template("FaqBundle:Partials:homeFaq.html.twig")
     * @return array of faq
     */
    public function indexAction()
    {
        $faq = $this->getFaqManager()->getResultAll();
        $category = $this->getCategoryManager()->getResultAll();

        return [
            'faq' => $faq,
            'category' => $category
        ];
    }

    /**
     * @Route("admin/faq/list/{page}", name="faq_list", defaults={"page" = 1})
     * @Template("FaqBundle:Default:list.html.twig")
     * @param Request $request
     * @param integer $page
     * @return array of faqs and pagination
     */
    public function listAction(Request $request, $page)
    {
        if ($page < 1) {
            $page = 1;
        }

        $requestVal = $request->query->all();
        $limit = $this->getParameter('faq.max_faq_per_page');

        $faq = $this->getFaqManager()->getResultFilterPaginated(current($requestVal), $limit, ($page - 1) * $limit);
        $nbFilteredFaq = $this->getFaqManager()->getResultFilterCount(current($requestVal));
        $pagination = $this->getFaqManager()->getPagination($requestVal, $page, 'faq_list', $limit, $nbFilteredFaq);

        return [
            'faq' => $faq,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/admin/faq/{id}/show", name="faq_show")
     * @ParamConverter("faq", class="FaqBundle:Faq")
     * @param Faq $faq
     * @return Response
     * @Security("has_role('ROLE_EDITOR')")
     * @Cache(smaxage=600)
     */
    public function showAction(Faq $faq)
    {
        return $this->render('FaqBundle:Default:show.html.twig', ['faq' => $faq]);
    }

    /**
     * @Route("/admin/faq/new", name="faq_new")
     * @Route("/admin/faq/{id}/edit", name="faq_edit")
     * @Template("FaqBundle:Default:edit.html.twig")
     * @param Request $request
     * @param Faq|null $faq
     * @return array|RedirectResponse
     * @ParamConverter("faq", class="FaqBundle:Faq")
     * @Security("has_role('ROLE_EDITOR')")
     */
    public function newEditAction(Request $request, Faq $faq = null)
    {
        $entityToProcess = $this->getFaqFormHandler()->processForm($faq);

        if ($this->getFaqFormHandler()->handleForm($this->getFaqFormHandler()->getForm(), $entityToProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getFaqFormHandler()->getMessage());

            return $this->redirectToRoute('faq_list');
        }

        return [
            'form' => $this->getFaqFormHandler()->createView(),
            'faq' => $entityToProcess,
        ];
    }

    /**
     * @Route("/admin/faq/{id}/delete", name="faq_delete")
     * @ParamConverter("faq", class="FaqBundle:Faq")
     * @param Faq $faq
     * @return RedirectResponse
     */
    public function deleteAction(Faq $faq)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        $this->getFaqManager()->remove($faq);
        $this->addFlash('success', $this->get('translator')->trans('%title% : supprimer', ['%title%' => $faq->getAsk()], 'divers'));

        return new RedirectResponse($this->get('router')->generate('faq_list'));
    }

    /**
     * @Template("FaqBundle:Partials:formFilter.html.twig")
     * @param Request $request
     * @return Response
     */
    public function formFilterAction(Request $request)
    {
        $form = $this->getFaqManager()->getFaqSearchForm(new Faq());

        try {
            $this->getFaqFormHandler()->handleSearchForm($form, $request);
        } catch (\Exception $e) {
            $this->get('logger')->error($e->getMessage());
            $this->addFlash('error', $e->getMessage());
        }

        return $this->render('FaqBundle:Partials:formFilter.html.twig', ['form' => $form->createView()]);
    }

    public function getFaqFormHandler()
    {
        return $this->get('faq.faq.form.handler');
    }

    public function getFaqManager()
    {
        return $this->get('faq.manager_service');
    }
    public function getCategoryManager()
    {
        return $this->get('app.category_manager');
    }
}
