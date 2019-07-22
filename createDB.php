<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'autoload.php';

use lib\Useful\Useful;

$aSqlPath = [];
$aSqlPath['mysql'] = 'doc/sql/mysql.sql';
$aSqlPath['mysqlpdo'] = 'doc/sql/mysql.sql';
$aSqlPath['sqlitepdo'] = 'doc/sql/sqlite.sql';

$oConnection = Useful::getConnectionArray();

$sMotor = (!empty($oConnection->motor)) ? $oConnection->motor : '';

$sPath = (!empty($aSqlPath[$sMotor])) ? $aSqlPath[$sMotor] : '';

try {
	$oConnection = Useful::getConnectionDB();
	$oConnection->connect();
	
	if(!empty($sPath)){
		$sFile = getFileContents($sPath);
		
		$oConnection->run($sFile);
	}else{
		throw new Exception("The path of the .sql file is not set.");
	}

	$oConnection->commit();
	$oConnection->close();

	echo "OK";
} catch (Exception $e) {
	$oConnection->rollback();
	$oConnection->close();
	echo $e->getMessage();
}

function getFileContents($sFilePath){
	$oFile = fopen($sFilePath, "r");

	$sFile = '';
	while (!feof($oFile)){
	    $sLine = fgets($oFile);
	    $sFile .= $sLine;
	}

	fclose($oFile);

	return $sFile;
}