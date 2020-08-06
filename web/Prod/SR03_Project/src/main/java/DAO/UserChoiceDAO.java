package DAO;

import Entity.UserChoice;
import com.mysql.jdbc.Connection;
import com.mysql.jdbc.PreparedStatement;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import static DAO.DAOUtilitaire.getRequetePreparee;

/**
 * Cette classe permet la gestion des informations en base de données des choix des utilisateurs pendant un parcours
 */
public class UserChoiceDAO extends DAO<UserChoice> {

    /* différentes requêtes possibles */
    private static final String SQL_SELECT_ALL = "SELECT * FROM userchoice";
    private static final String SQL_ADD = "INSERT INTO userchoice (recordid, answerid, questionid) VALUES (?, ?, ?)";
    private static final String SQL_SELECT_ALL_BY_SURVEYID = "SELECT * FROM userchoice WHERE recordid = ?";
    private static final String SQL_SELECT_ALL_BY_RECORDID_QUESID = "SELECT * FROM userchoice WHERE recordid = ? AND questionid = ?";
    private static final String SQL_DELETE = "DELETE FROM userchoice WHERE recordid = ?";

    /**
     * Simple méthode utilitaire permettant de faire la correspondance (le
     * mapping) entre une ligne issue de la table des utilisateurs (un
     * ResultSet) et un bean Utilisateur.
     */
    private static UserChoice map(ResultSet resultSet) throws SQLException {
        UserChoice userChoice = new UserChoice();
        userChoice.setId(resultSet.getLong("id"));
        userChoice.setAnswerID(resultSet.getLong("answerid"));
        userChoice.setRecordID(resultSet.getLong("recordid"));
        userChoice.setQuestionID(resultSet.getLong("questionid"));
        return userChoice;
    }

    @Override
    /**
     * méthode permettant de trouver un objet avec son id : useless ici
     */
    public UserChoice find(long id) throws DAOException {
        return null;
    }

    /**
     * méthode permettant de retourner la liste de tous les choix d'un parcours en fonction de id question
     */
    public UserChoice findAllByRecordQuest(long recordId, long questionId) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        UserChoice userChoice = null;

        try {
            /* Récupération d'une connexion depuis la Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_SELECT_ALL_BY_RECORDID_QUESID, false, recordId, questionId);
            resultSet = preparedStatement.executeQuery();
            /* Parcours de la ligne de données */
            if (resultSet.next()) {
                userChoice = map(resultSet);
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }

        return userChoice;
    }

    /**
     * méthode permettant de retourner tous les choix en fonction de l'id du questionnaire
     */
    public List<UserChoice> findAllBySurveyId(long surveyID) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        List<UserChoice> liste = new ArrayList<UserChoice>();

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
     * méthode permettant de retourner tous les choix des utilisateurs de la bdd
     */
    public List<UserChoice> findAll() {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        List<UserChoice> liste = new ArrayList<UserChoice>();

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

    @Override
    /**
     * méthode permettant de créer un choix utilisateur lors d'un parcour
     */
    public Long create(UserChoice userChoice) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;

        try {
            /* Récupérer la connexion du Factory */
            connexion = (Connection) this.connect;

            preparedStatement = getRequetePreparee(connexion, SQL_ADD, true,
                    userChoice.getRecordID(),
                    userChoice.getAnswerID(),
                    userChoice.getQuestionID());

            if (preparedStatement.executeUpdate() == 0)
                throw new DAOException("Échec de la création du choix utilisateur");

            resultSet = preparedStatement.getGeneratedKeys();

            if (resultSet.next()) {
                userChoice.setId(resultSet.getLong(1));
            } else
                throw new DAOException("Échec de la création du choix utilisateur en base, pb ID auto-généré.");

        } catch (SQLException e) {
            throw new DAOException(e);
        }
        return userChoice.getId();
    }

    @Override
    public void update(UserChoice userChoice) {
        return;
    }

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
                throw new DAOException("Échec de la suppression du choix !");

        } catch (SQLException e) {
            throw new DAOException(e);
        }
    }
}