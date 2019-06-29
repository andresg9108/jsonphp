<?php

const __DIRMAIN__ = "../../";
require_once __DIRMAIN__.'autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json; charset=utf-8");

$sView = (isset($_GET["view"])) ? $_GET["view"] : "";
$sAction = (isset($_GET["action"])) ? $_GET["action"] : "";

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
