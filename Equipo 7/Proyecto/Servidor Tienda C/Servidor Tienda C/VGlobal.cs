using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Net;
using System.Xml;

namespace Servidor_Tienda_C
{
    public static class VGlobal
    {
        public static List<Mensajes> MensajesBuffer = new List<Mensajes>();
        public static Mensajes MensajeActual { get; set; }
        public static void añadirBuffer(EndPoint endpoint_Cliente, string mensaje)
        {
            var aux2 = VGlobal.mensaje_prueba;
            Mensajes aux = new(endpoint_Cliente, mensaje);
            MensajesBuffer.Add(aux);
        }
        public static string mensaje_prueba = "<?xml version=\"1.0\"?><!--ACK--><!--¿Cómo poner referencia a squema?--><ack>	<info_mensaje>		<emisor>			<IP>192.0.2.1</IP>			<ID>0</ID>			<tipo>monitor</tipo>		</emisor>		<receptor>			<IP>192.0.2.2</IP>			<ID>2</ID>			<tipo>tienda</tipo>		</receptor>		<id>			<ipemisor>192.0.2.1</ipemisor>			<contador>2</contador>		</id>		<protocolo>alta</protocolo>		<tipo>ACK</tipo>	</info_mensaje>	<tipo_mensaje>MSI</tipo_mensaje>	<!--Tipo del mensaje al que responde-->	<id_mensaje>		<!--Id del mensaje al que responde-->		<ipemisor>192.0.2.2</ipemisor>		<contador>1</contador>	</id_mensaje></ack>";

    }

}
