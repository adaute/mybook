package Bean;

import DAO.*;
import Entity.*;
import Util.RequestManager;
import net.bootsfaces.utils.FacesMessages;
import org.primefaces.PrimeFaces;

import javax.annotation.PostConstruct;
import javax.enterprise.context.SessionScoped;
import javax.inject.Named;
import java.io.Serializable;
import java.util.*;
import java.util.concurrent.atomic.AtomicInteger;

/**
 * Cette classe permet la gestion des questionnaires : questions/réponses et thémes.
 */
@Named
@SessionScoped
public class SurveyBean implements Serializable {

    private static final long serialVersionUID = 1L;

    /*sessions*/
    private static final String URL_QUIZZ = "/admin/crudQuizz.xhtml?faces-redirect=true";
    private static final String SHOW_SURVEY = "/admin/showQuizz.xhtml?faces-redirect=true";
    private static final String CRUD_SURVEY = "/admin/addQuizz.xhtml?faces-redirect=true";
    /* Liens de redirection */
    private final String SUCCESS = "/sr03/admin/crudSurvey.xhtml";

    /* définition des attributs */
    private List<Survey> list_surveyEnabled = null;
    private List<Survey> list_surveyDisabled = null;

    private List<Survey> list_survey = null;
    private List<Subject> list_subject = null;
    private List<Question> list_questions = null;

    //attribut pour ajouter/modifier un questionnaire
    private Map<Question, List<Answer>> mapQuestAnswers;
    private Map<String, Long> mapSubject;

    private SurveyDAO surveyDao;
    private SubjectDAO subjectDao;
    private QuestionDAO questionDao;
    private AnswerDAO answerDao;

    private Survey survey;
    private Subject subject;

    @PostConstruct
    /**
     *  Méthode d'initialisation du BeanManager avec l'annotation :  @PostConstruct
     */
    public void init() {

        // DAO
        surveyDao = DAOFactory.getInstance().getSurveyDao();
        subjectDao = DAOFactory.getInstance().getSubjectDao();
        questionDao = DAOFactory.getInstance().getQuestionDao();
        answerDao = DAOFactory.getInstance().getAnswerDao();

        /* remplir les listes */
        list_surveyEnabled = surveyDao.findAllStatus(1);
        list_surveyDisabled = surveyDao.findAllStatus(0);
        list_questions = new ArrayList<>();
        list_subject = subjectDao.findAll();

        mapQuestAnswers = new LinkedHashMap<>();
        mapSubject = new TreeMap<>(); // plus rapide pour la recherche

        survey = new Survey();
        subject = new Subject();

        addOrUpdate(-1); // init
    }

    //Permet d'update et de créer un quizz

    /**
     * Méthode permettant de créer ou de modifier un questionnaire
     */
    public String createUpdateQuiz() {

        long QuestionnaireID;

        if (survey.getId() == null) {
            survey.setActive(true);
            QuestionnaireID = surveyDao.create(survey);
            FacesMessages.info("form:send", "Info", "Questionnaire créé");
        } else {
            QuestionnaireID = survey.getId();
            surveyDao.update(survey);
            FacesMessages.info("form:send", "Info", "Questionnaire maj");

            // supprimer les parcours
            TrackRecordDAO trackRecordDAO = DAOFactory.getInstance().getTrackRecordDao();
            UserChoiceDAO userChoiceDAO = DAOFactory.getInstance().getChoiceDao();

            List<TrackRecord> list_parcours = trackRecordDAO.findAllBySurveyId(survey.getId());

            // delete parcours/choix
            if (list_parcours != null) {
                list_parcours.forEach((record) -> {
                    userChoiceDAO.delete(record.getId());
                    trackRecordDAO.delete(record.getId());
                });
            }
        }

        // pour toutes les questions du questionnaire
        list_questions.forEach(question -> {

            long idQuestion;

            question.setSurveyID(QuestionnaireID);
            question.setOrder((long) list_questions.indexOf(question) + 1);
            question.setIsactive(true);

            if (question.getId() == 0) // cas création
                idQuestion = questionDao.create(question);
            else { // cas update
                idQuestion = question.getId();
                questionDao.update(question);
            }


            AtomicInteger cpt = new AtomicInteger(0);

            // pour toutes les réponses de la question associée
            mapQuestAnswers.get(question).forEach(answer -> {

                answer.setOrder((long) mapQuestAnswers.get(question).indexOf(answer) + 1);
                answer.setIdQuestion(idQuestion);
                answer.setIsactive(true);

                if (answer.getId() == null) { // cas create
                    long IdReponse = answerDao.create(answer);
                    if (question.getAnswerId() == cpt.get())
                        question.setAnswerId(IdReponse);
                } else { // cas update
                    answerDao.update(answer);
                    if (question.getAnswerId() == cpt.get())
                        question.setAnswerId(answer.getId());
                }

                questionDao.update(question);
                cpt.getAndIncrement();
            });
        });

        majListe(); //maj des listes pour l'affichage
        addOrUpdate(-1);

        return URL_QUIZZ;
    }

