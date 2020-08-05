using System;
using System.Collections.Generic;
using choixResto.Models;

namespace ChoixResto.Models.DAL
{
    public interface IDal : IDisposable
    {
        void DataBaseInit();

        List<Resto> ObtientTousLesRestaurants();
       
        void CreerRestaurant(string nom, string telephone);
        void ModifierRestaurant(int id, string nom, string telephone);
        bool RestaurantExiste(string nom);

        int AjouterUtilisateur(string prenom, string password);
        Utilisateur ObtenirUtilisateur(int id);
        Utilisateur ObtenirUtilisateur(string id);
        Utilisateur Authentifier(string prenom, string password);

        bool ADejaVote(int idSondage, string idStr);

        int CreerUnSondage();
        void AjouterVote(int idSondage, int idResto, int idUtilisateur);

        List<Resultats> ObtenirLesResultats(int id);
    }
}
