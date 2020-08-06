<?php

namespace TicketBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use TicketBundle\Entity\Ticket;
use TicketBundle\Entity\Answer;

class TicketController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param Ticket|null $ticket
     * @return array|RedirectResponse
     * @Template("TicketBundle:Default:contact.html.twig")
     */
    public function indexAction(Request $request, Ticket $ticket = null)
    {
        $entityToProcess = $this->getTicketFormHandler()->processHomeForm($ticket);

        if ($this->getTicketFormHandler()->handleForm($this->getTicketFormHandler()->getForm(), $entityToProcess, $request)) {

            $this->addFlash('success', $this->getTicketFormHandler()->getMessage());

            return $this->redirectToRoute('contact');
        }

        return [
            'form' => $this->getTicketFormHandler()->createView(),
            'ticket' => $entityToProcess,
        ];
    }

    /**
     * @Route("/admin/ticket/list/{page}", name="ticket_list", defaults={"page" = 1})
     * @Template("TicketBundle:Default:Ticket/list.html.twig")
     * @param Request $request
     * @param integer $page
     * @return array of ticket and pagination
     */
    public function listAction(Request $request, $page)
    {
        if ($page < 1) {
            $page = 1;
        }

        $requestVal = $request->query->all();

        $limit = $this->getParameter('ticket.max_ticket_per_page');

        $ticket = $this->getTicketManager()->getResultFilterPaginated(current($requestVal), $limit, ($page - 1) * $limit);
        $nbFilteredTicket = $this->getTicketManager()->getResultFilterCount(current($requestVal));
        $pagination = $this->getTicketManager()->getPagination($requestVal, $page, 'ticket_list', $limit, $nbFilteredTicket);

        return [
            'ticket' => $ticket,
            'pagination' => $pagination,
        ];
    }

    /**
     * @Route("ticket/show", name="ticket_show")
     * @param Request $request
     * @param Answer|null $answer
     * @return array|RedirectResponse
     * @Template("TicketBundle:Default:Ticket/showClient.html.twig")
     */
    public function showTicketAction(Request $request, Answer $answer = null)
    {
        $entityToProcess = $this->getTicketFormHandler()->processAnswerForm($answer);

        $token = $request->query->get('token');

        if (!$token) {
            return $this->redirectToRoute('contact');
        }

        $ticket = $this->getTicketManager()->getTicketByToken($token);

        if (!$ticket) {
            return $this->redirectToRoute('contact');
        }

        $answers = $this->getTicketManager()->getAnswerByTicketID($ticket[0]->getId());

        if ($this->getTicketFormHandler()->handleAnswerForm($this->getTicketFormHandler()->getForm(), $entityToProcess, $request,$ticket[0])) {
            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getTicketFormHandler()->getMessage());
            return $this->redirectToRoute('ticket_show', array('token' => $token));
        }

        return [
            'form' => $this->getTicketFormHandler()->createView(),
            'answer' => $entityToProcess,
            'answers'=>$answers,
            'ticket' => $ticket[0],
        ];
    }

    /**
     * @Route("/admin/ticket/{id}/state", name="ticket_state")
     * @ParamConverter("ticket", class="TicketBundle:Ticket")
     * @param Ticket $ticket
     * @return RedirectResponse
     */
    public function stateAction(Ticket $ticket)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }

        $this->getTicketManager()->setState($ticket);

        $this->addFlash('success', $this->get('translator')->trans('%title% : state modify', ['%title%' => $ticket->getSubject()], 'divers'));

        return new RedirectResponse($this->get('router')->generate('ticket_list'));
    }

    /**
     * @Template("TicketBundle:Partials:Ticket/formFilter.html.twig")
     * @return Response
     */
    public function formFilterAction()
    {
        $form = $this->getTicketManager()->getTicketSearchForm(new Ticket());
        return $this->render('TicketBundle:Partials:Ticket/formFilter.html.twig', ['form' => $form->createView()]);
    }

    public function getTicketManager()
    {
        return $this->get('ticket.ticket_manager');
    }

    public function getTicketFormHandler()
    {
        return $this->get('ticket.ticket.form.handler');
    }
}
