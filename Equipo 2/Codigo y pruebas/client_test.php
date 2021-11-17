<?php
    

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

    //The data you want to send via POST
    $xml = simplexml_load_file('test.xml');
    $url = "http://127.0.0.1/server_test.php";

    $result = httpRequest($url, $xml);
    
    //print_r($result);
    
    echo 'La respuesta es ', $result;
?>