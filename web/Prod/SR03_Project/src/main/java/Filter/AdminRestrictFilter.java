package Filter;

import Entity.User;

import javax.servlet.annotation.WebFilter;

/**
 * Cette classe permet de filtrer les accés admin.
 */

@WebFilter(urlPatterns = "/admin/*")
public class AdminRestrictFilter extends MetaFilter {
    /* Filtre permttant d'accéder aux fichiers admin */

    @Override
    protected boolean canAccess(User user) {
        return user.getStatutUser() == 1; // 1 Admin
    }
}
