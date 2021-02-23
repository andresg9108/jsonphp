<?php

const __DIRMAIN__ = "../../../";
require_once __DIRMAIN__.'autoload.php';
require_once __DIRMAIN__.'pdf/functions.php';

$sAdminName = "Andres Gonzalez";
$aRows = getTestDataArray();
$sRows = "";

foreach($aRows as $i => $v){
	$sName = (!empty($v->name)) ? $v->name : "";
	$sLastName = (!empty($v->last_name)) ? $v->last_name : "";
	$sPhone = (!empty($v->phone)) ? $v->phone : "";
	$sDirection = (!empty($v->direction)) ? $v->direction : "";
	$sCity = (!empty($v->city)) ? $v->city : "";

	$sRows .= getTemplate('row', [$sName, $sLastName, $sPhone, $sDirection, $sCity]);
}

$sHtml = getTemplate('template', [$sAdminName, $sRows]);

$mpdf = new \Mpdf\Mpdf([
	'mode' => 'utf-8', 
	//'format' => [100, 300], 
	//'orientation' => 'L', 
	'margin_header' => 0,
	'margin_footer' => 0,
	'margin_top' => 2.5,
	'margin_left' => 2.5,
	'margin_right' => 2.5,
	'margin_bottom' => 2.5,
]);

//$mpdf->SetHTMLHeader('Header');
//$mpdf->SetHTMLFooter('Footer');
$mpdf->WriteHTML($sHtml);

$mpdf->Output();