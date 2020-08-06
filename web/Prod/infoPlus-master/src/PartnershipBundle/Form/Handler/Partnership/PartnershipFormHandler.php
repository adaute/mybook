<?php
namespace PartnershipBundle\Form\Handler\Partnership;

use PartnershipBundle\Entity\Manager\Interfaces\PartnershipManagerInterface;
use PartnershipBundle\Form\Handler\Partnership\Interfaces\PartnershipFormHandlerStrategy;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use PartnershipBundle\Entity\Partnership;

class PartnershipFormHandler
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
     * @var PartnershipFormHandlerStrategy $partnershipFormHandlerStrategy
     */
    private $partnershipFormHandlerStrategy;

    /**
     * @var PartnershipFormHandlerStrategy $newActorFormHandlerStrategy
     */
    protected $newPartnershipFormHandlerStrategy;

    /**
     * @var PartnershipFormHandlerStrategy $updateActorFormHandlerStrategy
     */
    protected $updatePartnershipFormHandlerStrategy;

    /**
     * @var PartnershipManagerInterface $partnershipManager
     */
    protected $partnershipManager;

    /**
     * @param PartnershipFormHandlerStrategy $nafhs
     */
    public function setNewPartnershipFormHandlerStrategy(PartnershipFormHandlerStrategy $nafhs) {
        $this->newPartnershipFormHandlerStrategy = $nafhs;
    }

    /**
     * @param PartnershipFormHandlerStrategy $uafhs
     */
    public function setUpdatePartnershipFormHandlerStrategy(PartnershipFormHandlerStrategy $uafhs) {
        $this->updatePartnershipFormHandlerStrategy = $uafhs;
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param Partnership|null $partnership
     * @return Partnership
     */
    public function processForm(Partnership $partnership = null)
    {
        if (is_null($partnership)) {
            $partnership = new Partnership();
            $this->partnershipFormHandlerStrategy = $this->newPartnershipFormHandlerStrategy;
        } else {
            $this->partnershipFormHandlerStrategy = $this->updatePartnershipFormHandlerStrategy;
        }

        $this->form = $this->createForm($partnership);

        return $partnership;
    }

    /**
     * @param Partnership $partnership
     * @return FormInterface
     */
    public function createForm(Partnership $partnership)
    {
        return $this->partnershipFormHandlerStrategy->createForm($partnership);
    }

    /**
     * @param FormInterface $form
     * @param Partnership $partnership
     * @param Request $request
     * @return bool
     */
    public function handleForm(FormInterface $form, Partnership $partnership, Request $request)
    {
        if (
            (null === $partnership->getId() && $request->isMethod('POST'))
            || (null !== $partnership->getId() && $request->isMethod('PUT'))
        ) {

            $form->handleRequest($request);

            if (!$form->isValid()) {
                return false;
            }

            $this->message = $this->partnershipFormHandlerStrategy->handleForm($request, $partnership);

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
        return $this->partnershipFormHandlerStrategy->createView();
    }
}
