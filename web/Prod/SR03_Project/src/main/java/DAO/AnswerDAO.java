package DAO;

import Entity.Answer;
import com.mysql.jdbc.Connection;
import com.mysql.jdbc.PreparedStatement;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import static DAO.DAOUtilitaire.getRequetePreparee;

/**
 * Cette classe permet la gestion des informations en base de données des réponses aux questionnaires
 */
public class AnswerDAO extends DAO<Answer> {

    /* différentes requêtes possibles */
    private static final String SQL_SELECT_ID = "SELECT * FROM answer WHERE id = ?";
    private static final String SQL_DELETE = "DELETE FROM answer WHERE id = ?";
    private static final String SQL_SELECT_ALL = "SELECT * FROM answer WHERE idquestion= ? ORDER BY answer_order";
    private static final String SQL_ADD = "INSERT INTO answer (label, idquestion, answer_order, isactive) VALUES (?, ?, ?, ?)";
    private static final String SQL_UPDATE = "UPDATE answer SET label=?,answer_order=?, isactive=?  WHERE id = ?";
    private static final String SQL_SELECT_ALL_STATUS = "SELECT * FROM answer where isactive=?";
    private static final String SQL_SELECT_ALL_QUESTIONID = "SELECT * FROM answer where idquestion=? ORDER BY answer_order";

    /**
     * Simple méthode utilitaire permettant de faire la correspondance (le
     * mapping) entre une ligne issue de la table des réponses (un
     * ResultSet) et un bean des réponses.
     */
    private static Answer map(ResultSet resultSet) throws SQLException {
        Answer answer = new Answer();
        answer.setId(resultSet.getLong("id"));
        answer.setLabel(resultSet.getString("label"));
        answer.setIdQuestion(resultSet.getLong("idquestion"));
        answer.setOrder(resultSet.getLong("answer_order"));
        answer.setIsactive(resultSet.getBoolean("isactive"));
        return answer;
    }

    @Override
    /**
     * méthode permettant de trouver un objet avec son id
     */
    public Answer find(long id) throws DAOException {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        Answer answer = null;

        try {
            /* Récupérer la connexion du Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_SELECT_ID, false, id);
            resultSet = preparedStatement.executeQuery();
            /* Parcours de la ligne de données de l'éventuel ResulSet retourné */
            if (resultSet.next()) {
                answer = map(resultSet);
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }
        return answer;
    }

    /**
     * méthode permettant de trouver une liste de réponse à l'aide de l'ID de la question
     */
    public List<Answer> findAllQuestionID(long questionID) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        List<Answer> liste = new ArrayList<Answer>();

        try {
            /* Récupération d'une connexion depuis la Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_SELECT_ALL_QUESTIONID, false, questionID);
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
     * méthode permettant de retourner la liste des réponses
     */
    public List<Answer> findAll() {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        List<Answer> liste = new ArrayList<Answer>();

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
     * méthode permettant de retourner la liste des réponses actives/non actives
     */
    public List<Answer> findAllStatus(int status) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        List<Answer> liste = new ArrayList<Answer>();

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
     * méthode permettant de créer une réponse
     */
    public Long create(Answer answer) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;

        try {
            /* Récupérer la connexion du Factory */
            connexion = (Connection) this.connect;

            // préparer la requête
            preparedStatement = getRequetePreparee(connexion, SQL_ADD, true,
                    answer.getLabel(),
                    answer.getIdQuestion(),
                    answer.getOrder(),
                    answer.getIsactive()
            );

            if (preparedStatement.executeUpdate() == 0)
                throw new DAOException("Échec de la création de la réponse");

            resultSet = preparedStatement.getGeneratedKeys();

            if (resultSet.next()) {
                answer.setId(resultSet.getLong(1));
            } else
                throw new DAOException("Échec de la création de la réponse en base, pb ID auto-généré.");

        } catch (SQLException e) {
            throw new DAOException(e);
        }

        return answer.getId();
    }

    @Override
    /**
     * méthode permettant de mettre à jour une réponse
     */
    public void update(Answer answer) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;

        try {
            /* Récupération d'une connexion depuis la Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_UPDATE, false,
                    answer.getLabel(),
                    answer.getOrder(),
                    answer.getIsactive(),
                    answer.getId()
            );
            int statut = preparedStatement.executeUpdate();
            /* Analyse du statut retourné par la requête d'insertion */
            if (statut == 0) {
                throw new DAOException("Échec de la mise à jour de la réponse, aucune ligne modifiée dans la table.");
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }
    }

    @Override
    /**
     * méthode permettant de supprimer une réponse
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
                throw new DAOException("Échec de la suppression de la réponse !");

        } catch (SQLException e) {
            throw new DAOException(e);
        }
    }
}