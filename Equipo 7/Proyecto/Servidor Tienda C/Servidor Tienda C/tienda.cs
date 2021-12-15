using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Servidor_Tienda_C
{
    public class tienda
    {
        public tienda(string ip_tienda, string id_tienda)
        {
            this.ip_tienda = ip_tienda;
            this.id_tienda = id_tienda;
        }

        public string ip_tienda { get; set; }
        public string id_tienda { get; set; }
    }
}
