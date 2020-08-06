package Util;

import javax.annotation.PostConstruct;
import javax.faces.bean.ApplicationScoped;
import javax.faces.bean.ManagedBean;
import javax.faces.context.ExternalContext;
import javax.faces.context.FacesContext;
import java.io.Serializable;

@ManagedBean
@ApplicationScoped
/**
 * Cette classe permet de gérer les différentd path des pages et assets
 */

public class AppUrlStore implements Serializable {
    private static final long serialVersionUID = 1L;

    private String baseUrl = null;
    private String adminHomeUrl = null;
    private String traineeHomeUrl = null;
    private String crudUserUrl = null;
    private String crudUserAddUrl = null;

    private String loginUrl = null;
    private String crudQuizzUrl = null;
    private String crudQuizzAddUrl = null;


    public String getBaseUrl() {
        return baseUrl;
    }

    public String getAdminHomeUrl() {
        return adminHomeUrl;
    }

    public String getTraineeHomeUrl() {
        return traineeHomeUrl;
    }

    public String getCrudUserUrl() {
        return crudUserUrl;
    }

    public String getCrudQuizzUrl() {
        return crudQuizzUrl;
    }

    public String getLoginUrl() {
        return loginUrl;
    }

    public String getCrudUserAddUrl() {
        return crudUserAddUrl;
    }

    public String getCrudQuizzAddUrl() {
        return crudQuizzAddUrl;
    }

    @PostConstruct
    public void init() {
        ExternalContext externalContext = FacesContext.getCurrentInstance().getExternalContext();
        String baseUrl = externalContext.getInitParameter("BaseUrl");

        this.baseUrl = baseUrl;
        this.adminHomeUrl = baseUrl + "admin/admin_home.xhtml";
        this.traineeHomeUrl = baseUrl + "stagiaire/stagiaire_home.xhtml";
        this.crudUserUrl = baseUrl + "admin/crudUser.xhtml";
        this.loginUrl = baseUrl + "connexion.xhtml";
        this.crudQuizzUrl = baseUrl + "admin/crudQuizz.xhtml";
        this.crudUserAddUrl = baseUrl + "admin/addUser.xhtml";
        this.crudQuizzAddUrl = baseUrl + "admin/addQuizz.xhtml";
    }
}
