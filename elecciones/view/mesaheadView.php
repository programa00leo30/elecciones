<?php 
	foreach ($columnas as $k=>$v) { 
		echo $v[0]  ;
		if (isset($v[1])){
			$Tvalor = isset( ${$v[1]}->id     )? ${$v[1]}->id     : (isset($mesas->$k)?$mesas->$k:0);
			$Ttexto = isset( ${$v[1]}->nombre )? ${$v[1]}->nombre :"";
		}else{
			// $valor=isset($mesas->$k)?$mesas->$k:0;
			$Tvalor = (isset($mesas->$k)?$mesas->$k:0) ;
			$Ttexto = "";
			// echo "--sin dato--";
		}
		
		if(isset($v[1])){ 
			echo "<h3>$Ttexto</h3>\n";
			/*if (isset(${$v[1]}->nombre))
				echo "(".${$v[1]}->nombre.")"; 
			*/
		};
		
		if (!isset($v[2])){ 
			?><input type="number" name="<?php echo $k 
		?>" class="form-control" value="<?php 
			/*
			if(isset($v[1])){ 
					echo ${$v[1]}->id ;
			}else{
				echo $mesas->$k;
			};
			echo "/>";
			*/
			echo $Tvalor."\"/>";
		}; 
		// var_dump($v);
		echo "<br>\n<hr>";
		// var_dump($k);
	} 
