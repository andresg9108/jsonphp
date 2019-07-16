<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'autoload.php';

use lib\Useful\Useful;

$oConnection = Useful::getConnectionDB();
$oConnection->connect();

$oConnection->queryArray("SELECT * FROM user;", ['field1', 'field2', 'field3', 'field4']);
$aResponse = $oConnection->getQuery();

echo json_encode($aResponse);

