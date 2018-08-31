<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'autoload.php';

use lib\Useful\Useful;
use model\person\personProxy;

$sName = 'Andres Felipe';
$sLastName = 'Gonzalez Florez';
$sEmail = 'info@vendapues.net';
$sUser = 'vendapues';
$sPassword = '123456789';

$sName = Useful::getFilterCharacters($sName);
$sLastName = Useful::getFilterCharacters($sLastName);
$sEmail = Useful::getFilterCharacters($sEmail);
$sUser = Useful::getFilterCharacters($sUser);
$sEmail = str_replace(' ', '', $sEmail);
$sUser = str_replace(' ', '', $sUser);
$sPassword = (!empty($sPassword)) ? md5($sPassword) : '';

$sRegistrationCode = Useful::getRandomCode();
$aEmailUser = [];
$aEmailUser['email'] = $sEmail;
$aEmailUser['registration_code'] = $sRegistrationCode;
$aEmailUser['main'] = 1;
$aEmailUser['status'] = 0;
$oEmailUser = (object)$aEmailUser;

$aUser = [];
$aUser['user'] = $sUser;
$aUser['password'] = $sPassword;
$aUser['status'] = 0;
$aUser['id_profile'] = 2;
$aUser['email_user'] = [$oEmailUser];
$oUser = (object)$aUser;

$aPerson = [];
$aPerson['name'] = $sName;
$aPerson['last_name'] = $sLastName;
$aPerson['users'] = [$oUser];
$oPerson = (object)$aPerson;

$oResponse = personProxy::save($oPerson);

echo json_encode($oResponse);