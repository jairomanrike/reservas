<?php
session_start();

//Denegar acceso a traves de Iframes
header('X-FRAME-OPTIONS: DENY');

//MODO_DESARROLLO
//MODO_PRODUCCION
$modo="MODO_DESARROLLO";

if($modo=="MODO_PRODUCCION")
{
    error_reporting(E_ALL & ~E_NOTICE);
	ini_set('display_errors','On');
}
else if($modo=="MODO_PRODUCCION")
{
    error_reporting(0);
	ini_set('display_errors','Off'); 
}

$arreglo_seguridad=array(
"http://localhost/prueba/",
"http://localhost/prueba/index.php"
);

// $_SESSION["SEGURIDAD_SERVIDOR"]=$arreglo_seguridad;


?>