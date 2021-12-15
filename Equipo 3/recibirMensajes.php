<?php
//Inicializamos variables.
$contT = 0;
$contC = 0;
$cont  = 0;
$n_mensajes=0;

//TOMAR MENSAJE CON EL POST.
$xml = simplexml_load_string($_POST['xml']);

//Obtenemos los datos que hay que guardar de los mensajes: IP emisor, contador, ID emisor, tipo emisor, IP receptor, ID recpetor, tipo receptor, protocolo, tipo de mensaje, detalles.  
//Obtenemos los datos del emisor (los índices indican dónde aparece cada atributo dentro del tipo en el XSD).
$ip_emisor = $xml -> infoMensaje -> emisor -> ip;
$id_emisor = $xml -> infoMensaje -> emisor -> id;
$tipo_emisor = $xml -> infoMensaje -> emisor -> tipo;

//Obtenemos los datos del receptor (los índices indican dónde aparece cada atributo dentro del tipo en el XSD).
$ip_receptor = $xml -> infoMensaje -> receptor -> ip;
$id_receptor = $xml -> infoMensaje -> receptor -> id;
$tipo_receptor = $xml -> infoMensaje -> receptor -> tipo;

//Obtenemos contador.
$contador = $xml -> infoMensaje -> id -> contador;

//Obtenemos protocolo.
$protocolo = $xml -> infoMensaje -> protocolo;

//Obtenemos tipo de mensaje.
$tipomsn = $xml -> infoMensaje -> tipo;

//TODO: FALTA DETALLES.
$detalles = "Detalles";

//Si es un MSI (mensaje de alta), vemos si es tienda o cliente y aumentamos el número de los mismos.
if($tipomsn=="MSI") {
    // Asigno ID cliente
    $cont = $cont + 1;
    $id_emisor = $cont;

    // Comprobamos si el mensaje de alta viene de un cliente o de una tienda.
    if ($tipo_emisor == "tienda") {
        $contT = $contT + 1;
    } else {
        $contC  = $contC + 1;
    }
}

// Añadimos los datos al ACK.

// Primero cargamos el fichero ACK.
$ack = simplexml_load_file('Mensajes/ack.xml');

// Una vez cargamos el fichero, cambiamos los datos por los que hemos calculado previamente.
$ack -> infoMensaje -> emisor -> ip = $ip_emisor;
$ack -> infoMensaje -> emisor -> id = $id_emisor;
$ack -> infoMensaje -> emisor -> tipo = $tipo_emisor;
$ack -> infoMensaje -> receptor -> ip = $ip_receptor;
$ack -> infoMensaje -> receptor -> id = $id_receptor;
$ack -> infoMensaje -> receptor -> tipo = $tipo_receptor;
$ack -> infoMensaje -> id -> ipEmisor = $ip_emisor;
$ack -> infoMensaje -> id -> contador = $n_mensajes;
$ack -> infoMensaje -> protocolo = $protocolo;
$ack -> infoMensaje -> tipo = 'ACK';
$ack -> tipoMensajePregunta = $tipomsn;
$ack -> idPregunta -> ipEmisor = $ip_emisor;
$ack -> idPregunta -> contador = $contador;

//Iniciamos la conexión con la BBDD.
require_once 'conectarBBDD.php';
$link = conexion();
error_log($id_emisor);
error_log($contador);
$sql="INSERT INTO Mensajes(ipE,cont,idE,tipoE,ipR,idR,tipoR,protocolo,tipoM,detalles) VALUES ('$ip_emisor',$contador,$id_emisor,'$tipo_emisor','$ip_receptor',$id_receptor,'$tipo_receptor','$protocolo','$tipomsn','$detalles');"; 
if (!mysqli_query($link, $sql)) {
    error_log('ERROR AL INSERTAR');//----------TODO: error al insertar info en bbdd
}

// Si tenemos un mensaje MSI mandamos un ACK como respuesta.
if($tipomsn=="MSI") {
    echo $ack-> asXML();
}

// Mensaje MEI
if($tipomsn=="MEI") {
    $sql = "SELECT COUNT(*) FROM MCIs";
    $resultado = mysqli_query($link, $sql);
    $existe_mci = mysqli_fetch_array($resultado)[0];
    error_log('\n\n'.$existe_mci);
    if($existe_mci > 0) {
        $sentencia = "SELECT mci FROM MCIs WHERE id=$id_emisor;";
        $resultado = mysqli_query($link, $sentencia);
        //var_dump($resultado);
        $mci= mysqli_fetch_array($resultado)[0];
        //$mci= mysqli_fetch_row($resultado);
        error_log($mci);
        echo $mci;
    }
    else {
        echo $ack-> asXML();
    }
}


//Dependiendo del tipo de mensaje, hacemos una cosa u otra.

//Si es un MFO
/*elseif ($tipomsn=="MFO") {
    if ($contT == NUM_TIENDAS and $contC == NUM_CLIENTES) {
        TODO
    }
    else if ($contT < NUM_TIENDAS) {
        echo("Esperando tiendas")
    }
    else if ($contC < NUM_CLIENTES) {
        echo("Esperando clientes)"
    }
}*/

//Insertamos en la BBDD "mensajes".
//$sql="INSERT INTO mensajes (ipemisor,contador,idemisor,tipoemisor,ipreceptor,idreceptor,tiporeceptor,protocolo,tipomsn) VALUES ($ip_emisor,$contador,$id_emisor,$tipo_emisor,$ip_receptor,$id_receptor,$tipo_receptor,$protocolo,$tipomsn)"; //FALTAN DETALLES. 
//$datos= my_sql_query($sql,$link);

/*if(!my_sql_query($sql, $link)) {
    //TODO ERROR
}*/

//echo xmlwriter_output_memory($xw);

?>