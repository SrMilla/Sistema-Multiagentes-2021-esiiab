using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Xml;

namespace Servidor_Tienda_C.XML
{
    class XML_lista_compra : Xml_Object
    {
        public XML_lista_compra(string emisor_ip, string emisor_id, string emisor_tipo, string receptor_ip, string receptor_id, string receptor_tipo, string protocolo, string tipo) : base(emisor_ip, emisor_id, emisor_tipo, receptor_ip, receptor_id, receptor_tipo, protocolo, tipo)
        {
        }
        public void generar_xml()
        {
            this.doc = this.crear_xml();

            
            XmlElement Lista_de_la_compra = this.doc.CreateElement(string.Empty, "Lista_de_la_compra", string.Empty);
            this.enunciado.AppendChild(Lista_de_la_compra);
            foreach (Producto i in Base_de_datos.productos)
            {
                /*Generamos producto*/
                XmlElement producto = doc.CreateElement(string.Empty, "producto", string.Empty);
                Lista_de_la_compra.AppendChild(producto);
                /*Nombre producto*/
                XmlElement name_producto = doc.CreateElement(string.Empty, "nombre_producto", string.Empty);
                producto.AppendChild(name_producto);
                
                XmlText name_producto_p = this.doc.CreateTextNode(i.Nombre_producto);
                name_producto.AppendChild(name_producto_p);
                /*Cantidad*/
                XmlElement cantidad_producto = doc.CreateElement(string.Empty, "cantidad_producto", string.Empty);
                producto.AppendChild(cantidad_producto);

                XmlText cantidad_producto_p = this.doc.CreateTextNode(i.Cantidad.ToString());
                cantidad_producto.AppendChild(cantidad_producto_p);
                /*Precio*/
                XmlElement precio_producto = doc.CreateElement(string.Empty, "precio_producto", string.Empty);
                producto.AppendChild(precio_producto);

                XmlText precio_producto_p = this.doc.CreateTextNode("precio");
                precio_producto.AppendChild(precio_producto_p);
            }
            

            this.doc.Save(".XMLFile2.xml");
        }
    }
}
