<?php

namespace model;

use \Exception;

class systemException extends Exception{

	public function getMessageWithCode(){
		return "(".$this->getCode().") ".$this->getMessage();
	}
}
