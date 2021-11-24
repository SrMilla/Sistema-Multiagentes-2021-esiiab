<?php
// Cabeceras para deshabilitar el CORs en php
header("Access-Control-Allow-Origin: *");
header('Content-type: application/xml');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization, X-Requested-With');
http_response_code(200);

// A la escucha...
$url = "php://input";
$miXml = $_POST[mensaje];


//Iniciamos la conexión con la bbdd
$server="localhost";
$db_username="root";
$db_password='';
$database="bbdd";
$link = mysqli_connect("$server","$db_username","$db_password") or die ("Imposible conectar a mySQL database");
$a= mysqli_select_db($link,"$database") or die("No se pudo conectar a la base de datos");
$conexion = mysql_connect("localhost","root","");
if(!$conexion)
{
	die ("No se ha podido encontrar porque: ".mysql_error());
}
mysql_select_db("multi",$conexion);

$xmlDoc = new DOMDocument();
$xmlDoc->load($miXml);

// Obtenemos la raiz del xml de respuesta
$raiz = $xmlDoc->documentElement;

?>