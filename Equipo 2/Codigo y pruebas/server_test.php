<?php
    $xml1 = simplexml_load_file('test.xml');
    $xml = $_POST["xml"];
    //print_r($xml);
    echo $xml1 -> nombre, ' ' , $xml['apellido'];
?>
