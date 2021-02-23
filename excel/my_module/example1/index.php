<?php

const __DIRMAIN__ = "../../../";
require_once __DIRMAIN__.'autoload.php';
require_once __DIRMAIN__.'excel/functions.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello');

$sFileName = 'example1.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($sFileName);

header("Content-disposition: attachment; filename=" . $sFileName);
header("Content-type: MIME");
readfile($sFileName);

unlink($sFileName);