<?php
namespace UserBundle\Form\Handler\Rank\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use UserBundle\Entity\Rank;

interface RankFormHandlerStrategy
{
    /**
     * @param Request $request
     * @param Rank $rank
     * @return mixed
     */
    public function handleForm(Request $request, Rank $rank);

    /**
     * @param Rank $rank
     * @return mixed
     */
    public function createForm(Rank $rank);

    /**
     * @return mixed
     */
    public function createView();
}
