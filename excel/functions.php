<?php

/*
*/
function getTestDataArray(){
	$aRows = [];

	$aRow = [];
	$aRow['name'] = "Homero";
	$aRow['last_name'] = "Simpson";
	$aRow['phone'] = "123";
	$aRow['direction'] = "Calle false 123";
	$aRow['city'] = "Springfield";
	$oRow = (object)$aRow;
	$aRows[] = $oRow;

	$aRow = [];
	$aRow['name'] = "Pepe";
	$aRow['last_name'] = "Diaz";
	$aRow['phone'] = "456";
	$aRow['direction'] = "Calle 70 #100-20";
	$aRow['city'] = "Medellin";
	$oRow = (object)$aRow;
	$aRows[] = $oRow;

	$aRow = [];
	$aRow['name'] = "Carolina";
	$aRow['last_name'] = "Perez";
	$aRow['phone'] = "789";
	$aRow['direction'] = "Calle 25 #230-50";
	$aRow['city'] = "London";
	$oRow = (object)$aRow;
	$aRows[] = $oRow;

	return $aRows;
}