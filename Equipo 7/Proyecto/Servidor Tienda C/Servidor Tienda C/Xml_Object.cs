using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml;

namespace Servidor_Tienda_C
{
    public class Xml_Object
    {
        public string emisor_ip { get; set; }
        public string emisor_id { get; set; }
        public string emisor_tipo { get; set; }
        public string receptor_ip { get; set; }
        public string receptor_id { get; set; }
        public string receptor_tipo { get; set; }
        public string protocolo { get; set; }
        public string tipo { get; set; }


        public Xml_Object(string mensaje)
        {
            XmlDocument doc = new XmlDocument();
           // XmlDocument doc2 = new XmlDocument();
            var aux=doc.GetElementsByTagName("info_mensaje")[0];
           
            doc.LoadXml(mensaje);
            var info_emisor = doc.SelectNodes("/ack/info_mensaje/emisor")[0];
            this.emisor_ip = info_emisor["IP"].InnerText;
            Console.Write("Emisor_Ip:" + this.emisor_ip + "\n");

            this.emisor_id = info_emisor["ID"].InnerText;
            Console.Write("Emisor_id:" + this.emisor_id + "\n");

            this.emisor_tipo = info_emisor["tipo"].InnerText;
            Console.Write("Emisor_tipo:" + this.emisor_tipo + "\n");

            var info_receptor = doc.SelectNodes("/ack/info_mensaje/receptor")[0];
            this.receptor_ip = info_receptor["IP"].InnerText;
            Console.Write("Receptor_Ip:" + this.receptor_ip+"\n");

            this.receptor_id = info_receptor["ID"].InnerText;
            Console.Write("Receptor_ID:" + this.receptor_id + "\n");

            this.receptor_tipo = info_receptor["tipo"].InnerText;
            Console.Write("Receptor_tipo:" + this.receptor_tipo + "\n");

            this.protocolo = doc.SelectNodes("/ack/info_mensaje/protocolo")[0].InnerText;
            Console.Write("Protocolo:" + this.protocolo);
            
            this.tipo = doc.SelectNodes("/ack/info_mensaje/tipo")[0].InnerText;
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
    }
}
