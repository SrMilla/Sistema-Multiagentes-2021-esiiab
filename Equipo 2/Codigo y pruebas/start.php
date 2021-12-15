<?php

    require_once('funciones.php');

    $monitorIP = $_POST['ip_monitor'];
    $nClientes = $_POST['n_clientes'];

    for($i = 0; $i < $nClientes; $i++) {
        httpRequest('http://localhost','http://'.$monitorIP.'/', 'ip');
    }
?>