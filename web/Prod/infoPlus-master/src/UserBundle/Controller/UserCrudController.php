<?php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use UserBundle\entity\user;

class UserCrudController extends Controller
{
    /**
     * @Route("/admin/user/list/{page}", name="user_list", defaults={"page" = 1})
     * @Template("UserBundle:Default:User/list.html.twig")
     * @param Request $request
     * @param integer $page
     * @return array of user and pagination
     */
    public function listAction(Request $request, $page)
    {
        if ($page < 1) {
            $page = 1;
        }

        $requestVal = $request->query->all();

        $limit = $this->getParameter('user.max_user_per_page');

        $user = $this->getUserManager()->getResultFilterPaginated(current($requestVal), $limit, ($page - 1) * $limit);
        $nbFilteredUser = $this->getUserManager()->getResultFilterCount(current($requestVal));
        $pagination = $this->getUserManager()->getPagination($requestVal, $page, 'user_list', $limit, $nbFilteredUser);

        return [
            'user' => $user,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/user/{id}/show", name="user_show")
     * @ParamConverter("user", class="UserBundle:User")
     * @param User $user
     * @return Response
     * @Cache(smaxage=600)
     */
    public function showAction(User $user)
    {
        return $this->render('UserBundle:Default:User/show.html.twig', ['user' => $user]);
    }

    /**
     * @Route("user/{id}/edit", name="userOnline_edit")
     * @Template("UserBundle:Default:User/profil.html.twig")
     * @param Request $request
     * @param User|null $user
     * @return array|RedirectResponse
     * @ParamConverter("user", class="UserBundle:User")
     */
    public function profilAction(Request $request, User $user = null)
    {
        $userOnline = $this->get('security.token_storage')->getToken()->getUser();

        if ($userOnline->getId() == $user->getId()) {

            $entityToProcess = $this->getUserFormHandler()->processForm($user, true);

            if ($this->getUserFormHandler()->handleForm($this->getUserFormHandler()->getForm(), $entityToProcess, $request)) {
                $this->addFlash('success', $this->getUserFormHandler()->getMessage());
                return $this->redirectToRoute('userOnline_edit', array('id' => $entityToProcess->getId()));
            }
        } else {
            return $this->redirect($this->generateUrl('user_dashboard'));
        }

        return [
            'form' => $this->getUserFormHandler()->createView(),
            'user' => $entityToProcess,
        ];
    }


    /**
     * @Route("/admin/user/{id}/edit", name="user_edit")
     * @Template("UserBundle:Default:User/edit.html.twig")
     * @param Request $request
     * @param User|null $user
     * @return array|RedirectResponse
     * @ParamConverter("user", class="UserBundle:User")
     * @Security("has_role('ROLE_EDITOR')")
     */
    public function newEditAction(Request $request, User $user = null)
    {

        $entityToProcess = $this->getUserFormHandler()->processForm($user, false);

        if ($this->getUserFormHandler()->handleForm($this->getUserFormHandler()->getForm(), $entityToProcess, $request)) {
            $this->addFlash('success', $this->getUserFormHandler()->getMessage());
            return $this->redirectToRoute('user_edit', array('id' => $entityToProcess->getId()));
        }

        return [
            'form' => $this->getUserFormHandler()->createView(),
            'user' => $entityToProcess,
        ];
    }

    /**
     * @Route("/user/{id}/delete", name="user_unsubscribe")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function unsubscribeAction(Request $request, User $user)
    {
        $userOnline = $this->get('security.token_storage')->getToken()->getUser();

        if ($userOnline->getId() == $user->getId()) {
            $this->getUserManager()->remove($user);
            $this->get('security.token_storage')->setToken(null);
            $session = $request->getSession();
            $session->invalidate();
            $this->addFlash('success', $this->get('translator')->trans('%title% : supprimer', ['%title%' => $user->getFirstName()], 'divers'));
            return $this->redirect($this->generateUrl('homepage'));
        } else {
            return $this->redirect($this->generateUrl('user_dashboard'));
        }
    }

    /**
     * @Route("/admin/user/{id}/delete", name="user_delete")
     * @ParamConverter("user", class="UserBundle:User")
     * @param User $user
     * @return RedirectResponse
     */
    public function deleteAction(User $user)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        $this->getUserManager()->remove($user);
        $this->addFlash('success', $this->get('translator')->trans('%title% : supprimer', ['%title%' => $user->getFirstName()], 'divers'));

        return new RedirectResponse($this->get('router')->generate('user_list'));
    }

    /**
     * @Template("UserBundle:Partials:User/formFilter.html.twig")
     * @return Response
     */
    public function formFilterAction()
    {
        $form = $this->getUserManager()->getUserSearchForm(new User());
        return $this->render('UserBundle:Partials:User/formFilter.html.twig', ['form' => $form->createView()]);
    }

    public function getUserManager()
    {
        return $this->get('user.user_manager');
    }

    public function getUserFormHandler()
    {
        return $this->get('user.user.form.handler');
    }


}
