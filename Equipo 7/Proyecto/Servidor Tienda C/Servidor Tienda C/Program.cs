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
                    Thread hilo_tratamiento = new Thread(new ThreadStart(tratamiento));
                    hilo_tratamiento.Start();
                }
               
            }
        }
        /// <summary>
        /// Esta funcion lo que hace es buscar el primer mensaje que no se haya tratado
        /// </summary>
        /// 
        
        public static void tratamiento()
        {
            bool epicardo = false;
            int inde = 0;
            var mensaje = new Mensajes();
            while (VGlobal.semaforo_buffer)
            {
                Console.WriteLine("Esperando a que nadie opere con el buffer");
            }
            VGlobal.semaforo_buffer = true;
            while (!epicardo)
            {
                if (!VGlobal.MensajesBuffer[inde-1].tratado)
                {
                    epicardo = true;
                    VGlobal.MensajesBuffer[inde].tratado = true;
                    mensaje = VGlobal.MensajesBuffer[inde];
                }
                else
                {
                    inde = +1;
                }
            }
            VGlobal.semaforo_buffer = false;


            //VGlobal.MensajeActual=VGlobal.MensajesBuffer[0];
            //VGlobal.Mensaje_tratado = new Xml_Object(VGlobal.MensajeActual.mensaje);//Guardamos el mensaje como mensaje objeto XML
            /*Tratamiento de datos*/
           /* if (VGlobal.Mensaje_tratado.tipo == "lista_productos")
            {
                
            }*/
            //tcp.broadcast(VGlobal.Mensaje_tratado.tipo, VGlobal.MensajeActual.Endpoint_Cliente);
            VGlobal.MensajesBuffer.RemoveAt(0);

        }
        public static void tratamiento2()
        {
            while (true)
            {
                while (VGlobal.MensajesBuffer.Count > 0)
                {
                    VGlobal.MensajeActual = VGlobal.MensajesBuffer[0];
                    // tipo_mensaje();
                    //VGlobal.Mensaje_tratado = new XML_ack(VGlobal.MensajeActual.mensaje);
                    var aux = tipo_mensaje(VGlobal.MensajeActual.mensaje);
                    //var aux = "mei";
                    switch (aux)
                    {
                        case "mci":
                            Console.WriteLine("Se ha recivido un mensaje " + aux + " que contiene:" + "\n");
                            VGlobal.Mensaje_tratado = new XML_mci(VGlobal.MensajeActual.mensaje);
                            break;
                        case "mei":
                            Console.WriteLine("Se ha recivido un mensaje " + aux + " que contiene:" + "\n");
                            VGlobal.Mensaje_tratado = new XML_mei(VGlobal.MensajeActual.mensaje);
                            break;
                        case "ack":
                            Console.WriteLine("Se ha recivido un mensaje " + aux + " que contiene:" + "\n");
                            VGlobal.Mensaje_tratado = new XML_ack(VGlobal.MensajeActual.mensaje);
                            break;

                    }
                    VGlobal.MensajesBuffer.RemoveAt(0);
                }
            }
            //VGlobal.Mensaje_tratado = new XML_mci(VGlobal.MensajeActual.mensaje);
            
            
        } 
        public static string tipo_mensaje(string mensaje)
        {
            var doc = new XmlDocument();
            doc.LoadXml(mensaje);
            var t = doc.InnerXml;
            return doc.SelectNodes("/")[0].LastChild.Name;
            
        }
        public static void rellenar_buffer_prueba()
        {
            System.Net.EndPoint x = (EndPoint)new IPEndPoint(IPAddress.Any, 0);
            string mensaje = "WILLEM DAFOE";
            var doc = new XmlDocument();

            doc.Load("prueba_mci.xml");
            var t = doc.InnerXml;

            VGlobal.añadirBuffer(x,t);
            doc.Load("prueba_Ack.xml");
            t = doc.InnerXml;
            VGlobal.añadirBuffer(x, t);
            
            doc.Load("prueba_mei.xml");
            t = doc.InnerXml;
            VGlobal.añadirBuffer(x, t);

            tratamiento2();
            //VGlobal.añadirBuffer(x, mensaje);

            Console.WriteLine("Inicia la prueba");

        }
        static void Main(string[] args)
        {
            Console.WriteLine("Hello World!");
            Thread C_buffer = new Thread(new ThreadStart(comprobar_buffer));
            
                 Thread trata2 = new Thread(new ThreadStart(tratamiento2));
            Thread HServidor = new Thread(new ThreadStart(HiloServidor));
            Thread Pruebas = new Thread(new ThreadStart(rellenar_buffer_prueba));
            //C_buffer.Start();
            HServidor.Start();
                trata2.Start();
            //Pruebas.Start();
            //var t = new Xml_Object(VGlobal.mensaje_prueba.ToString());
            Base_de_datos.Creacion_BBDD();
            /*string t = "1";
            var aux = new XML_lista_compra(t,t,t,t,t,t,t,"Lista_de_compra");
            aux.generar_xml();*/
            String t = "1";
            var aux = new XML_error(t, t, t, t, t, t, t, "error");
            aux.generar_xml("saboir"); 
        }
    }
}
