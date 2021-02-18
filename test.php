<?php

date_default_timezone_set("America/Lima");
error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'autoload.php';

use \Firebase\JWT\{JWT, ExpiredException};
use lib\Useful\{Useful, constantGlobal, systemException};
use model\example\example;

try {
	$oConnection = Useful::getConnectionDB();
	$oConnection->connect();

    $oExample = example::getInstance($oConnection);

    $sDate = date('Y-m-d H:i:s');
    echo $sDate;

	$oConnection->commit();
	$oConnection->close();
} catch (Exception $e) {
	$oConnection->rollback();
	$oConnection->close();
	
	echo $e->getMessage();
}