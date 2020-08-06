package DAO;

/**
 * méthode permettant la gestion des erreurs du DAO
 */
public class DAOException extends RuntimeException {
    /**
     * Constructeurs
     */
    public DAOException(String message) {
        super(message);
    }

    public DAOException(Throwable cause) {
        super(cause);
    }

    public DAOException(String message, Throwable cause) {
        super(message, cause);
    }
}
