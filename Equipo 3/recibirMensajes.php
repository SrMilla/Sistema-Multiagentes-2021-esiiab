<?php
error_log('proban1');
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
$detalles = "jeje";

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

    echo xmlwriter_output_memory($xw);

}

// Nuevo objeto SimpleXMLElement al que se le pasa un archivo xml.
//$ack = new SimpleXMLElement('Mensajes/ack.xml', 0, true);

// Añadimos los datos de ACK.

//Configruación inicial xmlwriter.
$xw = xmlwriter_open_memory();
xmlwriter_set_indent($xw, 1);
$res = xmlwriter_set_indent_string($xw, ' ');

xmlwriter_start_document($xw, '1.0', 'UTF-8');

    //Empiezo a rellenar ack.xml.

    xmlwriter_start_element($xw, 'ack');
        //Primera parte de un XML.
        xmlwriter_start_attribute($xw, 'xmlns:xsi');
        xmlwriter_text($xw, 'http://www.w3.org/2001/XMLSchema-instance');
        xmlwriter_end_attribute($xw);
        xmlwriter_start_attribute($xw, 'xsi:noNamespaceSchemaLocation');
        xmlwriter_text($xw, 'ack.xsd');
        xmlwriter_end_attribute($xw);

        //Pasamos a rellenar cada uno de los elementos de ack.xml.
        //Elemento info_mensaje.
        xmlwriter_start_element($xw, 'infoMensaje');
            //Elemento emisor.
            xmlwriter_start_element($xw, 'emisor');
                xmlwriter_start_element($xw, 'ip');
                xmlwriter_text($xw, $ip_receptor);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'id');
                xmlwriter_text($xw, $id_receptor);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'tipo');
                xmlwriter_text($xw, $tipo_receptor);
                xmlwriter_end_element($xw);
            xmlwriter_end_element($xw);
            //Elemento receptor.
            xmlwriter_start_element($xw, 'receptor');
                xmlwriter_start_element($xw, 'ip');
                xmlwriter_text($xw, $ip_emisor);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'id');
                xmlwriter_text($xw, $id_emisor);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'tipo');
                xmlwriter_text($xw, $tipo_emisor);
                xmlwriter_end_element($xw);
            xmlwriter_end_element($xw);
            //Elemento id.
            xmlwriter_start_element($xw, 'id');
                xmlwriter_start_element($xw, 'ipEmisor');
                xmlwriter_text($xw, $ip_receptor);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'contador');
                xmlwriter_text($xw, $n_mensajes);
                $n_mensajes=$n_mensajes+1;
                xmlwriter_end_element($xw);
            xmlwriter_end_element($xw);
            //Elemento protocolo.
            xmlwriter_start_element($xw, 'protocolo');
                xmlwriter_text($xw, $protocolo);
            xmlwriter_end_element($xw);
            //Elemento tipo.
            xmlwriter_start_element($xw, 'tipo');
                xmlwriter_text($xw, 'ACK');
            xmlwriter_end_element($xw);

        xmlwriter_end_element($xw);
        //Elemento tipoMensajePregunta.
        xmlwriter_start_element($xw, 'tipoMensajePregunta');
            xmlwriter_text($xw, $tipomsn);
        xmlwriter_end_element($xw);
        //Elemento idPregunta.
        xmlwriter_start_element($xw, 'idPregunta');
            xmlwriter_start_element($xw, 'ipEmisor');
            xmlwriter_text($xw, $ip_emisor);
            xmlwriter_end_element($xw);
            xmlwriter_start_element($xw, 'contador'); 
            xmlwriter_text($xw, $contador);
            xmlwriter_end_element($xw);
        xmlwriter_end_element($xw); 

    xmlwriter_end_element($xw); 

xmlwriter_end_document($xw);

error_log('proban2');
//Iniciamos la conexión con la BBDD.
require_once 'conectarBBDD.php';
$link = conexion();
error_log('proban3');
$sql="INSERT INTO Mensajes(ipE,cont,idE,tipoE,ipR,idR,tipoR,protocolo,tipoM,detalles) VALUES ('$ip_emisor',$contador,$id_emisor,'$tipo_emisor','$ip_receptor',$id_receptor,'$tipo_receptor','$protocolo','$tipomsn','$detalles')"; //FALTAN DETALLES. 
error_log($sql);
if (!mysqli_query($link, $sql)) {
    error_log('ERROR AL INSERTAR');//----------TODO: error al insertar info en bbdd
}
error_log('proban4');

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

?>