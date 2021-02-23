<?php

const __DIRMAIN__ = "../../../";
require_once __DIRMAIN__.'autoload.php';
require_once __DIRMAIN__.'excel/functions.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$aRows = getTestDataArray();

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Name');
$sheet->setCellValue('B1', 'Last name');
$sheet->setCellValue('C1', 'Phone');
$sheet->setCellValue('D1', 'Direction');
$sheet->setCellValue('E1', 'City');

$iRow = 2;
foreach ($aRows as $i => $v){
	$sName = (!empty($v->name)) ? $v->name : "";
	$sLastName = (!empty($v->last_name)) ? $v->last_name : "";
	$sPhone = (!empty($v->phone)) ? $v->phone : "";
	$sDirection = (!empty($v->direction)) ? $v->direction : "";
	$sCity = (!empty($v->city)) ? $v->city : "";

	$sheet->setCellValue('A'.$iRow, $sName);
	$sheet->setCellValue('B'.$iRow, $sLastName);
	$sheet->setCellValue('C'.$iRow, $sPhone);
	$sheet->setCellValue('D'.$iRow, $sDirection);
	$sheet->setCellValue('E'.$iRow, $sCity);

	$iRow++;
}

$sFileName = 'example2.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($sFileName);

header("Content-disposition: attachment; filename=" . $sFileName);
header("Content-type: MIME");
readfile($sFileName);

unlink($sFileName);