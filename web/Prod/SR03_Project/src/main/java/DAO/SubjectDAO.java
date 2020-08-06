package DAO;

import Entity.Subject;
import com.mysql.jdbc.Connection;
import com.mysql.jdbc.PreparedStatement;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import static DAO.DAOUtilitaire.getRequetePreparee;

/**
 * Cette classe permet la gestion des informations en base de données des thémes lié au questionnaire
 */
public class SubjectDAO extends DAO<Subject> {

    /* différentes requêtes possibles */
    private static final String SQL_SELECT_ID = "SELECT * FROM subject WHERE id = ?";
    private static final String SQL_SELECT_SUBJECT = "SELECT * FROM subject WHERE subject = ?";
    private static final String SQL_DELETE = "DELETE FROM subject WHERE id = ?";
    private static final String SQL_ADD = "INSERT INTO subject (subject) VALUES (?)";
    private static final String SQL_SELECT_ALL = "SELECT * FROM subject ORDER BY subject";
    private static final String SQL_UPDATE = "UPDATE subject SET subject=? WHERE id = ?";

    /**
     * Simple méthode utilitaire permettant de faire la correspondance (le
     * mapping) entre une ligne issue de la table des utilisateurs (un
     * ResultSet) et un bean Utilisateur.
     */
    private static Subject map(ResultSet resultSet) throws SQLException {
        Subject subject = new Subject();
        subject.setId(resultSet.getLong("id"));
        subject.setSubject(resultSet.getString("subject"));
        return subject;
    }

    @Override
    /**
     * méthode permettant de trouver un objet avec son id
     */
    public Subject find(long id) throws DAOException {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        Subject subject = null;

        try {
            /* Récupérer la connexion du Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_SELECT_ID, false, id);
            resultSet = preparedStatement.executeQuery();
            /* Parcours de la ligne de données de l'éventuel ResulSet retourné */
            if (resultSet.next()) {
                subject = map(resultSet);
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }
        return subject;
    }

    /**
     * méthode permettant de trouver un objet théme en fonction de son string
     */
    public Subject findBySubject(String subjectName) throws DAOException {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        Subject subject = null;

        try {
            /* Récupérer la connexion du Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_SELECT_SUBJECT, false, subjectName);
            resultSet = preparedStatement.executeQuery();
            /* Parcours de la ligne de données de l'éventuel ResulSet retourné */
            if (resultSet.next()) {
                subject = map(resultSet);
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }
        return subject;
    }

    @Override
    /**
     * méthode permettant de retourner la liste de tous les thémes en bdd
     */
    public List<Subject> findAll() {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        List<Subject> liste = new ArrayList<Subject>();

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
     * méthode permettant de créer un théme
     */
    public Long create(Subject subject) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;

        try {
            /* Récupérer la connexion du Factory */
            connexion = (Connection) this.connect;

            if (findBySubject(subject.getSubject()) != null) return (long) -1;

            preparedStatement = getRequetePreparee(connexion, SQL_ADD, true,
                    subject.getSubject());

            if (preparedStatement.executeUpdate() == 0)
                throw new DAOException("Échec de la création du questionnaire");

            resultSet = preparedStatement.getGeneratedKeys();

            if (resultSet.next()) {
                subject.setId(resultSet.getLong(1));
            } else
                throw new DAOException("Échec de la création du questionnaire en base, pb ID auto-généré.");

        } catch (SQLException e) {
            throw new DAOException(e);
        }

        return subject.getId();
    }

    @Override
    /**
     * méthode permettant de mettre à jour un théme
     */
    public void update(Subject subject) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;

        try {
            /* Récupération d'une connexion depuis la Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_UPDATE, false, subject.getSubject(), subject.getId());
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
     * méthode permettant de supprimer un théme
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