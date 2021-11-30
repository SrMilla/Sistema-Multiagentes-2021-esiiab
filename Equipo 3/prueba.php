<?php
require 'conectarBBDD.php';
$link = conexion();
$sentencia = "INSERT INTO Productos(nombre,precio) VALUES ('p1',8)";
mysqli_query($link, $sentencia);

?>