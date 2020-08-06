<?php
namespace DiaryBundle\Form\Handler\Diary;

use DiaryBundle\Form\Type\DiaryType;

use Symfony\Component\HttpFoundation\Request;
use DiaryBundle\Entity\Diary;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class NewDiaryFormHandlerStrategy extends AbstractDiaryFormHandlerStrategy
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
     * @param Diary $diary
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    public function createForm(Diary $diary)
    {
        $this->form = $this->formFactory->create(DiaryType::class, $diary, array(
            'action' => $this->router->generate('diary_new'),
            'method' => 'POST',
            'image' => null,
        ));

        return $this->form;
    }

    /**
     * @param Request $request
     * @param Diary $diary
     * @return string
     */
    public function handleForm(Request $request, Diary $diary)
    {
        $diary->getProduct()->setAuthor($this->securityTokenStorage->getToken()->getUser());
        $diary->getProduct()->setEnabled(1);
        $diary->setEnabled(1);
        $this->diaryManager->save($diary, true, true);

        return $this->translator
            ->trans('success', array(),'divers');
    }


}
