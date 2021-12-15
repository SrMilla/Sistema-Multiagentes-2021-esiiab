<?php

require_once '../conectarBBDD.php';
$link = conexion();

if(!$link)
{
	die ("No se ha podido encontrar porque: ".mysql_error());
}


$sentencia = "SELECT COUNT(*) FROM Mensajes;";
$resultado = mysqli_query($link, $sentencia);
$n_mensajes = mysqli_fetch_array($resultado)[0]; // Numero de tiendas

echo "---------------------------------------------------------------------------------------------------------";
echo "<br>";
echo "<br>";
echo "TOTAL MENSAJES: "."<b>".$n_mensajes."</b>";
echo "<br>";
echo "<br>";
echo "---------------------------------------------------------------------------------------------------------";

$sentencia = "SELECT * FROM Mensajes;";
$resultado = mysqli_query($link, $sentencia);
$mensajes = mysqli_fetch_all($resultado);

foreach ($mensajes as $un_mensaje) {
    echo "<br>";
    echo "<br>";
    echo "EMISOR: IP EMISOR: "."<b>'".$un_mensaje[0]."'</b>"." ID EMISOR "."<b>'".$un_mensaje[2]."'</b>"." TIPO EMISOR: "."<b>'".$un_mensaje[3]."'</b>"." CONTADOR: "."<b>'".$un_mensaje[1]."'</b>";
    echo "<br>";
    echo "<br>";
    echo "RECEPTOR: IP RECEPTOR: "."<b>'".$un_mensaje[4]."'</b>"." ID RECEPTOR "."<b>'".$un_mensaje[5]."'</b>"." TIPO RECEPTOR: "."<b>'".$un_mensaje[6]."'</b>";
    echo "<br>";
    echo "<br>";
    echo "PROTOCOLO: "."<b>'".$un_mensaje[7]."'</b>";
    echo "<br>";
    echo "<br>";
    echo "TIPO DE MENSAJE: "."<b>'".$un_mensaje[8]."'</b>";
    echo "<br>";
    echo "<br>";
    echo "DETALLES: "."<b>'".$un_mensaje[9]."'</b>";
    echo "<br>";
    echo "<br>";
    echo "---------------------------------------------------------------------------------------------------------";
}

// Cerramos la conexion de la BBDD
mysqli_close($link);


?>