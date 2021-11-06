using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml;

namespace Servidor_Tienda_C
{
    public class Xml_Object
    {
        public XmlDocument doc { get; set; }
        public string emisor_ip { get; set; }
        public string emisor_id { get; set; }
        public string emisor_tipo { get; set; }
        public string receptor_ip { get; set; }
        public string receptor_id { get; set; }
        public string receptor_tipo { get; set; }
        public string protocolo { get; set; }
        public string tipo { get; set; }
        public XmlElement enunciado { get; set; }

        public Xml_Object(string emisor_ip, string emisor_id, string emisor_tipo, string receptor_ip, string receptor_id, string receptor_tipo, string protocolo, string tipo) 
        {
            this.emisor_ip = emisor_ip;
            this.emisor_id = emisor_id;
            this.emisor_tipo = emisor_tipo;
            this.receptor_ip = receptor_ip;
            this.receptor_id = receptor_id;
            this.receptor_tipo = receptor_tipo;
            this.protocolo = protocolo;
            this.tipo = tipo;
        }

        public Xml_Object(string mensaje)
        {
            XmlDocument doc = new XmlDocument();
           // XmlDocument doc2 = new XmlDocument();
            //var aux=doc.GetElementsByTagName("info_mensaje")[0];
           
            doc.LoadXml(mensaje);
            this.doc = doc;
            List<string> posibles_tipos = new List<string>();
            posibles_tipos.Add("ack");
            posibles_tipos.Add("lista_compra");
            string tipo = "";
            foreach(string i in posibles_tipos)
            {
                var aux = doc.SelectNodes("/"+i)[0];
                if (aux != null){
                    tipo = i;
                }
            }
            //var aux = doc.SelectNodes("/ack")[0];

            var info_emisor = doc.SelectNodes("/"+tipo+"/info_mensaje/emisor")[0];
            this.emisor_ip = info_emisor["IP"].InnerText;
            Console.Write("Emisor_Ip:" + this.emisor_ip + "\n");

            this.emisor_id = info_emisor["ID"].InnerText;
            Console.Write("Emisor_id:" + this.emisor_id + "\n");

            this.emisor_tipo = info_emisor["tipo"].InnerText;
            Console.Write("Emisor_tipo:" + this.emisor_tipo + "\n");

            var info_receptor = doc.SelectNodes("/"+tipo+"/info_mensaje/receptor")[0];
            this.receptor_ip = info_receptor["IP"].InnerText;
            Console.Write("Receptor_Ip:" + this.receptor_ip+"\n");

            this.receptor_id = info_receptor["ID"].InnerText;
            Console.Write("Receptor_ID:" + this.receptor_id + "\n");

            this.receptor_tipo = info_receptor["tipo"].InnerText;
            Console.Write("Receptor_tipo:" + this.receptor_tipo + "\n");

            this.protocolo = doc.SelectNodes("/"+tipo+"/info_mensaje/protocolo")[0].InnerText;
            Console.Write("Protocolo:" + this.protocolo);
            
            this.tipo = doc.SelectNodes("/"+tipo+"/info_mensaje/tipo")[0].InnerText;
            Console.Write("Tipo:" + this.tipo);

            // XmlNodeList elemList = doc.GetElementsByTagName("info_mensaje");
            //var aux2 = doc.GetElementsByTagName("info_mensaje")[0];
            //var aux3=aux2.
            /*for (int i = 0; i < elemList.Count; i++)
            {
                
                //doc2.LoadXml(elemList[i].InnerXml;
                Console.WriteLine(elemList[i].InnerXml);
            }*/

            //
            //var info_mensaje_emisor_ip = info_mensaje_emisor.ChildNodes[0].InnerText;

            // Console.WriteLine("e");
        }

        public string xml_to_string()
        {
            return doc.OuterXml;
        }
        public XmlDocument crear_xml()
        {
        this.doc = new XmlDocument();
            XmlDeclaration xmlDeclaration = this.doc.CreateXmlDeclaration("1.0", "UTF-8", null);
            XmlElement root = this.doc.DocumentElement;
            this.doc.InsertBefore(xmlDeclaration, root);

            this.enunciado = this.doc.CreateElement(string.Empty, this.tipo, string.Empty);
            this.doc.AppendChild(this.enunciado);

            XmlElement element1 = this.doc.CreateElement(string.Empty, "info_mensaje", string.Empty);
            this.enunciado.AppendChild(element1);

            XmlElement emisor = this.doc.CreateElement(string.Empty, "emisor", string.Empty);
            element1.AppendChild(emisor);
           
            XmlElement receptor = this.doc.CreateElement(string.Empty, "receptor", string.Empty);
            element1.AppendChild(receptor);
            /*EMISOR_INFO_MENSAJE*/
            XmlElement e_ip = this.doc.CreateElement(string.Empty, "IP", string.Empty);
            emisor.AppendChild(e_ip);

            XmlText e_ip_te = this.doc.CreateTextNode("IP_EMISOR");
            e_ip.AppendChild(e_ip_te);

            XmlElement e_id = this.doc.CreateElement(string.Empty, "Id", string.Empty);
            emisor.AppendChild(e_id);

            XmlText e_id_te = this.doc.CreateTextNode("Id_EMISOR");
            e_id.AppendChild(e_id_te);

            XmlElement e_tipo = this.doc.CreateElement(string.Empty, "tipo", string.Empty);
            emisor.AppendChild(e_tipo);

            XmlText e_tipo_te = this.doc.CreateTextNode("tipo_emisor");
            e_tipo.AppendChild(e_tipo_te);

            /*RECEPTOR_INFO_MENSAJE*/
            XmlElement r_ip = this.doc.CreateElement(string.Empty, "IP", string.Empty);
            receptor.AppendChild(r_ip);

            XmlText r_ip_te = this.doc.CreateTextNode(this.receptor_ip);
            r_ip.AppendChild(r_ip_te);

            XmlElement r_id = this.doc.CreateElement(string.Empty, "Id", string.Empty);
            receptor.AppendChild(r_id);

            XmlText r_id_te = this.doc.CreateTextNode(this.receptor_id);
            r_id.AppendChild(r_id_te);

            XmlElement r_tipo = this.doc.CreateElement(string.Empty, "tipo", string.Empty);
            receptor.AppendChild(r_tipo);

            XmlText r_tipo_te = this.doc.CreateTextNode("tipo_emisor");
            r_tipo.AppendChild(r_tipo_te);
            //var t=doc.ToString();
            /*FIN INFO MENSAJE*/
            doc.Save(".XMLFile2.xml");
            //this.doc = doc;
            return doc;
        }
    }
}
