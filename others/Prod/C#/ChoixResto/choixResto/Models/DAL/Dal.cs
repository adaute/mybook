using System;
using System.Linq;
using System.Data.SqlClient;
using System.Collections.Generic;
using System.Security.Cryptography;
using System.Text;
using choixResto.Models;

namespace ChoixResto.Models.DAL
{
    public class Dal : IDal
    {
        private MysqlEf bdd;

        public Dal()
        {
            try
            {

            Console.WriteLine("** Entity Framework Core and SQL Server **\n");
            SqlConnectionStringBuilder builder = new SqlConnectionStringBuilder();
            builder.DataSource = "localhost,1433";   // update me
            builder.UserID = "SA";              // update me
            builder.Password = "YourStrong!Passw0rd";      // update 
            builder.InitialCatalog = "EFSampleDB";

            bdd = new MysqlEf(builder.ConnectionString);
            }
            catch (Exception e)
            {
                Console.WriteLine(e.ToString());
            }
        }

        public void DataBaseInit(){
           bdd.Database.EnsureDeleted();
           bdd.Database.EnsureCreated();
           Console.WriteLine("Created database schema from C# classes.");
        }

  
        // restos part 

        public List<Resto> ObtientTousLesRestaurants()
        {
            return bdd.Restos.ToList();
        }

        public void CreerRestaurant(string nom, string telephone)
        {
            bdd.Restos.Add(new Resto {Nom = nom, Telephone = telephone });
            bdd.SaveChanges();
        }

        public void ModifierRestaurant(int id, string nom, string telephone){
            Resto restoTrouve = bdd.Restos.FirstOrDefault(resto => resto.Id == id);
            if (restoTrouve != null)
            {
                restoTrouve.Nom = nom;
                restoTrouve.Telephone = telephone;
                bdd.SaveChanges();
            }
        }

        public bool RestaurantExiste(string nom){
            Resto restoTrouve = bdd.Restos.FirstOrDefault(resto => resto.Nom == nom);
            return restoTrouve != null ? true : false;
        }

        // user part
        public Utilisateur ObtenirUtilisateur(int id){
            return bdd.Users.FirstOrDefault(Utilisateur => Utilisateur.Id == id);
        }

        public Utilisateur ObtenirUtilisateur(string prenom)
        {
            return bdd.Users.FirstOrDefault(Utilisateur => Utilisateur.Prenom == prenom);
        }

        public int AjouterUtilisateur(string prenom, string password){
            bdd.Users.Add(new Utilisateur { Prenom = prenom, Password = EncodeMD5(password) });
            bdd.SaveChanges();
            return bdd.Users.FirstOrDefault(Utilisateur => Utilisateur.Prenom == prenom).Id;
        }

        public Utilisateur Authentifier(string prenom, string password){
            return bdd.Users.FirstOrDefault(Utilisateur => Utilisateur.Prenom == prenom &&  Utilisateur.Password == EncodeMD5(password));
        }

        //sondage part
        public int CreerUnSondage(){
            Sondage sondage = new Sondage { Date = DateTime.Now };
            bdd.Sondages.Add(sondage);
            bdd.SaveChanges();
            return sondage.Id;
        }

        public void AjouterVote(int idSondage, int idResto, int idUtilisateur)
        {
            Vote vote = new Vote
            {
                Resto = bdd.Restos.First(r => r.Id == idResto),
                Utilisateur = bdd.Users.First(u => u.Id == idUtilisateur)
            };
            Sondage sondage = bdd.Sondages.First(s => s.Id == idSondage);
            if (sondage.Votes == null)
                sondage.Votes = new List<Vote>();
            sondage.Votes.Add(vote);
            bdd.SaveChanges();
        }

        // resultat part
        public List<Resultats> ObtenirLesResultats(int idSondage)
        {
            List<Resto> restaurants = ObtientTousLesRestaurants();
            List<Resultats> resultats = new List<Resultats>();
            Sondage sondage = bdd.Sondages.First(s => s.Id == idSondage);
            foreach (IGrouping<int, Vote> grouping in sondage.Votes.GroupBy(v => v.Resto.Id))
            {
                int idRestaurant = grouping.Key;
                Resto resto = restaurants.First(r => r.Id == idRestaurant);
                int nombreDeVotes = grouping.Count();
                resultats.Add(new Resultats { Nom = resto.Nom, Telephone = resto.Telephone, NombreDeVotes = nombreDeVotes });
            }
            return resultats;
        }

        public bool ADejaVote(int idSondage, string idStr)
        {
            int id;
            if (int.TryParse(idStr, out id))
            {
                Sondage sondage = bdd.Sondages.First(s => s.Id == idSondage);
                if (sondage.Votes == null)
                    return false;
                return sondage.Votes.Any(v => v.Utilisateur != null && v.Utilisateur.Id == id);
            }
            return false;
        }

        public void Dispose()
        {
            bdd.Dispose();
        }

        private string EncodeMD5(string motDePasse){
            string motDePasseSel = "ChoixResto" + motDePasse + "ASP.NET MVC";
            return BitConverter.ToString(new MD5CryptoServiceProvider().ComputeHash(ASCIIEncoding.Default.GetBytes(motDePasseSel)));
        }

    }
}
