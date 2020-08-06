<?php
namespace FaqBundle\Form\Handler\Faq;

use FaqBundle\Entity\Manager\Interfaces\FaqManagerInterface;
use CoreBundle\Services\ManagerService;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use FaqBundle\Entity\Faq;
use FaqBundle\Form\Handler\Faq\Interfaces\FaqFormHandlerStrategy;


class FaqFormHandler
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
     * @var ManagerService $managerService
     */
    private $managerService;

    /**
     * @var FaqFormHandlerStrategy $faqFormHandlerStrategy
     */
    private $faqFormHandlerStrategy;

    /**
     * @var FaqFormHandlerStrategy $newFaqFormHandlerStrategy
     */
    protected $newFaqFormHandlerStrategy;

    /**
     * @var FaqFormHandlerStrategy $updateFaqFormHandlerStrategy
     */
    protected $updateFaqFormHandlerStrategy;

    /**
     * @var FaqManagerInterface $faqManager
     */
    protected $faqManager;

    /**
     * @param FaqFormHandlerStrategy $nafhs
     */
    public function setNewFaqFormHandlerStrategy(FaqFormHandlerStrategy $nafhs) {
        $this->newFaqFormHandlerStrategy = $nafhs;
    }

    /**
     * @param FaqFormHandlerStrategy $uafhs
     */
    public function setUpdateFaqFormHandlerStrategy(FaqFormHandlerStrategy $uafhs) {
        $this->updateFaqFormHandlerStrategy = $uafhs;
    }

    /**
     * @param ManagerService $managerService
     */
    public function setManagerService(ManagerService $managerService)
    {
        $this->managerService = $managerService;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param Faq|null $faq
     * @return Faq
     */
    public function processForm(Faq $faq = null)
    {
        if (is_null($faq)) {
            $faq = new Faq();
            $this->faqFormHandlerStrategy = $this->newFaqFormHandlerStrategy;
        } else {
            $this->faqFormHandlerStrategy = $this->updateFaqFormHandlerStrategy;
        }

        $this->form = $this->createForm($faq);

        return $faq;
    }

    /**
     * @param Faq $faq
     * @return FormInterface
     */
    public function createForm(Faq $faq)
    {
        return $this->faqFormHandlerStrategy->createForm($faq);
    }

    /**
     * @param FormInterface $form
     * @param Faq $faq
     * @param Request $request
     * @return bool
     */
    public function handleForm(FormInterface $form, Faq $faq, Request $request)
    {
        if (
            (null === $faq->getId() && $request->isMethod('POST'))
            || (null !== $faq->getId() && $request->isMethod('PUT'))
        ) {

            $form->handleRequest($request);

            if (!$form->isValid()) {
                return false;
            }

            $this->message = $this->faqFormHandlerStrategy->handleForm($request, $faq);

            return true;
        }
    }

    /**
     * @param FormInterface $form
     * @param Request $request
     * @throws \Exception
     */
    public function handleSearchForm(FormInterface $form, Request $request)
    {
        $attributes = $request->attributes->all();

        foreach ($attributes as $key => $val) {
            if (!empty($val)) {
                // category
                if (in_array($key, Faq::getObjectFields())) {
                    $objectManager = $this->managerService->getManagerClass($key . 'Manager');
                    $object = $objectManager->find($val);
                    $form->get($key)->setData($object);
                    continue;
                }
            }
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
        return $this->faqFormHandlerStrategy->createView();
    }
}
