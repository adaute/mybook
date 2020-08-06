package Bean;

import DAO.DAOFactory;
import DAO.TrackRecordDAO;
import DAO.UserChoiceDAO;
import Entity.TrackRecord;
import Entity.UserChoice;

import javax.annotation.PostConstruct;
import javax.enterprise.context.SessionScoped;
import javax.inject.Named;
import java.io.Serializable;
import java.util.List;

/**
 * Cette classe permet la gestion des résultats des utilisateurs aux questionnaires
 */
@Named
@SessionScoped
public class ResultBean implements Serializable {

    private static final long serialVersionUID = 1L;

    /* Liens de redirection */
    private static final String SHOW_RESULT = "/admin/ShowResultat.xhtml?faces-redirect=true";


    /* définition des attributs */
    private List<TrackRecord> liste_parcours = null;
    private List<UserChoice> liste_reponses = null;

    private TrackRecordDAO trackRecordDAO;
    private UserChoiceDAO userChoicedao;

    private TrackRecord trackRecord;

    private long idUser;

    @PostConstruct
    /**
     *  Méthode d'initialisation du BeanManager avec l'annotation :  @PostConstruct
     */
    public void init() {
        trackRecordDAO = DAOFactory.getInstance().getTrackRecordDao();
        userChoicedao = DAOFactory.getInstance().getChoiceDao();
    }

    /**
     * Méthode permettant d'afficher les différents résultats des parcours associés à un utilisateur userID avec redirection sur la page en adéquation
     */
    public String showStagiaireResultat(long userID) {
        idUser = userID;
        liste_parcours = trackRecordDAO.findAllByUserID(userID);
        return SHOW_RESULT;
    }

    // Getters

    /**
     * Méthode permettant d'obtenir la liste des parcours
     */
    public List<TrackRecord> getListe_parcours() {
        return liste_parcours;
    }

    /**
     * Méthode permettant d'obtenir la liste des réponses associé à un parcour par un utilisateur
     */
    public List<UserChoice> getListe_reponses() {
        return liste_reponses;
    }

    /**
     * Méthode permettant d'obtenir l'ID de l'utilisateur concerné
     */
    public long getIdUser() {
        return idUser;
    }

    //setters
}
