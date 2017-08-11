<?php
/* 


*/
class mesadetalle extends EntidadBase{
	protected $id;
	protected $idMesa  ;
	protected $idlista ;
	protected $idCargo;
	protected $cantidad;

     
    public function __construct() {
		$this->columnas = array( "id" , "idMesa" , 
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
		foreach ( $this->columnas as $c ){
			if ( $c <> "id" ){ // no es la columna de identificacion.
				// if ( $c <> $this->{$c}  ){
					// $this->__get($c);
					if ($this->id == ""){
						// verificacion. no esta el id.
						// echo "$c :: {".$this->{$c}."} id=".$this->id."; " ;
						debugf( "mesasadetalle:save no hay id para modificar: $c :: {".$this->{$c}."} id=".$this->id."; " );
					}else
					{
						$valor = $this->$c;
						if ($c == "cantidad"){
							$valor = $this->t($c); // obtengo el valor real o NULL de cantidad.
							if ($valor == "NULL")  
								$valor = 0; // en caso de NULL marcar a 0 
							else
								$valor= substr($valor,1,-1);		// quitar los ' del string
						}
						
						debugf( "mesasadetalle:save se Modifica: $c :: {".$valor."} id=".$this->id."; " );
						parent::setById( $c , $valor , $this->id );
					}
				// }else{
					// no hay datos para modificar
				//	debugf("mesadetalle:save sin datos a modificar ".$c ." = ". $this->{$c} );
				// }
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
			debugf( "mesasadetalle:agregar no se han cargado los valores ::mesadetalle::");
		}else{
			$Mcantidad = $this->t("cantidad");
			$Fcantidad = $this->cantidad;
			debugf("mesadetalle:agregar cantidad:".$Mcantidad );
			if ($Mcantidad == "NULL") $Mcantidad = 0 ;// valor por defecto al cargar nuevo registro.
			/*
			if ($Mcantidad == "NULL" ) {
				// valor nulo para cantidad = 0
				$Mcantidad = 0 ;
			}
			
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
						".$Mcantidad." );";
						
			// echo "<div>guardando: $query </div>";
			
			$save=$this->db()->query($query);

			if (!$save){
				// no se pudo agregar. buscando coincidencia para modificar.
				$respond = $this->db();
				$t=$respond->error; // obtener el valor de error ( si hubiese. )
				if (substr($t,strlen($t)-17) == "for key 'idUnico'"){
					// ya existe el registro. modificarlo.
					$query = "select * from mesadetalle 
						where 
							( `idMesa` = ".$this->t("idMesa")." ) and
							( `idlista` = ".$this->t("idlista")." ) and 
							( `idCargo` = ".$this->t("idCargo")." )
						limit 1;";
					$rt = $this->db()->query($query);
					
					if (!$rt){
							// error al actualizar el registro.
							// var_dump($this->db() );
							debugf( "mesasadetalle:agregar falla al buscar registro ::mesadetalle::");
					}else{
						$row 	= 	$rt->fetch_object()	;
						/*
						var_dump($row);
						echo "mesadetalle:agregar";
						echo "id:".$this->id
							." idMesa:".$this->idMesa
							." idlista:".$this->idlista
							." idCargo:".$this->idCargo
							." cantidad:".$this->cantidad
							."\n<br>";
						// $this->idMesa 	= $row->idMesa 		;
						// $this->idlista 	= $row->idlista 	;
						// $this->idCargo 	= $row->idCargo 	;
						// $this->cantidad = ($Mcantidad == "NULL"  )? 0 : $Fcantidad  ;
						*/
						$this->id 		= $row->id 			;
						debugf("mesadetalle:agregar actualizar cantidad ".($this->cantidad )." en ".$this->id."(".$Fcantidad.")");
						$this->save(); // actualizar los valores.
						
						return $this->id;
					}
				}else{
					debugf( "mesasadetalle:agregar error al cargar.:". $query.":::--<br>\n");
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
