<?php
// parte sesion del sistema. activar entorno global
require_once 'error.php';
require_once 'sesion.php';
require_once 'objeto.php';

// start_sesion();

//FUNCIONES PARA EL CONTROLADOR FRONTAL
 
function cargarControlador($controller){
	global $_SESSION,$ob_sesion;
	
	//$ob_sesion = new sesion();
	// obtengo el inicio de sesion.
	$ob_sesion = sesion::getInstance();

	if (isset($ob_sesion->registrado)){
		return cargarControladorSeguro($controller);
	}else{
		// login.
		// por defecto. verificar sesion.
		
		$controlador=ucwords(CONTROLADOR_DEFECTO).'Controller';
		$strFileController='controller/'.ucwords(CONTROLADOR_DEFECTO).'Controller.php';  
		
		require_once $strFileController;
		
		$controllerObj=new $controlador();
		// $_SESSION = $controllerObj->sesion();
		
		return $controllerObj;
	}
}

function cargarControladorSeguro($controller){
	global $_SESSION,$ob_sesion ;
	// var_dump($_SESSION);
	switch (accesso()) {
	case 0 :
		{
			// nivel de acceso adminsitrador
			if ($controller == "mesa"){
				$controlador="Fiscal".ucwords($controller).'Controller';
			}else{
				$controlador=ucwords($controller).'Controller';
			}
		};break;
		case 50 :
		{
			// nivel de acceso usuario normal
			$controlador=ucwords($controller).'Controller';
		};break;
	default :
		{
			// el resto.
			$strFileController='controller/'.ucwords(CONTROLADOR_DEFECTO).'Controller.php';
		};break;
	}
	if (isset($_SESSION["fin"]) and debugmode("not") ){
		// ha terminado y se dan las gracias.
		// echo "aqui";
		$strFileController='controller/'.ucwords(CONTROLADOR_FIN).'Controller.php';
	}
/*	
		if (isset($_SESSION["login"])){
			if ($controller == "mesa"){
				$controlador="fiscal".ucwords($controller).'Controller';
			}else{
				$controlador=ucwords($controller).'Controller';
			}
		}elseif (isset($_SESSION["fin"])){
			// echo "por aqui.";
			$strFileController='controller/'.ucwords(CONTROLADOR_FIN).'Controller.php';
		}else{
			
			// controlador sin permisos.
			$controlador=ucwords($controller).'Controller';
		}
*/		
		$strFileController='controller/'.$controlador.'.php';
		 
		if(!is_file($strFileController)){
			// en caso de que no existe el controlador carga controlador por defecto.	
			$strFileController='controller/'.ucwords(CONTROLADOR_DEFECTO).'Controller.php';
			
		}
		if (isset($_GET["dg"])){
			// depurador.
			debugf(base64_decode($_GET["dg"]));
		}
		 
		require_once $strFileController;
		// echo "$strFileController";
		$controllerObj=new $controlador();
		return $controllerObj;

} 

function cargarAccion($controllerObj,$action){
    global $_SESION,$ob_sesion ;
    // echo "accion: $action";
    $accion=$action;
    $controllerObj->$accion();
    
}
 
function lanzarAccion($controllerObj){
	global $_SESION,$ob_sesion ;
	$ac = (isset($_GET["d"]))?$_GET["d"]:ACCION_DEFECTO;
	if (isset($_SESSION["fin"]) and debugmode("not") ){
		// ha terminado y se dan las gracias.
		if ($ac <> "salir")
			$ac=ACCION_FIN;
		
	}
	switch (accesso()) {
		case 0 :
			{
				// nivel de acceso adminsitrador
				cargarAccion($controllerObj, $ac);
			};break;
		case 50 :
			{
				// nivel de acceso usuario normal
				
				cargarAccion($controllerObj, $ac);
			};break;
		case 99 :
			{
				// ya tiene sesion.
				cargarAccion($controllerObj, $ac);
			}
		default :
			{
				// el resto.
				cargarAccion($controllerObj, ACCION_DEFECTO);
			};break;
		}
/*		
	if (isset($_SESSION["fin"])){
		
		cargarAccion($controllerObj, ACCION_DEFECTO);	
	
	}elseif (isset($_GET["d"]) && method_exists($controllerObj, $_GET["d"])){
        cargarAccion($controllerObj, $_GET["d"]);
    }else{
        cargarAccion($controllerObj, ACCION_DEFECTO);
    }
*/
}

function milog($texto){
	/*
	INSERT INTO `c0740032_algo`.`registros` (
		`id` ,
		`usuario` ,
		`tiempo` ,
		`accion`
		)
		VALUES (
		NULL , 'nologin:algo', 
		'2017-08-10 13:48:22', 
		'un monton de cossas " y otras " que no quiero contar'' con distintos tipos de '' acciones.'
);
*/
	$log = new EntidadBase("registros");
	$log->columnas = array("id","usuario","tiempo","accion");
	$datos = array (
		"usuario" => "nologin:".$_SESSION["nologin"]["nombre"] ,
		"tiempo"=> date("Y-m-d H:i:s"), 
		"accion" => str_replace("'","''",$texto ) );
	$log->addnew($datos);
	
	}
	
function mensaje($mensaje,$render=false){
	global $_SESSION;
	static $msn="";
	static $coun=0;
	
	if (($coun==0) and isset($_SESSION["mensajes"])){
		$msn = $_SESSION["mensajes"];
	}
	$msn.="\t<div >".$mensaje."</div>\n";
	if ($render ){
		if ($coun>0){
			unset($_SESSION["mensajes"]);
			return "\t<h2>".$msn."</h2>\n";
		}else{
			return "";
		}
	}
	$_SESSION["mensajes"] = $msn;
	$coun++;	
	
}
function accesso(){
	global $_SESSION;
	//determina el nivel del cliente.
	if (isset($_SESSION["login"])){
		// cliente logeado.
		$nl=0;
	}elseif (isset($_SESSION["nologin"])){
		// cliente sin privilegios
		$nl=50;
	}else{
		// no se logeo
		$nl=99;
	}
	return $nl;
	
}
function debugf($mensaje,$render=0){ // falso.
	
	static $msn="";
	static $con=0;
	if ($render == true) $render =1;
	/*
	$llamado = debug_backtrace();
		// var_dump($llamado);
		echo "llamado desde:".$llamado[0]["line"].": clase:".$llamado[0]["class"]."<br>\n";
		
	*/
	if ($render == 2){
		// modo especial
		if ($con > 0 )
			$t = "(".$con.")".$msn ;
		else
			$t = false;
		
		return $t;
	}else{	
		$msn.="\t\t<div >".$mensaje."</div>\n";
		$con ++ ;
		if (($render <> 0) and debugmode){
			$a = new AyudaVistas();
			$url = $a->url("login","salir");
			$cerrar = <<<ENC
			<div class="left">
	<a href="$url" class="btn btn-danger">cerrar secion</a>
	</div>
ENC
	;
			return "\t<div>".$msn."</div>\n$cerrar";
		}
	}
}
function vardump($variable){
	// generar un var_dump para alguna variable.
	ob_start();
		var_dump($variable);
		$sal=ob_get_contents() ;
	ob_flush();
	debugf("var_dump::".$sal);
}

function debugmode($tipo=""){
	
	if ($tipo == "not"){
		return true;
		// return !debugmode ;
	}else{
		return debugmode ;
	}

}

?>
