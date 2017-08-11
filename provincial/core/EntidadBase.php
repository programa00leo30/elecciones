<?php
class EntidadBase{
    private $table;
    private $db;
    private $conectar;
	protected $columnas ;

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
     
    public function db(){
        return $this->db;
    }
     
    public function getAll(){
        $t="SELECT * FROM $this->table ORDER BY id DESC";
        debugf("Entidad: GETALL: sql: $t");
        // echo "Entidad: GETALL: sql: $t";
        $query=$this->db->query($t);
         
        //Devolvemos el resultset en forma de array de objetos
        while ($row = $query->fetch_object()) {
           $resultSet[]=$row;
        }
         
        return $resultSet;
    }
     
    public function getById($id){
		$sql= "SELECT * FROM $this->table WHERE id=$id";
        $query=$this->db->query($sql);
		// var_dump($query);
		if ($query->num_rows > 0 ) {
        if($row = $query->fetch_object()) {
           $resultSet=$row;
        }
        }else{
			var_dump($sql);
			$resultSet = false;
		}
        // var_dump($resultSet);
        return $resultSet;
    }
     
     
    public function setById($comlumn,$value,$id){
		// UPDATE 'c0740032_algo'.'ciudad' SET 'habitantes' = '15030' WHERE 'ciudad'.'id' =13;
        
			// echo "---------;".$this->{$this->table}["id"].";-----"; 
			// var_dump($this);
        if (strlen($id)>1 ) {
			$sql="UPDATE $this->table SET `$comlumn` = '$value' WHERE id=$id LIMIT 1 ;";
			 $query=$this->db->query($sql );
			// vardump($this->db());
			// debugf( "<div>::$sql::(EntidadBase:54)</div>" ) ;
			
			if($query) {
			   $resultSet=true; // se actualizo
			   // debugf("(ok)<br>\n");
			}else{
				$resultSet=false; // fallo el campo.
				debugf("EntidadBase: (false)-".$this->table."->$sql<--<br>\n");
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
				// echo "campo no seteado (val invalido) $campo\n";
				return "NULL"; // no hay informacion 
			}
		}else
			return false;
	}
	
}
?>
