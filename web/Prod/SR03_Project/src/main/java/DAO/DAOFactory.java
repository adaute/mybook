package DAO;

import java.io.IOException;
import java.io.InputStream;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.Properties;

/**
 * méthode permettant la gestion des DAO avec le template factory
 */
public class DAOFactory {
    private static final String FICHIER_PROPERTIES = "/DAO/dao.properties";
    private static final String PROPERTY_URL = "url";
    private static final String PROPERTY_DRIVER = "driver";
    private static final String PROPERTY_NOM_UTILISATEUR = "login";
    private static final String PROPERTY_MOT_DE_PASSE = "mdp";

    private String url;
    private String username;
    private String password;

    /* Création d'un objet DAOFactory (méthode private) */
    DAOFactory(String url, String username, String password) {
        this.url = url;
        this.username = username;
        this.password = password;
    }

    /**
     * Méthode chargée de récupérer les informations de connexion à la base de
     * données, charger le driver JDBC et retourner une instance de la Factory
     */
    public static DAOFactory getInstance() throws DAOConfigurationException {

        Properties properties = new Properties();
        String url;
        String driver;
        String nomUtilisateur;
        String motDePasse;

        ClassLoader classLoader = Thread.currentThread().getContextClassLoader();
        InputStream fichierProperties = classLoader.getResourceAsStream(FICHIER_PROPERTIES);

        if (fichierProperties == null) {
            throw new DAOConfigurationException("Le fichier properties " + FICHIER_PROPERTIES + " est introuvable.");
        }

        try {
            properties.load(fichierProperties);
            url = properties.getProperty(PROPERTY_URL);
            driver = properties.getProperty(PROPERTY_DRIVER);
            nomUtilisateur = properties.getProperty(PROPERTY_NOM_UTILISATEUR);
            motDePasse = properties.getProperty(PROPERTY_MOT_DE_PASSE);
        } catch (IOException e) {
            throw new DAOConfigurationException("Impossible de charger le fichier properties " + FICHIER_PROPERTIES, e);
        }

        try {
            Class.forName(driver);
        } catch (ClassNotFoundException e) {
            throw new DAOConfigurationException("Le driver est introuvable dans le classpath.", e);
        }

        DAOFactory instance = new DAOFactory(url, nomUtilisateur, motDePasse);
        return instance;
    }

    /**
     * Méthode chargée de fournir une connexion à la base de données
     */
    public Connection getConnection() throws SQLException {
        return DriverManager.getConnection(url, username, password);
    }

    /* Méthodes de récupération de l'implémentation des différents dao */
    public UserDAO getUserDao() {
        return new UserDAO();
    }

    public SurveyDAO getSurveyDao() {
        return new SurveyDAO();
    }

    public SubjectDAO getSubjectDao() {
        return new SubjectDAO();
    }

    public QuestionDAO getQuestionDao() {
        return new QuestionDAO();
    }

    public AnswerDAO getAnswerDao() {
        return new AnswerDAO();
    }

    public TrackRecordDAO getTrackRecordDao() {
        return new TrackRecordDAO();
    }

    public UserChoiceDAO getChoiceDao() {
        return new UserChoiceDAO();
    }
}
