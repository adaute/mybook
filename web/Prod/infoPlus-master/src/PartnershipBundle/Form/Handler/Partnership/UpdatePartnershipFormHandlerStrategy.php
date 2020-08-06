<?php
namespace PartnershipBundle\Form\Handler\Partnership;

use PartnershipBundle\Form\Type\PartnershipType;
use PartnershipBundle\Entity\Partnership;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UpdatePartnershipFormHandlerStrategy extends AbstractPartnershipFormHandlerStrategy
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
     * @param Partnership $partnership
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Partnership $partnership)
    {
        // we put image in the PartnershipType constructor to fill value when the form is loaded
        $this->form = $this->formFactory->create(
            PartnershipType::class,
            $partnership,
            [
                'action' => $this->router->generate('partnership_edit', ['id' => $partnership->getId()]),
                'method' => 'PUT',
                'image' => $partnership->getImage()
            ]
        );

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Partnership $partnership
     * @return string
     */
    public function handleForm(Request $request, Partnership $partnership)
    {

        $this->partnershipManager->save($partnership, false, true);

        return $this->translator
            ->trans('success_modify', array(),'divers');
    }
}
