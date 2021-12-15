using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml;

namespace Servidor_Tienda_C.XML
{
    class XML_mci : Xml_Object

    {
        public List<Producto> Productos{get;set;}
        public List<tienda> tiendas { get; set; }
        public XML_mci(string emisor_ip, string emisor_id, string emisor_tipo, string receptor_ip, string receptor_id, string receptor_tipo, string protocolo, string tipo) : base(emisor_ip, emisor_id, emisor_tipo, receptor_ip, receptor_id, receptor_tipo, protocolo, tipo)
        {
        }
        public XML_mci(string mensaje)
        {
            obtener_valores("mci", mensaje);
            var lista_productos = this.doc.SelectNodes("/" + "mci" + "/listaProductos")[0].ChildNodes;

            for (int i = 0; i < lista_productos.Count; i++)
            {
                var nombre_p = lista_productos[i]["nombre"].InnerText;
                var id = lista_productos[i]["id"].InnerText;
                var cantidad = lista_productos[i]["cantidad"].InnerText;
                var precio = lista_productos[i]["precio"].InnerText;
                Console.Write("Producto:" + nombre_p + "," + id + "," + cantidad + "," + precio + "\n");
            }
            var lista_tiendas = this.doc.SelectNodes("/" + "mci" + "/listaTiendas")[0].ChildNodes;
            for (int i = 0; i < lista_tiendas.Count; i++)
            {
                var ip = lista_tiendas[i]["ip"].InnerText;
                var id = lista_tiendas[i]["id"].InnerText;
                Console.Write("Id tienda:" + id + "\n");
                Console.Write("Ip tienda:" + ip + "\n");

                var t = 0;
            }
            /*this.tipomen = this.doc.SelectNodes("/" + "ack" + "/tipoMensajePregunta")[0].InnerText;

            this.ipEmisorAck = this.doc.SelectNodes("/" + "ack" + "/idPregunta")[0]["ipEmisor"].InnerText;
            this.contador = this.doc.SelectNodes("/" + "ack" + "/idPregunta")[0]["contador"].InnerText;
            var t = 0;
            Console.Write("Tipo mensaje:" + this.tipomen + "\n");
            Console.Write("Ip Emisor Ack:" + this.ipEmisorAck + "\n");
            Console.Write("ontador:" + this.contador + "\n");*/
        }
        public void generar_xml()
        {
            //LISTA DE LA COMPRA
            XmlElement Lista_de_la_compra = this.doc.CreateElement(string.Empty, "listaProductos", string.Empty);
            this.enunciado.AppendChild(Lista_de_la_compra);
            foreach (Producto i in Base_de_datos.productos)
            {
                /*Generamos producto*/
                XmlElement producto = doc.CreateElement(string.Empty, "producto", string.Empty);
                Lista_de_la_compra.AppendChild(producto);
                /*Nombre producto*/
                XmlElement name_producto = doc.CreateElement(string.Empty, "nombre", string.Empty);
                producto.AppendChild(name_producto);

                XmlText name_producto_p = this.doc.CreateTextNode(i.Nombre_producto);
                name_producto.AppendChild(name_producto_p);
                /*Cantidad*/
                XmlElement cantidad_producto = doc.CreateElement(string.Empty, "cantidad", string.Empty);
                producto.AppendChild(cantidad_producto);

                XmlText cantidad_producto_p = this.doc.CreateTextNode(i.Cantidad.ToString());
                cantidad_producto.AppendChild(cantidad_producto_p);
                /*Precio*/
                XmlElement precio_producto = doc.CreateElement(string.Empty, "precio", string.Empty);
                producto.AppendChild(precio_producto);

                XmlText precio_producto_p = this.doc.CreateTextNode("precio");
                precio_producto.AppendChild(precio_producto_p);
            }
            //LISTA DE TIENDAS
            XmlElement Lista_de_tiendas = this.doc.CreateElement(string.Empty, "Lista_de_la_compra", string.Empty);
            this.enunciado.AppendChild(Lista_de_tiendas);
            foreach (tienda i in Base_de_datos.tiendas)
            {
                /*Generamos producto*/
                XmlElement tiendac = doc.CreateElement(string.Empty, "tienda", string.Empty);
                Lista_de_la_compra.AppendChild(tiendac);
                /*IP tienda*/
                XmlElement tienda_ip = doc.CreateElement(string.Empty, "ip", string.Empty);
                tiendac.AppendChild(tienda_ip);

                XmlText tienda_ip_p = this.doc.CreateTextNode(i.ip_tienda);
                tienda_ip.AppendChild(tienda_ip_p);
                /*Cantidad*/
                XmlElement tienda_id = doc.CreateElement(string.Empty, "id", string.Empty);
                tiendac.AppendChild(tienda_id);

                XmlText tienda_id_v = this.doc.CreateTextNode(i.id_tienda);
                tienda_id.AppendChild(tienda_id_v);
                
            }
        }
    }
}
