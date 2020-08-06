<?php
namespace FaqBundle\Entity\Manager\Interfaces;

use CoreBundle\Entity\Manager\Interfaces\CommonManagerInterface;

use FaqBundle\Entity\Faq;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

interface FaqManagerInterface extends CommonManagerInterface
{
    /**
     * @param int $limit
     * @param int $offset
     * @return array of faq
     */
    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    /**
     * @param $requestVal
     * @return integer
     */
    public function getResultFilterCount($requestVal);

    /**
     * @param Faq $faq
     * @return FormInterface
     */
    public function getFaqSearchForm(Faq $faq);

    /**
     * @return array of faq
     */
    public function getResultAll();

    /**
     * @param string $searchFormType
     * @return FaqManagerInterface
     */
    public function setSearchFormType($searchFormType);

    /**
     * @param FormFactoryInterface $formFactory
     * @return FaqManagerInterface
     */
    public function setFormFactory($formFactory);

    /**
     * @param RouterInterface $router
     * @return FaqManagerInterface
     */
    public function setRouter($router);
}
