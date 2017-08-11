<?php
/*

paneles:

$partidos 			= los contenedores de todos los partidos.
$total 				= contenedor de todos los totales

$tabpane 			= posibles = " active" o "" 

$tituloTabpane 		= "Diputado nacional" o "Sendadores"
$idP 				= "dip_provincial" o "gobernador" el valor de panel.

*/




?>
					<div role="tabpanel" class="tab-pane fade <?php echo $tabpane ?> " id="<?php echo $idP ?>">
						<?php echo $contenidoPanel ?>
						
					</div>
