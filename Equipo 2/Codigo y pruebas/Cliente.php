<?php

    /* httpRequest($url, $data):
        Envia un mensaje http POST a un servidor PHP y devuelve la respuesta a la peticion.
            $ch es el objeto de la clase curl
            curl_exec() es la funcion que envia el mensaje
            La funcion curl_setopt modifica los parametros para el curl:
                CURLOPT_URL: Indica la URL del servidor
                CURLOPT_POST: True si es POST, (Por defecto False si es GET) 
                CURLOPT_POSTFIELDS: Datos que se envia en el POST
                CURLOPT_RETURNTRANSFER: True devuelve la respuesta, (Por defecto False solo la muestra 
                    por pantalla) 
        Inputs:
            $url: direccion url del servidor al que se le quiere enviar el mensaje
            $data: XML que contiene el mensaje que se quiere enviar
        Output: Respuesta del servidor (XML)
    -----------------------------------------------*/
    function httpRequest($url, $data) {
        $ch = curl_init();

        $xml = http_build_query(array('xml' => $data));

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

    //Conexion con monitor
    $monitor = ""; //IP del monitor
    $monitor_url = 'http://' . $monitor . '' ;

    $msi = simplexml_load_file('Mensajes/msi.xml');
    $mci = simplexml_load_string(httpRequest($monitor_url, $msi));    

    $productos = array();
    $tiendas = array();
    $tiendas_visitadas = array();
    foreach($mci -> lista_producto -> producto as $producto) {
        array_push($productos_init, ($producto -> id_producto) => ($producto -> cantidad));
    }
    foreach($mci -> lista_tiendas -> tienda as $tienda) {
        array_push($tiendas, $tienda);
    }

    //Ciclo de tiendas
    for ($i=0;$i<count($tiendas) && !empty($productos);i++) {
        //Protocolo compra
        array_push($tiendas_visitadas, $tiendas[i]);

        //Falta Funcion de Generar XML para los productos
        $msip = simplexml_load_file('Mensajes/msip.xml'); //XML de productos
        $ip = $tiendas[i] -> ip;
        $url_tienda = 'http://'. $ip.'/';
        $mip = simplexml_load_string(httpRequest($url_tienda,$msip));
        print_r($mip);

        //Modifica la lista de productos a enviar y genera un nuevo XML        

        $mcp = simplexml_load_file('Mensajes/mcp.xml');
        $mvp = simplexml_load_string(httpRequest($url_tienda, $mcp));
        print_r($mvp);

        //Protocolo descubrimiento de tiendas


    }

    //Protocolo de fin de objetivos
    $mensaje_fin = ''; //MFO
    $respuesta_fin = simplexml_load_string(petition($monitor_url, 'GET', $mensaje_fin));
    if ($respuesta_fin -> Tipo == 'ACK') {
        //FINAL
    } elseif ($respuesta_fin -> Tipo == "Error") {
        switch ($respuesta_fin -> Codigo) {
            case 0:
                //Error desconocido
                break;
            case 5:
                break;
            default:
                
        }
    }
    /*
        si ack:
            FIN
        sino:
            Analizar error
            Reenviar MFO
    */

?>