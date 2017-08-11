<?php


/* sublemas. 
	esto es cada sublista tienen este bloque
	valores que se deben obtener.
	$nombreCandidato = nombre del candiadto
	$nombreLista = nombre de la lista
	
*/

$norCandidato = (isset($norCandidato))?$norCandidato:"5";
$nombreLista = (isset($nombreLista))?$nombreLista:"sin nombre";


?>
													<div class="no_sublemas ">
														<div class="partidos"><?php 
														echo "(".$norCandidato.")".$nombreLista ?></div>
													</div>
