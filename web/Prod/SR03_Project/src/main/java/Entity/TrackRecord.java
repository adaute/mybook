package Entity;

import java.io.Serializable;

public class TrackRecord implements Serializable {

    // Attributs
    private Long id;
    private Long userID;
    private Long SurveyID;
    private int score;
    private long duration;

    //Getters
    public Long getId() {
        return id;
    }

    //Setters
    public void setId(Long id) {
        this.id = id;
    }

    public Long getUserID() {
        return userID;
    }

    public void setUserID(Long userID) {
        this.userID = userID;
    }

    public Long getSurveyID() {
        return SurveyID;
    }

    public void setSurveyID(Long surveyID) {
        SurveyID = surveyID;
    }

    public int getScore() {
        return score;
    }

    public void setScore(int score) {
        this.score = score;
    }

    public long getDuration() {
        return duration;
    }

    public void setDuration(long duration) {
        this.duration = duration;
    }

    @Override
    public String toString() {
        return "TrackRecord{" +
                "userID=" + userID +
                ", SurveyID=" + SurveyID +
                ", score=" + score +
                ", duration=" + duration +
                '}';
    }
}
