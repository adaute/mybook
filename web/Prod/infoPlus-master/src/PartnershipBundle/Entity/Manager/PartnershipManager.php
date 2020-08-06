<?php
namespace PartnershipBundle\Entity\Manager;

use CoreBundle\Entity\Manager\AbstractCommonManager;
use CoreBundle\Repository\AbstractCommonRepository;

use PartnershipBundle\Entity\Manager\Interfaces\PartnershipManagerInterface;
use PartnershipBundle\Entity\Partnership;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


class PartnershipManager extends AbstractCommonManager implements PartnershipManagerInterface
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
     * @var EventDispatcherInterface $dispatcher
     */
    protected $dispatcher;

    /**
     * @inheritdoc
     */
    public function __construct(
        AbstractCommonRepository $repository,
        EventDispatcherInterface $dispatcher
    )
    {
        parent::__construct($repository);
        $this->dispatcher = $dispatcher;
    }


    /**
     * @inheritdoc
     */
    public function getProductAbout($id)
    {
        return $this->repository->getProductAbout($id);
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
    public function getPartnershipSearchForm(Partnership $partnership)
    {
        return $this->formFactory->create(
            $this->searchFormType,
            $partnership,
            [
                'action' => $this->router->generate('partnership_list'),
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
        return 'partnershipManager';
    }
}
