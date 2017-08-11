<?php
include("head.php");
 
?>
    <body>
		<div class="container">
			<div class="row">
		<?php if (isset($msg)) echo "<div>$msg</div>" ; ?>
        <form action="<?php echo $helper->url("login","login"); ?>" method="post" class="col-xs-4 col-sm-6 col-lg-12">
            </div>
             <h2>Bienvenido:</h2>
            <div class="container">
					<div class="row">
						
            <div class="col-xs-8 col-sm-8 col-lg-12">
	<input type="text" name="login" class="form-control" placeholder="Nombre"></div>
					</div>
            <div class="row"
					<div class="col-xs-4 col-sm-6 col-lg-12">
						<p class="text-justify">
            <input type="submit" value="Enviar" class="btn btn-success"/>
        </form></p>
         </div>
          </div>
					<?php include("footer.php") ?>
				</div>
			</div>
        </div>
    </body>
</html>
