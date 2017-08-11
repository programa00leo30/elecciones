<?php
$candidatos = new candidatos();
$listas = new EnLista();
$registros = $listas->getAll("ORDER BY NroPartido ASC ");
$mesadetalle = new mesadetalle();

$valores = $mesadetalle->getBy("idMesa", $mesas->id);

function buscar ($arreglo, $lista, $cargo){	
	foreach($arreglo as $k){
		// var_dump($k);
		if ($k->idlista == $lista and $k->idCargo == $cargo){
			return $k->cantidad;
			break;
		} 
	
	}
	return "";
}

?>

            <h3>PARTIDOS / LISTAS:</h3>
            <hr/>
        
        	<table>
				
            <?php $nr= -1; 
				foreach($registros as $l) { //recorremos el array de objetos y obtenemos el valor de las propiedades ?>
                <?php 
					
					
				if (($l->Senador + $l->diputado )>0){
						// cantidad de votos cargados.
						$ValSenador = buscar($valores,$l->id,2);
						$Valdiputado = buscar($valores,$l->id,3);
						/*
						
						$nombre = "";
						if ($l->Senador == 1 ) {
							$a=$candidatos->getById($l->SenadorCandiato);
							$nombre .= $a->apellido.", ".$a->nombre." - ";
							$nombre .= $l->nombre;
						}
						if ($l->diputado == 1 ) {
							// $a = $candidatos->getById($l->DiputadoCandiato);
							// $nombre .= $a->apellido.", ".$a->nombre;
							$nombre .= $l->nombre;
						}
						*/
						if (!($nr == $l->NroPartido)){
							$nr = $l->NroPartido ;
							$nombre = "<hr> [$nr]".$l->AgrupacionPolitica."<br>\n";
						}else{
							$nombre = "";
						} 
						echo "<tr>\n<td colspan=2>"; // fila donde figura el nombre de la agurpacion	
						// echo $l->AgrupacionPolitica .
						echo $nombre . 	" ". $l->nombre ." " ;
						echo "</td></tr>\n";
						
						echo "<tr>\n";
						
						
						if ($l->Senador == 1 ){ // columna 1
							// aqui verifico si son 1 o 2 columnas:
							
							if ($l->diputado == 1){
								// existe diputado ( 2 columnas )
								echo "<td>\n";
							}else{
								// no existe diputado ( 1 columna)
								echo "<td colspan=2> \n";
							}
						?>
							<input type="number" name="<?php 
							echo "lista_senadores[".$l->id."]" ;?>"  value="<?php 
							echo $ValSenador; ?>" class="form-control"  placeholder="Senador" value="0" /> 
						
						
						<?php 
							
							echo "</td>"; // cierre de la columna. 
						};
						
						
						if ($l->diputado == 1 ){ // columna 2
						
						// aqui verifico si son 1 o 2 columnas:
							if ($l->Senador == 1){
								// existe diputado ( 2 columnas )
								echo "<td>\n";
							}else{
								// no existe diputado ( 1 columna)
								echo "<td colspan=2> \n";
							} 
							
						?>
							<input type="number" name="<?php 
							echo "lista_diputados[".$l->id."]" ;?>"  value="<?php 
							echo $Valdiputado;?>" class="form-control" placeholder="Diputado" value="0" /> 
						<?php 
						
						
							// cierre de columna:
							echo "</td>\n" ; 
						
						}	
					
					echo "</tr>\n"; // cierre de fila.
				}; 
					
					
					
			};
					
					?>
					
			</table>
                
        
