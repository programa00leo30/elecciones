<?php
class LoginController extends ControladorBase{
    private $usuario;
    private $status;
    
    public function __construct() {
        parent::__construct();
    }
     
    public function index(){
         
        //Creamos el objeto usuario
        $this->usuario=new Usuario();
         
        //Conseguimos todos los usuarios
        $allusers=$this->usuario->getAll();
        $this->status = $this->get_sesion("login");
		// if (!isset($this->status)){
		// 	$this->status = $this->get_sesion() 
        //Cargamos la vista index y le pasamos valores
        $this->view("login",array(
            "allusers"=>$allusers ,
            "login" => "login"
        ));
    }
	public function sesion(){
		// echo "aqui";
		if ( !isset($this->registrado)){
			// echo "sesion fail";
			$this->login();
		}
	}
    
	public function salir(){
		// echo "saliendo";
		// usuario offline.
				
		if (isset($this->status["id"])){
			$this->usuario->setById("activo","si",$this->status["id"]);
			// echo "aqui.";
			// session_destroy();
			// unset( $_SESSION );
			// echo "aqui.";
		}
		parent::salir();
		$this->redirect("login","login");
	
	}
	
	public function login(){
		// funcion de logeo y registro del sistema
		if ( !isset($this->registrado) ){
				// no se registro.
			if (isset($_POST["login"]) ){
				$usr = $_POST["login"] ;
				//Creamos el objeto usuario
				$usuario=new Usuario();
				// var_dump($this->usuario);
				//Conseguimos todos los usuarios
				if($usuario->check("usr",$usr)){
					// echo "login confirmado";
					$id = $usuario->getId();
					$nombr=$usuario->getNombre();
					$aceso=$usuario->getAcseso();
					// var_dump($this->sesion );
					$this->set_sesion("login", 
							array("id" => $id,"nombre" => $nombr,"aceso" => $aceso)); 
					$this->set_sesion("registrado", array("nombre" => $nombr));
					$usuario->setById("activo","on",$id);
					// var_dump($_SESSION);	
					$this->redirect("mesa","fiscal");
					// $this->view("mesaFiscal",array( ));
				}else{
					
					$this->set_sesion("registrado" ,array("nombre" => $usr)) ; // no hay login. 
					$this->set_sesion("nologin" ,array("nombre" => $usr)) ; // no hay login. 
					$this->redirect("mesa","index");
					// $this->view("mesasIndex",array(
					//	"msg" => "no login", ));
				}
			}else{
				$this->redirect("login","index");
			}
		}else{
			// redirige a inicio de mesas. cuando es un usuario sin permisos.
			$this->redirect("login", "index");
		}
	}
	
	public function __call($name,$arg){
		// cualquier otra planilla a la que se halla llamado
		$this->login();
		
			
	}
	public function gracias(){
         
       //Cargamos la vista index y le pasamos valores
        $this->view("muchasGracias",array( ));
    }
     
}
?>
