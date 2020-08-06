package Bean;

import DAO.*;
import Entity.*;
import Util.RequestManager;

import javax.annotation.PostConstruct;
import javax.enterprise.context.SessionScoped;
import javax.faces.context.FacesContext;
import javax.inject.Named;
import java.io.IOException;
import java.io.Serializable;
import java.util.ArrayList;
import java.util.Collections;
import java.util.HashMap;
import java.util.List;

/**
 * Cette classe permet la des parcours effectués par les utilisateurs
 */
@Named
@SessionScoped
public class TrackRecordBean implements Serializable {

    private static final long serialVersionUID = 1L;

    /* Liens de redirection */
    private static final String URL_QCM = "/stagiaire/qcm.xhtml?faces-redirect=true";
    private static final String URL_RESULTAT = "/stagiaire/resultat.xhtml?faces-redirect=true";

    /* définition des attributs */
    private List<Question> list_questions = null;
    private int current_index; // Curseur pour la liste des questions
    private List<TrackRecord> list_parcours = null;

    private List<TrackRecord> list_all_parcours = null;

    private long timer;
    private int score;
    private HashMap<Long, Long> choixUtilisateurs = null;

    private QuestionDAO questionDao;
    private TrackRecordDAO trackRecordDao;
    private AnswerDAO answerDAO;

    private UserChoiceDAO userChoiceDAO;
    private SurveyDAO surveyDao;

    private Survey survey;

    private TrackRecord trackRecord;

    @PostConstruct
    /**
     *  Méthode d'initialisation du BeanManager avec l'annotation :  @PostConstruct
     */
    public void init() {
        timer = 0;
        score = 0;
        current_index = 0; // Pour qu'à la première question qu'on ait 0
        choixUtilisateurs = new HashMap<Long, Long>();
        list_questions = new ArrayList<>();

        // DAO
        questionDao = DAOFactory.getInstance().getQuestionDao();
        trackRecordDao = DAOFactory.getInstance().getTrackRecordDao();
        userChoiceDAO = DAOFactory.getInstance().getChoiceDao();
        surveyDao = DAOFactory.getInstance().getSurveyDao();
        answerDAO = DAOFactory.getInstance().getAnswerDao();

        trackRecord = new TrackRecord();
        survey = new Survey();

        //récupérer la liste des parcours
        User utilisateur = (User) FacesContext.getCurrentInstance().getExternalContext().getSessionMap().get("sessionUser");
        list_parcours = trackRecordDao.findAllByUserID(utilisateur.getId());

        list_all_parcours = trackRecordDao.findAll();
    }

    /**
     * Méthode  permettant de montrer les informations associées à un parcour
     */
    public String show(long id) {
        //récupérer les informations pour les affichers
        trackRecord = trackRecordDao.find(id);
        list_questions = questionDao.findAllSurveyID(trackRecord.getSurveyID());
        return URL_RESULTAT;
    }

    /*** Enregistrement parcours **/

    /**
     * Méthode  permettant de vérifier si un utilisateur à déja effectué le parcour
     */
    public boolean isDone(long survey) {
        return trackRecordDao.findRecordWithUserID(
                survey,
                ((User) FacesContext.getCurrentInstance().getExternalContext().getSessionMap().get("sessionUser")).getId()
        );
    }

    /**
     * Méthode permettant démarer un quizz
     */
    public String launchQuizz() {
        long id = Long.parseLong((String) RequestManager.getParam("id"));

        // remplir la liste avec les questions à répondre
        list_questions = new ArrayList<>();
        list_questions.addAll(questionDao.findAllSurveyID(id));

        //hydrater l'objet parcour
        trackRecord.setSurveyID(id);
        trackRecord.setUserID(((User) FacesContext.getCurrentInstance().getExternalContext().getSessionMap().get("sessionUser")).getId());

        current_index = 0;

        return URL_QCM;
    }

    /**
     * Méthode  permettant d'enregistrer les réponses de l'utilisateur durant le parcours et d'afficher le résultat de celui-ci à la fin.
     */
    public String PlayQuizz() {

        long idReponse = Long.parseLong((String) RequestManager.getParam("idReponse")); // id de la réponse
        long idQuestion = Long.parseLong((String) RequestManager.getParam("idQuestion")); // id de la question

        choixUtilisateurs.put(idQuestion, idReponse); // enregistrer le choi de l'utilisateur dans la structure

        System.out.println("id" + idReponse + " d " + idQuestion);
        current_index++; // permet d'afficher les questions en fonction de l'index

        if (list_questions.size() != current_index) { // tant que toutes les questions ne sont pas répondu
            return URL_QCM;
        } else { // fin du parcour
            try {
                timer = Long.parseLong((String) RequestManager.getParam("input_chrono")); // récupérer le chrono
                //créer un parcours sans le score
                trackRecord.setDuration(timer); // hydrater l'objet
                trackRecord.setScore(0);

                long ParcoursID = trackRecordDao.create(trackRecord);

                // calculer le score avec les choix
                choixUtilisateurs.forEach((q, r) -> {
                    UserChoice userChoice = new UserChoice();
                    userChoice.setRecordID(ParcoursID);
                    userChoice.setQuestionID(q);
                    userChoice.setAnswerID(r);
                    userChoiceDAO.create(userChoice);
                    if (ScoreCalculate(q, r))
                        score += 1;
                });

                // maj le score
                trackRecord.setScore(score);
                trackRecordDao.update(trackRecord);

                // maj des élements pour l'affichage
                User utilisateur = (User) FacesContext.getCurrentInstance().getExternalContext().getSessionMap().get("sessionUser");
                list_parcours = trackRecordDao.findAllByUserID(utilisateur.getId());
                current_index = 0;
                FacesContext.getCurrentInstance().getExternalContext().redirect("resultat.xhtml?faces-redirect=true"); // redirection pour afficher le résultat
            } catch (IOException e) {
                e.printStackTrace();
            }
            return URL_RESULTAT;
        }
    }

