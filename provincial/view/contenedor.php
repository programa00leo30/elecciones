<?php

/* no tiene uso. solamente
 * es el contenedor principal.
 */

?>
	<main class="main-container" role="main">
		<div class="container">
		
			<div class="row">
				<div id="contenedor" class="col-xs-12 col-sm-12 col-md-12">
					<div id="combobox" class="hidden-print">
						<?php echo $selectorDeCiudad; ?>
					</div>
					<div id="datos" class="">
						<div id="titulo_categoria"><?php echo $titulo ?></div>
						<ul class="nav nav-tabs nav-justified" role="tablist">
							<li class="tab_gobernador active" role="presentation">
									<a href="#gobernador" aria-controls="gobernador" role="tab" data-toggle="tab" 
										class="tit_pestana">SENADOR</a></li>
							<li class="tab_dip_provincial" role="presentation">
									<a href="#dip_provincial" aria-controls="dip_provincial" role="tab" data-toggle="tab" 
										class="tit_pestana">DIP. NACIONAL</a></li>
						</ul>
						
								<?php 
									$partidos = new db("","select * from partidos where activo=0 ;");
									include("datos.php");
								?>

					</div>
				</div>
			</div>
		</div>
	</main>
	
