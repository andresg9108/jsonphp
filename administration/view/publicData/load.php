<?php

use lib\Util\{Util, constantGlobal};
use administration\controller\publicDataController;

$oPublicDataController = publicDataController::getInstance();

$aResponse = Util::getResponseArray(false, (object)[]
	,'', constantGlobal::ERROR_404);

switch ($sAction) {
	case 'appRegistration':
		$aResponse = $oPublicDataController->getRegCodeAction((object)$_GET, (object)$_POST);
		break;
}

echo json_encode($aResponse);
