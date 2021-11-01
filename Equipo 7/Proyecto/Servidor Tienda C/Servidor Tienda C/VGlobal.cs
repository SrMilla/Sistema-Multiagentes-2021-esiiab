using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Net;

namespace Servidor_Tienda_C
{
    public static class VGlobal
    {
        public static List<Mensajes> MensajesBuffer = new List<Mensajes>();
        public static void añadirBuffer(EndPoint endpoint_Cliente, string mensaje)
        {
            Mensajes aux = new(endpoint_Cliente, mensaje);
            MensajesBuffer.Add(aux);
        }
    }
    
}
