<?php
class FiscalMesaController extends ControladorBase{
    private $mesas;
    private $provincia = 20 ;
    private $ciudad = 21 ;
    private $departamentos = 7;
    private $mesadetalle; // contiene los valores del detalle de la mesa.
    private $datos; // array para enviar a los view;;
    
    public function __construct() {
		
      
        parent::__construct();
		
		$this->mesas = new mesas();
        $this->provincia = new Distrito();
        $this->ciudad = new ciudad();
        $this->departamentos = new departamentos();
        $this->mesadetalle = new mesadetalle();
  
    }
    
    
    public function index(){
		// objeto por defecto.
        //Creamos el objeto usuario
		$this->memoria();
        //Conseguimos todos los usuarios
        //Cargamos la vista index y le pasamos valores
        $this->view("fiscalIndex", $this->datos );
    }
    public function error($msg  = ""){
		$this->memoria();
		
		$this->view("fiscalIndex",$this->datos  );
	}
	public function fiscal(){
		$this->memoria();
		
		$this->view("fiscalIndex",$this->datos  );
	}
	
	public function confirmarmesa(){
		// $c=0;
		$this->cerrarmesa();
		// $c++;
	}
	
	public function confirmar(){
		// cambia el estado de la mesa a confirmado.
		if (isset($_GET["id"])){
			$id = $_GET["id"];
			$st= $this->mesas->SetById("verificado","1",$id);
			if ($st){
				// echo "confirmada.";
			}else{
				// echo "error";
			}
			
		}
		// vuelve a planilla.
		$this->redirect("mesa","verplanilla");
		
	}
	
	public function modificar(){
		// obtengo los valores de _POST["modificar"] / O _POST["nuevo"]
		if (isset($_POST["nuevo"])){
			// se intenta agregar una pagina.
			
			$r=$this->nuevamesa();
			if ($r){
					$t = $this->get_sesion("dbmesa");
					$t["accion"] = "modificar"; // marca de accion.
					
					$this->redirect("mesa","cerrarmesa");
			}else{
				// error .
				$this->redirect("mesa","index");
			}
		}
		if (isset($_POST["modificar"])){	
			$t=$this->getPOST();
			// cambiar nro de id de la mesas["id"]  para editar. 
			// o error y retornar a la planilla anterior.
			if ($t){
				$id = $this->mesas->selectionaMesa();
				
				if ($id){
					// mesa encontrada.
					$t = $this->get_sesion("dbmesa");
					$t["id"]=$id;				// cambiar el id de dbmesa al nuevo.
					$t["accion"] = "modificar"; // marca de accion.
					
					$this->set_sesion("dbmesa",$t); // guardar en memoria.
					$this->memoria();
					$this->redirect("mesa","cerrarmesa");
				}else{
					// mesa no encontrada
					// valor de eerror de estado.
					$this->redirect("mesa","index");
				}
			}else{
				// no hay datos.
				// valor de mesa encontrado.
				$this->redirect("mesa","cerrarmesa");
			}
		}
	}
    
    public function cerrarmesa(){
		// se selecciona una mesa.
		// este controlador recibe los datos.
		// $t["accion"] = "nueva";$t["accion"] = "modificar";
		$r = $this->get_sesion("dbmesa");
		$this->memoria();
		if (!isset($r["accion"])) {
			$r["accion"]="modificar";
			$this->set_sesion("dbmesa",$r);
		}
		debugf( "fiscalmesaController: acion:".$r["accion"]." id:".$r["id"]."<br>\n" );
		// vardump($this->get_sesion("dbmesa"));
		switch ($r["accion"]) {
			case "nueva" :{
				$r=$this->nuevamesa();
				if ($r){
					//$this->redirect("mesa","index");
					$this->view("fiscalCerrar",$this->datos);
					
				}else{
					// fallo agregar mesa
					$this->redirect("mesa","index");
				}
			}; break;
			case "modificar" :{
				
				// echo "modificar.<br>\n";
				// confirmar datos.
				
				$r = $this->editarmesa();
				if ($r){
					// editando.
					$this->memoria();
					
					$this->view("fiscalCerrar",$this->datos);
					// se edito.
				}else{
					// fallo edicion
					$this->memoria();
					// $this->datos["mesas"] = $dmesas;
					$this->view("fiscalCerrar",$this->datos);
					// echo "aqui despues de memoria.";
				}	
			};break;
			default : {
				// hay un error.
				// $this->redirect("mesa","index");
				// echo "mesa :  index ";
			}
		};
		
	}
	   
    public function alta(){
        // $mesas=new mesas();
        // $usu=$mesas->getUnUsuario();
        // var_dump($usu);
		
    }
  
	
	private function nuevamesa(){
		// verificar si existe sino agregar y guardar
		// verificar si existe sino agregar y guardar
		$obtenrpost = $this->getPOST();
		if ($obtenrpost){
			$rt= $this->Mesa_agregar();
			
		}else{
			$rt=false;
		}
		return $rt;
	}
	
