<?php

use lib\Useful\{Useful, constantGlobal};
use administration\controller\personController;

$oConnection = Useful::getConnectionArray();
$bPhpErrors = (!empty($oConnection->php_errors)) ? $oConnection->php_errors : false;
if($bPhpErrors){
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

$oPersonController = personController::getInstance();
$aResponse = Useful::getResponseArray(2, (object)[]
	,'', constantGlobal::ERROR_404);

switch ($sAction) {
	case 'update':
		$aResponse = $oPersonController->updateAction((object)$_GET, (object)$_POST);
		break;
}

echo json_encode($aResponse);