    /**
     * Méthode pour activer ou desactiver un questionnaire : si pas de parcours présent sinon méthode désactivé
     */
    public String changeStatusSurvey() {
        long id = Long.parseLong((String) RequestManager.getParam("id"));
        Survey survey = surveyDao.find(id);
        survey.setActive(!survey.getActive());
        surveyDao.update(survey);
        majListe();
        return URL_QUIZZ;
    }

    /**
     * Méthode permettant de supprimer un questionnaire
     */
    public String deleteSurvey(long id) {

        TrackRecordDAO trackRecordDAO = DAOFactory.getInstance().getTrackRecordDao();
        UserChoiceDAO userChoiceDAO = DAOFactory.getInstance().getChoiceDao();

        List<TrackRecord> list_parcours = trackRecordDAO.findAllBySurveyId(id);

        // delete parcours/choix
        if (list_parcours != null) {
            list_parcours.forEach((record) -> {
                userChoiceDAO.delete(record.getId());
                trackRecordDAO.delete(record.getId());
            });
        }

        // delete questions/réponses
        List<Question> list_question = questionDao.findAllSurveyID(id);
        if (list_question != null) {

            list_question.forEach((question) -> {

                // delete reponses
                List<Answer> list_answer = answerDao.findAllQuestionID(question.getId());

                if (list_answer != null) {
                    list_answer.forEach((answer) -> {
                        answerDao.delete(answer.getId());
                    });
                }

                // suppresion des questions
                questionDao.delete(question.getId());
            });
        }

        // du questionnaire
        surveyDao.delete(id);

        majListe(); // maj des listes

        return URL_QUIZZ;
    }

    /**
     * Méthode permettant d'afficher un questionnaire et ses questions/réponses
     */
    public String show(long id) {
        //récupérer les informations pour les affichers
        survey = surveyDao.find(id);
        list_questions = questionDao.findAllSurveyID(id);
        return SHOW_SURVEY;
    }

    /**
     * Méthode permettant d'afficher un questionnaire et ses questions/réponses pour pouvoir l'éditer ou en créer un nouveau
     */
    public String addOrUpdate(long id) {
        list_subject.forEach(subject -> {
            mapSubject.put(subject.getSubject(), subject.getId());
        });

        if (id > 0) {
            survey = surveyDao.find(id);
            list_questions = questionDao.findAllSurveyID(id);
            list_questions.forEach(question -> {
                mapQuestAnswers.put(question, answerDao.findAllQuestionID(question.getId()));
            });
        } else {
            survey = new Survey();
            list_questions = new ArrayList<>(); // reset la structure
            addQuestion(); // ajouter une question avec 2 réponse au minimun
        }
        return CRUD_SURVEY;
    }

    /**
     * Méthode pour ajouter une réponse sur l'interface graphique
     */
    public void addAnswer(Question question) {
        mapQuestAnswers.get(question).add(new Answer());
    }

    /**
     * Méthode pour supprimer une réponse sur l'interface graphique
     */
    public void removeAnswer(Question question, Answer answer) {
        mapQuestAnswers.get(question).remove(answer);
    }

    /**
     * Méthode pour déplacer une réponse sur l'interface graphique
     */
    public void MoveAnswer(Question question, Answer answer, String action) {
        int number = action.equals("up") ? -1 : 1;
        int position = mapQuestAnswers.get(question).indexOf(answer);
        Collections.swap(mapQuestAnswers.get(question), position, position + number);
    }

    /**
     * Méthode pour ajouter une question sur l'interface graphique
     */
    public void addQuestion() {
        Question question = new Question();

        mapQuestAnswers.put(question, new ArrayList<>()); //initialiser la structure

        for (int i = 0; i < 2; ++i) //ajouter deux nouvelles questions vides
            mapQuestAnswers.get(question).add(new Answer());

        list_questions.add(question); // ajouter la question et ses réponses dans la liste des questionnaires
    }

    /**
     * Méthode pour déplacer une question sur l'interface graphique
     */
    public void MoveQuestion(Question question, String action) {
        int number = action.equals("up") ? -1 : 1;
        int position = list_questions.indexOf(question);
        Collections.swap(list_questions, position, position + number); //changer la position dans la structure
    }

