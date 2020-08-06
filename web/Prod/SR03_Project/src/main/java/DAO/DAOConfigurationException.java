package DAO;

/**
 * méthode permettant la gestion des erreurs du DAO
 */
public class DAOConfigurationException extends RuntimeException {
    /**
     * Constructeurs
     */

    public DAOConfigurationException(String message) {
        super(message);
    }

    public DAOConfigurationException(Throwable cause) {
        super(cause);
    }

    public DAOConfigurationException(String message, Throwable cause) {
        super(message, cause);
    }

}
