<?php

namespace UserBundle\Form\Handler\Rank;

use UserBundle\Entity\Manager\Interfaces\RankManagerInterface;
use UserBundle\Form\Handler\Rank\Interfaces\RankFormHandlerStrategy;

use UserBundle\Entity\Rank;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractRankFormHandlerStrategy implements RankFormHandlerStrategy
{

    /**
     * @var Form
     */
    protected $form;

    /**
     * @var RankManagerInterface
     */
    protected $rankManager;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var RouterInterface $router
     */
    protected $router;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param RankManagerInterface $rankManager
     * @return AbstractRankFormHandlerStrategy
     */
    public function setRankManager(RankManagerInterface $rankManager)
    {
        $this->rankManager = $rankManager;
        return $this;
    }

    /**
     * @param FormFactoryInterface $formFactory
     * @return AbstractRankFormHandlerStrategy
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @param RouterInterface $router
     * @return AbstractRankFormHandlerStrategy
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @param TranslatorInterface $translator
     * @return AbstractRankFormHandlerStrategy
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
        return $this;
    }

    /**
     * @return \Symfony\Component\Form\FormView
     */
    public function createView()
    {
        return $this->form->createView();
    }

    /**
     * @param Request $request
     * @param Rank $rank
     * @return mixed
     */
    abstract public function handleForm(Request $request, Rank $rank);

    /**
     * @param Rank $rank
     * @return mixed
     */
    abstract public function createForm(Rank $rank);


}