<?php

namespace model;

use \Exception;

class systemException extends Exception{
	
	public function __toString(){
		return "Excepción contralada del Sistema.";
	}
}

?>