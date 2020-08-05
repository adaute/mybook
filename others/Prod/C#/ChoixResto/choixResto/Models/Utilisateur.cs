﻿using System.ComponentModel.DataAnnotations;

namespace ChoixResto.Models
{
    public class Utilisateur
    {
        public int Id { get; set; }
        [Required, MaxLength(80)]
        public string Prenom { get; set; }
        public string Password { get; set; }

    }
}
