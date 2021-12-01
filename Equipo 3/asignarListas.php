<?php
require_once 'conectarBBDD.php';
$link = conexion();

$sentencia = "SELECT COUNT(*) FROM Tiendas;";
$resultado = mysqli_query($link, $sentencia);
$n_tiendas = mysqli_fetch_array($resultado)[0]; // Numero de tiendas

$sentencia = "SELECT COUNT(*) FROM Compradores;";
$resultado = mysqli_query($link, $sentencia);
$n_comp    = mysqli_fetch_array($resultado)[0]; // Numero de compradores
$n_agentes = $n_tiendas + $n_comp;  // Numero de agentes (sin contar el monitor)
$n_prod = 5;//$_POST['n_prod'];     // Numero de productos

$sentencia = "SELECT n_mensajes FROM Variables_Globales WHERE NumeroFila=1;";
$resultado = mysqli_query($link, $sentencia);
$n_mensajes = mysqli_fetch_array($resultado)[0]; // Contador de mensajes que envia el monitor
// 
for ($i = 1; $i <= $n_prod; $i++) {
    $sentencia = "INSERT INTO Productos(nombre,precio) VALUES ('p".$i."',$i);";
    mysqli_query($link, $sentencia);
}

// Generamos listas de productos para tiendas y compradores,
// y listas de 2 tiendas para los compradores.
list($listas_p_t, $listas_p_c) = generar_listas_productos($n_tiendas, $n_comp, $n_prod);
$listas_t                      = generar_listas_tiendas($n_tiendas, $n_comp, $link);

/*
print_r($listas_p_t);
echo "<br>";
echo "<br>";
print_r($listas_p_c);
echo "<br>";
echo "<br>";
print_r($listas_t);
*/

// Contadores
$comp   = 0; 
$tienda = 0;

// El agente monitor tiene id=0, de modo que empezamos a contar en id=1
for ($i = 1; $i <= $n_agentes; $i++) {
    $sentencia = "SELECT * FROM Mensajes WHERE idE = $i";
    $resultado = mysqli_query($link, $sentencia);
    $m = mysqli_fetch_array($resultado); // Pasamos el resultado de la consulta a un array
    if ($m["tipoE"] == "comprador") {
        $lista_p = $listas_p_c[$comp];
        $lista_t = $listas_t[$comp];
        $sentencia = "UPDATE Compradores SET tienda1=".$lista_t[0][0].", tienda2=".$lista_t[1][0]." WHERE id = ".$i.";.";
        if (!mysqli_query($link, $sentencia)) {
            //----------TODO: error al insertar info en bbdd
        }
        for ($j = 0; $j < count($lista_p); $j++) {
            $sentencia = "INSERT INTO Prod_Comprador VALUES (".$lista_p[$j][0].",".$i.",".$lista_p[$j][1].");";
            if (!mysqli_query($link, $sentencia)) {
                //----------TODO: error al insertar info en bbdd
            }
        }
        //----------TODO: implementar función generar_MCI
        $mci = generar_MCI($lista_p, $lista_t, $m, $n_mensajes);
        $n_mensajes++;
        $sentencia = "INSERT INTO MCIs VALUES (".$i.",'$mci');";
        if (!mysqli_query($link, $sentencia)) {
            //----------TODO: error al insertar info en bbdd
        }
        $comp++;
    } else {
        $lista_p = $listas_p_t[$tienda];
        $lista_t = new SplFixedArray(0);

        for ($j = 0; $j < count($lista_p); $j++) {
            $sentencia = "INSERT INTO Prod_Comprador VALUES (".$lista_p[$j][0].",".$i.",".$lista_p[$j][1].");";
            if (!mysqli_query($link, $sentencia)) {
                //----------TODO: error al insertar info en bbdd
            }
        }
        //----------TODO: implementar función generar_MCI
        $mci = generar_MCI($lista_p, [], $m, $n_mensajes);
        $n_mensajes++;
        $sentencia = "INSERT INTO MCIs VALUES (".$i.",'$mci');";
        if (!mysqli_query($link, $sentencia)) {
            //----------TODO: error al insertar info en bbdd
        }
        $tienda++;
    }
}
$sentencia = "UPDATE Variables_Globales SET n_mensajes=".$n_mensajes." WHERE NumeroFila = 1;";
if (!mysqli_query($link, $sentencia)) {
    //----------TODO: error al insertar info en bbdd
}

