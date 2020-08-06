<?php
namespace DiaryBundle\Form\Handler\Diary;

use DiaryBundle\Form\Type\DiaryType;
use DiaryBundle\Entity\Diary;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UpdateDiaryFormHandlerStrategy extends AbstractDiaryFormHandlerStrategy
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
     * @param Diary $diary
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Diary $diary)
    {
        // we put image in the DiaryType constructor to fill value when the form is loaded
        $this->form = $this->formFactory->create(
            DiaryType::class,
            $diary,
            [
                'action' => $this->router->generate('diary_edit', ['id' => $diary->getId()]),
                'method' => 'PUT',
                'image' => $diary->getImage(),
            ]
        );

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Diary $diary
     * @return string
     */
    public function handleForm(Request $request, Diary $diary)
    {

        $this->diaryManager->save($diary, false, true);

        return $this->translator
            ->trans('success_modify', array(),'divers');
    }
}
