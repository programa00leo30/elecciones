<?php
/* 


*/
class mesas extends EntidadBase{
	protected $id;
	protected $fecha     ;
	protected $tiempo  ;
	protected $TotalVontantes;
	protected $Votantes;
	protected $idDistrito;
	protected $idseccion;
	protected $idCircuito;
	protected $idMesa;
	protected $VotosBlancos;
	protected $VotosNulos;
	protected $VotosRecurridos;
	protected $VotosInpugnados;
	protected $enEdicion;
	private $defecto;
	// este campo es para saber si puedo o no agregar el registro
	// en 1 = no , 2 = leer, 3 = leer y escribir.
	private $modo;


     
    public function __construct() {
		$this->columnas= array( "id" , "fecha" , "tiempo" , 
					"TotalVontantes" , "Votantes" , "idDistrito" ,
					 "idseccion" , "idCircuito" , "idMesa" , "VotosBlancos" , 
					 "VotosNulos" , "VotosRecurridos" , "VotosInpugnados" ,"enEdicion" );
        
        $this->defecto = array("TotalVontantes" => 0 , "Votantes" => 0 , "idseccion" => idDistritoDefecto ,
					"VotosBlancos" => 0, "VotosNulos"  =>0, "VotosRecurridos" =>0, 
					"VotosInpugnados" => 0 ,"enEdicion" => "S" );
        // crear los valores.
        foreach ($this->columnas as $c)
			$this->{$c} ;
		// valores por defecto.
		foreach ($this->defecto as $c=>$v)
			$this->{$c} = $v;
		$this->modo = 3 ; // todo ok.
        $table="mesa";
        
        
        parent::__construct($table);
    }
    
    public function actual(){
		//obtener los valores del registro actual
		parent::getById($_SESSION["mesas"]["id"] );
	}
	public function ubicar($idmesa){
		// debugf("mesa: $idmesa :-".$this->idCircuito);
		
		$lugar = new TotalMesas();
		$ubicacion = $lugar->donde($idmesa) ;
		if (isset($this->idCircuito)){
			
			if ($this->idCircuito > 0 ){
				if ($this->idCircuito <> $ubicacion[0]){
					// error, hay un dato errado, o
					// nro de mesa o nro de ciudad.
					$this->modo = 2 ; // no modifica ni agregar.
					debugf("model_mesa: modo error: ubicacion ".$ubicacion[0]." <> ".$this->idCircuito);
					return false;
				}else{
					// debugf("mesa: coinciden no hacer nada :".$this->idCircuito ." == ". $ubicacion[0]);
				}	
			}else{
				debugf("mesa: idCircuito invalido.");
			}
		}else{
			debugf("mesa: no se encuentra idCircuito.");
		}
		// echo "buqueda fallida. el "
		// var_dump($ubicacion);
		$this->idCircuito = $ubicacion[0]; // ciudad
		$this->idseccion = $ubicacion[1];  // departamento
		$this->idDistrito = $ubicacion[2]; // provincia.
		$this->modo = 3 ; // todo ok!
		
		/*
		debugf("mesas: ubicar funcion: $idmesa ::  ".
		"circuito=".$this->idCircuito." \n ".
		"idseccion=".$this->idseccion." \n ".
		"idDistrito=".$this->idDistrito."; ");
		*/
		
		return true;
		
	}
	public function idMesa($valor){
		// cuando cargo una mesa verifico en otra tabla
		// el lugar de la mesa: segun su nro.
		// echo "buscando: $valor";
			
		$rt=$this->ubicar($valor);
		if ($rt)
			$this->idMesa = $valor ;
		
		return $rt;
		
	}
	
	public function __set($campo,$valor){
		if(in_array($campo,$this->columnas)){
			// $this->columnas[$campo] ;
			// asegurar que idMesa pase a idMesa.
				
			if ($campo == "idMesa") 
				return $this->idMesa($valor);
			
			$this->{$campo} = $valor ;
			
			return true;
		}
		return false;
	}
	public function __call($name, $arguments)
    {
        // Nota: el valor $name es sensible a mayúsculas.
        // echo "Llamando al método de objeto '$name' "
        //     . implode(', ', $arguments). "\n";
		$campo = substr($name,3);
		if (count($arguments)>0){
			// es un set.
			return $this->__set($campo,$arguments[0]);
		}else{
			return $this->__get($campo);
		}
    }
	public function save(){
		$this->ubicar($this->idMesa ); // verificacion de datos .
		debugf("mesa: guardando. ");
		if ( $this->modo == 3 ){
			$rt=true; // si todo ok.
			foreach ($this->columnas as $c){
				if ($c<>"id" ){
					if ( $c <> $this->{$c}  ){
						$this->__get($c);
						if ($this->id == ""){
							// verificacion. no esta el id.
							// var_dump(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
							debugf( "mesas: no hay id para modificar: $c :: {".$this->{$c}."} id=".$this->id."; " );
							return false; // no se puede modificar ningun registro.
						}else
						{
							debugf( "mesas: modificar: $c :: {".$this->{$c}."} id=".$this->id."; " );
							$test = parent::setById( $c , $this->{$c} , $this->id );
							if (!$test){
								//fallo la actualizacion de un campo.
								debugf("mesas: modificar -falla-");
								$rt=false;
							}
						}
					}
				}
			}
			return $rt;
		}else {
			debugf("mesa: modificar: en modo error.");
			return false;
		}
	}
	
