<?php
namespace FaqBundle\Form\Handler\Faq;

use FaqBundle\Form\Type\Faq\FaqType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use FaqBundle\Entity\Faq;

class UpdateFaqFormHandlerStrategy extends AbstractFaqFormHandlerStrategy
{

    /**
     * @var AuthorizationCheckerInterface
     */
    protected $authorizationChecker;

    /**

     * Constructor.
     *
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct
    (
        AuthorizationCheckerInterface $authorizationChecker
    )
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param Faq $faq
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Faq $faq)
    {
        // we put image in the FaqType constructor to fill value when the form is loaded
        $this->form = $this->formFactory->create(
            FaqType::class,
            $faq,
            [
                'action' => $this->router->generate('faq_edit', ['id' => $faq->getId()]),
                'method' => 'PUT',
            ]
        );

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Faq $faq
     * @return string
     */
    public function handleForm(Request $request, Faq $faq)
    {
        $this->faqManager->save($faq, false, true);

        return $this->translator
            ->trans('success_modify', array(),'divers');
    }
}
