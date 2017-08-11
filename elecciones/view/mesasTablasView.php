<?php

/* valores estadisticos para fiscales que lo deseen.

*/

// var_dump($ciudad);
$sql="( SELECT m.*,d.idlista, d.idCargo, d.cantidad 
	FROM mesa as m left join mesadetalle as d on d.idMesa = m.id 
	WHERE m.idCircuito = '".$ciudad->id."' and m.idElecion = '1' ) as a ";
	

if (isset($_SESSION["login"])){
	$nivel = $_SESSION["login"]["aceso"];
	if ($nivel < 50 ){
		$sql="( SELECT m.*,d.idlista, d.idCargo, d.cantidad 
	FROM mesa as m LEFT JOIN mesadetalle as d ON d.idMesa = m.id 
	WHERE idElecion = '1' 
	ORDER BY m.id ASC  ) as a ";
	}
}else{
	// sin nivel adquirido.
	$nivel = 99;	
}
		


// echo $sql;
$dato = new EntidadBase($sql);

$candidatos = new candidatos();
$listas = new EnLista();
$registros = $listas->getAll();

include("head.php");

?>
<table border='2' >
<?php
// encabezado:
echo "<tr><th>nro de mesa</th><th>hora de actualizacion</th><th>TotalVotos / Votaron</th>";
$rt="<tr><th></th><th></th><th></th>";
$listados = $listas->getAll();

foreach ($listados as $l){

echo "<th colspan = 2 alt= \"lista_".$l->id . "\" >".$l->nombre."</th>";	

$sen = ($l->Senador == 1 )? 
	"SEN"
	// $candidatos->getById($l->SenadorCandiato)->nombre.", ".$candidatos->getById($l->SenadorCandiato)->apellido 
	: "xx";
$dip = ($l->diputado==1 )? 
	"DIP"
	// $candidatos->getById($l->DiputadoCandiato)->nombre.", ".$candidatos->getById($l->DiputadoCandiato)->apellido 
	: "xx";

$rt .= "<th>".$sen."</th><th>".$dip."</th>";
}

function ordenamiento($listados,$mitabla){
	// foreach($mitabla as $k=>$v){
	foreach ($listados as $l){
		$rt=""; 
		$alt = "alt=\"lista_".$l->id."\" ";
		$no= "<td $alt >xx</td>";
		if (isset($mitabla[$l->id])){
			$v = $mitabla[$l->id];
			if (isset($v[2])) {// senador
				$rt .= "<td $alt >".$v[2]."</td>";
			}else {
				// sin senador.
				$rt .=$no.$rt;
			}
			if (isset($v[3])) {
				// diputado
				$rt .= "<td $alt >".$v[3]."</td>";
			}else{
				// sin diputado
				$rt .= $rt.$no;
			}
			echo $rt;
		
		}else{
			echo "<td $alt colspan=2 >no hay datos</td>" ;
		}
			
	}
	
	
	
}
echo "</tr>\n$rt</tr>\n";
// var_dump($dato);
$datos = $dato->getAll();
$idreg = -1 ;
// var_dump($datos);
$mitabla = array();
	$st= "";$so = "";
if (isset($datos)) {
	foreach ($datos as $dat){
		

		if ($dat->id <> $idreg ){
			// antes de pasar al siguiente registro cargo el anterior.
			if (count($mitabla) > 0 ){
				// var_dump($mitabla);
				echo $st;
				ordenamiento($listados,$mitabla);
				echo $so;
				$mitabla=array(); // limpiando.
				$st= "";$so = "";
			}
			$btn=""; // sin boton.
			if ($nivel < 20 ){
					// puede confirmar las mesas
				$btn = "c:(\"".$dat->idCircuito."\")";
				if ( $dat->verificado == "0" ){
					$btn.="<a href=\"".$helper->url("mesa","confirmar&id=".$dat->id)."\" >confirm</a>";
				}
			}
			
			
			$st .= $so."<tr><td>"
				.$dat->idMesa . "</td><td>"
				.$dat->tiempo .$btn. "</td><td>"
				.$dat->TotalVontantes ." / " .$dat->Votantes . "</td>";
				
			$so .= "</tr>\n";
			$idreg = $dat->id ;
		}
		
		$mitabla[ $dat->idlista ][ $dat->idCargo ] = (isset($dat->cantidad)?$dat->cantidad:"-!data-");
		
		// $cargo = ($dat->idCargo==2)?"Dip:":"Sen:";
		/*
		echo  $st.
			// "<td>".$dat->idlista."</td>"
			// ."<td>".$dat->idCargo."</td>"
			"<td>".$cargo.$dat->cantidad."</td>";
		*/
		
	}
	if (count($mitabla) > 0 ){
		// var_dump($mitabla);
		echo $st;
		ordenamiento($listados,$mitabla);
		echo $so;
		$mitabla=array(); // limpiando.
		$st= "";$so = "";
	}
} // no hay datos en la tabla.

 $url = $helper->url("mesa","index");
?>
</table>
<div class="left">
	<a href="<?php echo $url ; ?>" class="btn btn-danger">regresar a carga</a>
	</div>
</html>
