<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * @Route("/admin/category/list/{page}", name="category_list", defaults={"page" = 1})
     * @Template("AppBundle:Default:Category/list.html.twig")
     * @param Request $request
     * @param integer $page
     * @return array of category and pagination
     */
    public function listAction(Request $request, $page)
    {
        if ($page < 1) {
            $page = 1;
        }

        $requestVal = $request->query->all();

        $limit = $this->getParameter('app.max_category_per_page');

        $category = $this->getCategoryManager()->getResultFilterPaginated(current($requestVal), $limit, ($page - 1) * $limit);
        $nbFilteredCategory = $this->getCategoryManager()->getResultFilterCount(current($requestVal));
        $pagination = $this->getCategoryManager()->getPagination($requestVal, $page, 'category_list', $limit, $nbFilteredCategory);

        return [
            'category' => $category,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/admin/category/new", name="category_new")
     * @Route("/admin/category/{id}/edit", name="category_edit")
     * @Template("AppBundle:Default:Category/edit.html.twig")
     * @param Request $request
     * @param Category|null $category
     * @return array|RedirectResponse
     * @ParamConverter("category", class="AppBundle:Category")
     * @Security("has_role('ROLE_EDITOR')")
     */
    public function newEditAction(Request $request, Category $category = null)
    {
        $entityToProcess = $this->getCategoryFormHandler()->processForm($category);

        if ($this->getCategoryFormHandler()->handleForm($this->getCategoryFormHandler()->getForm(), $entityToProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getCategoryFormHandler()->getMessage());

            return $this->redirectToRoute('category_edit', array('id' => $entityToProcess->getId()));
        }

        return [
            'form' => $this->getCategoryFormHandler()->createView(),
            'category' => $entityToProcess,
        ];
    }

    /**
     * @Route("/admin/category/{id}/delete", name="category_delete")
     * @ParamConverter("category", class="AppBundle:Category")
     * @param Category $category
     * @return RedirectResponse
     */
    public function deleteAction(Category $category)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        $this->getCategoryManager()->remove($category);
        $this->addFlash('success', $this->get('translator')->trans('%title% : supprimer', ['%title%' => $category->getTitle()], 'divers'));

        return new RedirectResponse($this->get('router')->generate('category_list'));
    }

    /**
     * @Template("AppBundle:Partials:formFilter.html.twig")
     * @return Response
     */
    public function formFilterAction()
    {
        $form = $this->getCategoryManager()->getCategorySearchForm(new Category());

        return $this->render('AppBundle:Partials:formFilter.html.twig', ['form' => $form->createView()]);
    }

    public function getCategoryFormHandler()
    {
        return $this->get('app.category.form.handler');
    }

    public function getCategoryManager()
    {
        return $this->get('app.category_manager');
    }

}
