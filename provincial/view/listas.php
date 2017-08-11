<?php

$sqlLista="select * from listas where idPartido = '".$partido["id"]."' ;" ;
$db_lista = new db("",$sqlLista) ;
 
ob_start() ;
while(	$tod = $db_lista->fetch_array() ) {
$listaporciento = "40%";
?>
										<div class="listas">
												<div class="sublemas">
													<div class="partidos"><?php echo $tod["nombre"] ?></div>
													<div class="progress2">
														<div class="progress-bar progress-bar-warning progress-bar-striped active" 
														role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" 
														style="width:<?php $listaporciento ?>">
													  </div>
													</div>
												</div>
										</div>

<?php

} ;
$listas = ob_get_contents();
ob_end_clean();

?>
