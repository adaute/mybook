package DAO;

import Entity.Question;
import com.mysql.jdbc.Connection;
import com.mysql.jdbc.PreparedStatement;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import static DAO.DAOUtilitaire.getRequetePreparee;


/**
 * Cette classe permet la gestion des informations en base de données des questions aux questionnaires
 */
public class QuestionDAO extends DAO<Question> {

    /* différentes requêtes possibles */
    private static final String SQL_SELECT_ID = "SELECT * FROM question WHERE id = ?";
    private static final String SQL_DELETE = "DELETE FROM question WHERE id = ?";
    private static final String SQL_ADD = "INSERT INTO question (title, question_order, isactive, surveyid,answerid) VALUES (?, ?, ?, ?, ?)";
    private static final String SQL_SELECT_ALL = "SELECT * FROM question WHERE surveyid = ? ORDER BY question_order";
    private static final String SQL_UPDATE = "UPDATE question SET title=?, question_order=?, isactive=?, answerid=?  WHERE id = ?";
    private static final String SQL_SELECT_ALL_STATUS = "SELECT * FROM question where isactive=?";
    private static final String SQL_SELECT_ALL_SURVEYID = "SELECT * FROM question where surveyid=? ORDER BY question_order";

    /**
     * Simple méthode utilitaire permettant de faire la correspondance (le
     * mapping) entre une ligne issue de la table des questions (un
     * ResultSet) et un bean Question.
     */
    private static Question map(ResultSet resultSet) throws SQLException {
        Question question = new Question();
        question.setId(resultSet.getLong("id"));
        question.setTitle(resultSet.getString("title"));
        question.setOrder(resultSet.getLong("question_order"));
        question.setIsactive(resultSet.getBoolean("isactive"));
        question.setSurveyID(resultSet.getLong("surveyid"));
        question.setAnswerId(resultSet.getLong("answerid"));
        return question;
    }

    @Override
    /**
     * méthode permettant de trouver un objet avec son id
     */
    public Question find(long id) throws DAOException {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        Question question = null;

        try {
            /* Récupérer la connexion du Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_SELECT_ID, false, id);
            resultSet = preparedStatement.executeQuery();
            /* Parcours de la ligne de données de l'éventuel ResulSet retourné */
            if (resultSet.next()) {
                question = map(resultSet);
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }
        return question;
    }

    @Override
    /**
     * méthode permettant de retourner la liste des questions en bdd
     */
    public List<Question> findAll() {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        List<Question> liste = new ArrayList<Question>();

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
     * méthode permettant de retourner la liste des questions en bdd à l'aide de l'id du questionnaire
     */
    public List<Question> findAllSurveyID(long surveyID) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        List<Question> liste = new ArrayList<Question>();

        try {
            /* Récupération d'une connexion depuis la Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_SELECT_ALL_SURVEYID, false, surveyID);
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
     * méthode permettant de retourner la liste des questions active/desactivé en bdd
     */
    public List<Question> findAllStatus(int status) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        List<Question> liste = new ArrayList<Question>();

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
     * méthode permettant de créer une question
     */
    public Long create(Question question) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;

        try {
            /* Récupérer la connexion du Factory */
            connexion = (Connection) this.connect;

            preparedStatement = getRequetePreparee(connexion, SQL_ADD, true,
                    question.getTitle(),
                    question.getOrder(),
                    question.getIsactive(),
                    question.getSurveyID(),
                    question.getAnswerId()
            );

            if (preparedStatement.executeUpdate() == 0)
                throw new DAOException("Échec de la création de la question");

            resultSet = preparedStatement.getGeneratedKeys();

            if (resultSet.next()) {
                question.setId(resultSet.getLong(1));
            } else
                throw new DAOException("Échec de la création de la question en base, pb ID auto-généré.");

        } catch (SQLException e) {
            throw new DAOException(e);
        }

        return question.getId();
    }

    @Override
    /**
     * méthode permettant de mette à jour une question
     */
    public void update(Question question) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;

        try {
            /* Récupération d'une connexion depuis la Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_UPDATE, false, question.getTitle(), question.getOrder(), question.getIsactive(), question.getAnswerId(), question.getId());
            int statut = preparedStatement.executeUpdate();
            /* Analyse du statut retourné par la requête d'insertion */
            if (statut == 0) {
                throw new DAOException("Échec de la mise à jour de la question, aucune ligne modifiée dans la table.");
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }
    }

    @Override
    /**
     * méthode permettant de supprimer une question
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
                throw new DAOException("Échec de la suppression de la question !");

        } catch (SQLException e) {
            throw new DAOException(e);
        }
    }
}