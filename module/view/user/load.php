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

$aResponse = Useful::getResponseArray(2, (object)[]
	,'', constantGlobal::ERROR_404);

try {
	$oUserController = userController::getInstance();

	switch ($sAction) {
		case 'sendRecoverPassword':
			$aResponse = $oUserController->sendRecoverPasswordAction((object)$_GET, (object)$_POST);
			break;
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
} catch (systemException $e) {
  $aResponse = Useful::getResponseArray(2, (object)[], $e->getMessage(), $e->getMessage());
} catch (Exception $e){
  $aResponse = Useful::getResponseArray(3, (object)[], constantGlobal::getConstant('CONTACT_SUPPORT'), $e->getMessage());
} catch (ExpiredException $e) {
  $aResponse = Useful::getResponseArray(4, (object)[], constantGlobal::getConstant('ERROR_SESSION'), constantGlobal::getConstant('ERROR_SESSION'));
}

echo json_encode($aResponse);
