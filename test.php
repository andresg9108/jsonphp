<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'autoload.php';

use lib\Util\{Util, constantGlobal};
use model\{connection, systemException};
use model\user\user;
use model\person\personProxy;

$sName = 'Andres';
$sLastName = 'Gonzalez';
$sEmail = 'info@vedapues.net';
$sUser = 'andresg1234567890';
$sPassword = '123456';

$sName = Util::getFilterCharacters($sName);
$sLastName = Util::getFilterCharacters($sLastName);
$sEmail = Util::getFilterCharacters($sEmail);
$sUser = Util::getFilterCharacters($sUser);
$sPassword = md5($sPassword);

$sRegistrationCode = Util::getRandomCode();
$aUser = [];
$aUser['email'] = $sEmail;
$aUser['user'] = $sUser;
$aUser['password'] = $sPassword;
$aUser['registration_code'] = $sRegistrationCode;
$aUser['status'] = 0;
$aUser['id_profile'] = 2;
$oUser = (object)$aUser;

$aPerson = [];
$aPerson['name'] = $sName;
$aPerson['last_name'] = $sLastName;
$aPerson['users'] = [$oUser];
$oPerson = (object)$aPerson;

$oPerson = personProxy::save($oPerson);









/*use Firebase\JWT\JWT;

$sPrivateKey = 'a5vbFgFFG4Fd2';
$iTime = time(); // Seg.
$aToken = [
	"iat" => $iTime, // Start
	"exp" => $iTime+120, // End
	"code" => '123'
];
$sJwt = JWT::encode($aToken, $sPrivateKey); // Encode

echo $sJwt;
echo "<br /><br />";

$sJwt = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1MzQxOTAwNzIsImV4cCI6MTUzNDI3NjQ3MiwiY29kZSI6IjY2In0.9mdn0XItUZ9loMylNSuA6-I2IWNpJphCAdpTm4aRHVk";
$oDecoded = JWT::decode($sJwt, $sPrivateKey, ['HS256']);
echo json_encode($oDecoded);*/

?>