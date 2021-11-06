using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml;

namespace Servidor_Tienda_C.XML
{
    public class XML_mensaje_de_error : Xml_Object
    {
        public XML_mensaje_de_error(string emisor_ip, string emisor_id, string emisor_tipo, string receptor_ip, string receptor_id, string receptor_tipo, string protocolo, string tipo) : base(emisor_ip, emisor_id, emisor_tipo, receptor_ip, receptor_id, receptor_tipo, protocolo, tipo)
        {
        }
        public void generar_xml()
        {
            this.doc = this.crear_xml();
            XmlElement mensaje_error = this.doc.CreateElement(string.Empty, "MensajeError", string.Empty);
            this.enunciado.AppendChild(mensaje_error);

            XmlElement texto = this.doc.CreateElement(string.Empty, "Texto", string.Empty);
            this.enunciado.AppendChild(texto);

            /*INCOMPLETO*/
        }
    }
}
