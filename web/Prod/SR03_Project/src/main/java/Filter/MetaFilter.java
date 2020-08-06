package Filter;

import Entity.User;

import javax.servlet.*;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import java.io.IOException;

/**
 * Cette classe abstraite permet de filtrer les accés de maniére logique
 */

abstract class MetaFilter implements Filter {
    private static final String REDIRECT_PAGE = "/connexion.xhtml";
    private static final String ATT_SESSION_USER = "sessionUser";

    @Override
    public void init(FilterConfig arg0) throws ServletException {
    }

    @Override
    public void destroy() {
    }

    @Override
    public void doFilter(ServletRequest req, ServletResponse res, FilterChain chain)
            throws IOException, ServletException {
        /* Cast des objets request et response */
        HttpServletRequest request = (HttpServletRequest) req;
        HttpServletResponse response = (HttpServletResponse) res;

        /* Récupération de la session depuis la requête */
        HttpSession session = request.getSession();
        User user = (User) session.getAttribute(ATT_SESSION_USER);

        if ((user == null) || !canAccess(user)) {
            /* Redirection vers la page de connexion */
            response.sendRedirect(request.getContextPath() + REDIRECT_PAGE);
        } else {
            /* Affichage de la page restreinte */
            chain.doFilter(request, response);
        }
    }

    protected boolean canAccess(User user) {
        return true;
    }
}
