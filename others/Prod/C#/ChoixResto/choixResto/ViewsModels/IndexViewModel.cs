using System;
using System.Collections.Generic;

namespace ChoixResto.ViewsModels
{
    public class IndexViewModel
    {
        public string Message { get; set; }
        public DateTime Date { get; set; }
        public Models.Resto Resto { get; set; }
        public List<Models.Resto> ListeDesRestos { get; set; }
        public string Login { get; set; }
    }


}
