<?php
namespace InternshipBundle\Form\Handler\Internship\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use InternshipBundle\Entity\Internship;

interface InternshipFormHandlerStrategy
{
    /**
     * @param Request $request
     * @param Internship $internship
     * @return mixed
     */
    public function handleForm(Request $request, Internship $internship);

    /**
     * @param Internship $internship
     * @return mixed
     */
    public function createForm(Internship $internship);

    /**
     * @param Internship $internship
     * @return mixed
     */
    public function createHomeForm(Internship $internship);

    /**
     * @return mixed
     */
    public function createView();
}