    public function agregar(){
		// agregar nuevo.
		$b=true; // no se han cargado los campos.
		
		foreach($this->columnas as $c){
			if ($this->defecto($c)){
				$b=false;
			}
			/*
			if (isset($this->$c) and $this->$c<>"") {
				$b=false;
			}
			*/
		}
		// antes de llegar a este punto
		// todos los campos de la base 
		// deben estar cargados.	
		if ($b and ($this->modo <> 3 ) ){
			// no hay valores
			debugf( "mesas:  no se han cargado los valores ::mesas:: modo:".$this->modo );
		}else{
			/*
				$sql = "INSERT INTO 'mesa' 
					('id', 'fecha', 'tiempo', 'TotalVontantes', 'Votantes', 'idDistrito', 'idseccion', 'idCircuito', 
					'idMesa', 'VotosBlancos', 'VotosNulos', 'VotosRecurridos', 'VotosInpugnados') 
					VALUES 
					(NULL, \'2017-07-07\', \'03:07:06\', \'600\', NULL, \'20\', \'7\', \'21\', 
					\'29\', NULL, NULL, NULL, NULL);";
			*/
			// $this->enEdicion = "S";// en edicion. S = si, N = no , C = cargada.
			
			$query="INSERT INTO `mesa` (`id`, `fecha`, `tiempo`, 
				`TotalVontantes`, `Votantes`, `idDistrito`, 
				`idseccion`,
				 `idCircuito`, `idMesa`, `VotosBlancos`, 
				`VotosNulos`, `VotosRecurridos`, `VotosInpugnados`, `enEdicion`) 
					VALUES(NULL,
					". //	'".$this->id."' ,
					"	".$this->t("fecha")." ,
						".$this->t("tiempo")." ,
						".$this->t("TotalVontantes")." ,
						".$this->t("Votantes")." ,
						".$this->t("idDistrito")." ,
					". $this->t("idseccion") ." ,
					  	".$this->t("idCircuito")." ,
						".$this->t("idMesa")." ,
						".$this->t("VotosBlancos")." ,
						".$this->t("VotosNulos")." ,
						".$this->t("VotosRecurridos")." ,
						".$this->t("VotosInpugnados")." ,
						".$this->t("enEdicion")."  );"; 
						
			// echo "<div>guardando: $query </div>";
			if (isset($_SESSION["nologin"])){
				// registrar actividad en el log.
				milog($query);
			}
			$save=$this->db()->query($query);
			if (!$save){
				// var_dump($this); 
				return null;
			}else{
				// ver cual es el id de la mesa.
				$tmp=$this->db();
				$tmp->error;
				if (( $tmp->affected_rows == 1 ) and ($tmp->errno == 0 )){
					return $tmp->insert_id;
				}
			}
		}
	}
	
    public function selectionaMesa(){
		
		$query = "select id , idseccion from mesa 
			where 
				( `idMesa` = ".$this->t("idMesa")." )  
			limit 1;";
		$rt = $this->db()->query($query);
		
		if (!$rt){
				// no hay registro con esos datos.
				return false;
		}else{
			// echo "\n$query\n";
			
			if ($rt->num_rows > 0 ){
				$row = $rt->fetch_object();
				
				// var_dump($row);
				$this->id = $row->id ;
				// var_dump($row);
				if ($row->idseccion < 1 ) { //no hay seccion.
						// corregir error de seccion por ciudad.
					// echo "pasa por aqui.";
					$this->ubica($this->id);	
				
				}
				// $dbmesa = $this->get_sesion("dbmesa");
				// $dbmesa["id"] = $this->id;
				// $this->set_sesion("dbmesa",$dbmesa); // modificando el valor estatico.
				// $this->save(); // guardar nuevos valores.
				
				return $this->id;
			}else{
				// la consulta no dio error pero no encontro registros.
				return false;
			}
		}
	
	}
    private function t($campo){
		// pequeño tratamiento a las variables.
		
		if (($this->$campo == "NULL") or ($this->$campo == "")){
			return "NULL";
		}else{
			return "'".$this->$campo."'";
		}
	}
	public function defecto($campo){
		$rt=false;
		$this->enEdicion = "S";// en edicion. S = si, N = no , C = cargada.
		$defecto = $this->defecto; // array con valores por defecto de los campos.
		
		if (isset($this->$campo)){ // el campo existe.
			if ($this->$campo <> ""){	// el campo es distinto de ""
				$rt=true; // campo correcto
				// echo "valso positivo para $campo:".$this->$campo."<--<br>\n";
			}else{
				// campo, buscar defecto porque esta sin contenido.
				if (isset($defecto[$campo])){
					$this->$campo = $defecto[$campo];
					$rt=true ;
					 
					debugf("mesas: cargo valor por defecto.");
				}else{
					
					$rt=false;
				}
			}
		}else{
			$rt= false;
			// echo "falso para $campo<br>\n";
		}
		return $rt;
	}
		
		
 
}
?>
