<?php

namespace TopicBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use TopicBundle\Entity\Topic;

class TopicController extends Controller
{
    /**
     * @Route("/admin/topic/list/{page}", name="topic_list", defaults={"page" = 1})
     * @Template("TopicBundle:Default:list.html.twig")
     * @param Request $request
     * @param integer $page
     * @return array of topic and pagination
     */
    public function listAction(Request $request, $page)
    {
        if ($page < 1) {
            $page = 1;
        }

        $requestVal = $request->query->all();

        $limit = $this->getParameter('topic.max_topic_per_page');

        $topic = $this->getTopicManager()->getResultFilterPaginated(current($requestVal), $limit, ($page - 1) * $limit);
        $nbFilteredTopic = $this->getTopicManager()->getResultFilterCount(current($requestVal));
        $pagination = $this->getTopicManager()->getPagination($requestVal, $page, 'topic_list', $limit, $nbFilteredTopic);

        return [
            'topic' => $topic,
            'pagination' => $pagination,
        ];
    }



    /**
     * @Template("TopicBundle:Partials:homeTopic.html.twig")
     */
    public function homeAction ()
    {
        $topic = $this->getTopicManager()->getEnableTopic();
        return [
            'topic' => $topic,
        ];
    }

    /**
     * @Route("/topic/{id}/show", name="topic_show")
     * @ParamConverter("topic", class="TopicBundle:Topic")
     * @param Topic $topic
     * @return Response
     * @Cache(smaxage=600)
     */
    public function showAction(Topic $topic)
    {
        return $this->render('TopicBundle:Default:show.html.twig', ['topic' => $topic]);
    }

    /**
     * @Route("/admin/topic/new", name="topic_new")
     * @Route("/admin/topic/{id}/edit", name="topic_edit")
     * @Template("TopicBundle:Default:edit.html.twig")
     * @param Request $request
     * @param Topic|null $topic
     * @return array|RedirectResponse
     * @ParamConverter("topic", class="TopicBundle:Topic")
     * @Security("has_role('ROLE_EDITOR')")
     */
    public function newEditAction(Request $request, Topic $topic = null)
    {

        $entityToProcess = $this->getTopicFormHandler()->processForm($topic);

        if ($this->getTopicFormHandler()->handleForm($this->getTopicFormHandler()->getForm(), $entityToProcess, $request)) {

            // we add flash messages to stick with context (new or edited object)
            $this->addFlash('success', $this->getTopicFormHandler()->getMessage());

            return $this->redirectToRoute('topic_edit', array('id' => $entityToProcess->getId()));
        }

        return [
            'form' => $this->getTopicFormHandler()->createView(),
            'topic' => $entityToProcess,
        ];
    }

    /**
     * @Route("/admin/topic/{id}/state", name="topic_state")
     * @ParamConverter("topic", class="TopicBundle:Topic")
     * @param Topic $topic
     * @return RedirectResponse
     */
    public function stateAction(Topic $topic)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }

        $this->getTopicManager()->setState($topic);

        $this->addFlash('success', $this->get('translator')->trans('%title% : state modify', ['%title%' => $topic->getTitle()], 'divers'));

        return new RedirectResponse($this->get('router')->generate('topic_list'));
    }

    /**
     * @Route("/admin/topic/{id}/delete", name="topic_delete")
     * @ParamConverter("topic", class="TopicBundle:Topic")
     * @param Topic $topic
     * @return RedirectResponse
     */
    public function deleteAction(Topic $topic)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('You cannot access this page!');
        }

        $this->getTopicManager()->remove($topic);

        $this->addFlash('success', $this->get('translator')->trans('%title% : supprimer', ['%title%' => $topic->getTitle()], 'divers'));

        return new RedirectResponse($this->get('router')->generate('topic_list'));
    }

    /**
     * @Template("TopicBundle:Partials:formFilter.html.twig")
     * @return Response
     */
    public function formFilterAction()
    {
        $form = $this->getTopicManager()->getTopicSearchForm(new Topic());
        return $this->render('TopicBundle:Partials:formFilter.html.twig', ['form' => $form->createView()]);
    }

    public function getTopicFormHandler()
    {
        return $this->get('topic.topic.form.handler');
    }

    public function getTopicManager()
    {
        return $this->get('topic.topic_manager');
    }
}
