<?php
namespace UserBundle\Form\Handler\Rank;

use UserBundle\Entity\Manager\Interfaces\RankManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\Handler\Rank\Interfaces\RankFormHandlerStrategy;

use UserBundle\Entity\Rank;

class RankFormHandler
{
    /**
     * @var string
     */
    private $message = "";

    /**
     * @var FormInterface $form
     */
    protected $form;


    /**
     * @var RankFormHandlerStrategy $rankFormHandlerStrategy
     */
    private $rankFormHandlerStrategy;

    /**
     * @var RankFormHandlerStrategy $newActorFormHandlerStrategy
     */
    protected $newRankFormHandlerStrategy;

    /**
     * @var RankFormHandlerStrategy $updateActorFormHandlerStrategy
     */
    protected $updateRankFormHandlerStrategy;

    /**
     * @var RankManagerInterface $rankManager
     */
    protected $rankManager;

    /**
     * @param RankFormHandlerStrategy $nafhs
     */
    public function setNewRankFormHandlerStrategy(RankFormHandlerStrategy $nafhs) {
        $this->newRankFormHandlerStrategy = $nafhs;
    }

    /**
     * @param RankFormHandlerStrategy $uafhs
     */
    public function setUpdateRankFormHandlerStrategy(RankFormHandlerStrategy $uafhs) {
        $this->updateRankFormHandlerStrategy = $uafhs;
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param Rank|null $rank
     * @return Rank
     */
    public function processForm(Rank $rank = null)
    {
        if (is_null($rank)) {
            $rank = new Rank();
            $this->rankFormHandlerStrategy = $this->newRankFormHandlerStrategy;
        } else {
            $this->rankFormHandlerStrategy = $this->updateRankFormHandlerStrategy;
        }

        $this->form = $this->createForm($rank);

        return $rank;
    }

    /**
     * @param Rank $rank
     * @return FormInterface
     */
    public function createForm(Rank $rank)
    {
        return $this->rankFormHandlerStrategy->createForm($rank);
    }

    /**
     * @param FormInterface $form
     * @param Rank $rank
     * @param Request $request
     * @return bool
     */
    public function handleForm(FormInterface $form, Rank $rank, Request $request)
    {
        if (
            (null === $rank->getId() && $request->isMethod('POST'))
            || (null !== $rank->getId() && $request->isMethod('PUT'))
        ) {

            $form->handleRequest($request);

            if (!$form->isValid()) {
                return false;
            }

            $this->message = $this->rankFormHandlerStrategy->handleForm($request, $rank);

            return true;
        }
    }

    /**
     * @param FormInterface $form
     * @param Request $request
     * @throws \Exception
     */
    public function handleSearchForm(FormInterface $form, Request $request)
    {
        $attributes = $request->attributes->all();

        foreach ($attributes as $key => $val) {
            if (!empty($val)) {
                // title, citation
                if (in_array($key, Rank::getLikeFields())) {
                    $form->get($key)->setData($val);
                    continue;
                }

            }
        }
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return mixed
     */
    public function createView()
    {
        return $this->rankFormHandlerStrategy->createView();
    }
}
