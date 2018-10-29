<?php

const __DIRMAIN__ = "../../";
require_once __DIRMAIN__.'autoload.php';

$sFile = 'example_data.html';
$sHtml = '';
if(is_file($sFile)){
  $sHtml = file_get_contents($sFile);
}

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