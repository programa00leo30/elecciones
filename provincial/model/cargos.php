<?php
class cargos extends EntidadBase{
	private $id ; //id          | int       |
	private $nombre ; //nombre      | varchar   |
	private $activo ; //activo      | varchar   |


     
    public function __construct() {
		$this->columnas= array("id" ,"nombre","activo" );
        
        // crear los valores.
        foreach ($this->columnas as $c)
			$this->{$c} ;
		
        $table="cargos";
        
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
    
	public function save(){
		foreach ($this->columnas as $c){
			if ($c<>"id" and $this->columnas[$c] <> $this->{$c} ){
				$this->db()->setById($c,$this->{$c},$this->campos["id"]);
			}
		}
				
	}
	
    public function add(){
		// agregar nuevo.
        $query="INSERT INTO cargos (id,nombre,activo)
                VALUES(NULL,
                       '".$this->nombre."',
                       '".$this->activo."');";
        
        $save=$this->db()->query($query);
        $this->db()->error;
        return $save;
    }
 
}
?>
