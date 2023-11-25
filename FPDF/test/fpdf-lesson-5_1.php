<?php
require 'fpdf.php';
$pdf=new FPDF();
$pdf->SetMargins(50, 30,10);
//SetMargins(50, 30,10);   กั้นด้านซ้าย 50 , กั้นด้าน บน 30 ,กั้นด้าน ขวา  10
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell(30,16,'The person who gives is much loved');
//$pdf->Text(10, 10, 'The person who gives is much loved');
$pdf->Output();
?>