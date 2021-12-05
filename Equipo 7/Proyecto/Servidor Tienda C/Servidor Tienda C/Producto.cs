using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace Servidor_Tienda_C
{
    public class Producto
    {
        public Producto(string nombre_producto, int cantidad)
        {
            Nombre_producto = nombre_producto;
            Cantidad = cantidad;
        }

        public string Nombre_producto { get; set; }
        public int Cantidad { get; set; }
        

    }
}
