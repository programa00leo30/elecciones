<?php
// $filtr = "and idDistrito = ? ";
// $filtr = "and idseccion = ? ";
// $filtr = "and idCircuito = ? ";
$totalSql = "( select 
	
	sum(TotalVontantes) as Tvotan,
	sum(VotosBlancos) as blanco,
	sum(VotosNulos) as nulos,
	sum(VotosRecurridos) as recurridos,
	sum(VotosInpugnados) as inpugnados,
	sum(cantidad) as recuento ,
	count(mesa.id) as mesas
	from mesa
		left join mesadetalle 
			on mesadetalle.idMesa = mesa.id 
	) as a " ;

$totalSql ="(  select `fecha` as id, `TotalVotantes`, `idCircuito`, `VotosBlancos`, 
`VotosNulos`, `VotosRecurridos`, `VotosInpugnados`, `idlista`, `idCargo`, `Votos`, `SUmino`, `SUman` 
from votosMesas ) as a ";

$db_mesas = new EntidadBase($totalSql);
$registros = $db_mesas->getAll(); 
$t = $registros[2] ;
var_dump($t);
/*
object(stdClass)#92 (12) { ["id"]=> string(10) "2017-07-10" ["TotalVotantes"]=> NULL ["idCircuito"]=> string(2) "21" 
["VotosBlancos"]=> NULL ["VotosNulos"]=> NULL ["VotosRecurridos"]=> NULL ["VotosInpugnados"]=> NULL 
["idlista"]=> NULL ["idCargo"]=> NULL ["Votos"]=> NULL ["SUmino"]=> string(1) "0" 
["SUman"]=> string(1) "4" } 
*/
$votaron = 6400; // $t->recuento + $t->blanco + $t->nulos + $t->recurridos + $t->inpugnados  ;
// */

// $votaron = 60000;
// $t->Tvotan  = 4500;

?>	
								<div class="col-xs-12 col-sm-12 col-md-3">
									<div id="totales">
										<div class="titulo" >EMPADRONADOS</div>
												<div class="totales">
													<div class="tr">
														<div class="cuadro">Totales:</div>
														<div class="cuadro1"><?php echo $t->Tvotan  ?></div>
													</div>
													<div class="tr">
														<div class="cuadro">Votaron:</div>
														<div class="cuadro1"><?php echo $votaron ?></div>
														<div class="cuadro2"><?php 
															echo round(($votaron/$t->Tvotan )*100 ,2)."%" 
															?></div>
													</div>
												</div>
												<div class="titulo" >MESAS</div>
												<div class="totales">
														<div class="tr">
															<div class="cuadro">Totales:</div>
															<div class="cuadro1"><?php echo $t->mesas  ?></div>
														  </div>
														<div class="tr">
															<div class="cuadro">Escrutadas:</div>
															<div class="cuadro1"><?php echo  $t->mesas  ?></div>
															<div class="cuadro2"><?php echo 
															round(($t->mesas /$t->mesas )/100,2)."%"?></div>
														  </div>
												</div>
												<div class="titulo" >VOTOS</div>
												<div class="totales">
														<div class="tr">
															<div class="cuadro">Afirmativos:</div>
															<div class="cuadro1"><?php echo $t->recuento  ?></div>
														<div class="cuadro2"><?php echo 
															round(($t->recuento /$t->Tvotan )*100,2)."%" ?></div>
														</div>
														<div class="tr">
															<div class="cuadro">Blancos:</div>
															<div class="cuadro1"><?php echo $t->blanco  ?></div>
															<div class="cuadro2"><?php echo 
															round(($t->blanco /$t->Tvotan )*100,2)."%" ?></div>
														</div>
														<div class="tr">
															<div class="cuadro">Nulos:</div>
															<div class="cuadro1"><?php echo $t->nulos  ?></div>
															<div class="cuadro2"><?php echo 
															round(($t->nulos /$t->Tvotan )*100,2)."%" ?></div>
														</div>
														<div class="tr">
															<div class="cuadro">Recurridos:</div>
															<div class="cuadro1"><?php echo $t->recurridos  ?></div>
															<div class="cuadro2"><?php echo 
															round(($t->recurridos /$t->Tvotan )*100,2)."%" ?></div>
														</div>
														<div class="tr">
															<div class="cuadro">Impugnados:</div>
															<div class="cuadro1"><?php echo $t->inpugnados  ?></div>
															<div class="cuadro2"><?php echo 
															round(($t->inpugnados /$t->Tvotan )*100,2)."%" ?></div>
														</div>
												</div>
										</div>
									</div>
								</div>
