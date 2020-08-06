<?php
namespace UserBundle\Entity\Manager;

use CoreBundle\Entity\Manager\AbstractCommonManager;
use CoreBundle\Repository\AbstractCommonRepository;

use UserBundle\Entity\Manager\Interfaces\RankManagerInterface;
use UserBundle\Entity\Rank;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Routing\RouterInterface;

class RankManager extends AbstractCommonManager implements RankManagerInterface
{
    /**
     * @var FormTypeInterface
     */
    protected $searchFormType;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var RouterInterface $router
     */
    protected $router;

    /**
     * @inheritdoc
     */
    public function __construct(AbstractCommonRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @inheritdoc
     */
    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0)
    {
        return $this->repository->getResultFilterPaginated($requestVal, $limit, $offset);
    }

    /**
     * @inheritdoc
     */
    public function getResultFilterCount($requestVal)
    {
        return $this->repository->getResultFilterCount($requestVal);
    }

    /**
     * @inheritdoc
     */
    public function getRankSearchForm(Rank $rank)
    {
        return $this->formFactory->create(
            $this->searchFormType,
            $rank,
            [
                'action' => $this->router->generate('rank_list'),
                'method' => 'GET',
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function setSearchFormType($searchFormType)
    {
        $this->searchFormType = $searchFormType;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setFormFactory($formFactory)
    {
        $this->formFactory = $formFactory;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return 'rankManager';
    }
}
