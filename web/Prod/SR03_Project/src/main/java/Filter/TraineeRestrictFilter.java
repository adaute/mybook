package Filter;

import Entity.User;

import javax.servlet.annotation.WebFilter;

/**
 * Cette classe permet de filtrer les accés stagiaire.
 */

@WebFilter(urlPatterns = "/stagiaire_*")
public class TraineeRestrictFilter extends MetaFilter {
    /* Filtre permttant d'accéder aux fichiers admin */

    @Override
    protected boolean canAccess(User user) {
        return user.getStatutUser() == 0; // 0 stagiaire
    }
}
