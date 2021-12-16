<?php
// Iniciamos la conexión con la BBDD.
require_once 'conectarBBDD.php';
$link = conexion();

// Inicializamos variables.
$sentencia = "SELECT n_mensajes FROM Variables_Globales WHERE NumeroFila=1;";
$resultado = mysqli_query($link, $sentencia);
$n_mensajes = mysqli_fetch_array($resultado)[0]; // Contador de mensajes que envia el monitor


// Obtenemos el número de tiendas y consumidores
$sentencia = "SELECT contT FROM Variables_Globales WHERE NumeroFila=1;";
$resultado = mysqli_query($link, $sentencia);
$contT = mysqli_fetch_array($resultado)[0]; // Contador de tiendas
$sentencia = "SELECT contC FROM Variables_Globales WHERE NumeroFila=1;";
$resultado = mysqli_query($link, $sentencia);
$contC = mysqli_fetch_array($resultado)[0]; // Contador de consumidores
$cont  = $contT + $contC;

// Tomamos el mensaje con el POST.
$xml = simplexml_load_string($_POST['xml']);

// Obtenemos los datos que hay que guardar de los mensajes: IP emisor, contador, ID emisor, tipo emisor, IP receptor, ID recpetor, tipo receptor, protocolo, tipo de mensaje, detalles.  
// Obtenemos los datos del emisor (los índices indican dónde aparece cada atributo dentro del tipo en el XSD).
$ip_emisor = $xml -> infoMensaje -> emisor -> ip;
$id_emisor = $xml -> infoMensaje -> emisor -> id;
$tipo_emisor = $xml -> infoMensaje -> emisor -> tipo;

// Obtenemos los datos del receptor (los índices indican dónde aparece cada atributo dentro del tipo en el XSD).
$ip_receptor = $xml -> infoMensaje -> receptor -> ip;
$id_receptor = $xml -> infoMensaje -> receptor -> id;
$tipo_receptor = $xml -> infoMensaje -> receptor -> tipo;

// Obtenemos contador.
$contador = $xml -> infoMensaje -> id -> contador;

// Obtenemos protocolo.
$protocolo = $xml -> infoMensaje -> protocolo;

// Obtenemos tipo de mensaje.
$tipomsn = $xml -> infoMensaje -> tipo;

// Obtenemos el resto del mensaje.
$detalles = "Detalles";

// Si es un MSI (mensaje de alta), vemos si es tienda o cliente y aumentamos el número de sus contadores.
if($tipomsn=="MSI") {
    // Asigno ID cliente
    $cont = $cont + 1;
    $id_emisor = $cont;

    // Comprobamos si el mensaje de alta viene de un cliente o de una tienda.
    if ($tipo_emisor == "tienda") {
        $contT = $contT + 1;
        $sentencia = "INSERT INTO Variables_Globales(contT) VALUES ($contT);";
        mysqli_query($link, $sentencia);
    } else {
        $contC  = $contC + 1;
        $sentencia = "INSERT INTO Variables_Globales(contC) VALUES ($contC);";
        mysqli_query($link, $sentencia);
    }
}

$sql="INSERT INTO Mensajes(ipE,cont,idE,tipoE,ipR,idR,tipoR,protocolo,tipoM,detalles) VALUES ('$ip_emisor',$contador,$id_emisor,'$tipo_emisor','$ip_receptor',$id_receptor,'$tipo_receptor','$protocolo','$tipomsn','$detalles');"; 

// En caso de que se haya dado algún erro al insertar los datos, lo mostramos por pantalla.
if (!mysqli_query($link, $sql)) {
    error_log('ERROR AL INSERTAR');
}

