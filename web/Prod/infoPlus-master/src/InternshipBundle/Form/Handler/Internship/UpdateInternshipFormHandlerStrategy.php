<?php
namespace InternshipBundle\Form\Handler\Internship;

use InternshipBundle\Form\Type\InternshipType;
use InternshipBundle\Entity\Internship;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UpdateInternshipFormHandlerStrategy extends AbstractInternshipFormHandlerStrategy
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
     * @param Internship $internship
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Internship $internship)
    {
        $this->form = $this->formFactory->create(
            InternshipType::class,
            $internship,
            [
                'action' => $this->router->generate('internship_edit', ['id' => $internship->getId()]),
                'method' => 'PUT',
            ]
        );

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Internship $internship
     * @return string
     */
    public function handleForm(Request $request, Internship $internship)
    {

        $this->internshipManager->save($internship, false, true);

        return $this->translator
            ->trans('success_modify', array(),'divers');
    }

    public function createHomeForm(Internship $internship){}
}
