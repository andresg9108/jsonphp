<?php

namespace lib\MVC;

class constant{

	/*
	*/
	public static function getConstant($sNameConstant, $aParameters = []){
		$sConstant = '';

		if(defined("static::$sNameConstant")){
			$sConstant = constant("static::$sNameConstant");
		}
		//trigger_error ("$sNameQuery  isn't defined");

		foreach ($aParameters as $i => $v) {
			$sConstant = str_replace("<".($i+1)."?>", $v, $sConstant);
	    }

	    return $sConstant;
	}
}

?>