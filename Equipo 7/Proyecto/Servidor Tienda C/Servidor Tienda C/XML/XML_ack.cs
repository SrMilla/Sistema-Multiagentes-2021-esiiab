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
        public string tipomen { get; set; }
        public string ipEmisorAck { get; set; }
        public XML_ack(string emisor_ip, string emisor_id, string emisor_tipo, string receptor_ip, string receptor_id, string receptor_tipo, string protocolo, string tipo) : base(emisor_ip, emisor_id, emisor_tipo, receptor_ip, receptor_id, receptor_tipo, protocolo, tipo)
        {
  


        }
        /// <summary>
        /// Genera el documento XML el cual la info se genera con la funcion crear_xml(),el cual sirve para añadir la info nada mas y luego añade los demas datos.
        /// </summary>
        public void generar_xml(string tipomen,string id_mensajec,string ip_emisor,string contadorc)
        {
            this.doc = this.crear_xml();
            /*XmlElement ack = this.doc.CreateElement(string.Empty, "ack", string.Empty);
            this.enunciado.AppendChild(ack);*/

            XmlElement tipo_mensaje = this.doc.CreateElement(string.Empty, "tipoMensajePregunta", string.Empty);
            this.enunciado.AppendChild(tipo_mensaje);
            XmlText tipo_mensaje_V = this.doc.CreateTextNode(tipomen);
            tipo_mensaje.AppendChild(tipo_mensaje_V);

            XmlElement idPregunta = this.doc.CreateElement(string.Empty, "idPregunta", string.Empty);
            this.enunciado.AppendChild(idPregunta);

            XmlElement ipEmisor = this.doc.CreateElement(string.Empty, "ipEmisor", string.Empty);
            idPregunta.AppendChild(ipEmisor);

            XmlElement contador = this.doc.CreateElement(string.Empty, "contador", string.Empty);
            idPregunta.AppendChild(contador);

            XmlText ipEmisor_v = this.doc.CreateTextNode(ip_emisor);
            ipEmisor.AppendChild(ipEmisor_v);

            XmlText contador_v = this.doc.CreateTextNode(this.contador);
            contador.AppendChild(contador_v);

        }
        public XML_ack(string mensaje)
        {
            obtener_valores("ack", mensaje);
            this.tipomen = this.doc.SelectNodes("/" + "ack"+ "/tipoMensajePregunta")[0].InnerText;

            this.ipEmisorAck= this.doc.SelectNodes("/" + "ack" + "/idPregunta")[0]["ipEmisor"].InnerText;
            this.contador= this.doc.SelectNodes("/" + "ack" + "/idPregunta")[0]["contador"].InnerText;
            var t = 0;
            Console.Write("Tipo mensaje:" + this.tipomen + "\n");
            Console.Write("Ip Emisor Ack:" + this.ipEmisorAck + "\n");
            Console.Write("Contador:" + this.contador + "\n");
        }

    }
}
