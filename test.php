<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'autoload.php';

use model\user\userProxy;

$sUser = 'vendapues';
$sPassword = '123456';

$aUser = [];
$aUser['user'] = $sUser;
$aUser['password'] = $sPassword;
$oUser = (object)$aUser;

return userProxy::validatelogIn($oUser);