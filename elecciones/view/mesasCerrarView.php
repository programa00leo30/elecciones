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
    
		<div class="container">
			<div class="row">
				<div class="col-xs-8 col-sm-8 col-lg-8">
				
        <form action="<?php echo $helper->url("mesa","confirmarmesa"); ?>" method="post">
            <h3>GRACIAS POR TU AYUDA <?php 
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
			
			<div class="row">
			<div class="col-xs-4 col-sm-4 col-lg-4">
            <input type="submit" value="enviar" class="btn btn-success"/><br>
        
         </div></div>
        </form>
       
           <style type="text/css">
        input{display:block; margin-bottom:5px;}
        #equivocado{margin:0 auto; padding:5px;}
        </style>
       
				<div id="equivocado">
         <section class="usuario">
                    <a href="<?php echo $helper->url("mesa","error"); 
						?>" class="btn btn-danger">Me equivoque con los datos</a>
                 
        <?php include("footer.php") ?>
    </body>
</html>
