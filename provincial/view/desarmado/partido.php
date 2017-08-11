<?php

/* cada partido tiene estos datos.:

	$nroPartido = nro de partido
	$nombrePartido = nombre del partido
	$imgPartido = nombre de la imagen del partido

	$partidoVotos = Votos obtenidos por el partido
	$partidoTotal = total de votos.
	
	$sublista  = es la infomacion de sublista contenplando los o el div. ( texto para agregar. )
*/

$nroPartido = (isset($nroPartido))?$nroPartido:"sin nombre";
$nombrePartido = (isset($nombrePartido))?$nombrePartido:"sin nombre";
$imgPartido = (isset($imgPartido))?$imgPartido:"img/noimg.png";


$partidoVotos = (isset($partidoVotos))?$partidoVotos:5;
$partidoTotal = (isset($partidoTotal))?$partidoTotal:10;
$sublista = isset($sublista)?$sublista:"";


$partidoPorcent = porcentaje( $partidoVotos , $partidoTotal );


?>
						<div class="datos" contagem="46.54">
						  <div class="images"><img src="<?php echo $img ?>" alt="<?php echo $nombrePartido ?>" width="110" height="56"></div>
						<div class="contenedor-barra">
							<div class="titulo"><?php echo $nroPartido ?> / <?php echo $nombrePartido ?></div>
							<div class="progress">
							  <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="46.54" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $partidoPorcent ?>% ; ">
							  <span class="sr-only"><?php echo $partidoPorcent ?>%</span>
							  </div>
							</div>
							  <div class="porcentaje"><?php echo $partidoPorcent ?>%</div>
							  <div class="cantidad2">(<?php echo $partidoVotos ?> Votos)</div>
							<div class="listas">
								<?php echo $sublista ?>
							  </div>
						  </div>
						 </div>
