<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'autoload.php';

use model\{connection, systemException};
use model\emailUser\emailUser;

try {
	$oConnection = connection::getInstance();
	$oConnection->connect();

	$oEmailUser = emailUser::getInstance($oConnection);
	$oEmailUser->iId = null;
	$oEmailUser->sEmail = 'soporte@example.com';
	$oEmailUser->sRegistrationCode = '123987';
	$oEmailUser->iStatus = 0;
	$oEmailUser->iIdUser = 1;

	$oEmailUser->save();

	$oConnection->commit();
	$oConnection->close();

	echo $oEmailUser->iId;
} catch (Exception $e) {
	$oConnection->rollback();
	$oConnection->close();

	echo $e->getMessage();
}