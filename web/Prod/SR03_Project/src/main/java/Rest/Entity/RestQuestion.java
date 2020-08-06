package Rest.Entity;

import Entity.Answer;
import Entity.Question;

import java.util.List;

public class RestQuestion {
    private long id;
    private String enonce;
    private long rightAnswer;
    private long position;
    private Boolean status;
    private List<Answer> answers;

    public RestQuestion(Question question, List<Answer> answers) {
        this.id = question.getId();
        this.status = question.getIsactive();
        this.enonce = question.getTitle();
        this.rightAnswer = question.getAnswerId();
        this.position = question.getOrder();
        this.answers = answers;
    }

    //getter
    public long getId() {
        return id;
    }

    // setter
    public void setId(long id) {
        this.id = id;
    }

    public String getEnonce() {
        return enonce;
    }

    public void setEnonce(String enonce) {
        this.enonce = enonce;
    }

    public long getRightAnswer() {
        return rightAnswer;
    }

    public void setRightAnswer(long rightAnswer) {
        this.rightAnswer = rightAnswer;
    }

    public long getPosition() {
        return position;
    }

    public void setPosition(long position) {
        this.position = position;
    }

    public Boolean getStatus() {
        return status;
    }

    public void setStatus(Boolean status) {
        this.status = status;
    }

    public List<Answer> getAnswers() {
        return answers;
    }

    public void setAnswers(List<Answer> answers) {
        this.answers = answers;
    }
}
