using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml;

namespace Servidor_Tienda_C.XML
{
    public class XML_ack : Xml_Object
    {
        public string contador { get; set; }
        public XML_ack(string emisor_ip, string emisor_id, string emisor_tipo, string receptor_ip, string receptor_id, string receptor_tipo, string protocolo, string tipo) : base(emisor_ip, emisor_id, emisor_tipo, receptor_ip, receptor_id, receptor_tipo, protocolo, tipo)
        {
  


        }
        /// <summary>
        /// Genera el documento XML el cual la info se genera con la funcion crear_xml(),el cual sirve para añadir la info nada mas y luego añade los demas datos.
        /// </summary>
        public void generar_xml()
        {
            this.doc = this.crear_xml();
            XmlElement ack = this.doc.CreateElement(string.Empty, "ack", string.Empty);
            this.enunciado.AppendChild(ack);

            XmlElement tipo_mensaje = this.doc.CreateElement(string.Empty, "tipo_mensaje", string.Empty);
            ack.AppendChild(tipo_mensaje);

            XmlElement id_mensaje = this.doc.CreateElement(string.Empty, "id_mensaje", string.Empty);
            ack.AppendChild(id_mensaje);

            XmlElement ipemisor = this.doc.CreateElement(string.Empty, "ipemisor", string.Empty);
            id_mensaje.AppendChild(ipemisor);

            XmlElement contador = this.doc.CreateElement(string.Empty, "contador", string.Empty);
            id_mensaje.AppendChild(contador);


        }
    }
}
