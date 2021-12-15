<?php

// Primero conectamos con la BBDD.
require_once '../conectarBBDD.php';
$link = conexion();

// Comprobamos que hemos conectado con la BBDD correctamente.
if(!$link)
{
	die ("No se ha podido encontrar porque: ".mysql_error());
}

// Sacamos el número de mensajes.
$sentencia = "SELECT COUNT(*) FROM Mensajes;";
$resultado = mysqli_query($link, $sentencia);
$n_mensajes = mysqli_fetch_array($resultado)[0]; 

// Imprimimos el número de mensajes.
echo "---------------------------------------------------------------------------------------------------------";
echo "<br>";
echo "<br>";
echo "TOTAL MENSAJES: "."<b>".$n_mensajes."</b>";
echo "<br>";
echo "<br>";
echo "---------------------------------------------------------------------------------------------------------";

// Seleccionamos todos los mensajes.
$sentencia = "SELECT * FROM Mensajes;";
$resultado = mysqli_query($link, $sentencia);
$mensajes = mysqli_fetch_all($resultado);

// Por cada uno de los mensajes, mostramos su información.
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