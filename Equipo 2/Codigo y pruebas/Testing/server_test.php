<?php
    include_once('../mensajes.php');
    #$xml1 = simplexml_load_file('test.xml');
    $xml = simplexml_load_string($_POST['xml']);
    $response = generateMSIP(['Tienda','1','192.168.0.2','80'],['Comprador','1','192.168.0.1','80'],[0=>['3','Pan','5'],1=>['4','Agua','5']]);
    echo $response;
?>
