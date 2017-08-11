<?php

class ControladorBase{
	public static $sesion ;
	
    public function __construct() {
		
        require_once 'EntidadBase.php';
        require_once 'ModeloBase.php';
        require_once 'objeto.php';     // objeto recordset.
        
        // obtengo secion
        // $this::sesion = sesion::constructor() ;
        
        //Incluir todos los modelos
        foreach(glob("model/*.php") as $file){
            require_once $file;
        }
    }
     
	
	public function get_sesion($value){
		global $od_sesion;
		if (isset($ob_sesion)){
			return $od_sesion->get($value);
		}else{
			$ob_sesion = new sesion();
			return $ob_sesion->get($value);
		}
	}
	
	public function set_sesion($name,$value){
		global $od_sesion;
		if (isset($ob_sesion)){
			return $od_sesion->set($name,$value);
		}else{
			$ob_sesion = new sesion();
			return $ob_sesion->set($name,$value);
		}
	}
	
    //Plugins y funcionalidades
     public function salir(){
		 // cerrar session	 
		session_destroy();
		unset( $_SESSION );
		// }
	}
	

/*
* Este método lo que hace es recibir los datos del controlador en forma de array
* los recorre y crea una variable dinámica con el indice asociativo y le da el 
* valor que contiene dicha posición del array, luego carga los helpers para las
* vistas y carga la vista que le llega como parámetro. En resumen un método para
* renderizar vistas.
*/
    public function view($vista,$datos){
        foreach ($datos as $id_assoc => $valor) {
			// echo "<div>$id_assoc = </div>";
			// var_dump($valor);
			// echo "<br>";
			//echo "$valor<br>";
            ${$id_assoc}=$valor; 
        }
        // echo "lanzo:$vista"; 
        require_once 'core/AyudaVistas.php';
        // aqui esta la variable auxiliar de todos los views.
        $helper = new AyudaVistas();
		
        require_once 'view/'.$vista.'View.php';
    }
     
    public function redirect($controlador=CONTROLADOR_DEFECTO,$accion=ACCION_DEFECTO){
        // todas las acciones terminan redirigiendo la pagina para cargar origen.
        // por axioma salvaguardar mensaje para la proxima
        // if (isset($ob_sesion->msg)) $ob_sesion->msg 
        $dt="";
        if (debugmode){
			require_once 'core/AyudaVistas.php';
			$datos = debugf("", 2 );
			if ($datos){
				
				$dt = "&dg=".base64_encode($datos);
				// echo $datos."<<<";
			}
		}
        header("Location:index.php?ac=".$controlador."&d=".$accion.$dt);
        //echo ("Location:index.php?ac=".$controlador."&d=".$accion.$dt);
    }
     
    //Métodos para los controladores
 
}
?>
