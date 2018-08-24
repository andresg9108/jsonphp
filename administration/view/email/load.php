<?php

require __DIRMAIN__.'vendor/phpmailer/phpmailer/src/Exception.php';
require __DIRMAIN__.'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIRMAIN__.'vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use lib\Util\{Util, constantGlobal};
use administration\controller\emailController;

$oEmailController = emailController::getInstance();

$aResponse = Util::getResponseArray(false, (object)[]
	,'', constantGlobal::ERROR_404);

switch ($sAction) {
	case 'send':
		$oMail = new PHPMailer();
		$oEmailController->setPHPMailer($oMail);
		$aResponse = $oEmailController->sendAction((object)$_GET, (object)$_POST);
		break;
}

echo json_encode($aResponse);
