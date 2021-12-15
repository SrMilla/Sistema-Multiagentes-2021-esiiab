using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Servidor_Tienda_C.XML
{
    class XML_mei : Xml_Object
    {
        public XML_mei(string mensaje)
        {
            obtener_valores("mei", mensaje);
        }
        public void generar_xml()
        {
            this.doc = this.crear_xml();

        }
    }
   
}
