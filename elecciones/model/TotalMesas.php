<?php
class TotalMesas extends EntidadBase{
	private $id ; //id          | int       |
	private $idCiudad 	; //nombre      | varchar   |
	private $TotalMesas ; //activo      | varchar   |
	private $idEleccion ; //activo      | varchar   |
	private $min 		; //activo      | varchar   |
	private $max 		; //activo      | varchar   |


     
    public function __construct() {
		$this->columnas= array("id" ,"idCiudad","TotalMesas","idEleccion" ,"min" ,"max" );
        
        // crear los valores.
        foreach ($this->columnas as $c)
			$this->{$c} ;
		
        $table="TotalMesas";
        
        parent::__construct($table);
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
	public function donde($NroMesa){
		// funcion que devuelve la localidad a la que pertenece la mesa.
		$todo = parent::query("SELECT * 
			FROM `TotalMesas` 
			WHERE min <= $NroMesa 
				and max >= $NroMesa "
				);
		
		$a = $todo->fetch_array();
		// var_dump($a);
		$b = new ciudad();
		
		$bc = $b->getById($a["idCiudad"]);
		// var_dump($bc);
		return array( $bc->id , $bc->idDepartamento, $bc->idProvincia );
		
		/*
		foreach ( $todo as $a ){
			if ($a->min >= $NroMesa and $a->max <=$NroMesa ){
				echo "encontrado:".$a->idCiudad ;
			
				$ciudad = $a->idCiudad;
				return $ciudad;
				break;
			}
			
		}
		echo "no encontre la ciudad".$a->idCiudad;
		return false;
		*/
	}
 
}
?>
