<?php
class mesaController extends ControladorBase{
    private $mesas;
    private $provincia;
    private $ciudad;
    private $departamentos;
    private $mesadetalle; // contiene los valores del detalle de la mesa.
    // private $dbMesa; // datos actuales de mesa
    private $datos; // array para enviar a los view;;
    
    public function __construct() {
		
      
        parent::__construct();
		
		$this->mesas = new mesas();
        $this->provincia = new Distrito();
        $this->ciudad = new ciudad();
        $this->departamentos = new departamentos();
        $this->mesadetalle = new mesadetalle();
  
    }
    
    private function memoria(){
		// $candidatos=$candidatos->getAll();
		// var_dump($this->get_sesion("dbmesa"));
		
		$dbmesa = $this->get_sesion("dbmesa");
		if ($dbmesa){
			$mesas = $this->mesas->buscar("id",$dbmesa["id"]);
			$provincia = $this->provincia->buscar("id",$mesas->idDistrito );
			$depa = $this->departamentos->buscar("id",$mesas->idseccion );
			$ciudad = $this->ciudad->buscar("id",$mesas->idCircuito );
			$rt= true;
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
        
        return $rt; // verdadero si esta cargado, falso caso contrario.
	}
        
    public function index(){
         // objeto por defecto.
        //Creamos el objeto usuario
		$this->memoria();
        // $cargos = new cargos();
        //Conseguimos todos los usuarios
        //Cargamos la vista index y le pasamos valores
        $this->view("mesasIndex", $this->datos );
    }
    
    public function parcial(){
		// parte de carga 
		// obtener datos de post.
		$obtenrpost = $this->getPOST();
		// setear variable de actualizacion de estado de mesa.
		$this->mesas->settiempo(date("H:m:s"));
		
		if (!$obtenrpost){
			// no he recibido valores de datos
			$r=$this->memoria();
			if (!$r){
				// hay datos mal carados
				$this->redirect("mesa","index");
			}
		}else {
			// si he recibido valores de agregar datos
			$r=$this->memoria();
			if (!$r){ // si no hay datos en memoria.
				$r=$this->Mesa_agregar($obtenrpost);
				$this->memoria(); // actualizar datos.
			}else{
				// intenta modificar datos.
				// echo "modificar:";
				$this->Mesa_Modificar();
			}
			
			if (!$r){ // fallo agregar mesa y / o error.
				// $this->redirect("mesa","index");
			}
			// si no puedo agregar datos, entonces ya existe.
		}
		// identificador del id.
		
		$this->mesas->setid($this->datos["mesas"]->id ) ; 
		if(isset($_POST["Votantes"])){
			// realmetne el parcial
			$v = $_POST["Votantes"];
			// echo "--->".$this->mesas->TotalVontantes."<---";
			if ($this->datos["mesas"]->TotalVontantes > 0 )
				if ( $v > $this->datos["mesas"]->TotalVontantes )
					$v=$this->datos["mesas"]->TotalVontantes; // valor final/cantidad maxima.
					
			$this->mesas->setVotantes($v);
		}else{	
			
		}
		
		$save=$this->mesas->save();
		$this->memoria(); // actualizacion de datos.
		$this->view("mesasParcial",$this->datos  );	
	}
	
	
	public function confirmarmesa(){
		$c=$this->get_sesion("dbmesa_cierre");
		if (!$c){
			$this->set_sesion("dbmesa_cierre", 1);
			$c=1;
		}else{
			$c++;
			$c++;
		}
		$this->set_sesion("dbmesa_cierre", $c);
		$this->cerrarmesa($c);
		$c++;
	}
	
    public function cerrarmesa($confir=0){
		
		// se cierra la mesa
		$this->memoria();
		$t=$this->getPOSTcierre();
		$c=($t <> false) && ($confir > 2) ;
		// var_dump($c);echo $confir;
		if ($c){
			// envia codigo y/o  confirmacion de detalle.
			$this->memoria();
			$t=$this->getPOSTcierre(); // se modifica el detalle de mesas.
			$this->getPOSTlista(); // se modifica datos de detalle de mesa.
			// se obtuvo informacion nueva.
			$tmp = $this->get_sesion("dbmesa");
			// echo "pasa por aqui";
			$save = $this->mesas->save();
			if ($save){
				$obtenrpost["id"]=$tmp["id"];
				debugf("mesacontroller: se modifica y altera los datos.");
				$this->set_sesion("dbmesa",$obtenrpost);
				if ($confir){
					$this->set_sesion("fin", "si");
					$this->view("muchasGracias", $this->datos );
				}else{
					$this->redirect("mesa","cerrarmesa");
				}
			}else{
				// vuelvo a pedir los datos
				$this->set_sesion("msg","hay datos incorrectos, por favor verifique.");
				// mensaje("hay datos incorrectos, por favor verifique.");
				// debugf("mesacontroller: " $)
				$this->redirect("mesas","cerrarmesa");
			}
		}
		else
		{	
			// entra por primera vez.
			if(isset($_POST["Votantes"])){
				// realmetne el parcial
				$this->mesas->setVotantes($_POST["Votantes"]);
			}
			debugf( "mesacontroller: -------------------------" );
			debugf( "mesacontroller: primera vuelta".$confir );
			$this->getPOSTlista();
			
			$save=$this->mesas->save();
			$this->memoria(); // actualizacion de datos.
			$this->view("mesasCerrar", $this->datos  );
		}
	}
	public function gracias(){
		// funcion final
		// $this->view("muchasGracias", $this->datos );
		$this->cerrarmesa(0); // para pruebas.
		
	}	
	public function error($msg=""){
		$r=$this->memoria();
		 $this->set_sesion("msg",$msg);
		if (!$r){
			// no pude agregar datos. y no estan en memoria
			$this->view("mesasIndex",$this->datos  );
		}else{
			// no pude agregar datos. pero estan en memoria.
			$this->view("mesasIndex",$this->datos  );
		}
			
	}
     
    private function Mesa_Modificar(){
		debugf("mesacontroller: quiero modificar datos...\n");
		// $tmp = $this->get_sesion("dbmesa");
		$mm = $this->memoria();
		$id= $this->datos["mesas"]->id;
		// var_dump($this->datos["mesas"]);
		foreach($this->datos["mesas"] as $k=>$v){
			$this->mesas->{"set".$k}($v);
		}
		$this->getPOST();
		$this->mesas->setid($id);	
		
		$save = $this->mesas->save();
		if ($save){
			// var_dump($save);
			$obtenrpost["id"]=$id;
			debugf("mesacontroller: se modifica y alteran los datos.".$id."<br>");
			// $this->set_sesion("dbmesa",$obtenrpost);
		}else{
			// vuelvo a pedir los datos
			$this->error("hay datos incorrectos, por favor verifique.");
			// $this->set_sesion("msg","hay datos incorrectos, por favor verifique.");
			// mensaje("hay datos incorrectos, por favor verifique.");
			// $this->redirect("mesa","index");
		}
	}
	
    private function Mesa_agregar($obtenrpost){
		//cargar una nueva mesa
		$rt=false;
        if ($obtenrpost){
			$save=$this->mesas->agregar(); // nueva mesa.
			if ($save){
				$this->mesas->setid($save);
				$obtenrpost["id"]=$save; // se guarda el valor del id creado. 
				$this->set_sesion("dbmesa",$obtenrpost);
				$rt=true;
				debugf("mesacontroller: se agrego nuevo registro ($save)");
			}else{
				//echo "no se tomo en cuenta.";
				debugf("mesacontroller: no se pudo agregar mesa...\n");
				$this->redirect("mesa","error");
			}
		}
		return $rt;
    }
    
    private function getPOSTlista(){
		// obtener valores de listas.
		// var_dump($_POST); // lista_senadores
		if (isset($_POST["lista_senadores"])){
			$dbmesa = $this->get_sesion("dbmesa");
			$campos = array( "id" , "idMesa" , 	"idlista" , "idCargo"  , "cantidad" );
			$pos = array( "idlista" , "idCargo"  , "cantidad" );
			// var_dump($_POST);

			foreach ($_POST["lista_senadores"] as $idLista=>$cantidad){
				// senadores:
				$this->mesadetalle->idMesa = $dbmesa["id"];
				$this->mesadetalle->idlista = $idLista;
				$this->mesadetalle->idCargo = 2 ; // senadores.
				$this->mesadetalle->cantidad = ( $cantidad * 1 ); // garantizar que es un nro.
				
				debugf("mesacontroller:getPOSTlista cantidad:" 
					. $this->mesadetalle->cantidad 
					." id:". $this->mesadetalle->idMesa 
					." ->". ($cantidad*1) );
				// */
				$this->mesadetalle->agregar();
					
			}
			foreach ($_POST["lista_diputados"] as $idLista=>$cantidad ){
				// diputados:
				$this->mesadetalle->idMesa = $dbmesa["id"];
				$this->mesadetalle->idlista = $idLista;
				$this->mesadetalle->idCargo = 3 ; // diputados.
				$this->mesadetalle->cantidad = ( strlen( $cantidad  ) > 0 )?$cantidad:0;
				$this->mesadetalle->agregar();
				
			}
		}else{
			debugf("mesacontrolle: no hay datos de detalle de la mesa");
		}
	}
	
    private function getPOSTcierre(){
		// var_dump($_POST);
		// $dbmesa = $this->get_sesion("dbmesa");
		
		$campos = array( "TotalVontantes" , "Votantes" , 
					// "idDistrito" ,  					// se calcula con el nro de mesa
					//  "idseccion" , "idCircuito" , 	// se calcula con el nro de mesa.
					 "idMesa" , "VotosBlancos" , 
					 "VotosNulos" , "VotosRecurridos" , "VotosInpugnados" );
		// campos obligatorios para agregar o actualizar datos.
		foreach($campos as $k) {
			if (!isset($_POST[$k])){
				debugf("mesacontroller: falta campo $k no obtenido");
				return false;
				break;
			}
		}
		
			// los campos obligatorios estan completos
			$this->mesas->fecha = (date("Y-m-d"));
			$this->mesas->tiempo = (date("H:m:s"));
			foreach ($campos as $v){
				$dbmesa[$v]= $_POST[$v];
				$this->mesas->$v = ($_POST[$v]);
			 }
			return $dbmesa;
		
		// return false;
	}
	private function getPOST(){
		// var_dump($_POST);
		$campos = array(
			// "idDistrito","idseccion",
			// "idCircuito",  				// refuerzo de nro de ciudad.
			"idMesa","TotalVontantes");
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
			// var_dump($_POST);
			// los campos obligatorios estan completos
			$this->mesas->fecha = (date("Y-m-d"));
			$this->mesas->tiempo = (date("H:m:s"));
			
			$this->mesas->TotalVontantes = ($_POST["TotalVontantes"]);
			$this->mesas->idElecion = idEleccionDefecto;
			// $mesa->setVotantes($_POST["Votantes"]);
			// $dbmesa["idDistrito"]= $_POST["idDistrito"]; // refuerzo de ciudad.
			// $this->mesas->idDistrito = ($_POST["idDistrito"]);
			
			// $dbmesa["idseccion"]= $_POST["idseccion"];
			// $this->mesas->idseccion = ($_POST["idseccion"]);
			
			// $dbmesa["idCircuito"]= $_POST["idCircuito"]; // refuerzo de ciudad
			// $this->mesas->idCircuito = ($_POST["idCircuito"]); 	// refuerzo de ciudad.
			
			$dbmesa["idMesa"]= $_POST["idMesa"];
			$this->mesas->idMesa = ($_POST["idMesa"]);
			$this->mesas->ubicar($_POST["idMesa"]);
			
			return $dbmesa;
		}
		return $rt;
		// return false;
	}
	
	
	
}
?>
