package Bean;

import DAO.DAOException;
import DAO.DAOFactory;
import DAO.UserDAO;
import Entity.User;
import net.bootsfaces.utils.FacesMessages;
import org.jasypt.util.password.ConfigurablePasswordEncryptor;

import javax.annotation.PostConstruct;
import javax.enterprise.context.SessionScoped;
import javax.faces.context.FacesContext;
import javax.inject.Named;
import java.io.Serializable;

/**
 * Cette classe permet la gestion de l'authentification des utilisateurs
 */
@Named
@SessionScoped
public class ConnexionBean implements Serializable {

    private static final long serialVersionUID = 1L;

    /* Liens de redirection */
    private static final String algo_encryption = "SHA-256";
    private static final String SESSION_USER = "sessionUser";
    private static final String ECHEC = "";
    private static final String ADMIN = "/admin/admin_home.xhtml?faces-redirect=true";
    private static final String TRAINEE = "/stagiaire/stagiaire_home.xhtml?faces-redirect=true";
    private static final String DECONNEXION = "/connexion?faces-redirect=true";

    /* définition des attributs */
    private User user;
    private UserDAO userDao;

    @PostConstruct
    /**
     *  Méthode d'initialisation du BeanManager avec l'annotation :  @PostConstruct
     */
    public void init() {
        this.user = new User();
        this.userDao = DAOFactory.getInstance().getUserDao();
    }


    /**
     * Méthode d'action appelée lors de l'authentificaiton de l'utilisateur
     */
    public String connexion() {
        User userConnect = null;

        //Utilisation de la bibliothèque Jasypt pour chiffrer le mot de passe
        ConfigurablePasswordEncryptor passwordEncryptor = new ConfigurablePasswordEncryptor();
        passwordEncryptor.setAlgorithm(algo_encryption);
        passwordEncryptor.setPlainDigest(false);

        FacesContext context = FacesContext.getCurrentInstance();

        try {
            userConnect = userDao.findByEmail(user.getEmail()); // voir si un utilisateur existe

            if (userConnect == null || !passwordEncryptor.checkPassword(user.getPassword(), userConnect.getPassword()))
                userConnect = null; // si ce n'est pas le cas retourner null

        } catch (DAOException e) {
            e.printStackTrace();
        }

        // enregistrer les informations de l'utilisateur dans la session et le rediriger vers la page adéquate ( admin ou stagiaire )
        if (userConnect != null && userConnect.getStatus()) {
            context.getExternalContext().getSessionMap().put(SESSION_USER, userConnect);
            if (userConnect.getStatutUser() == 1)
                return ADMIN;
            else
                return TRAINEE;
        } else {
            context.getExternalContext().getSessionMap().put(SESSION_USER, null);
            FacesMessages.error("myForm:loginMessage", "Connection failed!", "Utilisateur ou mot de passe incorrect");
            return ECHEC;
        }
    }

    /**
     * Méthode d'action pour la déconnection : vide la session et redirige vers la page d'accueil
     */
    public String deconnexion() {
        FacesContext context = FacesContext.getCurrentInstance();
        context.getExternalContext().getSessionMap().put(SESSION_USER, null);
        return DECONNEXION;
    }

    /**
     * Méthode pour récupérer l'objet utilisateur
     */
    public User getUtilisateur() {
        return this.user;
    }

    /**
     * Méthode pour interagir sur l'objet utilisateur
     */
    public void setUtilisateur(User user) {
        this.user = user;
    }

}
