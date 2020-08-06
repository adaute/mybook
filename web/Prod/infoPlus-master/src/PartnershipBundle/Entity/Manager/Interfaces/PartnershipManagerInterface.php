<?php
namespace PartnershipBundle\Entity\Manager\Interfaces;

use CoreBundle\Entity\Manager\Interfaces\CommonManagerInterface;
use PartnershipBundle\Entity\Partnership;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

interface PartnershipManagerInterface extends CommonManagerInterface
{
    /**
     * @param int $id
     */
    public function getProductAbout($id);

    /**
     * @param int $limit
     * @param int $offset
     * @return array of partnershipal
     */
    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    /**
     * @param $requestVal
     * @return integer
     */
    public function getResultFilterCount($requestVal);

    /**
     * @param Partnership $partnership
     * @return FormInterface
     */
    public function getPartnershipSearchForm(Partnership $partnership);

    /**
     * @param string $searchFormType
     * @return PartnershipManagerInterface
     */
    public function setSearchFormType($searchFormType);

    /**
     * @param FormFactoryInterface $formFactory
     * @return PartnershipManagerInterface
     */
    public function setFormFactory($formFactory);

    /**
     * @param RouterInterface $router
     * @return PartnershipManagerInterface
     */
    public function setRouter($router);
}