function generar_listas_productos($n_tiendas, $n_comp, $n_prod) {
    $listas_p_c = new SplFixedArray($n_comp);
    $listas_p_t = new SplFixedArray($n_tiendas);
    $min_prod = new SplFixedArray($n_prod);
    for ($i = 0; $i < $n_prod; $i++){
        $min_prod[$i] = 0;
    }
    for ($i = 0; $i < $n_comp; $i++) {
        $aux = [];
        for ($j = 0; $j < $n_prod; $j++){
            $n = rand(0, 5); // NUMEROS INVENTADOS, se puede cambiar o pasar por parametro
            if ($n != 0){
                $min_prod[$j] += $n;
                $nombre_prod = "p".($j+1);
                array_push($aux, array($nombre_prod,$j+1, $n,0));
                // $j + 1 pq los ids empiezan en 1
                // El precio es 0 pq de momento no lo usamos
            }
        }
        $listas_p_c[$i] = $aux;
    }
    for ($i = 0; $i < $n_tiendas-1; $i++) {
        $aux = [];
        for ($j = 0; $j < $n_prod; $j++){
            $n = rand(0, $min_prod[$j]);
            $min_prod[$j] -= $n;
            if ($n != 0){
                $nombre_prod = "p".($j+1);
                array_push($aux, array($nombre_prod, $j+1, $n, 0));
                // $j + 1 pq los ids empiezan en 1
                // El precio es 0 pq de momento no lo usamos
            }
        }
        $listas_p_t[$i] = $aux;
    }
    $aux = [];
    for ($j = 0; $j < $n_prod; $j++){
        $n = $min_prod[$j];
        if ($n != 0){
            $nombre_prod = "p".($j+1);
            array_push($aux, array($nombre_prod, $j+1, $n, 0));
            // $j + 1 pq los ids empiezan en 1
            // El precio es 0 pq de momento no lo usamos
        }
    }
    $listas_p_t[$n_tiendas-1] = $aux;
    return array($listas_p_t, $listas_p_c);
}

function generar_listas_tiendas($n_tiendas, $n_comp, $link) {
    $listas_t = new SplFixedArray($n_comp);

    $sentencia = "SELECT id,ip FROM Tiendas;";
    $resultado = mysqli_query($link, $sentencia);
    $tiendas = mysqli_fetch_all($resultado);

    $t = 0;
    for ($i = 0; $i < $n_comp; $i++) {
        $aux = [];
        array_push($aux, array($tiendas[$t][0],$tiendas[$t][1]));
        if ($t+1==$n_tiendas){
            $t = -1;
        }
        array_push($aux, array($tiendas[$t+1][0],$tiendas[$t+1][1]));
        $t = $t + 2;
        if ($t==$n_tiendas){
            $t = 0;
        }
        $listas_t[$i] = $aux;
    }
    return $listas_t;
}
function generar_MCI($lista_p, $lista_t, $m, $n_mensajes){
    $xml = simplexml_load_file('mci.xml');
    $xml -> infoMensaje -> emisor -> ip = $m['ipR'];
    $xml -> infoMensaje -> emisor -> id = $m['idR'];
    $xml -> infoMensaje -> emisor -> tipo = $m['tipoR'];
    $xml -> infoMensaje -> receptor -> ip = $m['ipE'];
    $xml -> infoMensaje -> receptor -> id = $m['idE'];
    $xml -> infoMensaje -> receptor -> tipo = $m['tipoE'];
    $xml -> infoMensaje -> id -> ipEmisor = $m['ipR'];
    $xml -> infoMensaje -> id -> contador = $n_mensajes; // TODO: no se como guardar un contador global.
    $xml -> infoMensaje -> protocolo = 'alta';
    $xml -> infoMensaje -> tipo = 'MSI';
    for ($i = 0; $i < count($lista_p); $i++) {
        $xml -> listaProductos -> producto[$i] -> nombre = $lista_p[$i][0];
        $xml -> listaProductos -> producto[$i] -> id = $lista_p[$i][1];
        $xml -> listaProductos -> producto[$i] -> cantidad = $lista_p[$i][2];
        $xml -> listaProductos -> producto[$i] -> precio = $lista_p[$i][3];
    }
    for ($i = 0; $i < count($lista_t); $i++){
        $xml -> listaTiendas -> tienda[$i] -> ip = $lista_t[$i][1];
        $xml -> listaTiendas -> tienda[$i] -> id = $lista_t[$i][0];
    }
    return $xml->asXML();
}
?>