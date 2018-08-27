<?php

namespace lib\MVC;

use lib\Util\Util;

class query {

	/*
	*/
	public static function getQuery($sNameQuery, $aParameters = []){
		$sQuery = '';
		$oConnection = Util::getConnectionArray();
		$sQueryPrefix = (!empty($oConnection->query_prefix)) ? $oConnection->query_prefix : '';
		
		$sNameQueryPfx = $sQueryPrefix.$sNameQuery;
		if(defined("static::$sNameQueryPfx")){
			$sQuery = constant("static::$sNameQueryPfx");
		}else{
			if(defined("static::$sNameQuery")){
				$sQuery = constant("static::$sNameQuery");
			}
			//trigger_error ("$sNameQuery  isn't defined");
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
