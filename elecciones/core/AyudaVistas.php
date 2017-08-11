<?php
class AyudaVistas{
     
    public function url($controlador=CONTROLADOR_DEFECTO,$accion=ACCION_DEFECTO){
        $urlString="index.php?ac=".$controlador."&d=".$accion;
        return $urlString;
    }
     
    //Helpers para las vistas
}
?>
