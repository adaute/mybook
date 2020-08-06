<?php

namespace DiaryBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DiaryBundle\Entity\Diary;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DiaryController extends Controller
{
    /**
     * @Route("/payment/{id}", name="payment_diary")
     */
    public function paymentAction($id)
    {
        $diary = $this->getDiaryManager()->getProductAbout($id);

        if (!$diary || $diary[0]->getRemainingSpace() == 0) {
            return $this->redirectToRoute('diary');
        }

        $price = $diary[0]->getProduct()->getPrice();

        if($this->isGranted('IS_AUTHENTICATED_FULLY')){
            $user = $this->get('user.user_manager')->getUserByIdRank($this->get('security.token_storage')->getToken()->getUser()->getId());
            if($user[0][1])
                $price = $diary[0]->getProduct()->getPrice()*0.90;
        }

        $payment = $this->getPaymentManager();

        $paymentSend = $payment->sendPayment([
            'amount' => $price,
            'description' => $diary[0]->getId().':'.$diary[0]->getProduct()->getDescription(),
        ]);

        return $this->redirect($paymentSend['redirectPaypalApproval']);
    }

    /**
     * @Route("/diary/{page}", name="diary", defaults={"page" = 1})
     * @Template("DiaryBundle:Partials:homeDiary.html.twig")
     * @param Request $request
     * @param integer $page
     * @return array of diary and pagination
     */
    public function diaryAction(Request $request,$page)
    {
        if ($page < 1) {
            $page = 1;
        }
        $rank = null;
        $requestVal = $request->query->all();

        $limit = $this->getParameter('diary.max_diary_home_page');

        $diary = $this->getDiaryManager()->getResultFilterPaginated(current($requestVal), $limit, ($page - 1) * $limit);
        $nbFilteredDiary = $this->getDiaryManager()->getResultFilterCount(current($requestVal));
        $pagination = $this->getDiaryManager()->getPagination($requestVal, $page, 'diary', $limit, $nbFilteredDiary);
        $invoice = $this->getInvoiceManager()->getInvoiceByIdUserQueryBuilder($this->get('security.token_storage')->getToken()->getUser());

        if($this->isGranted('IS_AUTHENTICATED_FULLY'))
            $rank = $this->get('user.user_manager')->getUserByIdRank($this->get('security.token_storage')->getToken()->getUser()->getId());

        return [
            'diary' => $diary,
            'invoice' => $invoice,
            'rank' => $rank[0][1],
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/admin/diary/list/{page}", name="diary_list", defaults={"page" = 1})
     * @Template("DiaryBundle:Default:list.html.twig")
     * @param Request $request
     * @param integer $page
     * @return array of diary and pagination
     */
    public function listAction(Request $request, $page)
    {
        if ($page < 1) {
            $page = 1;
        }

        $requestVal = $request->query->all();

        $limit = $this->getParameter('diary.max_diary_per_page');

        $diary = $this->getDiaryManager()->getResultFilterPaginated(current($requestVal), $limit, ($page - 1) * $limit);
        $nbFilteredDiary = $this->getDiaryManager()->getResultFilterCount(current($requestVal));
        $pagination = $this->getDiaryManager()->getPagination($requestVal, $page, 'diary_list', $limit, $nbFilteredDiary);

        return [
            'diary' => $diary,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("/diary/{id}/show", name="diary_show")
     * @ParamConverter("diary", class="DiaryBundle:Diary")
     * @param Diary $diary
     * @return Response
     * @Cache(smaxage=600)
     */
    public function showAction(Diary $diary)
    {
        return $this->render('DiaryBundle:Default:show.html.twig', ['diary' => $diary]);
    }

    /**
     * @Route("/admin/diary/new", name="diary_new")
     * @Route("/admin/diary/{id}/edit", name="diary_edit")
     * @Template("DiaryBundle:Default:edit.html.twig")
     * @param Request $request
     * @param Diary|null $diary
     * @return array|RedirectResponse
     * @ParamConverter("diary", class="DiaryBundle:Diary")
     * @Security("has_role('ROLE_EDITOR')")
     */
    public function newEditAction(Request $request, Diary $diary = null)
    {
        $entityToProcess = $this->getDiaryFormHandler()->processForm($diary);

        if ($this->getDiaryFormHandler()->handleForm($this->getDiaryFormHandler()->getForm(), $entityToProcess, $request)) {

            $this->addFlash('success', $this->getDiaryFormHandler()->getMessage());

            return $this->redirectToRoute('diary_edit', array('id' => $entityToProcess->getId()));
        }

        return [
            'form' => $this->getDiaryFormHandler()->createView(),
            'diary' => $entityToProcess,
        ];
    }

    /**
     * @Route("/admin/diary/{id}/state", name="diary_state")
     * @ParamConverter("diary", class="DiaryBundle:Diary")
     * @param Diary $diary
     * @return RedirectResponse
     */
    public function stateAction(Diary $diary)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }

        $this->getDiaryManager()->setState($diary);

        $this->addFlash('success', $this->get('translator')->trans('%title% : state modify', ['%title%' => $diary->getProduct()->getTitle()], 'divers'));

        return new RedirectResponse($this->get('router')->generate('diary_list'));
    }

    /**
     * @Route("/admin/diary/{id}/delete", name="diary_delete")
     * @ParamConverter("diary", class="DiaryBundle:Diary")
     * @param Diary $diary
     * @return RedirectResponse
     */
    public function deleteAction(Diary $diary)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }
        $this->getDiaryManager()->remove($diary);
        $this->addFlash('success', $this->get('translator')->trans('%title% : supprimer', ['%title%' => $diary->getTitle()], 'divers'));

        return new RedirectResponse($this->get('router')->generate('diary_list'));
    }

    /**
     * @Template("DiaryBundle:Partials:formFilter.html.twig")
     * @return Response
     */
    public function formFilterAction()
    {
        $form = $this->getDiaryManager()->getDiarySearchForm(new Diary());
        return $this->render('DiaryBundle:Partials:formFilter.html.twig', ['form' => $form->createView()]);
    }

    public function getDiaryFormHandler()
    {
        return $this->get('diary.diary.form.handler');
    }

    public function getDiaryManager()
    {
        return $this->get('diary.diary_manager');
    }

    public function getProductManager()
    {
        return $this->get('payment.product_manager');
    }

    public function getInvoiceManager()
    {
        return $this->get('payment.payment_manager');
    }

    public function getPaymentManager()
    {
        return $this->get('paypal_payment.payment');
    }

    public function getUserManager()
    {
        return $this->get('user.user_manager');
    }
}
