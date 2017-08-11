<?php
class EnLista extends EntidadBase{
	private $id                ; 	// int       |
	private $idPart            ; 	// int       |
	private $NroPartido        ; 	// int       |
	private $AgrupacionPolitica; 	// text      |
	private $NroLista          ; 	// int       |
	private $nombre            ; 	// varchar   |
	private $Senador           ; 	// bigint    |
	private $diputado          ; 	// bigint  

     
    public function __construct() {
		$this->columnas= array(
		"id", "idPart", "NroPartido",  	
	"AgrupacionPolitica", "NroLista",  	
	"nombre", "Senador", "diputado"
		);
        // esta clase no es una tabla. solamente sirve para leer informacion.
        // crear los valores.
        foreach ($this->columnas as $c)
			$this->{$c} ;
		
        $table="EnLista";
        
        parent::__construct($table);
    }

	public function __set($campo,$valor){
		/*
		no se permite guardar campos.
		if(in_array($campo,$this->columnas)){
			// $this->columnas[$campo] ;
			$this->{$campo} = $valor ;
			return true;
		}
		*/
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
			return null;
		}else{
			return $this->__get($campo);
		}
    }
    
	public function save(){
		return false;
				
	}
	
    public function add(){
		// agregar nuevo.
        
        return false;
    }
 
}
?>
