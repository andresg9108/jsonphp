<?php

const __DIRMAIN__ = "../../";
require_once __DIRMAIN__.'autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json; charset=utf-8");

use lib\Useful\{Useful, constantGlobal, systemException};

$sView = (isset($_GET["view"])) ? $_GET["view"] : "";
$sAction = (isset($_GET["action"])) ? $_GET["action"] : "";

if(Useful::getBooleanPhpErrors()){
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
}

date_default_timezone_set(Useful::getStringPhpTimezone());

if(is_dir($sView)){
  require_once $sView."/load.php";
}else{
	$aResponse = (object)[
      'status'=>2,
      'response'=>[],
      'text'=>[
      	'client'=>'Error', 
      	'developer'=>'Error 404'
      ]
    ];
  	echo json_encode((object)$aResponse);
}
