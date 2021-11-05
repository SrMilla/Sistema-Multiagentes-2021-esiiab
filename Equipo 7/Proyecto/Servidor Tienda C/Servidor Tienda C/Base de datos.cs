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
    }
}
