package Entity;

import java.io.Serializable;

public class Answer implements Serializable {

    // Attributs
    private Long id;
    private String label;
    private Long idQuestion;
    private Long order;
    private Boolean isactive;

    //Getters
    public Long getId() {
        return id;
    }

    //Setters
    public void setId(Long id) {
        this.id = id;
    }

    public String getLabel() {
        return label;
    }

    public void setLabel(String label) {
        this.label = label;
    }

    public Long getIdQuestion() {
        return idQuestion;
    }

    public void setIdQuestion(Long idQuestion) {
        this.idQuestion = idQuestion;
    }

    public Long getOrder() {
        return order;
    }

    public void setOrder(Long order) {
        this.order = order;
    }

    public Boolean getIsactive() {
        return isactive;
    }

    public void setIsactive(Boolean isactive) {
        this.isactive = isactive;
    }

    @Override
    public String toString() {
        return "Answer{" +
                "id=" + id +
                ", label='" + label + '\'' +
                ", idQuestion=" + idQuestion +
                ", order=" + order +
                ", IsActive=" + isactive +
                '}';
    }
}
