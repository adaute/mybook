<?php
namespace InternshipBundle\Form\Handler\Internship;

use InternshipBundle\Entity\Manager\Interfaces\InternshipManagerInterface;
use InternshipBundle\Form\Handler\Internship\Interfaces\InternshipFormHandlerStrategy;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use InternshipBundle\Entity\Internship;

class InternshipFormHandler
{
    /**
     * @var string
     */
    private $message = "";

    /**
     * @var FormInterface $form
     */
    protected $form;


    /**
     * @var InternshipFormHandlerStrategy $internshipFormHandlerStrategy
     */
    private $internshipFormHandlerStrategy;

    /**
     * @var InternshipFormHandlerStrategy $newActorFormHandlerStrategy
     */
    protected $newInternshipFormHandlerStrategy;

    /**
     * @var InternshipFormHandlerStrategy $updateActorFormHandlerStrategy
     */
    protected $updateInternshipFormHandlerStrategy;

    /**
     * @var InternshipManagerInterface $internshipManager
     */
    protected $internshipManager;

    /**
     * @param InternshipFormHandlerStrategy $nafhs
     */
    public function setNewInternshipFormHandlerStrategy(InternshipFormHandlerStrategy $nafhs) {
        $this->newInternshipFormHandlerStrategy = $nafhs;
    }

    /**
     * @param InternshipFormHandlerStrategy $uafhs
     */
    public function setUpdateInternshipFormHandlerStrategy(InternshipFormHandlerStrategy $uafhs) {
        $this->updateInternshipFormHandlerStrategy = $uafhs;
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param Internship|null $internship
     * @return Internship
     */
    public function processHomeForm(Internship $internship = null)
    {
        if (is_null($internship)) {
            $internship = new Internship();
            $this->internshipFormHandlerStrategy = $this->newInternshipFormHandlerStrategy;
        }
        $this->form = $this->createHomeForm($internship);

        return $internship;
    }


    /**
     * @param Internship|null $internship
     * @return Internship
     */
    public function processForm(Internship $internship = null)
    {
        if (is_null($internship)) {
            $internship = new Internship();
            $this->internshipFormHandlerStrategy = $this->newInternshipFormHandlerStrategy;
        } else {
            $this->internshipFormHandlerStrategy = $this->updateInternshipFormHandlerStrategy;
        }
        $this->form = $this->createForm($internship);

        return $internship;
    }

    /**
     * @param Internship $internship
     * @return FormInterface
     */
    public function createHomeForm(Internship $internship)
    {
        return $this->internshipFormHandlerStrategy->createHomeForm($internship);
    }

    /**
     * @param Internship $internship
     * @return FormInterface
     */
    public function createForm(Internship $internship)
    {
        return $this->internshipFormHandlerStrategy->createForm($internship);
    }

    /**
     * @param FormInterface $form
     * @param Internship $internship
     * @param Request $request
     * @return bool
     */
    public function handleForm(FormInterface $form, Internship $internship, Request $request)
    {
        if (
            (null === $internship->getId() && $request->isMethod('POST'))
            || (null !== $internship->getId() && $request->isMethod('PUT'))
        ) {

            $form->handleRequest($request);

            if (!$form->isValid()) {
                return false;
            }

            $this->message = $this->internshipFormHandlerStrategy->handleForm($request, $internship);

            return true;
        }
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @return mixed
     */
    public function createView()
    {
        return $this->internshipFormHandlerStrategy->createView();
    }
}
