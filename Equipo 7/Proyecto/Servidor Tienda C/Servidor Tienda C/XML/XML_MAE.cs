using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Servidor_Tienda_C.XML
{
    class XML_MAE : Xml_Object
    {
        public XML_MAE(string emisor_ip, string emisor_id, string emisor_tipo, string receptor_ip, string receptor_id, string receptor_tipo, string protocolo, string tipo) : base(emisor_ip, emisor_id, emisor_tipo, receptor_ip, receptor_id, receptor_tipo, protocolo, tipo)
        {
        }
        public void generar_xml()
        {
            this.doc = this.crear_xml();

        }
        public XML_MAE(string mensaje)
        {
            obtener_valores("mae", mensaje);
         
        }
    }
}
