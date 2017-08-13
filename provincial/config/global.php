<?php
define("CONTROLADOR_DEFECTO", "index");
define("ACCION_DEFECTO", "index");

define("CONTROLADOR_FIN", "fin");
define("ACCION_FIN", "gracias");

define("debugmode",false);

define("idEleccionDefecto",1); // nro de identificacion de eleccion.
define("idDistritoDefecto",7); // nro de identificacion de eleccion.

session_name("eleciones");


$ScrtipDire = pathinfo( __file__, PATHINFO_DIRNAME);
$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;


//Más constantes de configuración
?>
