<?php
include("head.php");
/*
Circuito: (<?php echo $ciudad->nombre ?>)<input type="number" name="idCircuito" max="24" class="form-control"value="<?php echo $ciudad->id ?>" /><br>
            
*/

?>
    <body>
		<div class="container"> 
        <form action="<?php echo $helper->url("mesa","parcial"); ?>" method="post" class="col-lg-5">
        <blockquote>
  <p><H3>Bienvenido <?php echo $_SESSION["registrado"]["nombre"] ;?></H3></P>
				
</blockquote>
            <hr/>
            Distrito: (<?php echo $provincia->nombre ?>)<input type="number" name="idDistrito" max="24" class="form-control" value="<?php echo $provincia->id ?>" /> <br>
            Mesa: <input type="number" name="idMesa" class="form-control"value="<?php echo $mesas->idMesa ?>" /><br>
            Total de Votantes: <input type="number" name="TotalVontantes" class="form-control"value="<?php echo $mesas->TotalVontantes ?>" /><br>
            <p class="text-justify">
            <input type="submit" value="enviar" class="btn btn-success"/><br>
        </form></div></p>
        <div class="row"></div>
         
        <?php include("footer.php") ?>
    </body>
</html>
