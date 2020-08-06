package Rest;

import javax.ws.rs.ApplicationPath;
import javax.ws.rs.core.Application;
import java.util.HashSet;
import java.util.Set;

//https://stackoverflow.com/questions/26709288/jax-rs-how-to-extend-application-class-to-scan-packages

//Define URI for all URIs.
@ApplicationPath("/rest/")

//The java class root resource and provider classes
public class RestApplications extends Application {

    private final Set<Class<?>> allClases = new HashSet<>();

    //The method returns a non-empty collection with classes, that must be included in the published JAX-RS application

    @Override
    public Set<Class<?>> getClasses() {
        allClases.add(RestConversionService.class);
        allClases.add(RestQuestionnaire.class);
        return allClases;
    }
}