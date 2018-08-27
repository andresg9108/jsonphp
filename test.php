<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'autoload.php';

use model\{connection, systemException};
use model\user\user;

try {
	$oConnection = connection::getInstance();
	$oConnection->connect();

	$oUser = user::getInstance($oConnection);
	$oUser->iId = null;
	$oUser->sEmail = "andresg9108@yahoo.es";
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
