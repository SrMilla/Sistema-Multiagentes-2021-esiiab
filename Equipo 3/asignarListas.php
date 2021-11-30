<?php
//Iniciamos la conexión con la bbdd
$server="localhost";
$db_username="root";
$db_password='';
$database="multi";
$link = mysqli_connect("$server","$db_username","$db_password") or die ("Imposible conectar a mySQL database");
$a= mysqli_select_db($link,"$database") or die("No se pudo conectar a la base de datos");

if(!$link)
{
    die ("No se ha podido encontrar porque: ".mysql_error());
}
mysql_select_db("multi",$link);

$n_prod    = 3;                     // Numero de productos
$n_tiendas = 3;                     // Numero de tiendas
$n_comp    = 3;                     // Numero de compradores
$n_agentes = $n_tiendas + $n_comp;  // Numero de agentes (sin contar el monitor)

// Generamos listas de productos para tiendas y compradores,
// y listas de 2 tiendas para los compradores.
list($listas_p_t, $listas_p_c) = generar_listas_productos($n_tiendas, $n_comp, $n_prod);
$listas_t                      = generar_listas_tiendas($n_tiendas, $n_comp);

// Contadores
$comp   = 0; 
$tienda = 0;

// El agente monitor tiene id=0, de modo que empezamos a contar en id=1
for ($i = 1; $i <= $n_agentes; $i++) {
    $sentencia = "SELECT * FROM Mensajes WHERE idE = $i";
    $resultado = mysqli_query($link, $sentencia);
    $m = mysql_fecth_array($resultado); // Pasamos el resultado de la consulta a un array
    if ($m["tipoE"] == "comprador") {
        $lista_p = $listas_p_c[$comp];
        $lista_t = $listas_t[$comp];
        $sentencia = "UPDATE Compradores SET tienda1=$lista_t[1], tienda2=$lista_t[2] WHERE id = $i";
        if (!mysqli_query($link, $sentencia)) {
            //----------TODO: error al insertar info en bbdd
        }
        for ($j = 0; $j < count($lista_p); $j++) {
            $sentencia = "INSERT INTO Prod_Comprador VALUES ($lista_p[$j][0],$i,$lista_p[$j][1])";
            if (!mysqli_query($link, $sentencia)) {
                //----------TODO: error al insertar info en bbdd
            }
        }
        //----------TODO: implementar función generar_MCI
        //$lista_MCI_c[$comp] = generar_MCI($lista_p, $lista_t, $m);
        $comp++;
    } else {
        $lista_p = $listas_p_t[$tienda];
        $lista_t = new SplFixedArray(0);

        for ($j = 0; $j < count($lista_p); $j++) {
            $sentencia = "INSERT INTO Prod_Comprador VALUES ($lista_p[$j][0],$i,$lista_p[$j][1])";
            if (!mysqli_query($link, $sentencia)) {
                //----------TODO: error al insertar info en bbdd
            }
        }
        //----------TODO: implementar función generar_MCI
        //$lista_MCI_t[$tienda] = generar_MCI($lista_p, $m);
        $tienda++;
    }
}

function generar_listas_productos($n_tiendas, $n_comp, $n_prod) {
    listas_p_c = new SplFixedArray($n_comp);
    listas_p_t = new SplFixedArray($n_tiendas);
    min_prod = new SplFixedArray($n_prod);
    for ($i = 0; $i < $n_prod; $i++){
        min_prod[$i] = 0;
    }
    for ($i = 0; $i < $n_comp; $i++) {
        listas_p_c[$i] = new array();
        for ($j = 0; $j < $n_prod; $j++){ //hay que comprobar si los ids empiezan en 1 o en 0
            $n = rand(0, 5); // NUMEROS INVENTADOS, se puede cambiar o pasar por parametro
            if ($n != 0){
                min_prod[$j] += $n;
                array_push(listas_p_c[$i], array($j, $n));
            }
        }
    }
    for ($i = 0; $i < $n_tiendas; $i++) {
        listas_p_t[$i] = new array();
        for ($j = 0; $j < $n_prod; $j++){ //hay que comprobar si los ids empiezan en 1 o en 0
            $n = rand(0, min_prod[$j]);
            if ($n != 0){
                array_push(listas_p_t[$i], array($j, $n));
            }
        }
    }
    return array(listas_p_t, listas_p_c)
}

function generar_listas_tiendas($n_tiendas, $n_comp) {
    $listas_t = new SplFixedArray($n_comp);

    for ($i = 0; $i < $n_comp; $i++) {
        
    }
    return $listas_t
}
?>