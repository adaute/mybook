using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using ChoixResto.Models;
using ChoixResto.Models.DAL;
using Microsoft.AspNetCore.Mvc;

// For more information on enabling MVC for empty projects, visit https://go.microsoft.com/fwlink/?LinkID=397860

namespace choixResto.Controllers
{
    public class RestaurantController : Controller
    {
        // GET: /<controller>/
        [ActionName("Index")]
        public IActionResult Index()
        {
            IDal dal = new Dal();
            /*dal.DataBaseInit();

            int idSondage1 = dal.CreerUnSondage();
            int idUtilisateur1 = dal.AjouterUtilisateur("Utilisateur1", "12345");
            int idUtilisateur2 = dal.AjouterUtilisateur("Utilisateur2", "12345");
            int idUtilisateur3 = dal.AjouterUtilisateur("Utilisateur3", "12345");
            dal.CreerRestaurant("Resto pinière", "0102030405");
            dal.CreerRestaurant("Resto pinambour", "0102030405");
            dal.CreerRestaurant("Resto mate", "0102030405");
            dal.CreerRestaurant("Resto ride", "0102030405");
            dal.AjouterVote(idSondage1, 1, idUtilisateur1);
            dal.AjouterVote(idSondage1, 3, idUtilisateur1);
            dal.AjouterVote(idSondage1, 4, idUtilisateur1);
            dal.AjouterVote(idSondage1, 1, idUtilisateur2);
            dal.AjouterVote(idSondage1, 1, idUtilisateur3);
            dal.AjouterVote(idSondage1, 3, idUtilisateur3);

            int idSondage2 = dal.CreerUnSondage();
            dal.AjouterVote(idSondage2, 2, idUtilisateur1);
            dal.AjouterVote(idSondage2, 3, idUtilisateur1);
            dal.AjouterVote(idSondage2, 1, idUtilisateur2);
            dal.AjouterVote(idSondage2, 4, idUtilisateur3);
            dal.AjouterVote(idSondage2, 3, idUtilisateur3);*/

            List<Resto> listeDesRestaurants = dal.ObtientTousLesRestaurants();
            return View(listeDesRestaurants);
        }

        public IActionResult ModifierRestaurant(int? id)
        {
            if (id.HasValue)
            {
                using (IDal dal = new Dal())
                {
                    Resto restaurant = dal.ObtientTousLesRestaurants().FirstOrDefault(r => r.Id == id.Value);
                    if (restaurant == null)
                        return View("Error");
                    return View(restaurant);
                }
            }
            else
                return View("Error");
        }

        [HttpPost]
        public IActionResult ModifierRestaurant(Resto resto)
        {
            using (IDal dal = new Dal())
            {
                dal.ModifierRestaurant(resto.Id, resto.Nom, resto.Telephone);
                return RedirectToAction("Index");
            }
        }
    }
}
