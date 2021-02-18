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

$sEmail = 'example@gmail.com';
$sSubject = 'Test Subject';
$sMessage = Useful::getEmailTemplate('example', ['¡Hello World!']);

$oMailA = Useful::getMailArray();

$sServerName = (!empty($oMailA->name)) ? $oMailA->name : "";
$sServerHost = (!empty($oMailA->host)) ? $oMailA->host : "";
$sSmtpSecure = (!empty($oMailA->smtp_secure)) ? $oMailA->smtp_secure : "";
$sServerPort = (!empty($oMailA->port)) ? $oMailA->port : "";
$sServerUsername = (!empty($oMailA->username)) ? $oMailA->username : "";
$sServerPassword = (!empty($oMailA->password)) ? $oMailA->password : "";

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