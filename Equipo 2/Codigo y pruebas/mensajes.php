<?php
//funciones auxiliares

    function generateCabecera($xw,$origen,$dest,$tipo,$descrip) {
        //echo('Cabecera');
        xmlwriter_start_element($xw, 'info_mensaje');
            xmlwriter_start_element($xw, 'emisor');
                xmlwriter_start_element($xw, 'tipo_emisor');
                xmlwriter_text($xw, $origen[0]);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'id_emisor');
                xmlwriter_text($xw, $origen[1]);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'ip_emisor');
                xmlwriter_text($xw, $origen[2]);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'puerto_emisor');
                xmlwriter_text($xw, $origen[3]);
                xmlwriter_end_element($xw);
            xmlwriter_end_element($xw);
            xmlwriter_start_element($xw, 'receptor');
                xmlwriter_start_element($xw, 'tipo_receptor');
                xmlwriter_text($xw, $dest[0]);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'id_receptor');
                xmlwriter_text($xw, $dest[1]);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'ip_receptor');
                xmlwriter_text($xw, $dest[2]);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'puerto_receptor');
                xmlwriter_text($xw, $dest[3]);
                xmlwriter_end_element($xw);
            xmlwriter_end_element($xw);
            xmlwriter_start_element($xw, 'datos_mensaje');
                xmlwriter_start_element($xw, 'id_mensaje');
                xmlwriter_text($xw, '1');
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'cuerpo');
                xmlwriter_text($xw, $descrip);
                xmlwriter_end_element($xw);
            xmlwriter_end_element($xw);
            xmlwriter_start_element($xw, 'tipo_mensaje');
            xmlwriter_text($xw, $tipo);
            xmlwriter_end_element($xw);
        xmlwriter_end_element($xw);
    
        return $xw;
    }

    function generateMSIP($origen,$dest,$prods) {

        //echo('MSIP');
        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        $res = xmlwriter_set_indent_string($xw, ' ');
        
        xmlwriter_start_document($xw, '1.0', 'UTF-8');

            xmlwriter_start_element($xw, 'mensaje_solictud_info_productos');
                xmlwriter_start_attribute($xw, 'xmlns:xsi');
                xmlwriter_text($xw, 'http://www.w3.org/2001/XMLSchema-instance');
                xmlwriter_end_attribute($xw);
                xmlwriter_start_attribute($xw, 'xsi:noNamespaceSchemaLocation');
                xmlwriter_text($xw, 'MSIP_Schema.xsd');
                xmlwriter_end_attribute($xw);

                $xw = generateCabecera($xw,$origen,$dest,'MSIP','Desc');

                xmlwriter_start_element($xw,'lista_productos');
                foreach ($prods as $prod) {
                    xmlwriter_start_element($xw,'producto');
                        xmlwriter_start_element($xw,'nombre_producto');
                        xmlwriter_text($xw,$prod[1]);
                        xmlwriter_end_element($xw);
                        xmlwriter_start_element($xw,'id_producto');
                        xmlwriter_text($xw,key($prod));
                        xmlwriter_end_element($xw);
                        xmlwriter_start_element($xw,'cantidad');
                        xmlwriter_text($xw,$prod[0]);
                        xmlwriter_end_element($xw);
                        xmlwriter_start_element($xw,'precio');
                        xmlwriter_text($xw,$prod[2]);
                        xmlwriter_end_element($xw);
                    xmlwriter_end_element($xw);
                }
            xmlwriter_end_element($xw);
        xmlwriter_end_document($xw);
        
        return xmlwriter_output_memory($xw);
    }

    //$msg = generateMSIP(['Comprador','1','192.168.0.1','80'],['Tienda','1','192.168.0.2','80'],[0=>['3','Pan','5']]);

    //echo('Hola');
    //print_r($msg); 
?>