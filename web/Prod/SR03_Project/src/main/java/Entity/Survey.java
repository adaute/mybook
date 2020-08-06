package Entity;

import java.io.Serializable;

public class Survey implements Serializable {

    // Attributs
    private Long id;
    private String title;
    private Long subject;
    private Boolean active;

    //Getters
    public Long getId() {
        return id;
    }

    //Setters
    public void setId(Long id) {
        this.id = id;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public Long getSubject() {
        return subject;
    }

    public void setSubject(Long subject) {
        this.subject = subject;
    }

    public Boolean getActive() {
        return active;
    }

    public void setActive(Boolean active) {
        this.active = active;
    }

    @Override
    public String toString() {
        return "Survey{" +
                "id=" + id +
                ", title='" + title + '\'' +
                ", subject=" + subject +
                ", IsActive=" + active +
                '}';
    }
}
