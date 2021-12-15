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
            $tag: etiqueta a la que se codifica los datos a enviar para recibirlos en $_POST (por defecto: 'xml')
        Output: Respuesta del servidor (XML)
    -----------------------------------------------*/
    function httpRequest($url, $data, $tag = 'xml') {
        $ch = curl_init();

        $xml = http_build_query(array($tag => $data));

        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

        //Solo utilizar para test en local 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $return = curl_exec($ch);
        $error = curl_error($ch);

        //Utilizar para debug
        print_r($error);

        return $return;
    }
?>