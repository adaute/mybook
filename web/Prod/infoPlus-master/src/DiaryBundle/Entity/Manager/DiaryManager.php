<?php
namespace DiaryBundle\Entity\Manager;

use CoreBundle\Entity\Manager\AbstractCommonManager;
use CoreBundle\Repository\AbstractCommonRepository;

use DiaryBundle\Entity\Manager\Interfaces\DiaryManagerInterface;
use DiaryBundle\Entity\Diary;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


class DiaryManager extends AbstractCommonManager implements DiaryManagerInterface
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
    public function getDiarySearchForm(Diary $diary)
    {
        return $this->formFactory->create(
            $this->searchFormType,
            $diary,
            [
                'action' => $this->router->generate('diary_list'),
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
    public function setState(Diary $diary)
    {
        if($diary->getEnabled() == 0){
            $diary->setEnabled(1);
            $diary->getProduct()->setEnabled(1);
            $diary->setPublishedAt(new \DateTime());
        } else {
            $diary->setEnabled(0);
            $diary->getProduct()->setEnabled(0);

            $diary->setUpdatedAt(new \DateTime());
        }
        $this->save($diary, false, true);
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return 'diaryManager';
    }
}
