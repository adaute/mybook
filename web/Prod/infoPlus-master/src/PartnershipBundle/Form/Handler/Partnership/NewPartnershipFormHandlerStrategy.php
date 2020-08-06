<?php
namespace PartnershipBundle\Form\Handler\Partnership;

use PartnershipBundle\Form\Type\PartnershipType;

use Symfony\Component\HttpFoundation\Request;
use PartnershipBundle\Entity\Partnership;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NewPartnershipFormHandlerStrategy extends AbstractPartnershipFormHandlerStrategy
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
     * @param Partnership $partnership
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Partnership $partnership)
    {
        $this->form = $this->formFactory->create(PartnershipType::class, $partnership, array(
            'action' => $this->router->generate('partnership_new'),
            'method' => 'POST',
            'image' => null,
        ));

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Partnership $partnership
     * @return string
     */
    public function handleForm(Request $request, Partnership $partnership)
    {
        $partnership->setEnabled(1);
        $this->partnershipManager->save($partnership, true, true);

        return $this->translator
            ->trans('success', array(),'divers');
    }


}
