package Util;

import javax.faces.context.FacesContext;
import java.util.Map;

/**
 * Cette classe permet de gérer plus facilement les requests
 */
public class RequestManager {
    /* Class permettant de gérer plus facilement les requests */

    public static Object getParam(String key) {
        /* get param avec valeur par défaut null */
        return getParam(key, null);
    }

    public static Object getParam(String key, Object defaut) {
        /* Permet d'obtenir un paramètre passé en paramettre en get ou post avec une valeur par défaut */
        FacesContext fc = FacesContext.getCurrentInstance();
        Map<String, String> params = fc.getExternalContext().getRequestParameterMap();
        if (params.containsKey(key)) {
            return params.get(key);
        } else {
            return defaut;
        }
    }
}
