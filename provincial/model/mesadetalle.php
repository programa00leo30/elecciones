<?php
/* 


*/
class mesadetalle extends EntidadBase{
	private $id;
	private $idMesa  ;
	private $idlista ;
	private $idCargo;
	private $cantidad;

     
    public function __construct() {
		$this->columnas= array( "id" , "idMesa" , 
				"idlista" , "idCargo"  , "cantidad"  );
        
        // crear los valores.
        foreach ($this->columnas as $c)
			$this->{$c} ;
		
        $table="mesadetalle";
        
        
        parent::__construct($table);
    }
    public function actual(){
		//obtener los valores del registro actual
		parent::getById($_SESSION["dbmesadetalle"]["id"] );
	}
	

	public function __set($campo,$valor){
		if(in_array($campo,$this->columnas)){
			// $this->columnas[$campo] ;
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
		foreach ($this->columnas as $c){
			if ($c<>"id" ){
				if ( $c <> $this->{$c}  ){
					$this->__get($c);
					if ($this->id == ""){
						// verificacion. no esta el id.
						// echo "$c :: {".$this->{$c}."} id=".$this->id."; " ;
						debugf( "mesasadetalle: no hay id para modificar: $c :: {".$this->{$c}."} id=".$this->id."; " );
					}else
					{
						debugf( "mesasadetalle: se Modifica: $c :: {".$this->{$c}."} id=".$this->id."; " );
						parent::setById( $c , $this->{$c} , $this->id );
					}
				}
			}
	   }
	}
	
    public function agregar(){
		// agregar nuevo.
		$b=true; // no se han cargado los campos.
		foreach($this->columnas as $c){
			if (isset($this->$c) and $this->$c<>"") {
				$b=false;
			}
		}
				
		if ($b){
			// no hay valores
			debugf( "mesasadetalle: no se han cargado los valores ::mesadetalle::");
		}else{
			/*
				$sql = "INSERT INTO 'mesa' 
					('id', 'fecha', 'tiempo', 'TotalVontantes', 'Votantes', 'idDistrito', 'idseccion', 'idCircuito', 
					'idMesa', 'VotosBlancos', 'VotosNulos', 'VotosRecurridos', 'VotosInpugnados') 
					VALUES 
					(NULL, \'2017-07-07\', \'03:07:06\', \'600\', NULL, \'20\', \'7\', \'21\', 
					\'29\', NULL, NULL, NULL, NULL);";
			*/
			$query="INSERT INTO `mesadetalle` (`id` , `idMesa` , 
				`idlista` , `idCargo`  , `cantidad`) 
					VALUES(NULL,
					". //	'".$this->id."' ,
					"	".$this->t("idMesa")." ,
						".$this->t("idlista")." ,
						".$this->t("idCargo")." ,
						".$this->t("cantidad")." );";
						
			// echo "<div>guardando: $query </div>";
			
			$save=$this->db()->query($query);

			if (!$save){
				$respond = $this->db();
				$t=$respond->error;
				if (substr($t,strlen($t)-17) == "for key 'idUnico'"){
					// ya existe el registro. modificarlo.
					$query = "select id from mesadetalle 
						where 
							( `idMesa` = ".$this->t("idMesa")." ) and
							( `idlista` = ".$this->t("idlista")." ) and 
							( `idCargo` = ".$this->t("idCargo")." )
						limit 1;";
					$rt = $this->db()->query($query);
					
					if (!$rt){
							// error al actualizar el registro.
							// var_dump($this->db() );
					}else{
						$row = $rt->fetch_object();
						$this->id = $row->id ;
						$this->save(); // guardar nuevos valores.
						
						return $this->id;
					}
				}else{
					debugf( "mesasadetalle: error al cargar.:". $query.":::--<br>\n");
					// var_dump($this->db());// buscar una solucion.
				
				return null;
				}
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
    
    public function t($campo){
		// pequeño tratamiento a las variables.
		
		if (($this->$campo == "NULL") or ($this->$campo == "")){
			return "NULL";
		}else{
			return "'".$this->$campo."'";
		}
	}
 
}
?>
