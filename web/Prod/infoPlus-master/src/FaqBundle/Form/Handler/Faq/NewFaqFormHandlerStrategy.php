<?php
namespace FaqBundle\Form\Handler\Faq;

use FaqBundle\Form\Type\Faq\FaqType;
use Symfony\Component\HttpFoundation\Request;
use FaqBundle\Entity\Faq;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NewFaqFormHandlerStrategy extends AbstractFaqFormHandlerStrategy
{
    /**
     * @var TokenStorageInterface
     */
    protected $securityTokenStorage;

    /**
     * Constructor.
     *
     * @param TokenStorageInterface $securityTokenStorage
     */
    public function __construct(TokenStorageInterface $securityTokenStorage)
    {
        $this->securityTokenStorage = $securityTokenStorage;
    }

    /**
     * @param Faq $faq
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Faq $faq)
    {
        $this->form = $this->formFactory->create(FaqType::class, $faq, array(
            'action' => $this->router->generate('faq_new'),
            'method' => 'POST',
        ));

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Faq $faq
     * @return string
     */
    public function handleForm(Request $request, Faq $faq)
    {
        $this->faqManager->save($faq, true, true);
        return $this->translator
            ->trans('succes', array(),'divers');
    }


}
