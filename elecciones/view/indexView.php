<?php
include("head.php");
?>
    <body>
        <form action="<?php echo $helper->url("mesa","index"); ?>" method="post" class="col-xs-12 col-sm-6 col-md-8">
            <h3>Bienvenido:<?php 
					echo $_SESSION["registrado"]["nombre"] ;
				?></h3>
				</div>
            <hr/>
            <div class="row">
  <div class="col-xs-12 col-sm-8 col-md-8">
            Nombre: <input type="text" name="nombre" class="form-control"/>
            <input type="submit" value="enviar" class="btn btn-success"/>
			</form>
			</div>
        </div>  
        <?php include("footer.php") ?>
    </body>
</html>
