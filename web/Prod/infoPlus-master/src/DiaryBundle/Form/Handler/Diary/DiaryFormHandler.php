<?php
namespace DiaryBundle\Form\Handler\Diary;

use DiaryBundle\Entity\Manager\Interfaces\DiaryManagerInterface;
use DiaryBundle\Form\Handler\Diary\Interfaces\DiaryFormHandlerStrategy;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use DiaryBundle\Entity\Diary;

class DiaryFormHandler
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
     * @var DiaryFormHandlerStrategy $diaryFormHandlerStrategy
     */
    private $diaryFormHandlerStrategy;

    /**
     * @var DiaryFormHandlerStrategy $newActorFormHandlerStrategy
     */
    protected $newDiaryFormHandlerStrategy;

    /**
     * @var DiaryFormHandlerStrategy $updateActorFormHandlerStrategy
     */
    protected $updateDiaryFormHandlerStrategy;

    /**
     * @var DiaryManagerInterface $diaryManager
     */
    protected $diaryManager;

    /**
     * @param DiaryFormHandlerStrategy $nafhs
     */
    public function setNewDiaryFormHandlerStrategy(DiaryFormHandlerStrategy $nafhs) {
        $this->newDiaryFormHandlerStrategy = $nafhs;
    }

    /**
     * @param DiaryFormHandlerStrategy $uafhs
     */
    public function setUpdateDiaryFormHandlerStrategy(DiaryFormHandlerStrategy $uafhs) {
        $this->updateDiaryFormHandlerStrategy = $uafhs;
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param Diary|null $diary
     * @return Diary
     */
    public function processForm(Diary $diary = null)
    {
        if (is_null($diary)) {
            $diary = new Diary();
            $this->diaryFormHandlerStrategy = $this->newDiaryFormHandlerStrategy;
        } else {
            $this->diaryFormHandlerStrategy = $this->updateDiaryFormHandlerStrategy;
        }

        $this->form = $this->createForm($diary);

        return $diary;
    }

    /**
     * @param Diary $diary
     * @return FormInterface
     */
    public function createForm(Diary $diary)
    {
        return $this->diaryFormHandlerStrategy->createForm($diary);
    }

    /**
     * @param FormInterface $form
     * @param Diary $diary
     * @param Request $request
     * @return bool
     */
    public function handleForm(FormInterface $form, Diary $diary, Request $request)
    {
        if (
            (null === $diary->getId() && $request->isMethod('POST'))
            || (null !== $diary->getId() && $request->isMethod('PUT'))
        ) {

            $form->handleRequest($request);

            if (!$form->isValid()) {
                return false;
            }

            $this->message = $this->diaryFormHandlerStrategy->handleForm($request, $diary);

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
        return $this->diaryFormHandlerStrategy->createView();
    }
}
