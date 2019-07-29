<?php

require __DIRMAIN__.'vendor/phpmailer/phpmailer/src/Exception.php';
require __DIRMAIN__.'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIRMAIN__.'vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use \Firebase\JWT\{JWT, ExpiredException};
use lib\Useful\{Useful, constantGlobal, systemException};
use module\controller\emailController;

$oConnection = Useful::getConnectionArray();
$bPhpErrors = (!empty($oConnection->php_errors)) ? $oConnection->php_errors : false;
if($bPhpErrors){
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

$aResponse = Useful::getResponseArray(2, (object)[]
	,'', constantGlobal::ERROR_404);

try {
	$oEmailController = emailController::getInstance();
	
	switch ($sAction) {
		case 'send':
			$oMail = new PHPMailer();
			$oEmailController->setPHPMailer($oMail);
			$aResponse = $oEmailController->sendAction((object)$_GET, (object)$_POST);
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
