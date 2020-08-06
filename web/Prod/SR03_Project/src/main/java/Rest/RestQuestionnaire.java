package Rest;

import DAO.DAOFactory;
import Entity.Answer;
import Entity.Question;
import Entity.Subject;
import Entity.Survey;
import Rest.Entity.RestQuestion;
import com.google.gson.Gson;

import javax.ws.rs.GET;
import javax.ws.rs.Path;
import javax.ws.rs.PathParam;
import javax.ws.rs.Produces;
import javax.ws.rs.core.MediaType;
import java.util.ArrayList;
import java.util.List;


@Path("getQuestionnaire")
public class RestQuestionnaire {

    @GET
    @Path("/{id}")
    @Produces(MediaType.APPLICATION_JSON)
    public String getQuestionnaire(@PathParam("id") int id) {

        Survey questionnaire = DAOFactory.getInstance().getSurveyDao().find(id);
        List<RestQuestion> allQuestions = new ArrayList<>();

        if (questionnaire != null) {

            Subject subject = DAOFactory.getInstance().getSubjectDao().find(questionnaire.getSubject());

            List<Question> questions = DAOFactory.getInstance().getQuestionDao().findAllSurveyID(id);

            questions.forEach(question -> {
                List<Answer> answers = DAOFactory.getInstance().getAnswerDao().findAllQuestionID(question.getId());
                RestQuestion myQuestion = new RestQuestion(question, answers);
                allQuestions.add(myQuestion);
            });

            Rest.Entity.RestQuestionnaire myQuestionnaire = new Rest.Entity.RestQuestionnaire(questionnaire, subject.getSubject(), allQuestions);

            return new Gson().toJson(myQuestionnaire);
        } else {
            return "{\"error\" : \"Resource not found\"}";
        }
    }

    @GET
    @Produces(MediaType.APPLICATION_JSON)
    public String getQuestionnaires() {

        List<Survey> questionnaires = DAOFactory.getInstance().getSurveyDao().findAll();
        List<Rest.Entity.RestQuestionnaire> myQuestionnaires = new ArrayList<>();

        questionnaires.forEach(questionnaire -> {

            Subject subject = DAOFactory.getInstance().getSubjectDao().find(questionnaire.getSubject());
            List<RestQuestion> allQuestions = new ArrayList<>();
            List<Question> questions = DAOFactory.getInstance().getQuestionDao().findAllSurveyID(questionnaire.getId());

            questions.forEach(question -> {
                List<Answer> answers = DAOFactory.getInstance().getAnswerDao().findAllQuestionID(question.getId());
                RestQuestion myQuestion = new RestQuestion(question, answers);
                allQuestions.add(myQuestion);
            });

            Rest.Entity.RestQuestionnaire myQuestionnaire = new Rest.Entity.RestQuestionnaire(questionnaire, subject.getSubject(), allQuestions);
            myQuestionnaires.add(myQuestionnaire);
        });

        return new Gson().toJson(myQuestionnaires);
    }

}
