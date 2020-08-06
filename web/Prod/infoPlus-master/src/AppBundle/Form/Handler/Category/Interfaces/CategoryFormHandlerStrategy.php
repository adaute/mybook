<?php
namespace AppBundle\Form\Handler\Category\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Category;

interface CategoryFormHandlerStrategy
{
    /**
     * @param Request $request
     * @param Category $category
     * @return mixed
     */
    public function handleForm(Request $request, Category $category);

    /**
     * @param Category $category
     * @return mixed
     */
    public function createForm(Category $category);

    /**
     * @return mixed
     */
    public function createView();
}
