<?php
class AyudaVistas{
     
    public function url($controlador=CONTROLADOR_DEFECTO,$accion=ACCION_DEFECTO){
        $urlString="index.php?ac=".$controlador."&d=".$accion;
        return $urlString;
    }
    public function encode($text){
	
	    $problem_enc=array(
        'euro', 'sbquo', 'bdquo', 'hellip', 'dagger', 'Dagger', 'permil',
        'lsaquo', 'lsquo', 'rsquo', 'ldquo',
        'rdquo', 'bull', 'ndash', 'mdash', 'trade', 'rsquo', 'brvbar', 'copy',
        'laquo', 'reg', 'plusmn', 'micro', 'para', 'middot', 'raquo', 'nbsp'
		);
		$text=mb_convert_encoding($text,'HTML-ENTITIES','UTF-8');
		$text=preg_replace('#(?<!\&ETH;)\&('.implode('|',$problem_enc).');#s','--amp{$1}',$text);
		$text=mb_convert_encoding($text,'UTF-8','HTML-ENTITIES');
		$text=utf8_decode($text);
		$text=mb_convert_encoding($text,'HTML-ENTITIES','UTF-8');
		$text=preg_replace('#\-\-amp\{([^\}]+)\}#su','&$1;',$text);
		$text=mb_convert_encoding($text,'UTF-8','HTML-ENTITIES');
		return $text;
	}

	public function utf82iso88592($tekscik , $sentido=0) {
		$remp = array (
		 "\xC4\x85" => "&#261;", "\xC4\x84" => '&#260;', "\xC4\x87" => '&#263;', "\xC4\x86" => '&#262;',
		 "\xC4\x99" => '&#281;', "\xC4\x98" => '&#280;', "\xC5\x82" => '&#322;', "\xC5\x81" => '&#321;',
		 "\xC5\x84" => '&#324;', "\xC5\x83" => '&#323;', 
		"\xC3\xB3" => '&#243;',  
		 // A á
		"\xC1"  => '&#193;', "\xE1" => '&#225;',
		 // E é
		 "\xC9"  => '&#193;', "\xE9"  => '&#233;', 
		 // I í
		 "\xCD"  => '&#205;', "\xED"  => '&#237;', 
		 // O í 
		 "\xD3"  => '&#211;', "\xF3"  => '&#243;',
		 // U ú
		 "\xDA"  => '&#218;', "\FA"  => '&#250;', 
		 "\xF1"  => '&#241;', 
		 
		 "\xC3\x93" => '&#211;', "\xC5\x9B" => '&#347;', "\xC5\x9A" => '&#346;',  "\xC5\xBC" => '&#380;',
		 "\xC5\xBB" => '&#379;', "\xC5\xBA" => '&#378;', "\xC5\xB9" => '&#377;' ) ;
		 if ($sentido == 0)
	//		foreach ($remp as $k=>$v ) {
				$tekscik = str_replace(array_keys($remp) , array_values($remp), $tekscik ) ;
	//		}
		 else
			foreach ($remp as $k=>$v ) $tekscik = str_replace($v , $k, $tekscik ) ;
		 return $tekscik;
	} // utf82iso88592

	public function iso885922utf8($tekscik) {
		
		 return utf82iso88592($tekscik,1) ;
	} // iso885922utf8

    //Helpers para las vistas
}
?>
