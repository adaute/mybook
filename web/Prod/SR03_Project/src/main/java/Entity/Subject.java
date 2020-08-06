package Entity;

import java.io.Serializable;

public class Subject implements Serializable {

    // Attributs
    private Long id;
    private String subject;

    //Getters
    public Long getId() {
        return id;
    }

    //Setters
    public void setId(Long id) {
        this.id = id;
    }

    public String getSubject() {
        return subject;
    }

    public void setSubject(String subject) {
        this.subject = subject;
    }

    @Override
    public String toString() {
        return "Competence{subject='" + this.subject + "'}";
    }
}
