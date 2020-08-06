<?php

namespace PartnershipBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PartnershipBundle\Entity\Partnership;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class PartnershipController extends Controller
{
    /**
     * @Route("/partnership/{page}", name="partnership", defaults={"page" = 1})
     * @Template("PartnershipBundle:Partials:homePartnership.html.twig")
     * @param Request $request
     * @param integer $page
     * @return array of partnership and pagination
     */
    public function partnershipAction(Request $request,$page)
    {
        if ($page < 1) {
            $page = 1;
        }

        $requestVal = $request->query->all();

        $limit = $this->getParameter('partnership.max_partnership_per_page');

        $partnership = $this->getPartnershipManager()->getResultFilterPaginated(current($requestVal), $limit, ($page - 1) * $limit);
        $nbFilteredPartnership = $this->getPartnershipManager()->getResultFilterCount(current($requestVal));
        $pagination = $this->getPartnershipManager()->getPagination($requestVal, $page, 'partnership', $limit, $nbFilteredPartnership);

        return [
            'partnership' => $partnership,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/admin/partnership/list/{page}", name="partnership_list", defaults={"page" = 1})
     * @Template("PartnershipBundle:Default:list.html.twig")
     * @param Request $request
     * @param integer $page
     * @return array of partnership and pagination
     */
    public function listAction(Request $request, $page)
    {
        if ($page < 1) {
            $page = 1;
        }

        $requestVal = $request->query->all();

        $limit = $this->getParameter('partnership.max_partnership_per_page');

        $partnership = $this->getPartnershipManager()->getResultFilterPaginated(current($requestVal), $limit, ($page - 1) * $limit);
        $nbFilteredPartnership = $this->getPartnershipManager()->getResultFilterCount(current($requestVal));
        $pagination = $this->getPartnershipManager()->getPagination($requestVal, $page, 'partnership_list', $limit, $nbFilteredPartnership);

        return [
            'partnership' => $partnership,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/partnership/{id}/show", name="partnership_show")
     * @ParamConverter("partnership", class="PartnershipBundle:Partnership")
     * @param Partnership $partnership
     * @return Response
     * @Cache(smaxage=600)
     */
    public function showAction(Partnership $partnership)
    {
        return $this->render('PartnershipBundle:Default:show.html.twig', ['partnership' => $partnership]);
    }

    /**
     * @Route("/admin/partnership/new", name="partnership_new")
     * @Route("/admin/partnership/{id}/edit", name="partnership_edit")
     * @Template("PartnershipBundle:Default:edit.html.twig")
     * @param Request $request
     * @param Partnership|null $partnership
     * @return array|RedirectResponse
     * @ParamConverter("partnership", class="PartnershipBundle:Partnership")
     * @Security("has_role('ROLE_EDITOR')")
     */
    public function newEditAction(Request $request, Partnership $partnership = null)
    {
        $entityToProcess = $this->getPartnershipFormHandler()->processForm($partnership);

        if ($this->getPartnershipFormHandler()->handleForm($this->getPartnershipFormHandler()->getForm(), $entityToProcess, $request)) {

            $this->addFlash('success', $this->getPartnershipFormHandler()->getMessage());

            return $this->redirectToRoute('partnership_edit', array('id' => $entityToProcess->getId()));
        }

        return [
            'form' => $this->getPartnershipFormHandler()->createView(),
            'partnership' => $entityToProcess,
        ];
    }

    /**
     * @Route("/admin/partnership/{id}/delete", name="partnership_delete")
     * @ParamConverter("partnership", class="PartnershipBundle:Partnership")
     * @param Partnership $partnership
     * @return RedirectResponse
     */
    public function deleteAction(Partnership $partnership)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        $this->getPartnershipManager()->remove($partnership);
        $this->addFlash('success', $this->get('translator')->trans('%name% : supprimer', ['%title%' => $partnership->getName()], 'divers'));

        return new RedirectResponse($this->get('router')->generate('partnership_list'));
    }

    /**
     * @Template("PartnershipBundle:Partials:formFilter.html.twig")
     * @return Response
     */
    public function formFilterAction()
    {
        $form = $this->getPartnershipManager()->getPartnershipSearchForm(new Partnership());
        return $this->render('PartnershipBundle:Partials:formFilter.html.twig', ['form' => $form->createView()]);
    }

    public function getPartnershipFormHandler()
    {
        return $this->get('partnership.partnership.form.handler');
    }

    public function getPartnershipManager()
    {
        return $this->get('partnership.partnership_manager');
    }

}