    private function editarmesa(){
		// paso la seccion de modificar que sirve
		// para recopilar datos.
		$rt= false;
		$t = $this->getPOSTcierre(); // obtengo los datos de cierre.
		// echo "edicion de mesa:";
		//var_dump($t);
		if ($t){
			// se obtuvo informacion nueva.
			// $tmp = $this->get_sesion("dbmesa");
			// $this->mesas->buscar("id",$tmp["id"]);
			foreach($t as $k=>$v){
				$this->mesas->{"set".$k}($v);
			}
			
			$save = $this->mesas->save();
			
			if ($save){
				$datos = $this->getPOSTlista();
				// $obtenrpost["id"]=$tmp["id"];
				// $this->set_sesion("dbmesa",$t);
				debugf("fiscalmesaController: se modifica y altera los datos.");
				$confir = $this->memoria();
				// $this->set_sesion("dbmesa",$obtenrpost);
				if ($confir){
					// $this->redirect("mesa","index"); // vuelven al principio
					// $this->view("muchasGracias", $this->datos );
					// echo " confirmado ";
					$rt=$save;
					
				}else{
					// echo " no confirmado ";
					// $this->redirect("mesa","index");
					// ( $rt= false )
				}
			}else{
				// vuelvo a pedir los datos
				debugf("fiscalmesaController: error al guardar los datos.<br>\n");
				$this->set_sesion("msg","hay datos incorrectos, por favor verifique.");
				// echo " no se pudo guardar. ";
				// $this->redirect("mesa","index");
				//($rt=false)
			}
				
		}else{
			// no recibi datos.
			// echo " edicion negada.";
		}
		
		return $rt;
	}
			
	public function verplanilla(){
		
		$this->memoria();
		// echo "memoria";
		if (isset($this->datos["ciudad"])){
			// var_dump($this->datos);
			$this->view("mesasTablas",$this->datos);
			
		}else{
			$this->redirect("mesa","index");
		}
		
	}
     
    // public function 
    
    private function memoria(){
		// $candidatos=$candidatos->getAll();
		$dbmesa = $this->get_sesion("dbmesa");
		
		if ($dbmesa and isset($dbmesa["id"]) ){
			$mesas = $this->mesas->buscar("id",$dbmesa["id"]);
			
			$provincia = $this->provincia->buscar("id",$mesas->idDistrito );
			$depa = $this->departamentos->buscar("id",$mesas->idseccion );
			$ciudad = $this->ciudad->buscar("id",$mesas->idCircuito );
			$rt=true;
			
        }else{
			// por defecto:
			$provincia =  $this->provincia->buscar("id",20); // santa cruz
			$depa=  $this->departamentos->buscar("id",7); // güer aike.
			$ciudad= $this->ciudad->buscar("id",21); // rio Gallegos.
			$mesas = $this->mesas;
			$rt=false;
		}
		// echo "provincia:".$provincia->nombre."<br>";
        $this->datos = array(
            "provincia"=> $provincia, 
            "seccion"=> $depa, 
            "ciudad"=> $ciudad, 
            "mesas"=> $mesas
        );
        return $rt; 
	}
	
	private function Mesa_agregar(){
		//cargar una nueva mesa
		$rt=false;
		$obtenrpost = $this->getPOST();
        if ($obtenrpost){
			$save=$this->mesas->agregar(); // nueva mesa.
			if ($save){
				$this->mesas->setid($save);
				$obtenrpost["id"]=$save; // se guarda el valor del id creado. 
				$this->set_sesion("dbmesa",$obtenrpost);
				$rt=true;
				debugf("fiscalmesaController: se agrego nuevo registro ($save)");
				// echo "se agrego un registro."; var_dump($save);echo "----------------\n"; var_dump($obtenrpost);
			}else{
				// echo "no se tomo en cuenta.";
				debugf("fiscalmesaController: no se pudo agregar mesa...\n");
				$this->redirect("mesa","error");
			}
		}
		return $rt;
    }
    
    
    private function getPOSTlista(){
		// obtener valores de listas.
		debugf("fiscalmesacontroller: obteniendo datos postlsita.");
		if (isset($_POST["lista_senadores"])){
			$dbmesa = $this->get_sesion("dbmesa");
			$campos = array( "id" , "idMesa" , 	"idlista" , "idCargo"  , "cantidad" );
			$pos = array( "idlista" , "idCargo"  , "cantidad" );
			$sumaVoto = array(2=>0,3=>0);

			foreach ($_POST["lista_senadores"] as $idLista=>$cantidad){
				// senadores:
				$this->mesadetalle->idMesa = $dbmesa["id"];
				$this->mesadetalle->idlista = $idLista;
				$this->mesadetalle->idCargo = 2 ; // senadores.
				$this->mesadetalle->cantidad = $cantidad;
				$sumaVoto[2] += $cantidad;
				$this->mesadetalle->agregar();
					
			}
			foreach ($_POST["lista_diputados"] as $idLista=>$cantidad ){
				// diputados:
				$this->mesadetalle->idMesa = $dbmesa["id"];
				$this->mesadetalle->idlista = $idLista;
				$this->mesadetalle->idCargo = 3 ; // diputados.
				$this->mesadetalle->cantidad = $cantidad;
				$sumaVoto[3] += $cantidad;
				$this->mesadetalle->agregar();
				
			}
			return $sumaVoto; 
		}
	}
	
