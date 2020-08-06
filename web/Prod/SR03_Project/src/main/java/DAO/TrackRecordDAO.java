package DAO;

import Entity.TrackRecord;
import com.mysql.jdbc.Connection;
import com.mysql.jdbc.PreparedStatement;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import static DAO.DAOUtilitaire.getRequetePreparee;

/**
 * Cette classe permet la gestion des informations en base de données des questions des parcours
 */
public class TrackRecordDAO extends DAO<TrackRecord> {

    /* différentes requêtes possibles */
    private static final String SQL_SELECT_ID = "SELECT * FROM trackrecord WHERE id = ?";
    private static final String SQL_ADD = "INSERT INTO trackrecord (score, delay, userid, surveyid) VALUES (?, ?, ?, ?)";
    private static final String SQL_UPDATE = "UPDATE trackrecord SET score=? WHERE id = ?";
    private static final String SQL_SELECT_ALL_USER = "SELECT * FROM trackrecord WHERE userid = ?";
    private static final String SQL_SELECT_ALL = "SELECT * FROM trackrecord";
    private static final String SQL_DELETE = "DELETE FROM trackrecord WHERE id = ?";
    private static final String SQL_SELECT_ALL_USER_PARCOURID = "SELECT * FROM trackrecord WHERE userid = ? AND surveyid = ?";
    private static final String SQL_SELECT_ALL_BY_SURVEYID = "SELECT * FROM trackrecord WHERE surveyid = ?";

    /**
     * Simple méthode utilitaire permettant de faire la correspondance (le
     * mapping) entre une ligne issue de la table des utilisateurs (un
     * ResultSet) et un bean Utilisateur.
     */
    private static TrackRecord map(ResultSet resultSet) throws SQLException {
        TrackRecord trackRecord = new TrackRecord();
        trackRecord.setId(resultSet.getLong("id"));
        trackRecord.setScore(resultSet.getInt("score"));
        trackRecord.setDuration(resultSet.getInt("delay"));
        trackRecord.setUserID(resultSet.getLong("userid"));
        trackRecord.setSurveyID(resultSet.getLong("surveyid"));
        return trackRecord;
    }

    @Override
    /**
     * méthode permettant de trouver un objet avec son id
     */
    public TrackRecord find(long id) throws DAOException {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        TrackRecord trackRecord = null;

        try {
            /* Récupérer la connexion du Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_SELECT_ID, false, id);
            resultSet = preparedStatement.executeQuery();
            /* Parcours de la ligne de données de l'éventuel ResulSet retourné */
            if (resultSet.next()) {
                trackRecord = map(resultSet);
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }
        return trackRecord;
    }

    /**
     * méthode permettant de retourner l'ensemble des parcours d'un utilisateur donné
     */
    public List<TrackRecord> findAllByUserID(long userID) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        List<TrackRecord> liste = new ArrayList<TrackRecord>();

        try {
            /* Récupération d'une connexion depuis la Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_SELECT_ALL_USER, false, userID);
            resultSet = preparedStatement.executeQuery();
            /* Parcours de la ligne de données */
            while (resultSet.next()) {
                liste.add(map(resultSet));
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }

        return liste;
    }

    /**
     * méthode permettant de retourner la liste des parcours d'un questionnaire
     */
    public List<TrackRecord> findAllBySurveyId(long surveyID) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        List<TrackRecord> liste = new ArrayList<TrackRecord>();

        try {
            /* Récupération d'une connexion depuis la Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_SELECT_ALL_BY_SURVEYID, false, surveyID);
            resultSet = preparedStatement.executeQuery();
            /* Parcours de la ligne de données */
            while (resultSet.next()) {
                liste.add(map(resultSet));
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }

        return liste;
    }

    @Override
    /**
     * méthode permettant de retourner la liste de l'ensemble des parcours de la bdd
     */
    public List<TrackRecord> findAll() {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        List<TrackRecord> liste = new ArrayList<TrackRecord>();

        try {
            /* Récupération d'une connexion depuis la Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_SELECT_ALL, false);
            resultSet = preparedStatement.executeQuery();
            /* Parcours de la ligne de données */
            while (resultSet.next()) {
                liste.add(map(resultSet));
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }

        return liste;
    }

    /**
     * méthode permettant de savoir si un utilisateur à déja effectué un parcour
     */
    public boolean findRecordWithUserID(long idSurvey, long idUser) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        List<TrackRecord> liste = new ArrayList<TrackRecord>();

        try {
            /* Récupération d'une connexion depuis la Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_SELECT_ALL_USER_PARCOURID, false, idUser, idSurvey);
            resultSet = preparedStatement.executeQuery();
            /* Parcours de la ligne de données */
            while (resultSet.next()) {
                liste.add(map(resultSet));
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }
        return liste.size() > 0;
    }

    @Override
    /**
     * méthode permettant de d'enregistrer un nouveau parcour en bdd
     */
    public Long create(TrackRecord trackRecord) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;

        try {
            /* Récupérer la connexion du Factory */
            connexion = (Connection) this.connect;

            preparedStatement = getRequetePreparee(connexion, SQL_ADD, true,
                    trackRecord.getScore(),
                    trackRecord.getDuration(),
                    trackRecord.getUserID(),
                    trackRecord.getSurveyID());

            if (preparedStatement.executeUpdate() == 0)
                throw new DAOException("Échec de la création du parcour");

            resultSet = preparedStatement.getGeneratedKeys();

            if (resultSet.next()) {
                trackRecord.setId(resultSet.getLong(1));
            } else
                throw new DAOException("Échec de la création du parcour en base, pb ID auto-généré.");

        } catch (SQLException e) {
            throw new DAOException(e);
        }
        return trackRecord.getId();
    }

    @Override
    /**
     * méthode permettant de mettre à jour un parcours
     */
    public void update(TrackRecord trackRecord) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;

        try {
            /* Récupération d'une connexion depuis la Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_UPDATE, false, trackRecord.getScore(), trackRecord.getId());
            int statut = preparedStatement.executeUpdate();
            /* Analyse du statut retourné par la requête d'insertion */
            if (statut == 0) {
                throw new DAOException("Échec de la mise à jour du parcour, aucune ligne modifiée dans la table.");
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }
    }

    /**
     * méthode permettant de supprimer un parcours
     */
    @Override
    public void delete(long id) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;

        try {
            /* Récupérer la connexion du Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_DELETE, false, id);

            if (preparedStatement.executeUpdate() == 0)
                throw new DAOException("Échec de la suppression du parcour !");

        } catch (SQLException e) {
            throw new DAOException(e);
        }
    }
}