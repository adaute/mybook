<?php
namespace UserBundle\Form\Handler\Rank;

use UserBundle\Form\Type\Rank\RankType;
use UserBundle\Entity\Rank;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UpdateRankFormHandlerStrategy extends AbstractRankFormHandlerStrategy
{
    /**
     * @var AuthorizationCheckerInterface
     */
    protected $authorizationChecker;

    /**

     * Constructor.
     *
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct
    (
        AuthorizationCheckerInterface $authorizationChecker
    )
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param Rank $rank
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Rank $rank)
    {
        $this->form = $this->formFactory->create(
            RankType::class,
            $rank,
            [
                'action' => $this->router->generate('rank_edit', ['id' => $rank->getId()]),
                'method' => 'PUT'
            ]
        );

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Rank $rank
     * @return string
     */
    public function handleForm(Request $request, Rank $rank)
    {

        $this->rankManager->save($rank, false, true);

        return $this->translator
            ->trans('success_modify', array(),'divers');
    }
}
