<?php

namespace lib\MVC;

use lib\Util\Util;

class query {

	/*
	*/
	public static function getQuery($sNameQuery, $aParameters = []){
		$sQuery = '';
		$oConnection = Util::getConnectionArray();
		$sMotor = (!empty($oConnection->motor)) ? $oConnection->motor : '';
		$sQueryPrefix = (!empty($oConnection->query_prefix)) ? $oConnection->query_prefix : '';

		if(defined("static::$sNameQuery")){
			$sQuery = constant("static::$sNameQuery");
		}
		//trigger_error ("$sNameQuery  isn't defined");
		
		if($sMotor == 'mysql'){
			$sNameQueryMSQL = $sQueryPrefix.$sNameQuery;
			if(defined("static::$sNameQueryMSQL")){
				$sQuery = constant("static::$sNameQueryMSQL");
			}
		}else if($sMotor == 'sqlite'){
		}

		foreach ($aParameters as $i => $v) {
	      if(is_null($v))
	        $sQuery = str_replace("<".($i+1)."?>", "null", $sQuery);
	      else
	        $sQuery = str_replace("<".($i+1)."?>", $v, $sQuery);
	    }
	    
	    return $sQuery;
	}
}

?>
