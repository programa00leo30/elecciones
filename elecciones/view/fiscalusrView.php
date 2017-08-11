<?php
include("head.php");

?>
    <body>
		<form action="<?php echo $helper->url("fiscal","crear"); ?>" method="post" class="col-lg-5">
            <h3>Añadir usuario</h3>
            <hr/>
            Nombre: <input type="text" name="nombre" class="form-control"/>
            documento: <input type="text" name="usr" class="form-control"/>
            nivel de acceso: <input type="text" name="password" class="form-control" value=50 />
            <input type="submit" value="enviar" class="btn btn-success"/>
        </form>
        <div class="col-xs-12 col-sm-6 col-md-8">
			<a class="btn btn-success" href="<?php echo $helper->url("fiscal","index"); ?>">refrescar</a>
        <div class="col-xs-12 col-sm-6 col-md-8">
            <h3>fiscales:</h3>
            <hr/>
        </div>
        <section class="col-xs-12 col-sm-6 col-md-8 usuario"  >
            <?php foreach($allusers as $user) { //style="height:400px;"overflow-y:scroll;" recorremos el array de objetos y obtenemos el valor de las propiedades ?>
                <?php echo $user->id; ?> -
                <?php echo $user->nombre; ?> -
                <?php echo $user->usr; ?> -
                <?php 
                if( $user->activo == "on" ) 
					echo "<a class=\"right btn btn-success\" href=\"".$helper->url("fiscal","offline&id=".$user->id ) ."\">online</a>";
				else
					echo "<a class=\"right btn btn-danger\" href=\"".$helper->url("fiscal","online&id=".$user->id ) ."\">offline</a>";
					// echo "<div class='btn btn-danger' >ofline</div>"; 
					?> -
                <div class="right">
                    <a href="<?php echo $helper->url("fiscal","borrar"); 
						?>&id=<?php echo $user->id; ?>" class="btn btn-danger">Borrar</a>
                </div>
                <hr/>
            <?php } ?>
        </section>
         
        <?php include("footer.php") ?>
    </body>
</html>
