<?php
namespace UserBundle\Entity\Manager\Interfaces;

use CoreBundle\Entity\Manager\Interfaces\CommonManagerInterface;
use UserBundle\Entity\Rank;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

interface RankManagerInterface extends CommonManagerInterface
{
    /**
     * @param int $limit
     * @param int $offset
     * @return array of rank
     */
    public function getResultFilterPaginated($requestVal,$limit = 20, $offset = 0);

    /**
     * @param $requestVal
     * @return integer
     */
    public function getResultFilterCount($requestVal);

    /**
     * @param Rank $rank
     * @return FormInterface
     */
    public function getRankSearchForm(Rank $rank);

    /**
     * @param string $searchFormType
     * @return RankManagerInterface
     */
    public function setSearchFormType($searchFormType);

    /**
     * @param FormFactoryInterface $formFactory
     * @return RankManagerInterface
     */
    public function setFormFactory($formFactory);

    /**
     * @param RouterInterface $router
     * @return RankManagerInterface
     */
    public function setRouter($router);
}
