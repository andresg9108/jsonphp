<?php

const __DIRMAIN__ = "../../";
require_once __DIRMAIN__.'autoload.php';

//$mpdf = new \Mpdf\Mpdf();
//$mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);
//$mpdf = new \Mpdf\Mpdf(['format' => [100, 100]]);
$mpdf = new \Mpdf\Mpdf([
	'mode' => 'utf-8', 
	'format' => [100, 300], 
	'orientation' => 'L', 
	'margin' => [10, 10, 10, 10]
]);

$mpdf->WriteHTML('<h1>Hello world!</h1>');
$mpdf->Output();
