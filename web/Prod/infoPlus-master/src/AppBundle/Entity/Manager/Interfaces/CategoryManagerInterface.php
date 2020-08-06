<?php
namespace AppBundle\Entity\Manager\Interfaces;

use CoreBundle\Entity\Manager\interfaces\CommonManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Routing\RouterInterface;

use AppBundle\Entity\Category;


interface CategoryManagerInterface extends CommonManagerInterface
{
    public function getResultAll();
    
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
     * @param Category $category
     * @return FormInterface
     */
    public function getCategorySearchForm(Category $category);

    /**
     * @param string $searchFormType
     * @return CategoryManagerInterface
     */
    public function setSearchFormType($searchFormType);

    /**
     * @param FormFactoryInterface $formFactory
     * @return CategoryManagerInterface
     */
    public function setFormFactory($formFactory);

    /**
     * @param RouterInterface $router
     * @return CategoryManagerInterface
     */
    public function setRouter($router);
}
