using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace ChoixResto.Models
{
    [Table("Restos")]
    public class Resto
    {
        public int Id { get; set; }
        [Required, MaxLength(100)]
        public string Nom { get; set; }
        [Display(Name = "Téléphone")]
        public string Telephone { get; set; }
     }
}
