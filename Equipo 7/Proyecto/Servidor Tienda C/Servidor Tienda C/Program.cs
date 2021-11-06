using System;
using System.Net;
using System.Threading;
using System.Xml;
using Servidor_Tienda_C.XML;
namespace Servidor_Tienda_C
{
    class Program
    {
        public static void HiloServidor()
        {
            Console.WriteLine("Inicia el servidor");
            tcp.pro();
        }
        public static void comprobar_buffer()
        {
            while (true)
            {
                //Console.WriteLine("pepe");
               if(VGlobal.MensajesBuffer.Count != 0)
                {
                    Console.Write("Se empieza tratamiento de mensaje");
                    //tratamiento();
                }
               
            }
        }
        public static void tratamiento()
        {
            VGlobal.MensajeActual=VGlobal.MensajesBuffer[0];
            VGlobal.Mensaje_tratado = new Xml_Object(VGlobal.MensajeActual.mensaje);//Guardamos el mensaje como mensaje objeto XML
            /*Tratamiento de datos*/
            //tcp.broadcast(VGlobal.Mensaje_tratado.tipo, VGlobal.MensajeActual.Endpoint_Cliente);
            VGlobal.MensajesBuffer.RemoveAt(0);

        }
        public static void rellenar_buffer_prueba()
        {
            System.Net.EndPoint x = (EndPoint)new IPEndPoint(IPAddress.Any, 0);
            string mensaje = "WILLEM DAFOE";
            VGlobal.añadirBuffer(x, VGlobal.mensaje_prueba.ToString());
            tratamiento();
            //VGlobal.añadirBuffer(x, mensaje);

            Console.WriteLine("Inicia la prueba");

        }
        static void Main(string[] args)
        {
            Console.WriteLine("Hello World!");
            Thread C_buffer = new Thread(new ThreadStart(comprobar_buffer));
            Thread HServidor = new Thread(new ThreadStart(HiloServidor));
            Thread Pruebas = new Thread(new ThreadStart(rellenar_buffer_prueba));
            // C_buffer.Start();
            //HServidor.Start();
            Pruebas.Start();
            //var t = new Xml_Object(VGlobal.mensaje_prueba.ToString());
            Base_de_datos.Creacion_BBDD();
            /*string t = "1";
            var aux = new XML_lista_compra(t,t,t,t,t,t,t,"Lista_de_compra");
            aux.generar_xml();*/
        }
    }
}