if($tipomsn=="MSI" or $tipomsn=="MFO" or $tipomsn=="MEI"){
    // Añadimos los datos al ACK.
    // Primero cargamos el fichero ACK.
    $ack = simplexml_load_file('Mensajes/ack.xml');

    // Una vez cargamos el fichero, cambiamos los datos por los que hemos calculado previamente.
    $ack -> infoMensaje -> emisor -> ip = $ip_receptor;
    $ack -> infoMensaje -> emisor -> id = $id_receptor;
    $ack -> infoMensaje -> emisor -> tipo = $tipo_receptor;
    $ack -> infoMensaje -> receptor -> ip = $ip_emisor;
    $ack -> infoMensaje -> receptor -> id = $id_emisor;
    $ack -> infoMensaje -> receptor -> tipo = $tipo_emisor;
    $ack -> infoMensaje -> id -> ipEmisor = $ip_receptor;
    $ack -> infoMensaje -> id -> contador = $n_mensajes;
    $ack -> infoMensaje -> protocolo = $protocolo;
    $ack -> infoMensaje -> tipo = 'ACK';
    $ack -> tipoMensajePregunta = $tipomsn;
    $ack -> idPregunta -> ipEmisor = $ip_emisor;
    $ack -> idPregunta -> contador = $contador;

    switch($tipomsn){
        case 'MFO':
            if($tipo_emisor == 'tienda'){
                $sentencia = "UPDATE Tiendas SET active=0 WHERE id = ".$id_emisor.";";
                if (!mysqli_query($link, $sentencia)) {
                    error_log('ERROR AL UPDATEAR');
                }
            } else {
                $sentencia = "UPDATE Compradores SET active=0 WHERE id = ".$id_emisor.";";
                if (!mysqli_query($link, $sentencia)) {
                    error_log('ERROR AL UPDATEAR');
                }
            }
        case 'MSI':
            echo $ack-> asXML();
            $sql="INSERT INTO Mensajes(ipE,cont,idE,tipoE,ipR,idR,tipoR,protocolo,tipoM,detalles) VALUES ('$ip_receptor',$n_mensajes,$id_receptor,'$tipo_receptor','$ip_emisor',$id_emisor,'$tipo_emisor','$protocolo','ACK','$detalles');"; 
            // En caso de que se haya dado algún erro al insertar los datos, lo mostramos por pantalla.
            if (!mysqli_query($link, $sql)) {
                error_log('ERROR AL INSERTAR');
            }
            // Updateamos el número de mensajes
            $sentencia = "INSERT INTO Variables_Globales(n_mensajes) VALUES ($n_mensajes+1);";
            mysqli_query($link, $sentencia);
            break;

        case 'MEI':
            // Comprobamos si ya se han asignado las listas de productos y tiendas
            // (si ya estan generados los MCIs)
            $sql = "SELECT COUNT(*) FROM MCIs";
            $resultado = mysqli_query($link, $sql);
            $existe_mci = mysqli_fetch_array($resultado)[0];

            // En caso de que ya tengamos MCIs, mandamos un MCI al emisor como respuesta.
            if($existe_mci > 0) {
                // Tomamos el MCI que corresponde al emisor.
                $sentencia = "SELECT mci FROM MCIs WHERE id=$id_emisor;";
                $resultado = mysqli_query($link, $sentencia);
                $mci= mysqli_fetch_array($resultado)[0];
                error_log($mci);
                echo $mci;
            }
            // En caso de que no tengamos MCIs, mandamos un ACK.
            else {
                echo $ack-> asXML();
                $sql="INSERT INTO Mensajes(ipE,cont,idE,tipoE,ipR,idR,tipoR,protocolo,tipoM,detalles) VALUES ('$ip_receptor',$n_mensajes,$id_receptor,'$tipo_receptor','$ip_emisor',$id_emisor,'$tipo_emisor','$protocolo','ACK','$detalles');"; 
                // En caso de que se haya dado algún erro al insertar los datos, lo mostramos por pantalla.
                if (!mysqli_query($link, $sql)) {
                    error_log('ERROR AL INSERTAR');
                }
                // Updateamos el número de mensajes
                $sentencia = "INSERT INTO Variables_Globales(n_mensajes) VALUES ($n_mensajes+1);";
                mysqli_query($link, $sentencia);
            }
            break;
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

?>