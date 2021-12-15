<?php
//funciones de generacion de mensajes

    function generateCabecera($xw,$origen,$dest,$id,$protoc,$tipo) {
        //echo('Cabecera');
        xmlwriter_start_element($xw, 'info_mensaje');
            xmlwriter_start_element($xw, 'emisor');
                xmlwriter_start_element($xw, 'ip');
                xmlwriter_text($xw, $origen[0]);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'id');
                xmlwriter_text($xw, $origen[1]);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'tipo');
                xmlwriter_text($xw, $origen[2]);
                xmlwriter_end_element($xw);
            xmlwriter_end_element($xw);
            xmlwriter_start_element($xw, 'receptor');
                xmlwriter_start_element($xw, 'ip');
                xmlwriter_text($xw, $dest[0]);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'id');
                xmlwriter_text($xw, $dest[1]);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'tipo');
                xmlwriter_text($xw, $dest[2]);
                xmlwriter_end_element($xw);
            xmlwriter_end_element($xw);
            xmlwriter_start_element($xw, 'id');
                xmlwriter_start_element($xw, 'ip_emisor');
                xmlwriter_text($xw, $id[0]);
                xmlwriter_end_element($xw);
                xmlwriter_start_element($xw, 'contador');
                xmlwriter_text($xw, $id[1]);
                xmlwriter_end_element($xw);
            xmlwriter_end_element($xw);
            xmlwriter_start_element($xw, 'protocolo');
            xmlwriter_text($xw, $protoc);
            xmlwriter_end_element($xw);
            xmlwriter_start_element($xw, 'tipo');
            xmlwriter_text($xw, $tipo);
            xmlwriter_end_element($xw);
        xmlwriter_end_element($xw);
    
        return $xw;
    }

    function generateMSI($origen, $dest) {
        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        $res = xmlwriter_set_indent_string($xw,' ');

        xmlwriter_start_document($xw, '1.0', 'UTF-8');
            xmlwriter_start_element($xw, 'msi');
                xmlwriter_start_attribute($xw, 'xmlns:xsi');
                xmlwriter_text($xw, 'http://www.w3.org/2001/XMLSchema-instance');
                xmlwriter_end_attribute($xw);
                xmlwriter_start_attribute($xw, 'xsi:noNamespaceSchemaLocation');
                xmlwriter_text($xw, 'Mensajes/msi.xsd');
                xmlwriter_end_attribute($xw);

                $xw = generateCabecera($xw,$origen,$dest,[$origen[0],0],'alta','MSI');
            xmlwriter_end_element($xw);
        xmlwriter_end_document($xw);

        return xmlwriter_output_memory($xw);
    }

    function generateMSIT($origen, $dest) {
        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        $res = xmlwriter_set_indent_string($xw,' ');

        xmlwriter_start_document($xw, '1.0', 'UTF-8');
            xmlwriter_start_element($xw, 'msit');
                xmlwriter_start_attribute($xw, 'xmlns:xsi');
                xmlwriter_text($xw, 'http://www.w3.org/2001/XMLSchema-instance');
                xmlwriter_end_attribute($xw);
                xmlwriter_start_attribute($xw, 'xsi:noNamespaceSchemaLocation');
                xmlwriter_text($xw, 'Mensajes/msit.xsd');
                xmlwriter_end_attribute($xw);

                $xw = generateCabecera($xw,$origen,$dest,[$origen[0],0],'solicitarTiendas','MSIT');
            xmlwriter_end_element($xw);
        xmlwriter_end_document($xw);

        return xmlwriter_output_memory($xw);
    }

    function generateMSIP($origen,$dest,$prods) {

        //echo('MSIP');
        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        $res = xmlwriter_set_indent_string($xw, ' ');
        
        xmlwriter_start_document($xw, '1.0', 'UTF-8');

            xmlwriter_start_element($xw, 'msip');
                xmlwriter_start_attribute($xw, 'xmlns:xsi');
                xmlwriter_text($xw, 'http://www.w3.org/2001/XMLSchema-instance');
                xmlwriter_end_attribute($xw);
                xmlwriter_start_attribute($xw, 'xsi:noNamespaceSchemaLocation');
                xmlwriter_text($xw, 'Mensajes/msip.xsd');
                xmlwriter_end_attribute($xw);

                $xw = generateCabecera($xw,$origen,$dest,[$origen[0],0],'compra','MSIP');

                xmlwriter_start_element($xw,'listaProductos');
                foreach ($prods as $prod) {
                    xmlwriter_start_element($xw,'producto');
                        xmlwriter_start_element($xw,'nombre');
                        xmlwriter_text($xw,$prod);
                        xmlwriter_end_element($xw);
                        xmlwriter_start_element($xw,'id');
                        xmlwriter_text($xw,key($prod[0]));
                        xmlwriter_end_element($xw);
                        xmlwriter_start_element($xw,'cantidad');
                        xmlwriter_text($xw,$prod[1]);
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

    function generateMSET($origen, $dest, $time) {
        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        $res = xmlwriter_set_indent_string($xw, ' ');

        xmlwriter_start_document($xw, '1.0', 'UTF-8');
            xmlwriter_start_element($xw, 'mset');
                xmlwriter_start_attribute($xw, 'xmlns:xsi');
                xmlwriter_text($xw, 'http://www.w3.org/2001/XMLSchema-instance');
                xmlwriter_end_attribute($xw);
                xmlwriter_start_attribute($xw, 'xsi:noNamespaceSchemaLocation');
                xmlwriter_text($xw, 'Mensajes/mset.xsd');
                xmlwriter_end_attribute($xw);

                $xw = generateCabecera($xw,$origen,$dest,[$origen[0],0],'entradaTienda','MSET');

                xmlwriter_start_element($xw, 'hora');
                xmlwriter_text($xw,$time[0]);
                xmlwriter_end_element($xw);

                xmlwriter_start_element($xw, 'minuto');
                xmlwriter_text($xw,$time[1]);
                xmlwriter_end_element($xw);
            xmlwriter_end_element($xw);
        xmlwriter_end_document($xw);
        
        return xmlwriter_output_memory($xw);
    }

    function generateMCP($origen,$dest,$prods) {

        //echo('MSIP');
        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        $res = xmlwriter_set_indent_string($xw, ' ');
        
        xmlwriter_start_document($xw, '1.0', 'UTF-8');

            xmlwriter_start_element($xw, 'mcp');
                xmlwriter_start_attribute($xw, 'xmlns:xsi');
                xmlwriter_text($xw, 'http://www.w3.org/2001/XMLSchema-instance');
                xmlwriter_end_attribute($xw);
                xmlwriter_start_attribute($xw, 'xsi:noNamespaceSchemaLocation');
                xmlwriter_text($xw, 'Mensajes/mcp.xsd');
                xmlwriter_end_attribute($xw);

                $xw = generateCabecera($xw,$origen,$dest,[$origen[0],0],'compra','MCP');

                xmlwriter_start_element($xw,'listaProductos');
                foreach ($prods as $prod) {
                    xmlwriter_start_element($xw,'producto');
                        xmlwriter_start_element($xw,'nombre');
                        xmlwriter_text($xw,$prod);
                        xmlwriter_end_element($xw);
                        xmlwriter_start_element($xw,'id');
                        xmlwriter_text($xw,key($prod[0]));
                        xmlwriter_end_element($xw);
                        xmlwriter_start_element($xw,'cantidad');
                        xmlwriter_text($xw,$prod[1]);
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

    function generateMFO($origen,$dest) {
        $xw = xmlwriter_open_memory();
        xmlwriter_set_indent($xw, 1);
        $res = xmlwriter_set_indent_string($xw,' ');

        xmlwriter_start_document($xw, '1.0', 'UTF-8');
            xmlwriter_start_element($xw, 'mfo');
                xmlwriter_start_attribute($xw, 'xmlns:xsi');
                xmlwriter_text($xw, 'http://www.w3.org/2001/XMLSchema-instance');
                xmlwriter_end_attribute($xw);
                xmlwriter_start_attribute($xw, 'xsi:noNamespaceSchemaLocation');
                xmlwriter_text($xw, 'Mensajes/mfo.xsd');
                xmlwriter_end_attribute($xw);

                $xw = generateCabecera($xw,$origen,$dest,[$origen[0],0],'finalizacion','MFO');
            xmlwriter_end_element($xw);
        xmlwriter_end_document($xw);

        return xmlwriter_output_memory($xw);
    }
?>