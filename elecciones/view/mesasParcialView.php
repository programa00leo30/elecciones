<?php
include("head.php");
// var_dump($mesas);

$parcial = round(( ( $mesas->Votantes / $mesas->TotalVontantes )  * 100 ),0) ."%";


?>
    <body>
		<div class="container">
        <form action="<?php echo $helper->url("mesa","parcial"); ?>" method="post" class="col-lg-5">
            <h3>Carga pacial: <?php echo $_SESSION["registrado"]["nombre"] ; ?></h3>
			<h4>Distrito: (<?php echo $provincia->nombre ?>)Circuito: (<?php 
			 echo $ciudad->nombre ?>) Mesa: (<?php echo $mesas->idMesa ?>)</h4>
				<hr/>
            <div >
            parcial: <input type="number" name="Votantes" class="form-control" value="<?php echo $mesas->Votantes ?>" />
            <input type="submit" value="parcial" class="btn btn-success" name="parcial"/>
			</div>
        </form></div>
        </div>
        
        <!-- Barra -->
        
        <style type="text/css">
        input{display:block; margin-bottom:5px;}
        #contenedor{margin:0 auto; padding:5px;}
</style>

        <div class="container">
        <div class="row">
			<div id="contenedor">
			        <div class="col-xs-8 col-sm-8 col-lg-8">
				<div class="progress">
				<div class="progress-bar progress-bar-success progress-bar-striped" 
				 style="width:<?php echo $parcial ?>"aria-valuenow="60" aria-valuemin="0"
				  aria-valuemax="100" style="width:<?php echo $parcial ?>"><?php echo $parcial ?></div>
					<span class="sr-only"></span>
		</div>
		</div>

			</div>
					</div>
				</div>
			</div>
        </div>
        </div>
        
        <!--Barra--> 
        <div class="container">
        <div class="row">
         <div class="col-xs-4 col-sm-6 col-lg-12">
            <h3>Otras acciones:</h3>
					<hr/>
				</div>
			</div>
        <section class="usuario" style="height:50px">
                    <a href="<?php echo $helper->url("mesa","error"); 
						?>" class="btn btn-danger">Me equivoque con los datos</a>
                </div></div>
                <div class="container">
                <div class="row">
				         <div class="col-xs-4 col-sm-6 col-lg-12" style="height:50px">
                    <a href="<?php echo $helper->url("mesa","cerrarmesa"); 
						?>" class="btn btn-primary">Cerramos mesa, voy a cargar datos</a>
					</div>
					</div>
                </div>
					</div>
					
					<div class="container">
						<div class="row">
					</section>
						<?php include("footer.php") ; ?> 
        </div>
         </div>
    </body>
</html>
