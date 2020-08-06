<?php

namespace InternshipBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use InternshipBundle\Entity\Internship;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class InternshipController extends Controller
{

    /**
     * @Route("/internship/{page}", name="internshipOffers", defaults={"page" = 1})
     * @Template("InternshipBundle:Partials:homeInternship.html.twig")
     * @param Request $request
     * @param integer $page
     * @return array of internship and pagination
     */
    public function internshipAction(Request $request,$page)
    {
        if ($page < 1) {
            $page = 1;
        }

        $requestVal = $request->query->all();

        $limit = $this->getParameter('internship.max_internship_per_page');

        $internship = $this->getInternshipManager()->getResultFilterPaginated(current($requestVal), $limit, ($page - 1) * $limit);
        $nbFilteredInternship = $this->getInternshipManager()->getResultFilterCount(current($requestVal));
        $pagination = $this->getInternshipManager()->getPagination($requestVal, $page, 'internship', $limit, $nbFilteredInternship);

        return [
            'internship' => $internship,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/internshipFormular", name="internship")
     * @Template("InternshipBundle:Partials:internshipFormular.html.twig")
     * @param Request $request
     * @param Internship|null $internship
     * @return array|RedirectResponse
     * @ParamConverter("internship", class="InternshipBundle:Internship")
     */
    public function indexAction(Request $request, Internship $internship = null)
    {

        $entityToProcess = $this->getInternshipFormHandler()->processHomeForm($internship);

        if ($this->getInternshipFormHandler()->handleForm($this->getInternshipFormHandler()->getForm(), $entityToProcess, $request)) {

            $this->addFlash('success', $this->getInternshipFormHandler()->getMessage());

            return $this->redirectToRoute('internship');
        }

        return [
            'form' => $this->getInternshipFormHandler()->createView(),
            'internship' => $entityToProcess,
        ];
    }

    /**
     * @Route("/admin/internship/list/{page}", name="internship_list", defaults={"page" = 1})
     * @Template("InternshipBundle:Default:list.html.twig")
     * @param Request $request
     * @param integer $page
     * @return array of Internship and pagination
     */
    public function listAction(Request $request, $page)
    {
        if ($page < 1) {
            $page = 1;
        }

        $requestVal = $request->query->all();

        $limit = $this->getParameter('Internship.max_internship_per_page');

        $internship = $this->getInternshipManager()->getResultFilterPaginated(current($requestVal), $limit, ($page - 1) * $limit);
        $nbFilteredInternship = $this->getInternshipManager()->getResultFilterCount(current($requestVal));
        $pagination = $this->getInternshipManager()->getPagination($requestVal, $page, 'internship_list', $limit, $nbFilteredInternship);

        return [
            'internship' => $internship,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/internship/{id}/show", name="internship_show")
     * @ParamConverter("internship", class="InternshipBundle:Internship")
     * @param Internship $internship
     * @return Response
     * @Cache(smaxage=600)
     */
    public function showAction(Internship $internship)
    {
        return $this->render('InternshipBundle:Default:show.html.twig', ['internship' => $internship]);
    }

    /**
     * @Route("/admin/internship/new", name="internship_new")
     * @Route("/admin/internship/{id}/edit", name="internship_edit")
     * @Template("InternshipBundle:Default:edit.html.twig")
     * @param Request $request
     * @param Internship|null $internship
     * @return array|RedirectResponse
     * @ParamConverter("internship", class="InternshipBundle:Internship")
     * @Security("has_role('ROLE_EDITOR')")
     */
    public function newEditAction(Request $request, Internship $internship = null)
    {


        $entityToProcess = $this->getInternshipFormHandler()->processForm($internship);

        if ($this->getInternshipFormHandler()->handleForm($this->getInternshipFormHandler()->getForm(), $entityToProcess, $request)) {

            $this->addFlash('success', $this->getInternshipFormHandler()->getMessage());

            return $this->redirectToRoute('internship_edit', array('id' => $entityToProcess->getId()));
        }

        return [
            'form' => $this->getInternshipFormHandler()->createView(),
            'internship' => $entityToProcess,
        ];
    }

    /**
     * @Route("/admin/Internship/{id}/delete", name="internship_delete")
     * @ParamConverter("internship", class="InternshipBundle:Internship")
     * @param Internship $internship
     * @return RedirectResponse
     */
    public function deleteAction(Internship $internship)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        $this->getInternshipManager()->remove($internship);
        $this->addFlash('success', $this->get('translator')->trans('%title% : supprimer', ['%title%' => $internship->getTitle()], 'divers'));

        return new RedirectResponse($this->get('router')->generate('internship_list'));
    }

    /**
     * @Template("InternshipBundle:Partials:formFilter.html.twig")
     * @return Response
     */
    public function formFilterAction()
    {
        $form = $this->getInternshipManager()->getInternshipSearchForm(new Internship());
        return $this->render('InternshipBundle:Partials:formFilter.html.twig', ['form' => $form->createView()]);
    }

    public function getInternshipFormHandler()
    {
        return $this->get('Internship.Internship.form.handler');
    }

    public function getInternshipManager()
    {
        return $this->get('Internship.Internship_manager');
    }

}
