<?php
defined('FPDF_FONTPATH','fonts/');
require 'fpdf.php';
$pdf=new FPDF();
$pdf->AddFont('angsana','','angsa.php');
$pdf->AddFont('angsana','B','angsab.php');
$pdf->AddFont('angsana','I','angsai.php');
$pdf->AddFont('angsana','BI','angsaz.php');
$pdf->AddPage();
$pdf->SetFont('angsana','',12);
$pdf->SetXY(10, 10);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'อังสนา ตัวธรรมดา ขนาด 12'));

$pdf->SetFont('angsana','B',16);
$pdf->SetXY(10, 20);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'อังสนา ตัวหนา ขนาด 16'));

$pdf->SetFont('angsana','I',24);
$pdf->SetXY(10, 30);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'อังสนา ตัวเอียง ขนาด 24'));

$pdf->SetFont('angsana','BI',32);
$pdf->SetXY(10, 40);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', 'อังสนา ตัวเอียง ขนาด 32'));

$pdf->Output();
?>