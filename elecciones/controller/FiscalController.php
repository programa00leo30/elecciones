<?php
class FiscalController extends ControladorBase{
     
    public function __construct() {
        parent::__construct();
    }
     
    public function index(){
        // echo "aqui";
        //Creamos el objeto usuario
        $usuario=new Usuario();
         
        //Conseguimos todos los usuarios
        $allusers=$usuario->getAll();
        
        //Cargamos la vista index y le pasamos valores
        $this->view("fiscalusr",array(
            "allusers"=>$allusers
        ));
    }
    public function offline(){
		$id = $_GET["id"] ;
		$usuario=new Usuario();
		$usuario->setById("activo","si",$id);
		$this->index();
			
	}
	
    
    public function online(){
		$id = $_GET["id"] ;
		$usuario=new Usuario();
		$usuario->setById("activo","on",$id);
		$this->index();
			
	}
	
    public function crear(){
		if(isset($_POST["nombre"])){
                 // echo "<div>cargando objeto .</div>";
				//var_dump($controllerObj);
            //Creamos un usuario
            $usuario=new Usuario();
            $usuario->setNombre($_POST["nombre"]);
            $usuario->setUsr($_POST["usr"]);
            $usuario->setAcseso($_POST["password"]);
            // $usuario->setPassword(sha1($_POST["password"]));
            // echo "cargado.";
            $save=$usuario->save();
			
        }else{
			// var_dump($_POST);
		}
        $this->redirect("fiscal", "index");
    }
     
    public function borrar(){
        if(isset($_GET["id"])){ 
            $id=(int)$_GET["id"];
             
            $usuario=new Usuario();
            $usuario->deleteById($id); 
        }
        $this->redirect("fiscal","index");
    }
     
     
    public function hola(){
        $usuarios=new UsuariosModel();
        $usu=$usuarios->getUnUsuario();
        var_dump($usu);
    }
 
}
?>
