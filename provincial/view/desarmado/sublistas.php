<?php

/* sublemas. 
	esto es cada sublista tienen este bloque
	valores que se deben obtener.
	$nombreCandidato = nombre del candiadto
	$nombreLista = nombre de la lista
	$listaVotos = Votos obtenidos por la lista
	$listaTotal = Votos obtenidos por el partido
	
*/

$nombreCandidato = (isset($nombreCandidato))?$nombreCandidato:"sin nombre";
$nombreLista = (isset($nombreLista))?$nombreLista:"sin nombre";
$lnombreCandidato = (isset($lnombreCandidato))?$lnombreCandidato:"sin nombre";

$listaVotos = (isset($listaVotos))?$listaVotos:5;
$listaTotal = (isset($listaTotal))?$listaTotal:10;


$listporcent = porcentaje($listaVotos , $listaTotal );

?>
													<div class="sublemas" data-toggle="tooltip" data-placement="left" title="" data-original-title="<?php echo $lnombreCandidato ?>">
													  <div class="partidos"><?php echo $lnombreCandidato ?></div>
													  <div class="progress2">
														<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $listporcent."%" ?>">
														</div>
													  </div>
													  <div class="cantidad">(<?php echo $listaVotos ?> Votos)</div>
													  <div class="porcentaje2"><?php echo $listporcent ."%" ?></div>
													</div>
