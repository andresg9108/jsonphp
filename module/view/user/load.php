<?php

use \Firebase\JWT\{JWT, ExpiredException};
use lib\Useful\{Useful, constantGlobal, systemException};
use module\controller\userController;

$oConnection = Useful::getConnectionArray();
$bPhpErrors = (!empty($oConnection->php_errors)) ? $oConnection->php_errors : false;
if($bPhpErrors){
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

$oResponse = Useful::getResponseArray(2, (object)[]
	,'', constantGlobal::ERROR_404);

try {
	$oUserController = userController::getInstance();

	switch ($sAction) {
		case 'sendRecoverPassword':
			$oResponse = $oUserController->sendRecoverPasswordAction((object)$_GET, (object)$_POST);
			break;
		case 'validateRecoverPassword':
			$oResponse = $oUserController->validateRecoverPasswordAction((object)$_GET, (object)$_POST);
			break;
		case 'recoverPassword':
			$oResponse = $oUserController->recoverPasswordAction((object)$_GET, (object)$_POST);
			break;
		case 'validateEmailByCode':
			$oResponse = $oUserController->validateEmailByCodeAction((object)$_GET, (object)$_POST);
			break;
		case 'validateSession':
			$oResponse = $oUserController->validateSessionAction((object)$_GET, (object)$_POST);
			break;
		case 'validateEmailAndUser':
			$oResponse = $oUserController->validateEmailAndUserAction((object)$_GET, (object)$_POST);
			break;
		case 'checkIn':
			$oResponse = $oUserController->checkInAction((object)$_GET, (object)$_POST);
			break;
		case 'logIn':
			$oResponse = $oUserController->logInAction((object)$_GET, (object)$_POST);
			break;
	}
} catch (systemException $e) {
  $oResponse = Useful::getResponseArray(2, (object)[], $e->getMessage(), $e->getMessage());
} catch (Exception $e){
  $oResponse = Useful::getResponseArray(3, (object)[], constantGlobal::getConstant('CONTACT_SUPPORT'), $e->getMessage());
} catch (ExpiredException $e) {
  $oResponse = Useful::getResponseArray(4, (object)[], constantGlobal::getConstant('ERROR_SESSION'), constantGlobal::getConstant('ERROR_SESSION'));
}

echo json_encode($oResponse);
