<?php
require 'fpdf.php';
$pdf=new FPDF();
$pdf->SetTopMargin(50);
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(50,10,'Overcome a stingy person with generosity.');
$pdf->Output();
?>