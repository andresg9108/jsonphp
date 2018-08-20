<?php

use lib\Util\{Util, constantGlobal};
use administration\controller\userController;

$oUserController = userController::getInstance();

$aResponse = Util::getResponseArray(false, (object)[]
	,'', constantGlobal::ERROR_404);

switch ($sAction) {
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

?>