    private function getPOSTcierre(){
		// var_dump($_POST);
		// $dbmesa = $this->get_sesion("dbmesa");
		$dbmesa = $this->getPOST();
		// var_dump($dbmesa);
		$campos = array( "TotalVontantes" , "Votantes" , 
			// "idDistrito" , 	 "idseccion" , "idCircuito" , 
			// "idMesa" , 
			"VotosBlancos" , 
					 "VotosNulos" , "VotosRecurridos" , "VotosInpugnados" );
		// campos obligatorios para agregar o actualizar datos.
		foreach($campos as $k) {
			if (!isset($_POST[$k])){
				return false;
				break;
			}
		}
		// verificar caso especial totalvotante > votantes:
		if ( $_POST["TotalVontantes"] < $_POST["Votantes"] ) {
			$_POST["Votantes"] = $_POST["TotalVontantes"] ;
		}
		
		// los campos obligatorios estan completos
		$this->mesas->fecha = (date("Y-m-d"));
		$this->mesas->tiempo = (date("H:m:s"));
		foreach ($campos as $v){
			$dbmesa[$v] = $_POST[$v];
			$this->mesas->$v = ($_POST[$v]);
		 }
		 // var_dump($dbmesa);
		return $dbmesa;
		
		// return false;
	}
	
	private function getPOST(){
		// var_dump($_POST);
		$campos = array(	
				// "idDistrito","idseccion","idCircuito",
				"idMesa");
		$defecto = array("TotalVontantes" => 0 , "Votantes" => 0 ,
					"VotosBlancos" => 0, "VotosNulos"  =>0, "VotosRecurridos" =>0, 
					"VotosInpugnados" => 0 ,"enEdicion" => "F" );
					
		// campos obligatorios para agregar o actualizar datos.
		$rt=true;
		foreach($campos as $k) {
			if (!isset($_POST[$k])){
					// $this->redirect("mesa","index");
					$rt=false;
			}else{
				if ( strlen($_POST[$k]) < 1){
				$rt=false;
				}
			}
		}
		
		if ( $rt )
		{
			
			//campos por defecto.
			foreach($defecto as $camp=>$val){
				$this->mesas->$camp = $val;
			}
			// var_dump($_POST);
			// los campos obligatorios estan completos
			$this->mesas->fecha = (date("Y-m-d"));
			$this->mesas->tiempo = (date("H:m:s"));
			
			$this->mesas->TotalVontantes = 0;
			$this->mesas->idElecion = idEleccionDefecto;
			 
			// $mesa->setVotantes($_POST["Votantes"]);
			/* $dbmesa["idDistrito"]= $_POST["idDistrito"];
			$this->mesas->idDistrito = ($_POST["idDistrito"]);
			
			$dbmesa["idseccion"]= $_POST["idseccion"];
			$this->mesas->idseccion = ($_POST["idseccion"]);
			
			$dbmesa["idCircuito"]= $_POST["idCircuito"];
			$this->mesas->idCircuito = ($_POST["idCircuito"]);
			*/ 
			// fiscalizar nivel de accesso a un lugar.
			
			$aceso = $this->get_sesion("login");
			if ($aceso["aceso"] > 9 ) { ;// , array("aceso" => $aceso));)
				// restringido a una ciudad.
				$lugar = new TotalMesas();
				$ubicacion = $lugar->donde($_POST["idMesa"]) ;
				
				if (!isset($dbmesa["idCircuito"])){
					$dbmesa["idCircuito"] = $ubicacion[0] ; // identificando ubicacion.
				
				}else {
					// bloqueado por no tener permiso de modificar otra mesa 
					// de otra ciudad.
					$this->error("mesa fuera de rango.");
					return false;
				}
				// else{
				$this->mesas->idCircuito = $dbmesa["idCircuito"] ;
				// $this->mesas->idCircuito = $dbmesa["idCircuito"] ;
				
				// }
			} // sin restriccion de localidad.
			else
			{
				// debugf( "fiscalmesacontroller: ubicando ");
				if ( ! $this->mesas->ubicar($_POST["idMesa"]) ) {
					// fallo la ubicacion. posiblemente que el idCiudad no conicida.
					// corrigiendo.
					debugf("fiscalcontroller: falla. corrigiendo");
					$lugar = new TotalMesas();
					$ubicacion = $lugar->donde($_POST["idMesa"]) ;
					$thits->mesas->idCircuito = $ubicacion[0];
					$thits->mesas->idseccion = $ubicacion[1];
					$thits->mesas->idDistrito = $ubicacion[2];
				}
				
			}	
			// var_dump($this->mesas);
			$this->mesas->idMesa = ($_POST["idMesa"]);
			
			if ($this->mesas->idMesa = ($_POST["idMesa"])){
				$dbmesa["idMesa"]= $_POST["idMesa"];
			}else{
				// error, no puede modificar esta mesa por que esta en otra localidad.
				$this->error("la mesa esta fuera del area de ubicacion.");
			}
			
			return $dbmesa;
		}
		return $rt;
		// return false;
	}
}
?>
