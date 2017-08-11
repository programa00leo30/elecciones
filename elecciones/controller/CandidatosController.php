<?php
class CandidatosController extends ControladorBase{
     
    public function __construct() {
        parent::__construct();
    }
     
    public function index(){
         
        //Creamos el objeto usuario
        $candidatos=new candidatos();
        $cargos = new cargos();
        //Conseguimos todos los usuarios
        $candidatos=$candidatos->getAll();
        
        //Cargamos la vista index y le pasamos valores
        $this->view("candidatos",array(
            "candidatos"=>$candidatos, 
            "cargos"=>$cargos
        ));
    }
     
    public function listar(){
        if(isset($_POST["nombre"])){
			//Creamos un candidato
            $candidato=new candidatos();
            $candidato->setNombre($_POST["nombre"]);
            $candidato->setApellido($_POST["Apellido"]);
            $candidato->setidCargo($_POST["idCargo"]);
            
            // $candidato->setPassword(sha1($_POST["password"]));
            $save=$candidato->save();
        }else{
			// var_dump($_POST);
		}
		// una vez terminado dirige a:
        $this->redirect("Usuarios", "index");
    }
     
    public function borrar(){
        if(isset($_GET["id"])){ 
            $id=(int)$_GET["id"];
             
            $usuario=new Usuario();
            $usuario->deleteById($id); 
        }
        $this->redirect();
    }
     
     
 
}
?>
