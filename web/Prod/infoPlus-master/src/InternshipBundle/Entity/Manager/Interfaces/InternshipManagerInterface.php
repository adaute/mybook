<?php
namespace InternshipBundle\Entity\Manager\Interfaces;

use CoreBundle\Entity\Manager\Interfaces\CommonManagerInterface;
use InternshipBundle\Entity\Internship;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

interface InternshipManagerInterface extends CommonManagerInterface
{
    /**
     * @param int $id
     */
    public function getProductAbout($id);

    /**
     * @param int $limit
     * @param int $offset
     * @return array of internshipal
     */
    public function getResultFilterPaginated($requestVal, $limit = 20, $offset = 0);

    /**
     * @param $requestVal
     * @return integer
     */
    public function getResultFilterCount($requestVal);

    /**
     * @param Internship $internship
     * @return FormInterface
     */
    public function getInternshipSearchForm(Internship $internship);

    /**
     * @param string $searchFormType
     * @return InternshipManagerInterface
     */
    public function setSearchFormType($searchFormType);

    /**
     * @param FormFactoryInterface $formFactory
     * @return InternshipManagerInterface
     */
    public function setFormFactory($formFactory);

    /**
     * @param RouterInterface $router
     * @return InternshipManagerInterface
     */
    public function setRouter($router);
}
