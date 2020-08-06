<?php
namespace InternshipBundle\Form\Handler\Internship;

use InternshipBundle\Form\Type\InternshipType;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use InternshipBundle\Entity\Internship;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NewInternshipFormHandlerStrategy extends AbstractInternshipFormHandlerStrategy
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
     * @param Internship $internship
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createHomeForm(Internship $internship)
    {

        $this->form = $this->formFactory->create(InternshipType::class, $internship, array(
            'action' => $this->router->generate('internship'),
            'method' => 'POST',
        ));

        return $this->form;
    }

    /**
     * @param Internship $internship
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Internship $internship)
    {

        $this->form = $this->formFactory->create(InternshipType::class, $internship, array(
            'action' => $this->router->generate('internship_new'),
            'method' => 'POST',
        ));

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Internship $internship
     * @return string
     */
    public function handleForm(Request $request, Internship $internship)
    {
        $internship->setEnabled(0);
        $this->internshipManager->save($internship, true, true);

        return $this->translator
            ->trans('success', array(),'divers');
    }


}
