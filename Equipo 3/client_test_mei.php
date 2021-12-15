<?php

    function httpRequest($url, $data) {
        $ch = curl_init();

        $xml = http_build_query(array('xml' => $data));
        //print_r($xml);

        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $return = curl_exec($ch);
        $error = curl_error($ch);

        print_r($error);

        return $return;
    }

    // En XML ponemos el mensaje que queremos mandar y en URL la dirección del servidor que recibirá el mensaje.
    $xml = file_get_contents('Mensajes/mei.xml');
    $url = "localhost/recibirMensajes.php";

    $result = simplexml_load_string(httpRequest($url, $xml));
    
    print_r($result);
?>