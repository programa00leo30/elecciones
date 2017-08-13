<?php

include("funciones.php");
include("head.php");
include("chamullo.php");

$fecha = "2017-8-13";
$idEleccion = idEleccionDefecto;
// $idCiudad = -1 ; // ciudad.

$totalMesa = new EntidadBase("TotalMesas");
// $Pagtitulo ="TODA LA PROVINCIA"; // ?? ELEGIR TITULO ??

if (!isset($idCiudad) ){
	$idCiudad= -1 ;
	$tm=$totalMesa->getAll();
	$c=0;$e=0;
	foreach($tm as $t){
		$c+=$t->TotalMesas;
	}
	$te=$ciudades->getAll();
	foreach($te as $t){
		$e+=$t->habitantes;
	}
}else{
	$c=0;$e=0;
	if ($idCiudad > 0 ){
			
		$tm = $totalMesa->getBy("idCiudad",$idCiudad);
		if (isset($tm[0]))	$c = $tm[0]->TotalMesas;
		else $c=0;
		
		$te=$ciudades->getById($idCiudad);
		$e=$te->habitantes;
		
	}else{
		$tm=$totalMesa->getAll();
		$c=0;	
		foreach($tm as $t){
			$c+=$t->TotalMesas;
		}
		$te=$ciudades->getAll();
		foreach($te as $t){
			$e+=$t->habitantes;
		}
		
	}	
}


$totalMesas = $c ;
$empadronados = $e ; //246090;


/* foreach ($lsistaCiudad as $reg){
	$partido = new EntidadBase("( SELECT 
	p.id AS id, 
	p.AgrupacionPolitica AS partido
	from partidos as p
	WHERE p.activo = 0
	ORDER BY p.AgrupacionPolitica ASC ) as a ");

$partidos = $partido->getAll() ;
*/

$candidato = new EntidadBase("candidatos");


// totales generales.
// fecha 	idcircuito 21	idseccion 7	idDistrito 20	MesasTomadas 	Votantes	TotalVontantes 	VotosBlancos 	
// VotosNulos 	VotosRecurridos 	VotosInpugnados 
// $idDistrito,$idseccion,$idcircuito,$idElecion

$datos = $mesa->estadistica_totales( idDistritoDefecto ,$idCiudad,$idEleccion);
// var_dump($datos);

$tablalistas = $mesa->estadistica_porlista( idDistritoDefecto ,$idCiudad,$idEleccion); // tabla estadistica de todas las listas.

$divTotal = entrada("totaldatos", array(
"afirmativos" => $datos[0]->Votantes , // cantidad de votantes empadronados.
"blanco" => $datos[0]->VotosBlancos ,
"Impugnados" => $datos[0]->VotosInpugnados ,
"recurridos" => $datos[0]->VotosRecurridos ,
"nulos" =>$datos[0]->VotosNulos,
"totalmesas" => $totalMesas  , 	// cantidad de mesas.
"escrutmesas" => $datos[0]->MesasTomadas  , // cantidad de mesas escrutadas ( cerradas. )
"empadron" => $empadronados  , 					// cantidad de votantes empadronados.

));

// $EnListatodos = $EnLista->getAll();
$Tbpartidos = $partidos->getAll();

$tabpane="";
$tabuladores="";

$Sen_Candia= array();
$Dip_Candia = array();

