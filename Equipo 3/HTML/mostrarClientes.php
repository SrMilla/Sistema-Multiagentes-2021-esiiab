<?php

require_once '../conectarBBDD.php';
$link = conexion();

if(!$link)
{
	die ("No se ha podido encontrar porque: ".mysql_error());
}


$sentencia = "SELECT COUNT(*) FROM Compradores;";
$resultado = mysqli_query($link, $sentencia);
$n_compradores = mysqli_fetch_array($resultado)[0]; // Numero de tiendas

echo "---------------------------------------------------------------------------------------------------------";
echo "<br>";
echo "<br>";
echo "TOTAL COMPRADORES: "."<b>".$n_compradores."</b>";
echo "<br>";
echo "<br>";
echo "---------------------------------------------------------------------------------------------------------";

$sentencia = "SELECT * FROM Compradores;";
$resultado = mysqli_query($link, $sentencia);
$compradores = mysqli_fetch_all($resultado);

foreach ($compradores as $un_comprador) {
    echo "<br>";
    echo "<br>";
    echo "NOMBRE CLIENTE: "."<b>'".$un_comprador[1]."'</b>"." ID COMPRADOR: "."<b>'".$un_comprador[0]."'</b>"." IP COMPRADOR "."<b>'".$un_comprador[2]."'</b>";
    echo "<br>";
    echo "<br>";
    echo("TIENDAS ASIGNADAS: ");
    echo "<br>";
    echo "<br>";
    echo "TIENDA 1: "."<b>'".$un_comprador[3]."'</b>";
    echo "<br>";
    echo "<br>";
    echo "TIENDA 2: "."<b>'".$un_comprador[4]."'</b>";
    echo "<br>";
    echo "<br>";
    echo "---------------------------------------------------------------------------------------------------------";
}

// Cerramos la conexion de la BBDD
mysqli_close($link);


?>