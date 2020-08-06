<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\Common\Collections\ArrayCollection;
use UserBundle\Entity\Rank;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class RankController extends Controller
{
    /**
     * @Route("/admin/rank/list/{page}", name="rank_list", defaults={"page" = 1})
     * @Template("UserBundle:Default:Rank/list.html.twig")
     * @param Request $request
     * @param integer $page
     * @return array of rank and pagination
     */
    public function listAction(Request $request, $page)
    {
        if ($page < 1) {
            $page = 1;
        }

        $requestVal = $request->query->all();

        $limit = $this->getParameter('user.max_rank_per_page');

        $rank = $this->getRankManager()->getResultFilterPaginated(current($requestVal), $limit, ($page - 1) * $limit);
        $nbFilteredRank = $this->getRankManager()->getResultFilterCount(current($requestVal));
        $pagination = $this->getRankManager()->getPagination($requestVal, $page, 'rank_list', $limit, $nbFilteredRank);

        return [
            'rank' => $rank,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Template("UserBundle:Partials:Rank/homeRank.html.twig")
     * @param Request $request
     * @return array of rank and pagination and user
     */
    public function rankAction(Request $request)
    {
        $requestVal = $request->query->all();

        $limit = $this->getParameter('user.max_rank_per_page');

        $rank = $this->getRankManager()->getResultFilterPaginated(current($requestVal), $limit);

        $user = $this->getUserManager()->getUserAll();

        return [
            'rank' => $rank,
            'user' => $user,
        ];
    }

    /**
     * @Route("/admin/rank/new", name="rank_new")
     * @Route("/admin/rank/{id}/edit", name="rank_edit")
     * @Template("UserBundle:Default:Rank/edit.html.twig")
     * @param Request $request
     * @param Rank|null $rank
     * @return array|RedirectResponse
     * @ParamConverter("rank", class="UserBundle:Rank")
     * @Security("has_role('ROLE_EDITOR')")
     */
    public function newEditAction(Request $request, Rank $rank = null)
    {
        $entityToProcess = $this->getRankFormHandler()->processForm($rank);

        if ($this->getRankFormHandler()->handleForm($this->getRankFormHandler()->getForm(), $entityToProcess, $request)) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getRankFormHandler()->getMessage());

            return $this->redirectToRoute('rank_edit', array('id' => $entityToProcess->getId()));
        }

        return [
            'form' => $this->getRankFormHandler()->createView(),
            'rank' => $entityToProcess,
        ];
    }

    /**
     * @Route("/admin/rank/{id}/delete", name="rank_delete")
     * @ParamConverter("rank", class="UserBundle:Rank")
     * @param Rank $rank
     * @return RedirectResponse
     */
    public function deleteAction(Rank $rank)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        $this->getRankManager()->remove($rank);
        $this->addFlash('success', $this->get('translator')->trans('%title% : supprimer', ['%title%' => $rank->getTitle()], 'divers'));

        return new RedirectResponse($this->get('router')->generate('rank_list'));
    }

    /**
     * @Template("UserBundle:Partials:Rank/formFilter.html.twig")
     * @return Response
     */
    public function formFilterAction()
    {
        $form = $this->getRankManager()->getRankSearchForm(new Rank());
        return $this->render('UserBundle:Partials:Rank/formFilter.html.twig', ['form' => $form->createView()]);
    }

    public function getRankFormHandler()
    {
        return $this->get('user.rank.form.handler');
    }

    public function getRankManager()
    {
        return $this->get('user.rank_manager');
    }
    public function getUserManager()
    {
        return $this->get('user.user_manager');
    }
}
