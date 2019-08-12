<?php

use \Firebase\JWT\{JWT, ExpiredException};
use lib\Useful\{Useful, constantGlobal, systemException};
use module\controller\exampleController;

$bPhpErrors = Useful::getBooleanPhpErrors();
if($bPhpErrors){
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

$oResponse = Useful::getResponseArray(2, (object)[]
	,'', constantGlobal::ERROR_404);

try {
	$oExampleController = exampleController::getInstance();
	
	switch ($sAction) {
		case 'example':
			$oResponse = $oExampleController->exampleAction((object)$_GET, (object)$_POST);
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