    /**
     * Méthode  permettant de calculer le classement de l'utilisateur en fonction des autres utilisateurs
     */
    public String Classement(Long surveyID, int score, int duration) {
        int pos = 1;
        List<TrackRecord> parcours = trackRecordDao.findAllBySurveyId(surveyID);
        for (int i = 0; i < parcours.size(); i++) {
            if (parcours.get(i).getScore() > score)
                pos++;
            else {
                if (parcours.get(i).getScore() == score && parcours.get(i).getDuration() < duration)
                    pos++;
            }
        }
        return pos + "/" + parcours.size();
    }

    /**
     * Méthode  permettant de calculer la note maximun obtenus à un qcm
     */
    public int calculMax(long surveyID) {
        int max = 0;
        List<TrackRecord> tracks = trackRecordDao.findAllBySurveyId(surveyID);

        if (tracks.size() == 0) max = -1; // pour cas aucun parcour

        for (int i = 0; i < tracks.size(); i++) {
            if (tracks.get(i).getScore() > max)
                max = tracks.get(i).getScore();
        }

        return max;
    }

    /**
     * Méthode  permettant de calculer max et temps
     */
    public String calculMaxTemp(long surveyID) {
        TrackRecord trackSave = null;
        List<TrackRecord> tracks = trackRecordDao.findAllBySurveyId(surveyID);
        List<Question> questions = questionDao.findAllSurveyID(surveyID);

        for (TrackRecord track : tracks) {
            if (trackSave == null || track.getScore() > trackSave.getScore())
                trackSave = track;
        }

        double pourcentage = (trackSave.getScore() / questions.size()) * 100;

        return pourcentage + "% en " + trackSave.getDuration() + " seconde(s)";
    }

    /**
     * Méthode  permettant de savoir si la reponse de l'utilisateur était la réponse attendue
     */
    public boolean ScoreCalculate(long questionID, long reponseID) {
        return questionDao.find(questionID).getAnswerId() == reponseID;
    }

    /**
     * Méthode  permettant de retourner la réponse de l'utilisateur d'une question avec son id => idQuestion
     */
    public String userReponse(long idQuestion) {
        return answerDAO.find(userChoiceDAO.findAllByRecordQuest(trackRecord.getId(), idQuestion).getAnswerID()).getLabel();
    }

    // Getters
    public List<Question> getList_questions() {
        return list_questions;
    }

    /**
     * Méthode  permettant d'inverser l'ordre d'apparition des questions
     */
    public List<Question> list_question_reverse() {
        List<Question> q = getList_questions();
        Collections.reverse(q);
        return q;
    }

    /**
     * Méthode  permettant d'afficher la liste des parcours d'un utilisateur
     */
    public List<TrackRecord> getList_parcoursView() {
        User utilisateur = (User) FacesContext.getCurrentInstance().getExternalContext().getSessionMap().get("sessionUser");
        return trackRecordDao.findAllByUserID(utilisateur.getId());
    }

    /**
     * Méthode  permettant  de donner le nombre de parcours en fonction d'un questionnaire
     */
    public int GetparcoursNbr(int idSurvey) {
        List<TrackRecord> listeParcours = trackRecordDao.findAllBySurveyId(idSurvey);
        if (listeParcours != null)
            return trackRecordDao.findAllBySurveyId(idSurvey).size();
        else
            return 0;
    }

    // Getters
    public List<TrackRecord> getList_parcours() {
        return list_parcours;
    }

    public List<TrackRecord> getList_all_parcours() {
        list_all_parcours = trackRecordDao.findAll();
        return list_all_parcours;
    }

    public HashMap<Long, Long> getChoixUtilisateurs() {
        return choixUtilisateurs;
    }

    public TrackRecord getTrackRecord() {
        return trackRecord;
    }

    public int getCurrent_index() {
        return current_index;
    }

    /**
     * Méthode  permettant de changer l'apparence du bouton lors du qcm pour l'affichage du résultat
     */
    public String afficher_boutton() {
        if (current_index + 1 == list_questions.size()) {
            return "Valider";
        } else {
            return "Question suivante";
        }
    }
}
