using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using choixResto.Models;
using ChoixResto.Models;
using ChoixResto.ViewsModels;
using Microsoft.AspNetCore.Mvc.Rendering;

namespace ChoixResto.Controllers
{
    public class HomeController : Controller
    {
        public IActionResult Index()
        {
            return View();
        }

        public IActionResult About()
        {
            ViewData["Message"] = "Your application description page.";

            return View();
        }

        public IActionResult Contact()
        {
            ViewData["Message"] = "Your contact page.";

            return View();
        }

        public IActionResult Privacy()
        {
            return View();
        }

        public IActionResult Test()
        {
            /* ViewData["message"] = "Bonjour depuis le contrôleur";
             ViewData["date"] = DateTime.Now;
             ViewData["resto"] = new Resto { Nom = "Choucroute party", Telephone = "1234" };

             Resto r = new Resto { Nom = "La bonne fourchette", Telephone = "1234" };
             return View(r);*/

            List<Models.Resto> listeDesRestos = new List<Resto>{
             new Resto { Id = 1, Nom = "Resto pinambour", Telephone = "1234" },
             new Resto { Id = 2, Nom = "Resto tologie", Telephone = "1234" },
             new Resto { Id = 5, Nom = "Resto ride", Telephone = "5678" },
             new Resto { Id = 9, Nom = "Resto toro", Telephone = "555" },
           };
            ViewBag.ListeDesRestos = new SelectList(listeDesRestos, "Id", "Nom",5);

            IndexViewModel vm = new IndexViewModel
            {
                Message = "Bonjour depuis le <span style=\"color:red\">contrôleur</span>",
                Date = DateTime.Now,
                Resto = new Resto { Nom = "La bonne fourchette", Telephone = "1234" },
                ListeDesRestos = new List<Resto>
                 {
                    new Resto { Nom = "Resto pinambour", Telephone = "1234" },
                    new Resto { Nom = "Resto tologie", Telephone = "1234" },
                    new Resto { Nom = "Resto ride", Telephone = "5678" },
                    new Resto { Nom = "Resto toro", Telephone = "555" },
                }
        };

            return View(vm);
        }


        public ActionResult AfficheListeRestaurant()
        {
            List<Resto> listeDesRestos = new List<Resto>
    {
        new Resto { Id = 1, Nom = "Resto pinambour", Telephone = "1234" },
        new Resto { Id = 2, Nom = "Resto tologie", Telephone = "1234" },
        new Resto { Id = 5, Nom = "Resto ride", Telephone = "5678" },
        new Resto { Id = 9, Nom = "Resto toro", Telephone = "555" }
    };
            return PartialView(listeDesRestos);
        }



        [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
        public IActionResult Error()
        {
            return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
        }
    }
}
