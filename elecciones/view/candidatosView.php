<?php
include("head.php");

?>
    <body>
		<div class="col-xs-12 col-sm-6 col-md-8">
            <h3>candidatos:</h3>
            <hr/>
        </div>
        <section class="col-xs-12 col-sm-6 col-md-8 usuario" style="height:400px;overflow-y:scroll;">
            <?php foreach($candidatos as $user) { //recorremos el array de objetos y obtenemos el valor de las propiedades ?>
                <?php echo $user->id; ?> -
                <?php echo $user->nombre; ?> -
                <?php echo $user->apellido; ?> -
                <?php echo $cargos->getById($user->idCargo)->nombre ; ?> -
                <div class="right">
                    <a href="<?php echo $helper->url("candidatos","borrar"); 
						?>&id=<?php echo $user->id; ?>" class="btn btn-danger">Borrar</a>
                </div>
                <hr/>
            <?php } ?>
        </section>
         
        <?php include("footer.php") ?>
    </body>
</html>
