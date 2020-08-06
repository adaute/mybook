<?php
namespace PartnershipBundle\Form\Handler\Partnership\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use PartnershipBundle\Entity\Partnership;

interface PartnershipFormHandlerStrategy
{
    /**
     * @param Request $request
     * @param Partnership $partnership
     * @return mixed
     */
    public function handleForm(Request $request, Partnership $partnership);

    /**
     * @param Partnership $partnership
     * @return mixed
     */
    public function createForm(Partnership $partnership);

    /**
     * @return mixed
     */
    public function createView();
}
