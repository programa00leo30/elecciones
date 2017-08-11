<?php
include("head.php");
$columnas= array(  	 
			"idDistrito" => array("confirmar el Distrito(Provincia)" , "provincia"),
			"idseccion" => array("confirmar la seccion (departamento)" ,"seccion"), 
			"idCircuito" => array("","ciudad",false) ,
			"idMesa"          => array("confirmar el nro de mesa: " ),

			"TotalVontantes" => array("cantidad total de los votantes:" ),
			"Votantes" => array("cuantos han votado:" ) , 
			"VotosBlancos"    => array("la cantidad de votos en blanco: "), 
			"VotosNulos"      => array("votos nulos:"), 
			"VotosRecurridos" => array("votos recurridos:"), 
			"VotosInpugnados" => array("votos inpugnados:") 
		);
					 
?>
    <body>
        <form action="<?php echo $helper->url("mesa","confirmarmesa"); ?>" method="post" class="col-lg-5">
            <h3>GRACIAS POR SU AYUDA: <?php 
					echo $_SESSION["registrado"]["nombre"] ;
				?></h3>
            <hr/>
            
			<?php 
			include("mesadetalleView.php");
			?>
			<hr><hr><hr>
            <?php
            include("mesaheadView.php");
            ?>
			
            <input type="submit" value="enviar" class="btn btn-success"/><br>
        
        
        </form>
         <section class="col-lg-7 usuario" style="height:400px;overflow-y:scroll;">
                <div class="right">
                    <a href="<?php echo $helper->url("mesa","error"); 
						?>" class="btn btn-danger">Modificar / Cargar otra mesa</a>
                </div>
                <hr/>
         </section>
        <?php include("footer.php") ?>
    </body>
</html>
