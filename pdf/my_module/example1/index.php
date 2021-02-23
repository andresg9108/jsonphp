<?php

const __DIRMAIN__ = "../../../";
require_once __DIRMAIN__.'autoload.php';
require_once __DIRMAIN__.'pdf/functions.php';

//$mpdf = new \Mpdf\Mpdf();
//$mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);
//$mpdf = new \Mpdf\Mpdf(['format' => [100, 100]]);
$mpdf = new \Mpdf\Mpdf([
	'mode' => 'utf-8', 
	'format' => [100, 300], 
	'orientation' => 'L', 
	'margin_header' => 2.5,
	'margin_footer' => 2.5,
	'margin_top' => 7.5,
	'margin_left' => 2.5,
	'margin_right' => 2.5,
	'margin_bottom' => 7.5,
]);

$mpdf->SetHTMLHeader('Header');
$mpdf->SetHTMLFooter('Footer');
$mpdf->WriteHTML('¡Hello world!');

$mpdf->Output();
