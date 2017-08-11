<?php


function porcentaje ( $v,$t){
	if ($t==0) {
		return 0;
	}else{
		return round ( ( $v / $t) * 100 , 1 ) ;
	}
}
	
function entrada($archivo,$datos){
	$fil = "view/desarmado/".$archivo.".php";
	if ( is_file( $fil )){
		
		foreach ($datos as $k=>$v) ${$k}=$v ;
		
		ob_start();
			include($fil);
			$rt=ob_get_contents();
		ob_clean();
	
	}else{
		$rt="nofile";
	}

	return $rt;		
	
}

