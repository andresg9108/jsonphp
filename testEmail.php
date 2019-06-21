<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require __DIRMAIN__.'vendor/phpmailer/phpmailer/src/Exception.php';
require __DIRMAIN__.'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIRMAIN__.'vendor/phpmailer/phpmailer/src/SMTP.php';
require_once __DIRMAIN__.'autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use lib\Useful\Useful;

$oMail = new PHPMailer();

$sEmail = 'info@example.net';
$sSubject = 'Test Subject';
$sMessage = 'Test Message';

$oMailD = Useful::getMailArray();
$sServerName = (!empty($oMailD->name)) ? $oMailD->name : "";
$sServerHost = (!empty($oMailD->host)) ? $oMailD->host : "";
$sSmtpSecure = (!empty($oMailD->smtp_secure)) ? $oMailD->smtp_secure : "";
$sServerPort = (!empty($oMailD->port)) ? $oMailD->port : "";
$sServerUsername = (!empty($oMailD->username)) ? $oMailD->username : "";
$sServerPassword = (!empty($oMailD->password)) ? $oMailD->password : "";

$oMail->isSMTP();//Protocolo
$oMail->CharSet = 'UTF-8';
$oMail->SMTPDebug = 0;//SMTP Debug
$oMail->Debugoutput = "html";//Salida de debug en html
$oMail->Host = $sServerHost;//Servidor
$oMail->Port = $sServerPort;//Puerto
if(!empty($sSmtpSecure))
$oMail->SMTPSecure = $sSmtpSecure;
$oMail->SMTPAuth = TRUE;//Autenticacion
$oMail->Username = $sServerUsername;//Usuario
$oMail->Password = $sServerPassword;//Password
$oMail->setFrom($sServerUsername, $sServerName);//De
$oMail->addReplyTo($sServerUsername, $sServerName);//Responder a

$oMail->addAddress($sEmail, $sEmail);
$oMail->Subject = $sSubject;
$oMail->msgHTML($sMessage);

try {
	if (!$oMail->send()) {
		$sMailError = $oMail->ErrorInfo;
		echo $sMailError;
	}else{
		echo "OK";
	}
} catch (Exception $e) {
	echo $e->getMessage();
}