//  fecha 	idcircuito 	idseccion 	idDistrito 	idLista 	idCargo 	cuantos 	cantidad 
for ($a=2; $a<4; $a++){
	$partido = "";
	foreach ($Tbpartidos as $ElPartido )
	{
		$t=$candidato->getAll();
		foreach ($t as $k){
			if ($k->idCargo == 2){
				$Sen_Candia[$k->id] = 0;
			}else{
				$Dip_Candia[$k->id] = 0;
			}
		}
		// $PartidoVotos = estadistica_partido($ElPartido->id);
	 // filtro listas por partido.:
		// $listas = $EnLista->getBy(" Senador = '1'  and idPart",$ElPartido->id  );
		$listas = $EnLista->getBy("idPart",$ElPartido->id  );
		$t= count ($listas); // cuantas listas tiene el partido
		// var_dump($listas);
		// echo "<br>\n".$ElPartido->id ;
		$totalPartido_senador=0;
		$totalPartido_diputado=0;
		
		if ($t==1){
			
			$candidatoSen = $candidato->getById($listas[0]->SenadorCandiato);
			$candidatoDip = $candidato->getById($listas[0]->DiputadoCandiato);

			if ($a==2){
				$txt = " - " . $candidatoSen->nombre .", ".$candidatoSen->apellido;
			}else{
				$txt = " - " . $candidatoDip->nombre .", ".$candidatoDip->apellido;
			}

			$l=entrada("sublista",array(
				"norCandidato" => $listas[0]->NroLista,
				"nombreLista" => $txt)); // $listas[0]->nombre .
			foreach ($tablalistas as $v){
					$idCandidatoSen = $candidato->getById($listas[0]->SenadorCandiato);
					$idCandidatoDip = $candidato->getById($listas[0]->DiputadoCandiato);
					
					if ($v->idLista == $listas[0]->id ){
						if ($v->idCargo == 2){
							$totalPartidosenador = $v->cantidad ;
							$Sen_Candia[$idCandidatoSen->id] += $v->cantidad; ;
							$totalPartido_senador += $v->cantidad;
						}else{
							$totalPartidodiput = $v->cantidad ;
							// var_dump($idCandidato);
							$Dip_Candia[$idCandidatoDip->id] += $v->cantidad ;
							$totalPartido_diputado += $v->cantidad;
						}
					}
					
				
			}
		}else{	
			$l="";
			foreach ($listas as $lista  ) {
				// para los totales.
				$totallista_senador=0;
				$totallista_diputado=0;
				foreach ($tablalistas as $v){
					// var_dump($lista);
					if ($v->idLista == $lista->id ){
						if ($v->idCargo == 2){
							$idCandidatoSen = $candidato->getById($lista->SenadorCandiato);
							$Sen_Candia[$idCandidatoSen->id] += $v->cantidad; ;
							$totalPartido_senador += $v->cantidad;
						}else{
							$idCandidatoDip = $candidato->getById($lista->DiputadoCandiato);
							// var_dump($idCandidato);
							$Dip_Candia[$idCandidatoDip->id] += $v->cantidad ;
							$totalPartido_diputado += $v->cantidad;
						}
					}
				}
			}
			// $candiatos = $candidato->getAll();
			
			foreach ($listas as $lista  ) {
			// foreach ($candiatos as $lista  ) {
				// para las listas.
				// $candidatoSen = $candidato->getById($lista->SenadorCandiato);
				// $candidatoDip = $candidato->getById($lista->DiputadoCandiato);

				// if ($a==2){
				// 	$txt =  $candidatoSen->nombre .", ".$candidatoSen->apellido;
				// }else{
				//	$txt =  $candidatoDip->nombre .", ".$candidatoDip->apellido;
				// }
				
				foreach ($tablalistas as $v){
					if ($v->idLista == $lista->id ){
						if ($v->idCargo == 2){
							$totallista_senador = $v->cantidad;
						}else{
							$totallista_diputado = $v->cantidad;
						}
					}
				}
				
				if ($a==2){
					if ($lista->SenadorCandiato > 0 ) {
						$candidatoSen = $candidato->getById($lista->SenadorCandiato);
						$txt = " - " . $candidatoSen->nombre .", ".$candidatoSen->apellido;
						$l.=entrada("sublistas",array(
							"nombreCandidato"=> "nocandidato:".$lista->nombre,
							"nombreLista" => 	$lista->nombre,
							"lnombreCandidato" => $txt ,	// $lista->nombre,
							"listaVotos" => 	($a==2)?$totallista_senador:$totallista_diputado,
							"listaTotal" =>		($a==2)?$totalPartido_senador:$totalPartido_diputado,
						));
					}
				}else{
					if ($lista->DiputadoCandiato > 0 ){
						$candidatoDip = $candidato->getById($lista->DiputadoCandiato);
						$txt = " - " . $candidatoDip->nombre .", ".$candidatoDip->apellido;
						$l.=entrada("sublistas",array(
							"nombreCandidato"=> "nocandidato:".$lista->nombre,
							"nombreLista" => 	$lista->nombre,
							"lnombreCandidato" => $txt ,	// $lista->nombre,
							"listaVotos" => 	($a==2)?$totallista_senador:$totallista_diputado,
							"listaTotal" =>		($a==2)?$totalPartido_senador:$totalPartido_diputado,
						));				
					}
				}
				
				
			}
		
		} // si tiene o no sublistas.
		

		
		// las listas estan cargadas. cargar los partidos.
		// var_dump($ElPartido);  Textos completos 	id 	NroLista 	AgrupacionPolitica 	activo 
		$partido .= entrada("partido",array(
			"nroPartido" => $ElPartido->NroLista,
			"nombrePartido" => $ElPartido->AgrupacionPolitica,
			"img" => $ElPartido->img,
			"imgPartido" => $ElPartido->AgrupacionPolitica.".png",
			"partidoVotos" => ($a==2)?$totalPartido_senador:$totalPartido_diputado,
			"partidoTotal" => $datos[0]->Votantes,
			"sublista" => $l,
		));
	
	 
	}
	$hora = date("H:m");
	$titulo  = ($a==2)?"SENADOR":"DIP. PROVINCIAL" ;
	$contenido = <<<CONT
	<!--- contenido de paneles. -->
						<div class="titulo_tab">$titulo</div>
						<div class="col-xs-12 col-sm-12 col-md-9">
							<div id="pai2" class="pai">
								$partido
							</div>
							<div id="titulo_imp">
								<div class="hora">Ultima actualizaci&oacute;n &nbsp$hora hs.</div>
							</div>
							
						</div>
						$divTotal	
	<!--- fin de contenido -->
CONT
;
	// $contenido = "este es contenido ".(($a==2)?"SENADOR":"DIP. PROVINCIAL")." ñadkjlñaksdj";
	// if (strlen($partido)>1){
	$tabpane .= entrada("tabpane",array(
		"contenidoPanel" => $contenido,
		"tabpane" => ($a==2)?"in active":"",
		"idP" => ($a==2)?"gobernador":"dip_provincial"
		));
	// }
}
$tabuladores = entrada("tabContenedor",array("tabContents" =>$tabpane )) ;
$str="";
?>

	<main class="main-container" role="main">
		<div class="container">
		
			<div class="row">
				<div id="contenedor" class="col-xs-12 col-sm-12 col-md-12">
					<div id="combobox" class="hidden-print">
					<?php 
						?><form name="form1" action="<?php echo $helper->url("index","filtro"); ?>" method="post" ?>
						<select name='ciudades' id="menu_localidad" onchange="submit();" class="form-control input-lg no-scroll" data-style="btn-primary" >		
						<?php
						$str.="\t\t\t\t\t\t<option value='-1' >TODA LA PROVINCIA</option>\n";
						
						$listaCiudad = $ciudades->getAll();
						foreach ( $listaCiudad as $reg  ) {
								// var_dump($reg);
								if($idCiudad == $reg->id ) $t=" selected=selected " ; else $t="" ;
								
								$str.="\t\t\t\t\t\t\t<option value='".$reg->id."' $t >".$reg->nombre."</option>\n";
						}  
						echo $str."\t\t\t\t\t\t</select> \n";
					?>
					</form>
					</div>
					<div id="datos" class="">
						<div id="titulo_categoria"><?php echo $Pagtitulo ?></div>
						<ul class="nav nav-tabs nav-justified" role="tablist">
							<li class="tab_gobernador active" role="presentation">
								<a href="#gobernador" aria-controls="gobernador" role="tab" data-toggle="tab" class="tit_pestana">SENADOR</a>
							</li>
							<li class="tab_dip_provincial" role="presentation">
								<a href="#dip_provincial" aria-controls="dip_provincial" role="tab" data-toggle="tab" class="tit_pestana">DIP. NACIONAL</a>
							</li>
						</ul>
						<?php echo $tabuladores ?>
					</div>
				</div>
			</div>
		</div>
	</main>
	
