<?php
define('FPDF_FONTPATH','../font/');

require('../fpdf.php');

$pdf=new FPDF();
$pdf->AddPage();
$pdf->Image('Untitled.png',10,12,30,0,'','http://www.select2web.com');

$pdf->Output();

?>