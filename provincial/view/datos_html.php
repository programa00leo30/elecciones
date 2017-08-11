<!-- DATOS -->
								<div class="datos" contagem="100">
									<div class="images"><img src="img/<?php echo $npartido ?>.png" alt="<?php echo $npartido ?>.png" width="110" height="56"></div>
									<div class="contenedor-barra">
										<div class="titulo"><?php echo $tituloLista ?></div>
										<div class="progress">
										  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $porcent ?>">
											<span class="sr-only"><?php echo $porcent ?></span>
										  </div>
										</div>
										<div class="porcentaje"><span><?php echo $porcent ?></span></div>
										<div class="cantidad2">(<?php echo $totalVotos ?> Votos)</div>
										<?php 
											echo $listas
										?>
									</div>
								</div>
<!--FIN DATOS -->
