package Entity;

import java.io.Serializable;

public class UserChoice implements Serializable {

    // Attributs
    private Long id;
    private Long RecordID;
    private Long answerID;
    private Long questionID;

    //Getters
    public Long getId() {
        return id;
    }

    //Setters
    public void setId(Long id) {
        this.id = id;
    }

    public Long getRecordID() {
        return RecordID;
    }

    public void setRecordID(Long recordID) {
        RecordID = recordID;
    }

    public Long getAnswerID() {
        return answerID;
    }

    public void setAnswerID(Long answerID) {
        this.answerID = answerID;
    }

    public Long getQuestionID() {
        return questionID;
    }

    public void setQuestionID(Long questionID) {
        this.questionID = questionID;
    }

    @Override
    public String toString() {
        return "UserChoice{" +
                "id=" + id +
                ", RecordID=" + RecordID +
                ", answerID=" + answerID +
                '}';
    }
}