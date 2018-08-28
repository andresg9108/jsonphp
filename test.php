<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'autoload.php';

/*require __DIRMAIN__.'vendor/phpmailer/phpmailer/src/Exception.php';
require __DIRMAIN__.'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require __DIRMAIN__.'vendor/phpmailer/phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use lib\Util\Util;

$oMail = new PHPMailer();

$sEmail = 'info@example.net';
$sSubject = 'Asunto';
$sMessage = 'Mi mensaje';
$sHtml = file_get_contents(__DIRMAIN__.'email/templates/checkin.html');
$sHtml = str_replace('<2?>', $sMessage, $sHtml);

$oMailD = Util::getMailArray();
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
$oMail->msgHTML($sHtml);

if (!$oMail->send()) {
  echo $oMail->ErrorInfo;
} else {
  echo "OK";
}*/






use model\{connection, systemException};
use model\user\user;

try {
	$oConnection = connection::getInstance();
	$oConnection->connect();

	$oUser = user::getInstance($oConnection);
	$oUser->iId = null;
	$oUser->sEmail = "example@example.com";
	$oUser->sUser = "andresg91082222";
	$oUser->sPassword = "123456789";
	$oUser->iStatus = 0;
	$oUser->sRegistrationCode = md5("1234567890");
	$oUser->save();

	$oConnection->commit();
	$oConnection->close();

	echo "OK";
} catch (Exception $e) {
	$oConnection->rollback();
	$oConnection->close();
	
	echo $e->getMessage();
} catch (systemException $e) {
	$oConnection->rollback();
	$oConnection->close();
	
	echo $e->getMessage();
}
