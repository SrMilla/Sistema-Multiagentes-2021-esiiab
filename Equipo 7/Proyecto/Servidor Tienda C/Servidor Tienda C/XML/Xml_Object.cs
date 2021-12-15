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
        public XmlElement element1 { get; set; }
        public Xml_Object() { }
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
        public void obtener_valores(string tipo,string mensaje)
        {

            doc = new XmlDocument();
            doc.LoadXml(mensaje);
            XmlDocument doc2 = new XmlDocument();
            //doc.Load("prueba_Ack.xml");
            //doc.Load("prueba_error.xml");
            //doc.Load("prueba_mci.xml");
            var info_emisor2 = doc.SelectNodes("/" + tipo + "/infoMensaje/emisor");
            var info_emisor = doc.SelectNodes("/" + tipo + "/infoMensaje/emisor")[0];
            this.emisor_ip = info_emisor["ip"].InnerText;
            Console.Write("Emisor_Ip:" + this.emisor_ip + "\n");

            this.emisor_id = info_emisor["id"].InnerText;
            Console.Write("Emisor_id:" + this.emisor_id + "\n");

            this.emisor_tipo = info_emisor["tipo"].InnerText;
            Console.Write("Emisor_tipo:" + this.emisor_tipo + "\n");

            var info_receptor = doc.SelectNodes("/" + tipo + "/infoMensaje/receptor")[0];
            this.receptor_ip = info_receptor["ip"].InnerText;
            Console.Write("Receptor_Ip:" + this.receptor_ip + "\n");

            this.receptor_id = info_receptor["id"].InnerText;
            Console.Write("Receptor_ID:" + this.receptor_id + "\n");

            this.receptor_tipo = info_receptor["tipo"].InnerText;
            Console.Write("Receptor_tipo:" + this.receptor_tipo + "\n");

            this.protocolo = doc.SelectNodes("/" + tipo + "/infoMensaje/protocolo")[0].InnerText;
            Console.Write("Protocolo:" + this.protocolo + "\n");

            this.tipo = doc.SelectNodes("/" + tipo + "/infoMensaje/tipo")[0].InnerText;
            Console.Write("Tipo:" + this.tipo + "\n");

        }
        /*public void obtener_valores_ack(string mensaje)
        {
            obtener_valores("ack", mensaje);

        }*/
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
            posibles_tipos.Add("mae");
            string tipo = "";
            foreach(string i in posibles_tipos)
            {
                var aux = doc.SelectNodes("/"+i)[0];
                if (aux != null){
                    tipo = i;
                    this.tipo = tipo;
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
            if (tipo == "ack")
            {

            }
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

            this.element1 = this.doc.CreateElement(string.Empty, "info_mensaje", string.Empty);
            this.enunciado.AppendChild(this.element1);

            XmlElement emisor = this.doc.CreateElement(string.Empty, "emisor", string.Empty);
            this.element1.AppendChild(emisor);
           
            XmlElement receptor = this.doc.CreateElement(string.Empty, "receptor", string.Empty);
            this.element1.AppendChild(receptor);


            /*EMISOR_INFO_MENSAJE*/


            XmlElement e_ip = this.doc.CreateElement(string.Empty, "ip", string.Empty);
            emisor.AppendChild(e_ip);

            XmlText e_ip_te = this.doc.CreateTextNode(this.emisor_ip);
            e_ip.AppendChild(e_ip_te);

            XmlElement e_id = this.doc.CreateElement(string.Empty, "id", string.Empty);
            emisor.AppendChild(e_id);

            XmlText e_id_te = this.doc.CreateTextNode(this.emisor_id);
            e_id.AppendChild(e_id_te);

            XmlElement e_tipo = this.doc.CreateElement(string.Empty, "tipo", string.Empty);
            emisor.AppendChild(e_tipo);

            XmlText e_tipo_te = this.doc.CreateTextNode(this.emisor_tipo);
            e_tipo.AppendChild(e_tipo_te);

            
            /*RECEPTOR_INFO_MENSAJE*/


            XmlElement r_ip = this.doc.CreateElement(string.Empty, "ip", string.Empty);
            receptor.AppendChild(r_ip);

            XmlText r_ip_te = this.doc.CreateTextNode(this.receptor_ip);
            r_ip.AppendChild(r_ip_te);

            XmlElement r_id = this.doc.CreateElement(string.Empty, "id", string.Empty);
            receptor.AppendChild(r_id);

            XmlText r_id_te = this.doc.CreateTextNode(this.receptor_id);
            r_id.AppendChild(r_id_te);

            XmlElement r_tipo = this.doc.CreateElement(string.Empty, "tipo", string.Empty);
            receptor.AppendChild(r_tipo);

            XmlText r_tipo_te = this.doc.CreateTextNode(this.receptor_tipo);
            r_tipo.AppendChild(r_tipo_te);

            // ID
            XmlElement id_g = this.doc.CreateElement(string.Empty, "id", string.Empty);
            this.element1.AppendChild(id_g);

            XmlElement ip_em_id = this.doc.CreateElement(string.Empty, "ipEmisor", string.Empty);
            id_g.AppendChild(ip_em_id);

            XmlText ip_em_id_valor = this.doc.CreateTextNode("ipEMISOR");
            ip_em_id.AppendChild(r_tipo_te);

            XmlElement contador = this.doc.CreateElement(string.Empty, "contador", string.Empty);
            id_g.AppendChild(ip_em_id);

            XmlText contador_v = this.doc.CreateTextNode("contador v");
            contador.AppendChild(contador_v);

            // Protocolo y tipo

            XmlElement protocolo = this.doc.CreateElement(string.Empty, "protocolo", string.Empty);
            element1.AppendChild(protocolo);

            XmlText protocolo_v = this.doc.CreateTextNode("protocolo v");
            protocolo.AppendChild(protocolo_v);

            XmlElement tipo = this.doc.CreateElement(string.Empty, "tipo", string.Empty);
            element1.AppendChild(tipo);

            XmlText tipo_v = this.doc.CreateTextNode(this.tipo);
            tipo.AppendChild(tipo_v);



            //var t=doc.ToString();
            /*FIN INFO MENSAJE*/
            doc.Save(".XMLFile2.xml");
            //this.doc = doc;
            return doc;
        }
    }
}
