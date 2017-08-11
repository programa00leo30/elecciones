<?php
include("head.php");

?>
    <body>
        <form action="<?php echo $helper->url("mesa","modificar"); ?>" method="post" class="col-lg-5">
            <h3>Bienvenido, Fiscal General: <?php 
					echo $_SESSION["login"]["nombre"] ;
				?></h3>
            <hr/>
            Mesa: <input type="number" name="idMesa" class="form-control"value="<?php echo $mesas->idMesa ?>" /><br>
            <input type="submit" name="nuevo" value="Nueva Mesa" class="btn btn-success"/><br>
            <input type="submit" name="modificar"   value="Modificar Mesa" class="btn btn-success"/><br>
        </form>
         <?php if (isset($ciudad)){
			 $url = $helper->url("mesa","verplanilla");
		?>	 
         <div class="left">
	<a href="<?php echo $url ; ?>" class="btn btn-danger">ver planilla</a>
	</div>
	
        <?php };
        include("footer.php") ?>
    </body>
</html>
