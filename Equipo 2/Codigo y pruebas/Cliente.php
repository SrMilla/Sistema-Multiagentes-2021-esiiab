<?php

    require_once('mensajes.php');
    require_once('funciones.php');
    

    //Conexion con monitor (introducimos manualmente los datos del monitor)
    /*$monitor = ""; //IP del monitor
    $monitor_url = 'http://' . $monitor . '' ;*/

    //Recibimos los datos del monitor
    $monitor_ip = $_POST['ip'];
    $monitor = [$monitor_url,0,'Monitor'];

    //Obtenemos nuestros propios datos
    $self = [getHostByName(getHostName()),-1,'Comprador'];

    //Mensaje Inicializacion 
    $msi = generateMSI($self,$monitor);
    $mci = simplexml_load_string(httpRequest($monitor_url, $msi));    


    //Inicializamos nuestra lista de productos
    $productos = array();
    $tiendas = array();
    $tiendas_visitadas = array();

    //Cargamos el array de productos con los productos indicados por el monitor
    foreach($mci -> listaProductos -> producto as $producto) {
        array_push($productos, ($producto -> nombre) => [$producto -> id,$producto -> cantidad,$producto -> precio]);
    }

    //Cargamos la lista de tiendas indicadas por el monitor
    foreach($mci -> listaTiendas -> tienda as $tienda) {
        array_push($tiendas, ($tienda -> id) => ($tienda -> ip));
    }

    //Ciclo de tiendas
    foreach ($tiendas as $tiendaID => $tiendaIP) { 
        array_push($tiendas_visitadas, $tiendaID);
        $ip = $tiendas[i] -> ip;
        $url_tienda = 'http://'. $ip.'/';

        //Protocolo compra
        $msip = generateMSIP($self,$tiendas[i],$productos); //XML de productos
        $mip = simplexml_load_string(httpRequest($url_tienda,$msip));
        //print_r($mip);

        //Modifica la lista de productos a enviar y genera un nuevo XML        

        $mcp = simplexml_load_file('Mensajes/mcp.xml');
        $mvp = simplexml_load_string(httpRequest($url_tienda, $mcp));
        //print_r($mvp);

        //Protocolo descubrimiento de tiendas

        //envia msit recibe mit
        $msit = generateMSIT($self,$tiendas[i]); //SIN HACER
        $mit = simplexml_load_string(httpRequest($url_tienda, $smit));

        foreach ($mit -> listaTiendas as $tienda) {
            if (!in_array($tienda -> tiendaID, $tiendas_visitadas)) {
                array_push($tiendas, $tienda);
            }
        }

    }

    //Protocolo de fin de objetivos
    $mfo = generateMFO($self,$monitor); //MFO
    $ack = simplexml_load_string(httpRequest($monitor_url, $mfo));
    if ($ack -> Tipo == 'ACK') {
        die;
    } 

?>