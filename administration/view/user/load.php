<?php

use lib\Useful\{Useful, constantGlobal};
use administration\controller\userController;

$oConnection = Useful::getConnectionArray();
$bPhpErrors = (!empty($oConnection->php_errors)) ? $oConnection->php_errors : false;
if($bPhpErrors){
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

$oUserController = userController::getInstance();
$aResponse = Useful::getResponseArray(2, (object)[]
	,'', constantGlobal::ERROR_404);

switch ($sAction) {
	case 'validateRecoverPassword':
		$aResponse = $oUserController->validateRecoverPasswordAction((object)$_GET, (object)$_POST);
		break;
	case 'recoverPassword':
		$aResponse = $oUserController->recoverPasswordAction((object)$_GET, (object)$_POST);
		break;
	case 'validateEmailByCode':
		$aResponse = $oUserController->validateEmailByCodeAction((object)$_GET, (object)$_POST);
		break;
	case 'validateSession':
		$aResponse = $oUserController->validateSessionAction((object)$_GET, (object)$_POST);
		break;
	case 'validateEmailAndUser':
		$aResponse = $oUserController->validateEmailAndUserAction((object)$_GET, (object)$_POST);
		break;
	case 'checkIn':
		$aResponse = $oUserController->checkInAction((object)$_GET, (object)$_POST);
		break;
	case 'logIn':
		$aResponse = $oUserController->logInAction((object)$_GET, (object)$_POST);
		break;
}

echo json_encode($aResponse);
