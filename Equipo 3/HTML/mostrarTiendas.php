<?php

// Primero conectamos con la BBDD.
require_once '../conectarBBDD.php';
$link = conexion();

// Comprobamos que hemos conectado con la BBDD correctamente.
if(!$link)
{
	die ("No se ha podido encontrar porque: ".mysql_error());
}

// Sacamos el número de tiendas.
$sentencia = "SELECT COUNT(*) FROM Tiendas;";
$resultado = mysqli_query($link, $sentencia);
$n_tiendas = mysqli_fetch_array($resultado)[0]; 

// Imprimimos el número de tiendas.
echo "---------------------------------------------------------------------------------------------------------";
echo "<br>";
echo "<br>";
echo "TOTAL TIENDAS: "."<b>".$n_tiendas."</b>";
echo "<br>";
echo "<br>";
echo "---------------------------------------------------------------------------------------------------------";

// Seleccionamos todas las tiendas.
$sentencia = "SELECT * FROM Tiendas;";
$resultado = mysqli_query($link, $sentencia);
$tiendas = mysqli_fetch_all($resultado);

// Por cada una de las tiendas, mostramos su información.
foreach ($tiendas as $una_tienda) {
    echo "<br>";
    echo "<br>";
    echo "NOMBRE TIENDA: "."<b>'".$una_tienda[1]."'</b>"." ID TIENDA: "."<b>'".$una_tienda[0]."'</b>"." IP TIENDA "."<b>'".$una_tienda[2]."'</b>";
    echo "<br>";
    echo "<br>";
    echo "---------------------------------------------------------------------------------------------------------";
}

// Cerramos la conexion de la BBDD
mysqli_close($link);
?>