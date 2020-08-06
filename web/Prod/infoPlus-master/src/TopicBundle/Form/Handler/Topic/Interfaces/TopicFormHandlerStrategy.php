<?php
namespace TopicBundle\Form\Handler\Topic\Interfaces;

use Symfony\Component\HttpFoundation\Request;
use TopicBundle\Entity\Topic;

interface TopicFormHandlerStrategy
{
    /**
     * @param Request $request
     * @param Topic $topic
     * @return mixed
     */
    public function handleForm(Request $request, Topic $topic);

    /**
     * @param Topic $topic
     * @return mixed
     */
    public function createForm(Topic $topic);

    /**
     * @return mixed
     */
    public function createView();
}
