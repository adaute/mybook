using Microsoft.EntityFrameworkCore;
using Microsoft.AspNetCore.Identity.EntityFrameworkCore;
using choixResto.Models;

namespace ChoixResto.Models.DAL
{
    public class MysqlEf : DbContext
    {
        string _connectionString;
        public MysqlEf(string connectionString)
        {
            this._connectionString = connectionString;
        }
        protected override void OnConfiguring(DbContextOptionsBuilder optionsBuilder)
        {
            optionsBuilder.UseSqlServer(this._connectionString);
        }

        public virtual DbSet<Sondage> Sondages { get; set; }
        public virtual DbSet<Resto> Restos { get; set; }
        public virtual DbSet<Utilisateur> Users { get; set; }
    }
}
