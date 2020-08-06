package DAO;

import Entity.User;
import com.mysql.jdbc.Connection;
import com.mysql.jdbc.PreparedStatement;

import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import static DAO.DAOUtilitaire.getRequetePreparee;

/**
 * Cette classe permet la gestion des informations en base de données des utilisateurs
 */
public class UserDAO extends DAO<User> {

    /* différentes requêtes possibles */
    private static final String SQL_SELECT_ID = "SELECT * FROM user WHERE id = ?";
    private static final String SQL_SELECT_EMAIL = "SELECT * FROM user WHERE email = ?";
    private static final String SQL_DELETE = "DELETE FROM user WHERE id = ?";
    private static final String SQL_ADD = "INSERT INTO user (email, password, firstname, lastname, compagny, phone, createdat, status, statutuser) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?)";
    private static final String SQL_UPDATE = "UPDATE user SET email=?,password=?,firstname=?,lastname=?,compagny=?,phone=?,statutuser=?,status=?  WHERE id = ?";
    private static final String SQL_SELECT_ALL = "SELECT * FROM user ORDER BY createdat";
    private static final String SQL_SELECT_ALL_STATUS = "SELECT * FROM user where status=? ORDER BY createdat";

    /*
     * Simple méthode utilitaire permettant de faire la correspondance (le
     * mapping) entre une ligne issue de la table des utilisateurs (un
     * ResultSet) et un bean Utilisateur.
     */
    private static User map(ResultSet resultSet) throws SQLException {
        User user = new User();
        user.setId(resultSet.getLong("id"));
        user.setEmail(resultSet.getString("email"));
        user.setPassword(resultSet.getString("password"));
        user.setFirstName(resultSet.getString("firstname"));
        user.setLastName(resultSet.getString("lastname"));
        user.setCompagny(resultSet.getString("compagny"));
        user.setPhone(resultSet.getString("phone"));
        user.setCreatedAt(resultSet.getTimestamp("createdAt"));
        user.setStatutUser(resultSet.getInt("statutUser"));
        user.setStatus(resultSet.getBoolean("status"));
        return user;
    }

    @Override
    /**
     * méthode permettant de trouver un objet avec son id
     */
    public User find(long id) throws DAOException {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        User user = null;

        try {
            /* Récupérer la connexion du Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_SELECT_ID, false, id);
            resultSet = preparedStatement.executeQuery();
            /* Parcours de la ligne de données de l'éventuel ResulSet retourné */
            if (resultSet.next()) {
                user = map(resultSet);
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }
        return user;
    }

    /**
     * méthode permettant de trouver un utilisateur avec son email
     */
    public User findByEmail(String email) throws DAOException {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        User user = null;

        try {
            /* Récupérer la connexion du Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_SELECT_EMAIL, false, email);
            resultSet = preparedStatement.executeQuery();
            /* Parcours de la ligne de données de l'éventuel ResulSet retourné */
            if (resultSet.next()) {
                user = map(resultSet);
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }
        return user;
    }

    @Override
    /**
     * méthode permettant de retourner la liste des utilisateurs de la bdd
     */
    public List<User> findAll() {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        List<User> liste = new ArrayList<User>();

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
     * méthode permettant de retourner les utilisateurs actifs/innactifs de la bdd
     */
    public List<User> findAllStatus(int status) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;
        List<User> liste = new ArrayList<User>();

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
     * méthode permettant de créer un utilisateur
     */
    public Long create(User user) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;
        ResultSet resultSet = null;

        try {
            /* Récupérer la connexion du Factory */
            connexion = (Connection) this.connect;

            String password = user.getPassword();

            preparedStatement = getRequetePreparee(connexion, SQL_ADD, true,
                    user.getEmail(),
                    user.getPassword(),
                    user.getFirstName(),
                    user.getLastName(),
                    user.getCompagny(),
                    user.getPhone(),
                    user.getStatus(),
                    user.getStatutUser());

            if (preparedStatement.executeUpdate() == 0)
                throw new DAOException("Échec de la création de l'utilisateur");

            resultSet = preparedStatement.getGeneratedKeys();

            if (resultSet.next()) {
                user.setId(resultSet.getLong(1));
            } else
                throw new DAOException("Échec de la création de l'utilisateur en base, pb ID auto-généré.");

        } catch (SQLException e) {
            throw new DAOException(e);
        }

        return user.getId();
    }

    @Override
    /**
     * méthode permettant de mettre à jour un utilisateur
     */
    public void update(User user) {
        Connection connexion = null;
        PreparedStatement preparedStatement = null;

        try {
            /* Récupération d'une connexion depuis la Factory */
            connexion = (Connection) this.connect;
            preparedStatement = getRequetePreparee(connexion, SQL_UPDATE, false, user.getEmail(), user.getPassword(), user.getFirstName(), user.getLastName(), user.getCompagny(), user.getPhone(), user.getStatutUser(), user.getStatus(), user.getId());
            int statut = preparedStatement.executeUpdate();
            /* Analyse du statut retourné par la requête d'insertion */
            if (statut == 0) {
                throw new DAOException("Échec de la mise à jour de l'utilisateur, aucune ligne modifiée dans la table.");
            }
        } catch (SQLException e) {
            throw new DAOException(e);
        }
    }

    @Override
    /**
     * méthode permettant de supprimer un utilisateur
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
                throw new DAOException("Échec de la suppression de l'utilisateur !");

        } catch (SQLException e) {
            throw new DAOException(e);
        }
    }
}