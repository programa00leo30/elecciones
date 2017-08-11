<?php
/* 


*/
class mesas extends EntidadBase{
	private $id;
	private $fecha     ;
	private $tiempo  ;
	private $idElecion  ;
	private $TotalVontantes;
	private $Votantes;
	private $idDistrito;
	private $idseccion;
	private $idCircuito;
	private $idMesa;
	private $VotosBlancos;
	private $VotosNulos;
	private $VotosRecurridos;
	private $VotosInpugnados;
	private $enEdicion;
	private $defecto;


     
    public function __construct() {
		$this->columnas= array( "id" , "fecha" , "tiempo" , "idElecion" , 
					"TotalVontantes" , "Votantes" , "idDistrito" ,
					 "idseccion" , "idCircuito" , "idMesa" , "VotosBlancos" , 
					 "VotosNulos" , "VotosRecurridos" , "VotosInpugnados" ,"enEdicion" );
        
        $this->defecto = array("TotalVontantes" => 0 , "Votantes" => 0 , "idElecion" => 1 ,
					"VotosBlancos" => 0, "VotosNulos"  =>0, "VotosRecurridos" =>0, 
					"VotosInpugnados" => 0 ,"enEdicion" => "S" );
        // crear los valores.
        foreach ($this->columnas as $c)
			$this->{$c} ;
		
        $table="mesa";
        
        
        parent::__construct($table);
    }
    public function actual(){
		//obtener los valores del registro actual
		parent::getById($_SESSION["mesas"]["id"] );
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
    public function estadistica_porlista($idDistrito,$idseccion,$idcircuito,$idElecion){
		// 
		if ($idcircuito >= 0){
			$ciudad = "idcircuito = '$idcircuito' and \n";
		}else{
			$ciudad= "";
		}
			
		$query = "
			select
	m.fecha,
	m.idcircuito,
	m.idseccion,
	m.idDistrito ,
	d.idlista as idLista ,
	d.idCargo  as idCargo,
	count(d.cantidad) as cuantos,
	sum(d.cantidad )as cantidad
	
 from mesa as m left join 
	mesadetalle as d on m.id = d.idMesa
where 
  $ciudad
m.idDistrito = '$idDistrito' and
	m.idseccion = '$idseccion' and
m.idElecion ='$idElecion'  and
m.verificado = 1 

group by m.idElecion , d.idlista, d.idCargo ;
		";
		$rt=$this->db()->query($query);
		if (!$rt){
			// sin registro
			return false;
		}else{
			
			//  fecha 	idcircuito 	idseccion 	idDistrito 	idLista 	idCargo 	cuantos 	cantidad 
			// $resultSet[]="";
			// $ts=$this->db()->fetch_object();
			// echo "sql:$query<br>\n";
			// echo "sql:$query<br>\n";
			// var_dump( $rt->fetch_object() );
			while ($row = $rt->fetch_object()) {
				$resultSet[]=$row;
			}
			if (!isset($resultSet)) {
				foreach($this->columnas as $v)$r[$v]="";
				$resultSet[]= new objeto( array_merge( $r ,$this->defecto ) );
			}
			// var_dump($resultSet);
			return $resultSet;
		}
	
	}

    public function estadistica_totales( $idDistrito,$idseccion,$idcircuito,$idElecion){
		// fecha 	idcircuito 21	idseccion 7	idDistrito 20	MesasTomadas 	Votantes TotalVontantes 	VotosBlancos 	
		// VotosNulos 	VotosRecurridos 	VotosInpugnados 
		if ($idcircuito >= 0){
			$ciudad = "idcircuito = '$idcircuito' and \n";
		}else{
			$ciudad= "";
		}
		
		$query = "select
	m.fecha,
	m.idcircuito,
	m.idseccion,
	m.idDistrito ,
	count(m.id )as MesasTomadas,
	sum(m.Votantes )as Votantes,
	sum(m.TotalVontantes )as TotalVontantes,
	sum(m.VotosBlancos )as VotosBlancos,
	sum(m.VotosNulos )as VotosNulos,
	sum(m.VotosRecurridos )as VotosRecurridos,
	sum(m.VotosInpugnados )as VotosInpugnados

 from mesa as m 

where 
 $ciudad
m.idDistrito = '$idDistrito' and
	m.idseccion = '$idseccion' and
m.idElecion ='$idElecion' and
m.verificado = 1 

group by m.idElecion" ;
		$rt=$this->db()->query($query);
		if (!$rt){
			// sin registro
			return false;
		}else{
			// echo "sql:$query;";
			
			while ($row = $rt->fetch_object()) {
				$resultSet[]=$row;
			}
			if (!isset($resultSet)) {
				foreach($this->columnas as $v)$r[$v]="";
				$resultSet[]= new objeto( array_merge( $r ,$this->defecto ) );
			}
			return $resultSet;
		}
			
		
	}
	public function save(){
		$rt=true; // si todo ok.
		foreach ($this->columnas as $c){
			if ($c<>"id" ){
				if ( $c <> $this->{$c}  ){
					$this->__get($c);
					if ($this->id == ""){
						// verificacion. no esta el id.
						// var_dump(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
						debugf( "mesas: no hay id para modificar: $c :: {".$this->{$c}."} id=".$this->id."; " );
						return false; // no se puede modificar ningun registro.
					}else
					{
						debugf( "mesas: modificar: $c :: {".$this->{$c}."} id=".$this->id."; " );
						$test = parent::setById( $c , $this->{$c} , $this->id );
						if (!$test){
							//fallo la actualizacion de un campo.
							$rt=false;
						}
					}
				}
			}
	   }
	   return $rt;
	}
	
    public function agregar(){
		// agregar nuevo.
		$b=true; // no se han cargado los campos.
		
		foreach($this->columnas as $c){
			if ($this->defecto($c)){
				$b=false;
			}
			/*
			if (isset($this->$c) and $this->$c<>"") {
				$b=false;
			}
			*/
		}
		// antes de llegar a este punto
		// todos los campos de la base 
		// deben estar cargados.	
		if ($b){
			// no hay valores
			debugf( "mesas:  no se han cargado los valores ::mesas::");
		}else{
			/*
				$sql = "INSERT INTO 'mesa' 
					('id', 'fecha', 'tiempo', 'TotalVontantes', 'Votantes', 'idDistrito', 'idseccion', 'idCircuito', 
					'idMesa', 'VotosBlancos', 'VotosNulos', 'VotosRecurridos', 'VotosInpugnados') 
					VALUES 
					(NULL, \'2017-07-07\', \'03:07:06\', \'600\', NULL, \'20\', \'7\', \'21\', 
					\'29\', NULL, NULL, NULL, NULL);";
			*/
			// $this->enEdicion = "S";// en edicion. S = si, N = no , C = cargada.
			
			$query="INSERT INTO `mesa` (`id`, `fecha`, `tiempo`, 
				`TotalVontantes`, `Votantes`, `idDistrito`, 
				`idseccion`, `idCircuito`, `idMesa`, `VotosBlancos`, 
				`VotosNulos`, `VotosRecurridos`, `VotosInpugnados`, `enEdicion`) 
					VALUES(NULL,
					". //	'".$this->id."' ,
					"	".$this->t("fecha")." ,
						".$this->t("tiempo")." ,
						".$this->t("TotalVontantes")." ,
						".$this->t("Votantes")." ,
						".$this->t("idDistrito")." ,
						".$this->t("idseccion")." ,
						".$this->t("idCircuito")." ,
						".$this->t("idMesa")." ,
						".$this->t("VotosBlancos")." ,
						".$this->t("VotosNulos")." ,
						".$this->t("VotosRecurridos")." ,
						".$this->t("VotosInpugnados")." ,
						".$this->t("enEdicion")."  );"; 
						
			// echo "<div>guardando: $query </div>";
			
			$save=$this->db()->query($query);
			if (!$save){
				// var_dump($this); 
				return null;
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
	
    public function selectionaMesa(){
		
		$query = "select id from mesa 
			where 
				( `idMesa` = ".$this->t("idMesa")." ) and
				( `idDistrito` = ".$this->t("idDistrito")." ) and 
				( `idCircuito` = ".$this->t("idCircuito")." ) and 
				( `idseccion` = ".$this->t("idseccion")." )
			limit 1;";
		$rt = $this->db()->query($query);
		
		if (!$rt){
				// no hay registro con esos datos.
				return false;
		}else{
			// echo "\n$query\n";
			
			if ($rt->num_rows > 0 ){
			$row = $rt->fetch_object();
			
			
			$this->id = $row->id ;
			// $dbmesa = $this->get_sesion("dbmesa");
			// $dbmesa["id"] = $this->id;
			// $this->set_sesion("dbmesa",$dbmesa); // modificando el valor estatico.
			// $this->save(); // guardar nuevos valores.
			
			return $this->id;
			}else{
				// la consulta no dio error pero no encontro registros.
				return false;
			}
		}
	
	}
    private function t($campo){
		// pequeño tratamiento a las variables.
		
		if (($this->$campo == "NULL") or ($this->$campo == "")){
			return "NULL";
		}else{
			return "'".$this->$campo."'";
		}
	}
	public function defecto($campo){
		$rt=false;
		$this->enEdicion = "S";// en edicion. S = si, N = no , C = cargada.
		$defecto = $this->defecto; // array con valores por defecto de los campos.
		
		if (isset($this->$campo)){ // el campo existe.
			if ($this->$campo <> ""){	// el campo es distinto de ""
				$rt=true; // campo correcto
				// echo "valso positivo para $campo:".$this->$campo."<--<br>\n";
			}else{
				// campo, buscar defecto porque esta sin contenido.
				if (isset($defecto[$campo])){
					$this->$campo = $defecto[$campo];
					$rt=true ;
					 
					debugf("mesas: cargo valor por defecto.");
				}else{
					
					$rt=false;
				}
			}
		}else{
			$rt= false;
			// echo "falso para $campo<br>\n";
		}
		return $rt;
	}
		
		
 
}
?>
