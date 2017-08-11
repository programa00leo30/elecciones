<?php
class Conectar{
    private $driver;
    private $host, $user, $pass, $database, $charset;
    private $con;
    
    public function __construct() {
        $db_cfg = require 'config/database.php';
        $this->driver=$db_cfg["driver"];
        $this->host=$db_cfg["host"];
        $this->user=$db_cfg["user"];
        $this->pass=$db_cfg["pass"];
        $this->database=$db_cfg["database"];
        $this->charset=$db_cfg["charset"];
                
    }
     
    public function conexion(){
         
        if($this->driver=="mysql" || $this->driver==null){
            $con=new mysqli($this->host, $this->user, $this->pass, $this->database);
            $con->query("SET NAMES '".$this->charset."'");
        }
        $this->con = $con; 
        return $con;
    }
    
    public function error(){
		// controlador de errores de la base de datos.
		if ($this->con->error){
			// menejador de error
			sesion::set("msg","(".$this->con->errorCode.")".$this->con->errorInfo);
		}
		
	}
  
}
?>