    /**
     * Méthode pour supprimer une question sur l'interface graphique
     */
    public void removeQuestion(Question question) {
        mapQuestAnswers.remove(question);
        list_questions.remove(question);
    }

    /**
     * Méthode pour un théme
     */
    public void addSubject() {
        Long id = subjectDao.create(subject);
        if (id > 0) { // si le sujet n'est pas présent dans la bdd
            subject = subjectDao.find(id);
            mapSubject.put(subject.getSubject(), subject.getId());
            subject = new Subject();
        }
        list_subject = subjectDao.findAll(); // maj liste
        PrimeFaces.current().executeScript("$('.modalTheme').modal('hide');");//cacher le modal
    }

    /**
     * Méthode pour associer le numéro de réponse sur l'interface et son id en base de donnée
     */
    public int idToPosNumber(Question question) {
        final int[] cpt = {1};

        mapQuestAnswers.get(question).forEach(answer -> {
            if (answer.getId() != question.getAnswerId())
                cpt[0]++;
        });

        return cpt[0];
    }

    /**
     * Méthode pour connaitre le nombre de questions d'un questionnaire
     */
    public int nbrQuestion(long idSurvey) {
        return questionDao.findAllSurveyID(idSurvey).size();
    }

    // maj les listes

    /**
     * Méthode pour mettre à jour les listes à afficher sur la vue
     */
    private void majListe() {
        list_surveyEnabled = surveyDao.findAllStatus(1);
        list_surveyDisabled = surveyDao.findAllStatus(0);
    }

    /**
     * Méthode permettant d'obtenir le titre d'un questionnaire
     */
    public String surveyToString(Long id) {
        return surveyDao.find(id).getTitle();
    }

    /**
     * Méthode permettant d'obtenir une question avec son id
     */
    public Question questionById(Long id) {
        return questionDao.find(id);
    }

    /**
     * Méthode permettant d'obtenir une réponse avec son id
     */
    public Answer answerById(Long id) {
        return answerDao.find(id);
    }

    /**
     * Méthode permettant d'obtenir le théme d'un questionnaire en string
     */
    public String surveyToThemeString(Long id) {
        return subjectToString(surveyDao.find(id).getSubject());
    }

    public String subjectToString(Long id) {
        return subjectDao.find(id).getSubject();
    }

    /**
     * Méthode permettant d'obtenir le string d'une réponse avec son id
     */
    public String answerToString(long id) {
        return answerDao.find(id).getLabel();
    }

    /**
     * Méthode permettant d'obtenir la postion d'une réponse
     */
    public long answerToPos(long id) {
        if (answerDao.find(id) != null) {
            return answerDao.find(id).getOrder();
        }
        return -1;
    }

    //Getter

    /**
     * Méthode permettant d'obtenir la liste des réponses d'une question
     *
     * @param questionID : id de la question
     * @return liste de réponse
     */
    public List<Answer> getAnswer(Long questionID) {
        return answerDao.findAllQuestionID(questionID);
    }

    /**
     * Méthode permettant d'accéder aux réponses d'une question
     *
     * @param question objet Question
     * @ liste Answer
     */
    public List<Answer> getAnswerUpdateCreate(Question question) {
        return mapQuestAnswers.get(question);
    }

    /**
     * Accesseur à list_surveyEnabled
     *
     * @return List<Survey>
     */
    public List<Survey> getList_surveyEnabled() {
        return list_surveyEnabled;
    }

    /**
     * Accesseur à list_surveyDisabled
     *
     * @return List<Survey>
     */
    public List<Survey> getList_surveyDisabled() {
        return list_surveyDisabled;
    }

    /**
     * Accesseur à list_survey
     *
     * @return List<Survey>
     */
    public List<Survey> getList_survey() {
        return list_survey;
    }

    /**
     * Accesseur à list_subject
     *
     * @return List<Subject>
     */
    public List<Subject> getList_subject() {
        return list_subject;
    }

    /**
     * Accesseur à list_questions
     *
     * @return List<Question>
     */
    public List<Question> getList_questions() {
        return list_questions;
    }

    /**
     * Setter list_question
     *
     * @param list_questions List<Question>
     */
    public void setList_questions(List<Question> list_questions) {
        this.list_questions = list_questions;
    }

    /**
     * Accesseur à mapSubject
     *
     * @return Map<String, Long>
     */
    public Map<String, Long> getMapSubject() {
        return mapSubject;
    }

    /**
     * Accesseur à survey
     *
     * @return Survey
     */
    public Survey getSurvey() {
        return survey;
    }

    /**
     * Accesseur à subject
     *
     * @return Subject
     */
    public Subject getSubject() {
        return subject;
    }

}
