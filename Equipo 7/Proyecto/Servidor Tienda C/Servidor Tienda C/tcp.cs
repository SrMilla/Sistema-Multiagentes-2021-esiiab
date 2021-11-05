using System;
using System.Collections.Generic;
using System.Linq;
using System.Net;
using System.Net.Sockets;
using System.Text;
using System.Threading;
using System.Threading.Tasks;

namespace Servidor_Tienda_C
{
    class tcp
    {
        static readonly object _lock = new object();
        static readonly Dictionary<int, TcpClient> list_clients = new Dictionary<int, TcpClient>();
        public static void pro()
        {
            int count = 1;

            TcpListener ServerSocket = new TcpListener(IPAddress.Any, 8010);
            ServerSocket.Start();

            while (true)
            {
                TcpClient client = ServerSocket.AcceptTcpClient();
                lock (_lock) list_clients.Add(count, client);
                Console.WriteLine("Someone connected!!");

                Thread t = new Thread(handle_clients);
                t.Start(count);
                count++;
            }
        }

            public static void handle_clients(object o)
        {
            int id = (int)o;
            TcpClient client;
            
            lock (_lock) client = list_clients[id];

            while (true)
            {
                NetworkStream stream = client.GetStream();
                byte[] buffer = new byte[1024];
                int byte_count = stream.Read(buffer, 0, buffer.Length);

                if (byte_count == 0)
                {
                    break;
                }
                var t = client;
                System.Net.EndPoint x = t.Client.RemoteEndPoint;

                string data = Encoding.ASCII.GetString(buffer, 0, byte_count);
                // VGlobal.MensajesBuffer.Append(x, data));
                VGlobal.añadirBuffer(x, data);
                //broadcast(data, x);
                //Console.WriteLine(cl);
                Console.WriteLine("Se ha recibido el dato:" + data + "id:" + id);
                
            }

            lock (_lock) list_clients.Remove(id);
            client.Client.Shutdown(SocketShutdown.Both);
            client.Close();
        }
        public static void broadcast(string data, System.Net.EndPoint mensajero)
        {
            byte[] buffer = Encoding.ASCII.GetBytes("Recibimos: " + data + Environment.NewLine);

            lock (_lock)
            {
                foreach (TcpClient c in list_clients.Values)
                {
                    NetworkStream stream = c.GetStream();
                    if (mensajero == c.Client.RemoteEndPoint)
                    {


                        //se da respuesta al cliente
                        stream.Write(buffer, 0, buffer.Length);
                        Console.WriteLine("Mensaje enviado a " + c.Client.RemoteEndPoint.ToString());
                    }
                    //stream.Write(buffer, 0, buffer.Length);
                    //Console.WriteLine("Mensaje enviado a " + c.Client.RemoteEndPoint.ToString());
                }
            }
        }
        public static void enviar_a_todos(string data)
        {
            byte[] buffer = Encoding.ASCII.GetBytes("Recibimos: " + data + Environment.NewLine);

            lock (_lock)
            {
                foreach (TcpClient c in list_clients.Values)
                {
                    NetworkStream stream = c.GetStream();
                    stream.Write(buffer, 0, buffer.Length);
                    Console.WriteLine("Mensaje enviado a " + c.Client.RemoteEndPoint.ToString());
                }
            }
        }
    }
}
