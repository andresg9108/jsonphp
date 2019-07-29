<?php

namespace model\example;

use \Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\Useful\{Useful, constantGlobal, systemException};
use lib\MVC\proxy;
use andresg9108\connectiondb\connection;
use model\example\{constantExample, queryExample};

class exampleProxy extends proxy {

	/*
	*/
	public static function getExample(){
		try {
			$oConnection = Useful::getConnectionDB();
			$oConnection->connect();

			$oConnection->commit();
			$oConnection->close();

			return (object)[];	
		}catch(systemException $e){
			$oConnection->rollback();
			$oConnection->close();
			throw new systemException($e->getMessage());
		}catch(Exception $e){
			$oConnection->rollback();
			$oConnection->close();
			throw new Exception($e->getMessage(), $e->getCode());
		}
	}
}
