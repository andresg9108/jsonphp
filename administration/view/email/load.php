<?php

require __DIRMAIN__.'vendor/phpmailer/phpmailer/src/Exception.php';
require __DIRMAIN__.'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIRMAIN__.'vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use lib\Useful\{Useful, constantGlobal};
use administration\controller\emailController;

$oConnection = Useful::getConnectionArray();
$bPhpErrors = (!empty($oConnection->php_errors)) ? $oConnection->php_errors : false;
if($bPhpErrors){
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
}

$oEmailController = emailController::getInstance();
$aResponse = Useful::getResponseArray(2, (object)[]
	,'', constantGlobal::ERROR_404);

switch ($sAction) {
	case 'send':
		$oMail = new PHPMailer();
		$oEmailController->setPHPMailer($oMail);
		$aResponse = $oEmailController->sendAction((object)$_GET, (object)$_POST);
		break;
}

echo json_encode($aResponse);
