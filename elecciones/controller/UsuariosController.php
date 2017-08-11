<?php
class UsuariosController extends ControladorBase{
     
    public function __construct() {
        parent::__construct();
    }
     
    public function index(){
         
        //Creamos el objeto usuario
        $usuario=new Usuario();
         
        //Conseguimos todos los usuarios
        $allusers=$usuario->getAll();
        
        //Cargamos la vista index y le pasamos valores
        $this->view("index",array(
            "allusers"=>$allusers
        ));
    }
     
    public function crear(){
        if(isset($_POST["nombre"])){
                 echo "<div>cargando objeto .</div>";
				//var_dump($controllerObj);
            //Creamos un usuario
            $usuario=new Usuario();
            $usuario->setNombre($_POST["nombre"]);
            $usuario->setUsr($_POST["usr"]);
            $usuario->setPassword(sha1($_POST["password"]));
            $save=$usuario->save();
        }else{
			// var_dump($_POST);
		}
        $this->redirect("candidatos", "index");
    }
     
    public function borrar(){
        if(isset($_GET["id"])){ 
            $id=(int)$_GET["id"];
             
            $usuario=new Usuario();
            $usuario->deleteById($id); 
        }
        $this->redirect();
    }
     
     
    public function hola(){
        $usuarios=new UsuariosModel();
        $usu=$usuarios->getUnUsuario();
        var_dump($usu);
    }
 
}
?>
