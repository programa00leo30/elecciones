<?php
error_reporting  (E_ALL);
ini_set ('display_errors', true);
//Configuración global
 require_once 'config/global.php';

//Base para los controladores
require_once 'core/ControladorBase.php';
 
//Funciones para el controlador frontal
require_once 'core/ControladorFrontal.func.php';
 
//Cargamos controladores y acciones
if(isset($_GET["ac"])){
	// cargar el objeto controlador
    $controllerObj=cargarControlador($_GET["ac"]);
    // disparar la accion de ese objeto.
    lanzarAccion($controllerObj);
}else{
    $controllerObj=cargarControlador(CONTROLADOR_DEFECTO);
    lanzarAccion($controllerObj);
}
	
?>
