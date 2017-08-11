<?php
class indexController extends ControladorBase{
     
    public function __construct() {
        parent::__construct();
    }
    public function filtro(){
		//Creamos el objeto usuario
        $mesa = new mesas();

        $EnLista = new EnLista();
        $Distrito = new Distrito();
        $departamentos = new departamentos();
        $cargos = new cargos();
        $candidatos = new candidatos();
        $ciudades = new EntidadBase("ciudad");
        $partidos = new EntidadBase(" (select * from partidos where activo=0) as a ");
        if (isset($_POST["ciudades"])){
			$idCiudad = (isset($_POST["ciudades"])?$_POST["ciudades"]: -1 ) ;
			if ($idCiudad >= 0 ){
				$esto = $ciudades->getById($idCiudad);
				// var_dump($esto);
				$Pagtitulo = $esto->nombre ;
			}else{
				$Pagtitulo = "TODA LA PROVINCIA";
			}
        }else{
		 $idCiudad = -1;
		 $Pagtitulo = "TODA LA PROVINCIA";
		}
        //Conseguimos todos los usuarios
        // $allusers=$usuario->getAll();
        
        //Cargamos la vista index y le pasamos valores
        $this->view("index",array(
            "mesa"=>$mesa,
            "EnLista"=>$EnLista,
            "partidos"=>$partidos,
            "Distrito"=>$Distrito,
            "cargos"=>$cargos,
            "candidatos"=>$candidatos,
            "ciudades"=>$ciudades,
            "idCiudad"=>$idCiudad,
            "Pagtitulo"=>$Pagtitulo,
        ));
		
	}
    public function index(){
         
        //Creamos el objeto usuario
        $mesa = new mesas();

        $EnLista = new EnLista();
        $Distrito = new Distrito();
        $departamentos = new departamentos();
        $cargos = new cargos();
        $candidatos = new candidatos();
        $ciudades = new EntidadBase("ciudad");
        $partidos = new EntidadBase(" (select * from partidos where activo=0) as a ");
        
        //Conseguimos todos los usuarios
        // $allusers=$usuario->getAll();
        
        //Cargamos la vista index y le pasamos valores
        $this->view("index",array(
            "mesa"=>$mesa,
            "EnLista"=>$EnLista,
            "partidos"=>$partidos,
            "Distrito"=>$Distrito,
            "cargos"=>$cargos,
            "candidatos"=>$candidatos,
            "ciudades"=>$ciudades,
            "Pagtitulo"=>"TODA LA PROVINCIA",
        ));
    }
     
   
 
}
?>
