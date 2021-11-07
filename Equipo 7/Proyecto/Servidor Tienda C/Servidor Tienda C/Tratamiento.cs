using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Servidor_Tienda_C.XML;
namespace Servidor_Tienda_C
{
    static class Tratamiento
    {
        public static void tratamiento_lista_productos()
        {
            /*Generar tratamiento a peticion de listado de productos*/
            var mensaje_xml = new XML_lista_compra(VGlobal.Mensaje_tratado.receptor_id, "emisor_id", "Tienda", "receptor_ip", "receptor_id", "Cliente", "protocolo", "lista_de_la_compra");
            mensaje_xml.generar_xml();
            var aux = mensaje_xml.xml_to_string();
            tcp.broadcast(aux, VGlobal.MensajeActual.Endpoint_Cliente);
        }
        public static void tratamiento_ack()
        {

        }
        public static void tratamiento_error()
        {

        }

    }
}
