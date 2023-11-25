<?php
require 'fpdf.php';
$pdf=new FPDF();
$pdf->SetRightMargin(50);
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(50,10,'The person who gives is much loved');
$pdf->Ln();
$pdf->Cell(50,10,'Any sinner is bound to suffer as a result of his own wrong-doing');
$pdf->Output();

?>