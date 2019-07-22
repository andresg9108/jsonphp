<?php

use lib\Useful\{Useful, constantGlobal};
use module\controller\exampleController;

$oConnection = Useful::getConnectionArray();
$bPhpErrors = (!empty($oConnection->php_errors)) ? $oConnection->php_errors : false;
$bPhpErrors = (!empty($oConnection->php_errors)) ? $oConnection->php_errors : false;
if($bPhpErrors){
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

$oExampleController = exampleController::getInstance();
$aResponse = Useful::getResponseArray(2, (object)[]
	,'', constantGlobal::ERROR_404);

switch ($sAction) {
	case 'example':
		$aResponse = $oExampleController->exampleAction((object)$_GET, (object)$_POST);
		break;
}

echo json_encode($aResponse);
