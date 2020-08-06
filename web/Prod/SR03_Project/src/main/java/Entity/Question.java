package Entity;

import java.io.Serializable;

public class Question implements Serializable {

    // Attributs
    private long id;
    private String title;
    private long order;
    private long surveyID;
    private long answerId;
    private Boolean isactive;

    //Getters
    public long getId() {
        return id;
    }

    //Setters
    public void setId(long id) {
        this.id = id;
    }

    public String getTitle() {
        return title;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public long getOrder() {
        return order;
    }

    public void setOrder(long order) {
        this.order = order;
    }

    public long getSurveyID() {
        return surveyID;
    }

    public void setSurveyID(long surveyID) {
        this.surveyID = surveyID;
    }

    public long getAnswerId() {
        return answerId;
    }

    public void setAnswerId(long answerId) {
        this.answerId = answerId;
    }

    public Boolean getIsactive() {
        return isactive;
    }

    public void setIsactive(Boolean isactive) {
        this.isactive = isactive;
    }

    @Override
    public String toString() {
        return "Question{" +
                "id=" + id +
                ", title='" + title + '\'' +
                ", order=" + order +
                ", surveyID=" + surveyID +
                ", answerId=" + answerId +
                ", isactive=" + isactive +
                '}';
    }
}
