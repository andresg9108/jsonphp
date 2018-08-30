<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

const __DIRMAIN__ = "./";
require_once __DIRMAIN__.'autoload.php';

use model\{connection, systemException};

try {
	$oConnection = connection::getInstance();
	$oConnection->connect();

	$sQuery = "SELECT `id`, `registration_date`, `email`, `user`, `password`, `status`, `registration_code`, `id_person`, `id_profile` FROM `user`";
	$aParameters = ['id', 'registration_date', 'email', 'user', 'password', 'status', 'registration_code', 'id_person', 'id_profile'];
	$oConnection->queryArray($sQuery, $aParameters);
	$aQuery = $oConnection->getQuery();
	
	$oConnection->commit();
	$oConnection->close();

	echo json_encode($aQuery);
} catch (Exception $e) {
	echo $e->getMessage();
}