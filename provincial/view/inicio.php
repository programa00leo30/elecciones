<?php


$id = "id=\"menu_localidad\" onChange=\"mostrarInfo(this.value)\" class=\"form-control input-lg no-scroll\" data-style=\"btn-primary\" >
<option value='-1'>Total Provincial</option";

$selectorDeCiudad = $ciudad->toSelect("ciudad",$id,"id","nombre",$selction="");
// $selectorDeCiudad = utf8_decode($selectorDeCiudad);
$selectorDeCiudad = utf82iso88592($selectorDeCiudad);


$titulo = "Total Provincial";
$cargos = new db("","select * from cargos where activo=0 ");

ob_start();

include("head.php");
include("chamullo.php");
include("contenedor.php");
include("piepagina.php") ;

$pagina = ob_get_contents();
ob_end_clean();

echo utf8_decode($pagina ); 
// echo "correccion terminada";
// echo $selectorDeCiudad;

$str="<select name='$nombre' $id >\n";		
		// var_dump($this->recordset["get_row"]);
		// var_dump($this->recordset["campos"]);
		// var_dump($this->recordset["query"]);
		while ( $reg = $this->fetch_array() ) {
			// var_dump($reg);
			$str.="\t<option value='".$this->recordset["get_row_texto"][$ValorCampo]."' >".
				$this->recordset["get_row_texto"][$campo]."</option>\n";
		} 
		
		
