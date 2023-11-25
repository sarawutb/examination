<?php
require('../fpdf.php');
 
 
$pdf=new FPDF();
$pdf->SetMargins( 50,30,10 );
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Cell( 30 , 16 , 'The person who gives is much loved');
$pdf->Output();
?>