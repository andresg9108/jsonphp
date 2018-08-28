<?php

use lib\Useful\{Useful, constantGlobal};
use administration\controller\publicDataController;

$oConnection = Useful::getConnectionArray();
$bPhpErrors = (!empty($oConnection->php_errors)) ? $oConnection->php_errors : false;
$bPhpErrors = (!empty($oConnection->php_errors)) ? $oConnection->php_errors : false;
if($bPhpErrors){
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

$oPublicDataController = publicDataController::getInstance();
$aResponse = Useful::getResponseArray(2, (object)[]
	,'', constantGlobal::ERROR_404);

switch ($sAction) {
	case 'appRegistration':
		$aResponse = $oPublicDataController->getRegCodeAction((object)$_GET, (object)$_POST);
		break;
}

echo json_encode($aResponse);
