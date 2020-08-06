<?php
namespace UserBundle\Form\Handler\Rank;

use UserBundle\Form\Type\Rank\RankType;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Rank;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NewRankFormHandlerStrategy extends AbstractRankFormHandlerStrategy
{
    /**
     * @var TokenStorageInterface
     */
    protected $securityTokenStorage;

    /**
     * Constructor.
     *
     * @param TokenStorageInterface $securityTokenStorage
     */
    public function __construct(TokenStorageInterface $securityTokenStorage)
    {
        $this->securityTokenStorage = $securityTokenStorage;
    }

    /**
     * @param Rank $rank
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Rank $rank)
    {
        $this->form = $this->formFactory->create(RankType::class, $rank, array(
            'action' => $this->router->generate('rank_new'),
            'method' => 'POST',
        ));

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Rank $rank
     * @return string
     */
    public function handleForm(Request $request, Rank $rank)
    {
        $rank->setPosition(0);
        $this->rankManager->save($rank, true, true);

        return $this->translator
            ->trans('succes', array(),'divers');
    }


}
