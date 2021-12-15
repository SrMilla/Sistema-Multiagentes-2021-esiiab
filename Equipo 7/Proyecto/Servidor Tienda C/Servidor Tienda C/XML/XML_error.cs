using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml;
using System.Xml.Serialization;

namespace Servidor_Tienda_C.XML
{
    class XML_error : Xml_Object
    {
        
        public XML_error(string emisor_ip, string emisor_id, string emisor_tipo, string receptor_ip, string receptor_id, string receptor_tipo, string protocolo, string tipo) : base(emisor_ip, emisor_id, emisor_tipo, receptor_ip, receptor_id, receptor_tipo, protocolo, tipo)
        {



        }
        public void generar_xml(string mensaje_str)
        {
            this.doc = this.crear_xml();
            XmlElement error = this.doc.CreateElement(string.Empty, "mensaje", string.Empty);
            this.enunciado.AppendChild(error);

            XmlElement texto = this.doc.CreateElement(string.Empty, "texto", string.Empty);
            XmlText texto_c = this.doc.CreateTextNode(mensaje_str);
            texto.AppendChild(texto_c);

            XmlElement mensaje = this.doc.CreateElement(string.Empty, "mensajeProv", string.Empty);
            error.AppendChild(mensaje);
            this.doc.Save(".XMLFile3.xml");
            var t = this.element1.Clone();
            ///AQUI DEBE ESTAR EL CUERPO DEL MENSAJE QUE ES COMO INFOMENSAJE
            var t2 = t.ChildNodes;
            mensaje.AppendChild(t2[0]);
            mensaje.AppendChild(t2[0]);
            this.doc.Save(".XMLFile2.xml");
        }
        public XML_error(string mensaje)
        {
            /*obtener_valores("error", mensaje);
            this.tipomen = this.doc.SelectNodes("/" + "ack" + "/tipoMensajePregunta")[0].InnerText;

            this.ipEmisorAck = this.doc.SelectNodes("/" + "ack" + "/idPregunta")[0]["ipEmisor"].InnerText;
            this.contador = this.doc.SelectNodes("/" + "ack" + "/idPregunta")[0]["contador"].InnerText;
            var t = 0;
            Console.Write("Tipo mensaje:" + this.tipomen + "\n");
            Console.Write("Ip Emisor Ack:" + this.ipEmisorAck + "\n");
            Console.Write("ontador:" + this.contador + "\n");*/
        }
    }
}
