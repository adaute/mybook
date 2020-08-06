<?php
namespace FaqBundle\Form\Handler\Faq\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use FaqBundle\Entity\Faq;

interface FaqFormHandlerStrategy
{
    /**
     * @param Request $request
     * @param Faq $faq
     * @return mixed
     */
    public function handleForm(Request $request, Faq $faq);

    /**
     * @param Faq $faq
     * @return mixed
     */
    public function createForm(Faq $faq);

    /**
     * @return mixed
     */
    public function createView();
}
