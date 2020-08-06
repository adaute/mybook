package Bean;

import DAO.DAOFactory;
import DAO.TrackRecordDAO;
import DAO.UserChoiceDAO;
import DAO.UserDAO;
import Entity.TrackRecord;
import Entity.User;
import Util.CommonUtils;
import Util.EmailManager;
import Util.RequestManager;
import net.bootsfaces.utils.FacesMessages;
import org.jasypt.util.password.ConfigurablePasswordEncryptor;

import javax.annotation.PostConstruct;
import javax.enterprise.context.SessionScoped;
import javax.faces.context.FacesContext;
import javax.inject.Named;
import java.io.IOException;
import java.io.Serializable;
import java.util.List;

@Named
@SessionScoped
public class UserBean implements Serializable {

    private static final long serialVersionUID = 1L;

    private static final String algo_encryption = "SHA-256";

    /* Liens de redirection */
    private static final String USER_EDIT = "/admin/addUser.xhtml?faces-redirect=true";


    /* définition des attributs */
    private List<User> list_userEnabled;
    private List<User> list_userDisabled;

    private User user;
    private UserDAO userDao;

    @PostConstruct
    /**
     *  Méthode d'initialisation du BeanManager avec l'annotation :  @PostConstruct
     */
    public void init() {
        user = new User();
        userDao = DAOFactory.getInstance().getUserDao();
        list_userEnabled = userDao.findAllStatus(1); // remplir la liste des utilisateurs actifs
        list_userDisabled = userDao.findAllStatus(0); // remplir la liste des utilisateurs innactifs
    }

    /**
     * Méthode pour ajouter un utilisateur
     */
    public String ajouterUnUser() {

        if (userDao.findByEmail(user.getEmail()) == null) {
            String password = CommonUtils.chain_generate(); // générer un mot de passe

            //Utilisation de la bibliothèque Jasypt pour chiffrer le mot de passe
            ConfigurablePasswordEncryptor passwordEncryptor = new ConfigurablePasswordEncryptor();
            passwordEncryptor.setAlgorithm(algo_encryption);
            passwordEncryptor.setPlainDigest(false);

            user.setPassword(passwordEncryptor.encryptPassword(password));

            userDao.create(user);

            System.out.println("utilisateur crée avec le password " + password);

            // envoyer l'email
            String content = "Bonjour, votre compte a été créé avec succès sur projet_SR03"
                    + "\n\nLogin: " + user.getEmail() + "\n\nPassword: " + password;
            EmailManager.envoyer(user.getEmail(), content, true);

            maj();// mettre à jour les listes affichées sur le site

            user = new User();

            FacesMessages.info("form:send", "Info", "Utilisateur enregistré");
            return "";
        } else {
            FacesMessages.error("form:send", "Error", "Email déja existant !");
            return "";
        }
    }

    /**
     * Méthode pour editer un utilisateur, on le charge et on affiche la box => redirection vers la page pour éditer un utilisateur
     */
    public String editUser(User usr) {
        if (usr == null)
            this.user = new User();
        else
            this.user = usr;
        return USER_EDIT;
    }

    /**
     * Méthode pour mettre à jour un utilisateur
     */
    public String updateUser() {
        userDao.update(user);
        user = new User();
        maj();// mettre à jour les listes affichées sur le site
        FacesMessages.info("formEditUser:send", "Info", "Utilisateur maj");
        try {
            FacesContext.getCurrentInstance().getExternalContext().redirect("crudUser.xhtml?faces-redirect=true"); // redirection aprés modification
        } catch (IOException e) {
            e.printStackTrace();
        }
        return "";
    }

    /**
     * Méthode pour mettre à jour le status (Activer/desactiver un utilisateur)
     */
    public String statusUser() {
        long id = Long.parseLong((String) RequestManager.getParam("id"));
        User user = userDao.find(id);
        user.setStatus(!user.getStatus());
        userDao.update(user);
        maj();// mettre à jour les listes affichées sur le site
        return "";
    }

    /**
     * Méthode pour supprimer un utilisateur
     */
    public String deleteUser() {
        long id = Long.parseLong((String) RequestManager.getParam("id"));

        TrackRecordDAO trackRecordDao = DAOFactory.getInstance().getTrackRecordDao();
        UserChoiceDAO userChoiceDAO = DAOFactory.getInstance().getChoiceDao();

        //suppresion des parcours et des choix
        List<TrackRecord> list_parcours = trackRecordDao.findAllByUserID(id);

        if (list_parcours != null) {
            list_parcours.forEach((record) -> {
                userChoiceDAO.delete(record.getId());
                trackRecordDao.delete(record.getId());
            });
        }

        userDao.delete(id);
        maj();// mettre à jour les listes affichées sur le site
        return "";
    }

    /**
     * Méthode pour récupérer l'adresse email avec id utilisateur
     */
    public String userToString(long user) {
        return userDao.find(user).getEmail();
    }

    /**
     * Méthode pour mettre à jour les listes pour la vue
     */
    public void maj() {
        list_userEnabled = userDao.findAllStatus(1);
        list_userDisabled = userDao.findAllStatus(0);
    }

    // Getters
    public User getUser() {
        return user;
    }

    public List<User> getList_userEnabled() {
        return list_userEnabled;
    }

    public List<User> getList_userDisabled() {
        return list_userDisabled;
    }
}