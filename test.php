<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'autoload.php';

use lib\Useful\{Useful, constantGlobal};
use model\{connection, systemException};
use model\person\{person, constantPerson};
use model\user\userProxy;

/*$oConnection = connection::getInstance();
$oConnection->connect();

$oPerson = person::getInstance($oConnection);
$oPerson->iId = 1;
$oPerson->sName = 'Andres';
$oPerson->sLastName = 'Gonzalez';
$oPerson->save();

$oConnection->commit();
$oConnection->close();*/

/*$oConnection = connection::getInstance();
$oConnection->connect();

$aData = [];
$aData['id'] = 100;
$aData['profile'] = 200;
$oData = (object)$aData;
$sCode = Useful::getJWT($oData, $oConnection);

echo $sCode;*/

/*$sCode = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NjEwNTIyNDMsImV4cCI6MTU2MTEzODY0MywiY29kZSI6eyJpZCI6MTAwLCJwcm9maWxlIjoyMDB9fQ.nqwsxlcPLIH-ViVQwX4sEoT4nKyJH_VS2jIL2qGZpOs";
$oObject = Useful::getDecodeJWT($sCode);

echo json_encode($oObject);*/

$aUser = [];
$aUser['user'] = 'andres';
$aUser['password'] = '1234567890';
$oUser = (object)$aUser;
$oResponse = userProxy::validatelogIn($oUser);

echo json_encode($oResponse);

