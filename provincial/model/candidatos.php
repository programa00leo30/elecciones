<?php
class candidatos extends EntidadBase{
	private $id ; //id          | int       |
	private $nombre ; //nombre      | varchar   |
	private $apellido ; //apellido    | varchar   |
	private $idCargo ; //idCargo     | int       |

     
    public function __construct() {
		
		$this->columnas= array("id" ,"nombre","apellido","idCargo" );
        
        // crear los valores.
        foreach ($this->columnas as $c)
			$this->{$c} ;
		
        $table="candidatos";
        
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
/*		
    public function getId() {
        return $this->id;
    }
 
    public function setId($id) {
        $this->id = $id;
    }
     
    public function getNombre() {
        return $this->nombre;
    }
 
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
 
     
     
    public function getapellido() {
        return $this->apellido;
    }
 
    public function setapellido($apellido) {
        $this->apellido = $apellido;
    }
 
     
    public function getidCargo() {
        return $this->idCargo;
    }
 
    public function setidCargo($idCargo) {
		// validar con la base de datos cargos.
        $this->idCargo = $idCargo;
    }
*/	
	public function save(){
		foreach ($this->columnas as $c){
			if ($c<>"id" and $this->columnas[$c] <> $this->{$c} ){
				$this->db()->setById($c,$this->{$c},$this->campos["id"]);
			}
		}
				
	}
	
    public function add(){
		// agregar nuevo.
        $query="INSERT INTO candidatos (id,nombre,apellido,idCargo)
                VALUES(NULL,
                       '".$this->nombre."',
                       '".$this->apellido."',
                       '".$this->idCargo."');";
        // echo "<div>guardando: $query </div>";
        
        $save=$this->db()->query($query);
        $this->db()->error;
        return $save;
    }
 
}
?>
