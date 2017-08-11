<?php
class finController extends ControladorBase{
     
    public function __construct() {
        parent::__construct();
    }
     
    public function gracias(){
         
       //Cargamos la vista index y le pasamos valores
        $this->view("muchasGracias",array( ));
    }
    public function __call($name,$arg){
		$this->gracias();
	}
 
}
?>
