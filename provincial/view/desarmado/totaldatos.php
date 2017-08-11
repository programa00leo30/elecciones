<?php
/*
	total de valores se ingresa dos veces.

*/

/*
$afirmativos = 151840 ; // cantidad de votantes empadronados.
$blanco = 9631 ;
$Impugnados = 32 ;
$recurridos = 176 ;
$nulos =2022;
$totalmesas = 821 ; // cantidad de mesas.
$escrutmesas = 719 ; // cantidad de mesas escrutadas ( cerradas. )


$empadron = 239130 ; // cantidad de votantes empadronados.
*/

$votaron = $afirmativos + $blanco + $Impugnados +$recurridos + $nulos ;	// cantidad de personas que votaron.

$votporcent = porcentaje($votaron , $empadron );
$afirmativos_porcetn = porcentaje($afirmativos , $empadron) ;
$blanco_porcent = porcentaje($blanco , $empadron) ;
$recurridos_porcent = porcentaje($recurridos , $empadron) ;
$Impugnados_porcent = porcentaje($Impugnados , $empadron) ;
$nulos_porcent = porcentaje($nulos , $empadron) ;
$porcentmesas = porcentaje( $escrutmesas , $totalmesas )   ; 

?>

						    <div class="col-xs-12 col-sm-12 col-md-3">
								<div id="totales">		
									<div class="titulo" >EMPADRONADOS</div>
									<div class="totales">
										<div class="tr">
											<div class="cuadro">Totales:</div>
											<div class="cuadro1"><?php echo $empadron ?></div>
										</div>
										<div class="tr">
											<div class="cuadro">Votaron:</div>
											<div class="cuadro1"><?php echo $votaron ?></div>
											<div class="cuadro2"><?php echo $votporcent ?>%</div>
										</div>
									</div>
									
								</div>
								
								<div id="totales">
										<div class="titulo" >MESAS</div>
										<div class="totales">
											<div class="tr">
												<div class="cuadro">Totales:</div>
												<div class="cuadro1"><?php echo $totalmesas ?></div>
											</div>
											<div class="tr">
												<div class="cuadro">Escrutadas:</div>
												<div class="cuadro1"><?php echo $escrutmesas ?></div>
												<div class="cuadro2"><?php echo $porcentmesas ?>%</div>
										    </div>
										</div>
								</div>
								
								<div id="totales">
									<div class="titulo" >VOTOS</div>
									<div class="totales">
										<div class="tr">
											<div class="cuadro">Afirmativos:</div>
											<div class="cuadro1"><?php echo $afirmativos ?></div>
											<div class="cuadro2"><?php echo $afirmativos_porcetn ?>%</div>
										</div>
										<div class="tr">
											<div class="cuadro">Blancos:</div>
											<div class="cuadro1"><?php echo $blanco ?></div>
											<div class="cuadro2"><?php echo $blanco_porcent ?>%</div>
										</div>
										<div class="tr">
											<div class="cuadro">Nulos:</div>
											<div class="cuadro1"><?php echo $nulos ?></div>
											<div class="cuadro2"><?php echo $nulos_porcent ?>%</div>
										</div>
										<div class="tr">
											<div class="cuadro">Recurridos:</div>
											<div class="cuadro1"><?php echo $recurridos ?></div>
											<div class="cuadro2"><?php echo $recurridos_porcent ?>%</div>
										</div>
										<div class="tr">
											<div class="cuadro">Impugnados:</div>
											<div class="cuadro1"><?php echo $Impugnados ?></div>
											<div class="cuadro2"><?php echo $recurridos_porcent ?>%</div>
										</div>
									</div>
								</div>
							</div>
