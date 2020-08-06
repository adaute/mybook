package DAO;

import java.sql.Connection;
import java.sql.SQLException;
import java.util.List;

/**
 * classe abstraite permet de représenter les différentes actions possibles par notre couche DAO
 */
public abstract class DAO<T> {

    /**
     * Création de l'objet connection pour les intéraction avec la base de données
     */
    public Connection connect;

    {
        try {
            connect = DAOFactory.getInstance().getConnection();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

    /**
     * Permet de récupérer un objet via son ID
     *
     * @param id
     * @return
     */
    public abstract T find(long id) throws DAOException;

    /**
     * Permet de récupérer une liste d'objets
     *
     * @return
     */
    public abstract List<T> findAll();

    /**
     * Permet de créer une entrée dans la base de données
     * par rapport à un objet
     *
     * @param obj
     */
    public abstract Long create(T obj);

    /**
     * Permet de mettre à jour les données d'une entrée dans la base
     *
     * @param obj
     */
    public abstract void update(T obj);

    /**
     * Permet la suppression d'une entrée de la base
     *
     * @param id
     */
    public abstract void delete(long id);
}
