<?php
class EntidadBase{
    private $table;
    private $db;
    private $conectar;
	public $columnas ;

    public function __construct($table) {
        $this->table=(string) $table;
         
        require_once 'Conectar.php';
       
        $this->conectar=new Conectar();
        $this->db=$this->conectar->conexion();
    }
    protected function error(){
		// devuelve un mensaje con el error
		if ($this->errorCode){
			return "entidad: (".$this->errorCode.")".$this->db()->error ;
		}else{
			return false; // sin error.
		}
	}
    public function getConetar(){
        return $this->conectar;
    }
     
    public function query($query){
		// salvedad para utilizar con precacucion.
        return $this->db->query($query);
    }
     
    public function db(){
        return $this->db;
    }
     
    public function getAll($orden = "ORDER BY id DESC " ){
		// echo "sql:"."SELECT * FROM $this->table ORDER BY id DESC" ;
        $query=$this->db->query("SELECT * FROM $this->table $orden");
          
        //Devolvemos el resultset en forma de array de objetos
        while ($row = $query->fetch_object()) {
           $resultSet[]=$row;
        }
        if (isset($resultSet))
			return $resultSet; // hay datos
		else
			return null; // no hay datos
		
    }
     
    public function getById($id){
		
        $query=$this->db->query("SELECT * FROM $this->table WHERE id=$id");
		// var_dump($query);
		if (!$query ){ // query es false ( error o no hay registros. )
			$query=$this->db->query("SELECT * FROM $this->table LIMIT 1; ");
			// POR FALLA devuelvo el 1ª objeto obtenido.
		}

		if($row = $query->fetch_object()) {
		   $resultSet=$row;
		}
		 
		return $resultSet;
		
    }
     
     
    public function setById($comlumn,$value,$id){
		// UPDATE 'c0740032_algo'.'ciudad' SET 'habitantes' = '15030' WHERE 'ciudad'.'id' =13;
        
			// echo "---------;".$this->{$this->table}["id"].";-----"; 
			// var_dump($this);
        if (strlen($id)>0 ) {
			$sql="UPDATE $this->table SET `$comlumn` = '$value' WHERE id=$id LIMIT 1 ;";
			 $query=$this->db->query($sql );
			// vardump($this->db());
			// debugf( "<div>::$sql::(EntidadBase:54)</div>" ) ;
			
			
			if($query) {
			   $resultSet=true; // se actualizo
			   // debugf("EntidadBase: (true)-".$this->table."->$sql<--ok<br>\n");
			   // debugf("(ok)<br>\n");
			}else{
				$resultSet=false; // fallo el campo.
				debugf("EntidadBase:setById (false)-".$this->table."->$sql<--<br>\n");
			 }
			return $resultSet;
		}else
			return false;
    }

    public function getBy($column,$value){
        $sql= "SELECT * FROM $this->table WHERE $column='$value' ;";
        // $sql= "SELECT * FROM $this->table WHERE idMesa='5' ;";
        // echo $sql;
        $query=$this->db->query($sql);
		
		if ($query->num_rows > 0 ){
			while($row = $query->fetch_object()) {
			   $resultSet[]=$row;
			}
		}else{
			$resultSet = array();
		}	
        return $resultSet;
    }
     
    public function deleteById($id){
        $query=$this->db->query("DELETE FROM $this->table WHERE id=$id"); 
        return $query;
    }
     
    public function deleteBy($column,$value){
        $query=$this->db->query("DELETE FROM $this->table WHERE $column='$value'"); 
        return $query;
    }
     
 
    /*
     * Aquí podemos montarnos un montón de métodos que nos ayuden
     * a hacer operaciones con la base de datos de la entidad
     */
	public function buscar($campo,$valor){
		$query=$this->db->query("SELECT * FROM $this->table ORDER BY id DESC");
          
        //Devolvemos el resultset en forma de array de objetos
        while ($row = $query->fetch_object()) {
			// var_dump($row);
			if (!isset($row->$campo)){
				// echo "no encontrado falla campo";
				return false; // no existe el campo.
			}else{
				if ($row->$campo == $valor){
					foreach($row as $k=>$v){
						// echo "<div>$k =<div>$v</div></div>\n";
						$this->$k = $v;
						// no se puede modificar directamente. $this->column[$k] = $v;
					}
					// $this->$row; // valores para todos los campos.
					return $row; // valor encontrado
				}
			}
		}
		
	}
	
		
    public function __get($campo){
		if ( in_array($campo,$this->columnas)){
			if (isset($this->$campo)){
				$t=$this->$campo;
				if ($t="") $t="NULL"; // devolver el TEXTO NULL
				// echo "campo obtenido:$t<br>\n";
				return $this->$campo;
			}else{
				debugf("entidadBase:__get no hay valor asignado para $campo");
				// echo "valor $campo :";var_dump($this->$campo);
				// echo "campo no seteado (val invalido) $campo\n";
				return "NULL"; // no hay informacion 
			}
		}else
			return false;
	}
	public function addnew($datos){
		
		// agregar nuevo registro.
		$tx = "INSERT INTO `".$this->table."` (";
		foreach ($this->columnas as $c){
			$tx .= "`$c` ,";
		}
		$tx = substr($tx,0,-1).") \n VALUE ( ";
		foreach ($this->columnas as $c){
			if (isset($datos[$c])){
				$tx .= "'".$datos[$c]."' ,";
			}else{
				$tx .= " NULL ,";
			}
		};
		$tx = substr($tx,0,-1).") ";
		// echo $tx."\n";
		$this->db->query($tx );
	}
}
