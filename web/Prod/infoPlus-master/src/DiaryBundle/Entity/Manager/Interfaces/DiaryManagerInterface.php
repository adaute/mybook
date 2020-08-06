<?php
namespace DiaryBundle\Entity\Manager\Interfaces;

use CoreBundle\Entity\Manager\Interfaces\CommonManagerInterface;
use DiaryBundle\Entity\Diary;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

interface DiaryManagerInterface extends CommonManagerInterface
{
    /**
     * @param int $id
     */
    public function getProductAbout($id);

    /**
     * @param int $limit
     * @param int $offset
     * @return array of diaryal
     */
    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    /**
     * @param $requestVal
     * @return integer
     */
    public function getResultFilterCount($requestVal);

    /**
     * @param Diary $diary
     * @return FormInterface
     */
    public function getDiarySearchForm(Diary $diary);

    /**
     * @param Diary $diary
     */
    public function setState(Diary $diary);

    /**
     * @param string $searchFormType
     * @return DiaryManagerInterface
     */
    public function setSearchFormType($searchFormType);

    /**
     * @param FormFactoryInterface $formFactory
     * @return DiaryManagerInterface
     */
    public function setFormFactory($formFactory);

    /**
     * @param RouterInterface $router
     * @return DiaryManagerInterface
     */
    public function setRouter($router);
}
