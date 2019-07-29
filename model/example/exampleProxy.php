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
		$oConnection = Useful::getConnectionDB();
		$oConnection->connect();

		$oConnection->commit();
		$oConnection->close();

		return (object)[];
	}
}
