<?php

require_once '../conectarBBDD.php';
$link = conexion();

if(!$link)
{
	die ("No se ha podido encontrar porque: ".mysql_error());
}


$sentencia = "SELECT COUNT(*) FROM Tiendas;";
$resultado = mysqli_query($link, $sentencia);
$n_tiendas = mysqli_fetch_array($resultado)[0]; // Numero de tiendas

$sentencia = "SELECT COUNT(*) FROM Compradores;";
$resultado = mysqli_query($link, $sentencia);
$n_comp    = mysqli_fetch_array($resultado)[0]; // Numero de compradores

echo "---------------------------------------------------------------------------------------------------------";
echo "<br>";
echo "<br>";
echo "TOTAL TIENDAS: "."<b>".$n_tiendas."</b>";
echo "<br>";
echo "<br>";
echo "---------------------------------------------------------------------------------------------------------";

$sentencia = "SELECT * FROM Tiendas;";
$resultado = mysqli_query($link, $sentencia);
$tiendas = mysqli_fetch_all($resultado);

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