<?php
class Usuario extends EntidadBase{
    private $id;
    private $nombre;
    private $usr;
    private $pas;
    private $activo;
    private $campos;
    public function __construct() {
        $this->campos = array("id","nombre","usr","pas","activo");
        
        $table="usuarios";
        parent::__construct($table);
    }
     
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
 
     
    public function getUsr() {
        return $this->usr;
    }
 
    public function setUsr($usr) {
        $this->usr = $usr;
    }
 
 
    public function getpas() {
        return $this->password;
    }
 
    public function setpas($pas) {
        $this->password = $pas;
    }
 
	public function check($campo,$valor){
		// busca en la base de datos el valor del campo
		if (in_array($campo,$this->campos)){
			
			$tmp = parent::getAll();
			foreach($tmp as $tm ){
				// var_dump($tm);
				// var_dump($valor);
				// echo "buscar: $valor en ". $tm->$campo ."<br>\n";
				if ($tm->$campo == $valor ){
					// valor encontrado.
					foreach($this->campos as $c){
						$this->$c = $tm->{$c} ;
					}
					return true;
				}
			}
		}else
			return false;
	}
	
    public function save(){
		
        $query="INSERT INTO usuarios (id,nombre,usr,password)
                VALUES(NULL,
                       '".$this->nombre."',
                       '".$this->usr."',
                       '".$this->password."');";
        echo "<div>guardando: $query </div>";
        $save=$this->db()->query($query);
        $this->db()->error;
        return $save;
    }
 
}
?>
