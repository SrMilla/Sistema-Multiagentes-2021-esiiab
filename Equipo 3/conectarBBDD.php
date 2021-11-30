<?php
function conexion(){
    //Iniciamos la conexión con la bbdd
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database="bbdd";
    // Create connection
    $link = mysqli_connect($servername, $username, $password) or die ("Imposible conectar a mySQL database");

    // Check connection
    if (!$link) {
        die("Connection failed: " . mysqli_connect_error());
    }
    mysqli_select_db($link,$database);
    return $link;
}
?>