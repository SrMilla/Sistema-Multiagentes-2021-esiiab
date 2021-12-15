<?php
    
    //require_once('mensajes.php');

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

    //The data you want to send via POST
    $xml = file_get_contents('Mensajes/mei.xml');
    $url = "localhost/recibirMensajes.php";


    //$xml = generateMSIP(['Comprador','1','192.168.0.1','80'],['Tienda','1','192.168.0.2','80'],[0=>['3','Pan','5']]);
    //$url = "localhost/server_test.php";

    //echo('PreRequest');

    $result = simplexml_load_string(httpRequest($url, $xml));
    
    print_r($result);

    //echo 'El producto 0 es ', $result->lista_productos->producto[0]->nombre_producto, '<br>';
    //echo 'El producto 1 es ', $result->lista_productos->producto[1]->nombre_producto;
?>