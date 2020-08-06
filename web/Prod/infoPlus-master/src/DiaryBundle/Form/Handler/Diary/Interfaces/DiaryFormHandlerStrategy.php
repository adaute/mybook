<?php
namespace DiaryBundle\Form\Handler\Diary\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use DiaryBundle\Entity\Diary;

interface DiaryFormHandlerStrategy
{
    /**
     * @param Request $request
     * @param Diary $diary
     * @return mixed
     */
    public function handleForm(Request $request, Diary $diary);

    /**
     * @param Diary $diary
     * @return mixed
     */
    public function createForm(Diary $diary);

    /**
     * @return mixed
     */
    public function createView();
}
