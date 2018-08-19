<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'autoload.php';

use model\user\userProxy;

$sUser = 'root';
$sPassword = 'e10adc3949ba59abbe56e057f20f883e';

$aUser = [];
$aUser['user'] = $sUser;
$aUser['password'] = $sPassword;
$oUser = (object)$aUser;

$oResponse = userProxy::validatelogIn($oUser);
echo json_encode($oResponse);







/*use model\user\userProxy;

$aUser = [];
$aUser['user'] = 'felipeffff';
$aUser['password'] = '123456';
$oUser = (object)$aUser;
$oResponse = userProxy::validatelogIn($oUser);
echo json_encode($oResponse);*/










/*use model\user\userProxy;

$aUser = [];
$aUser['id'] = 66;
$aUser['registration_code'] = '50b3bc0b074b5593d6eae93fb9610864';
$oUser = (object)$aUser;
$oResponse = userProxy::validateEmail($oUser);

echo json_encode($oResponse);*/









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