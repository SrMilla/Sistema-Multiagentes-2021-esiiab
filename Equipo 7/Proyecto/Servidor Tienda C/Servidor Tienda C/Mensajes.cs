using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Text;
using System.Threading.Tasks;

namespace Servidor_Tienda_C
{
    public class Mensajes
    {
        /// <summary>
        /// 
        /// </summary>
        /// <param name="endpoint_Cliente"></param>
        /// <param name="mensaje"></param>
        public Mensajes(EndPoint endpoint_Cliente, string mensaje)
        {
            this.Endpoint_Cliente = endpoint_Cliente;
            this.mensaje = mensaje;
        }

        public Mensajes()
        {
        }

        public System.Net.EndPoint Endpoint_Cliente { get; set; }
        public string mensaje { get; set; }
        public string respuesta { get; set; }
        public bool tratado { get; set; }
        public bool recibido { get; set; }

        
    }
}
