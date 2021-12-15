<?php

    require_once('../mensajes.php');
    require_once('../funciones.php');

    $tienda_url = 'http://' ;
    $tienda = [$monitor_url,0,'Tienda'];

    $productos = [];

    $msip = generateMSIP($self,$tienda,$productos); //XML de productos
    $mip = simplexml_load_string(httpRequest($url_tienda,$msip));

    print_r($mip);

?>