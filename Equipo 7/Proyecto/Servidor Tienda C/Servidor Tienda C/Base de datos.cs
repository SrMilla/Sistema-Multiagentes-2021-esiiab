using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Servidor_Tienda_C
{
    public static class Base_de_datos
    {
        public static List<Producto> productos = new List<Producto>();
        public static List<tienda> tiendas = new List<tienda>();
        /// <summary>
        /// Sirve para añadir cantidades de un producto,si ya exite en la base de datos se incrementa su cantidad
        /// </summary>
        /// <param name="name">Nombre del producto que se va añadir</param>
        /// <param name="cantidad">Cantidad del producto que se va añadir</param>
        public static void añadir_bbdd(string name,int cantidad)
        {
            Producto aux = new(name, cantidad);
             int aux2 = 0;
            int inde = -1;
            foreach (Producto i in productos)
            {
                if (name == i.Nombre_producto)
                {
                    inde = aux2;
                }
                aux2 = aux2 + 1;
            }
            if (inde > -1)
            {
                productos[inde].Cantidad = productos[inde].Cantidad + cantidad;
            }
            else
            {
                productos.Add(aux);
            }
        }
        /// <summary>
        /// Quita n cantidades de un productos
        /// </summary>
        /// <param name="name">Nombre del producto que se quiere retirar</param>
        /// <param name="cantidad">Cantidad de productos que se quieren retirar </param>
        /// <returns>Devuelve si se puede quitar esos valores es decir que dice por ejemplo si se quiere quitar 3 platanos y solo hay dpos te dice que no</returns>
        public static bool quitar_bbdd(string name,int cantidad)
        {
            Producto aux = new(name, cantidad);
            int aux2 = 0;
            int inde = -1;
            foreach (Producto i in productos)
            {
                if (name == i.Nombre_producto)
                {
                    inde = aux2;
                }
                aux2 = aux2 + 1;
            }
                if (inde > -1)
                {
                    if (productos[inde].Cantidad >= cantidad)
                    {
                        productos[inde].Cantidad = productos[inde].Cantidad - cantidad;
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
                else {
                    return false;
                }
        }
        /// <summary>
        /// Crea una base de datos 
        /// </summary>
        public static void Creacion_BBDD()
        {
            List<string> listOfNames = new List<string>()
{
    "Perro",
    "Gato",
    "Perro",
    "Gazpacho"
};
            foreach (string i in listOfNames)
            {
                añadir_bbdd(i, 2);
            }
            Console.WriteLine('2');

        }
        public static void añadir_tienda(string ip,string id)
        {
            tienda aux = new(ip, id);
            tiendas.Add(aux);

        }
        public static void Creacion_BBDD_tienda()
        {
            List<string> list_IP = new List<string>()
            {
                "ip_1",
                "ip_2"
            };
            int t = 0;
            foreach(string i in list_IP)
            {
                añadir_tienda(i, t.ToString());
                t = t + 1;
            }
        }
        
    }
}
