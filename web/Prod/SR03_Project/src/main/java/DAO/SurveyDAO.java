package DAO;

import Entity.Survey;
import com.mysql.jdbc.Connection;
import com.mysql.jdbc.PreparedStatement;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import static DAO.DAOUtilitaire.getRequetePreparee;

/**
 * Cette classe permet la gestion des informations en base de données des questionnaires
 */
public class SurveyDAO extends DAO<Survey> {

    /* différentes requêtes possibles */
    private static final String SQL_SELECT_ID = "SELECT * FROM survey WHERE id = ?";
    private static final String SQL_SELECT_SURVEY = "SELECT * FROM survey WHERE title = ?";
    private static final String SQL_DELETE = "DELETE FROM survey WHERE id = ?";
    private static final String SQL_ADD = "INSERT INTO survey (title, subject_id, isactive) VALUES (?, ?, ?)";
    private static final String SQL_SELECT_ALL = "SELECT * FROM survey ORDER BY title";
    private static final String SQL_UPDATE = "UPDATE survey SET title=?,subject_id=?,isactive=?  WHERE id = ?";
    private static final String SQL_SELECT_ALL_STATUS = "SELECT * FROM survey where isactive=?";

    /**
     * Simple méthode utilitaire permettant de faire la correspondance (le
     * mapping) entre une ligne issue de la table des utilisateurs (un
     * ResultSet) et un bean Utilisateur.
     */
    private static Survey map(ResultSet resultSet) throws SQLException {
        Survey survey = new Survey();
        survey.setId(resultSet.getLong("id"));
        survey.setTitle(resultSet.getString("title"));
        survey.setSubject(resultSet.getLong("subject_id"));
        survey.setActive(resultSet.getBoolean("isactive"));
        return survey;
    }

    @Override
    /**
     * méthode permettant de trouver un objet avec son id
     */
    public Survey find(long id) throws DAOException {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        Survey survey = null;

        try {
            /* Récupérer la connexion du Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_SELECT_ID, false, id);
            resultSet = preparedStatement.executeQuery();
            /* Parcours de la ligne de données de l'éventuel ResulSet retourné */
            if (resultSet.next()) {
                survey = map(resultSet);
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }
        return survey;
    }

    @Override
    /**
     * méthode permettant de retourner l'ensemble des questionnaires de la bdd
     */
    public List<Survey> findAll() {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        List<Survey> liste = new ArrayList<Survey>();

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
     * méthode permettant de retourner les questonnaires actifs ou innactifs.
     */
    public List<Survey> findAllStatus(int status) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        List<Survey> liste = new ArrayList<Survey>();

        try {
            /* Récupération d'une connexion depuis la Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_SELECT_ALL_STATUS, false, status);
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
     * méthode permettant de créer un questionnaire
     */
    public Long create(Survey survey) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;

        try {
            /* Récupérer la connexion du Factory */
            connexion = (Connection) this.connect;

            preparedStatement = getRequetePreparee(connexion, SQL_ADD, true,
                    survey.getTitle(),
                    survey.getSubject(),
                    survey.getActive());

            if (preparedStatement.executeUpdate() == 0)
                throw new DAOException("Échec de la création du questionnaire");

            resultSet = preparedStatement.getGeneratedKeys();

            if (resultSet.next()) {
                survey.setId(resultSet.getLong(1));
            } else
                throw new DAOException("Échec de la création du questionnaire en base, pb ID auto-généré.");

        } catch (SQLException e) {
            throw new DAOException(e);
        }
        return survey.getId();
    }

    @Override
    /**
     * méthode permettant de mettre à jour un questionnaire
     */
    public void update(Survey survey) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;

        try {
            /* Récupération d'une connexion depuis la Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_UPDATE, false, survey.getTitle(), survey.getSubject(), survey.getActive(), survey.getId());
            int statut = preparedStatement.executeUpdate();
            /* Analyse du statut retourné par la requête d'insertion */
            if (statut == 0) {
                throw new DAOException("Échec de la mise à jour du questionnaire, aucune ligne modifiée dans la table.");
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }
    }

    @Override
    /**
     * méthode permettant de supprimer un qustionnaire
     */
    public void delete(long id) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;

        try {
            /* Récupérer la connexion du Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_DELETE, false, id);

            if (preparedStatement.executeUpdate() == 0)
                throw new DAOException("Échec de la suppression du questionnaire !");

        } catch (SQLException e) {
            throw new DAOException(e);
        }
    }
}