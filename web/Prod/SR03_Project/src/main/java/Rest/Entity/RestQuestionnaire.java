package Rest.Entity;

import Entity.Survey;

import java.util.List;

// questionnaire data
public class RestQuestionnaire {
    private long id;
    private String nom;
    private String subject;
    private Boolean isActive;
    private List<RestQuestion> questions;

    public RestQuestionnaire(Survey questionnaire, String subject, List<RestQuestion> questions) {
        this.id = questionnaire.getId();
        this.nom = questionnaire.getTitle();
        this.isActive = questionnaire.getActive();
        this.subject = subject;
        this.questions = questions;
    }

    //getter
    public long getId() {
        return id;
    }

    //setter
    public void setId(long id) {
        this.id = id;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getSubject() {
        return subject;
    }

    public void setSubject(String subject) {
        this.subject = subject;
    }

    public Boolean getActive() {
        return isActive;
    }

    public void setActive(Boolean active) {
        isActive = active;
    }

    public List<RestQuestion> getQuestions() {
        return questions;
    }

    public void setQuestions(List<RestQuestion> questions) {
        this.questions = questions;
    }
}
