<?php
require 'fpdf.php';
//$pdf=new FPDF('L','mm','A4');
$pdf=new FPDF('p','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Text(10, 10, 'Hello World!');
$pdf->Output();
?>