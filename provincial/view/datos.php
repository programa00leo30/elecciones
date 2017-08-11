<?php

$partido = new EntidadBase("( SELECT 
	p.id AS id, 
	p.AgrupacionPolitica AS partido
from partidos as p
WHERE p.activo = 0
ORDER BY p.AgrupacionPolitica ASC ) as a ");

$partidos = $partido->getAll() ;

$candidato = new EntidadBase(" ( SELECT 
	ca.id,ca.nombre,ca.apellido,ca.idCargo , cl.idLista  
	FROM   candidatosEnLista as cl 
	LEft join `candidatos` as ca  
	on cl.idCandidato = ca.id ) as a ");

$candidatos = $candidato->getAll();


?>
<!-- tab panel paneles -->
					<div class="tab-content">
<!-- tab 1 -->
						<div role="tabpanel" class="tab-pane active" id="gobernador">
							<div class="titulo_tab">Senador</div>
								<div class="col-xs-12 col-sm-12 col-md-9">
									<div id="pai" class="pai">
<?php
foreach ($partidos as $ElPartido )
	{
	 // filtro listas por partido.:
	 $listas = $EnLista->getBy(" Senador = '1'  and idPart",$ElPartido->id  );
 
	foreach ($listas as $lista  ) {
	
		$postulante = $candidato->getBy("idLista",$lista->id);
		// hay que calcular estadisticas por candidato:
		$listaporciento = "50%" ; // calcular despues.
		$sumaVotos = 200; // suma de votos por lista. ( del total )

?>
<!-- DATOS -->
										<div class="datos" contagem="100">
										<div class="images"><img src="img/partido_mas.png" alt="MAS" width="110" height="56"></div>
											<div class="contenedor-barra">
												<div class="titulo"><?php 
														echo $lista->NroPartido." / ".$lista->AgrupacionPolitica ?></div>
												<div class="progress">
												  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" 
														aria-valuemax="100" style="width:<?php echo $listaporciento ?>">
													<span class="sr-only"><?php echo $listaporciento ?></span>
												  </div>
												</div>
												<div class="porcentaje"><span><?php echo $listaporciento ?></span></div>
												<div class="cantidad2">(<?php echo $sumaVotos ?> Votos)</div>
												<div class="listas">
													<div class="no_sublemas ">
														<div class="partidos"><?php 
														echo "(".$lista->NroLista.")".$lista->nombre ?></div>
													</div>
												</div>
											</div>
										</div>
<!-- fin de datos -->						
<?php
		
		};
	};
?>

						</div>
<!-- segun veo son 2 div a cerrar. -->					
				
<!-- fin senadores -->

								<div id="titulo_imp">
										<div class="hora">Ultima actualizaci&oacute;n &nbsp17:15 hs.</div>
									</div>
									
									<?php  include("totales.php") ?>
								</div>	
<!-- tab panel diputados -->
							<div role="tabpanel" class="tab-pane" id="dip_provincial">
								<div class="titulo_tab">Diputado Nacional</div>

<?php
foreach ($partidos as $ElPartido )
	{
	 // filtro listas por partido.:
	 $listas = $EnLista->getBy(" diputado = '1'  and idPart",$ElPartido->id  );
 
	foreach ($listas as $lista  ) {
	
		$postulante = $candidato->getBy("idLista",$lista->id);
		// hay que calcular estadisticas por candidato:
		$listaporciento = "50%" ; // calcular despues.
		$contagem = 100; 		  // cantidad de gente que voto.

		
// 
?>
<!-- DATOS -->
										<div class="datos" contagem="<?echo $contagem ?>">
										<div class="images"><img src="img/partido_mas.png" alt="MAS" width="110" height="56"></div>
											<div class="contenedor-barra">
												<div class="titulo"><?php 
														echo $lista->NroPartido." / ".$lista->AgrupacionPolitica ?></div>
												<div class="progress">
												  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" 
														aria-valuemax="100" style="width:<?php echo $listaporciento ?>">
													<span class="sr-only"><?php echo $listaporciento ?></span>
												  </div>
												</div>
												<div class="porcentaje"><span><?php echo $listaporciento ?></span></div>
												<div class="cantidad2">(<?php echo $sumaVotos ?> Votos)</div>
												<div class="listas">
													<?php echo $listas ; ?>
												</div>
											</div>
										</div>
<!-- fin de datos -->			
<?php
// */
		};
	};	
?>
								
							</div>
						</div>		
					</div>
				</div>
			</div>
			</div>
			

	


