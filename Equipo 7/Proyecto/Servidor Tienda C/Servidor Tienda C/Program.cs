using System;
using System.Threading;
using System.Xml;

namespace Servidor_Tienda_C
{
    class Program
    {
        public static void HiloServidor()
        {
            Console.WriteLine("Inicia el servidor");
            tcp.pro();
        }
        static void Main(string[] args)
        {
            Console.WriteLine("Hello World!");
            Thread HServidor = new Thread(new ThreadStart(HiloServidor));
            HServidor.Start();
        }
    }
}
