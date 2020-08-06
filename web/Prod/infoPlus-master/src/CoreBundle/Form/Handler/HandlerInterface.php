<?php

namespace CoreBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface HandlerInterface
{
    /**
     * handles the form
     *
     * @param FormInterface $form
     * @param Request $request
     * @param array $options
     */
    public function handle(FormInterface $form, Request $request, array $options = null);
} 