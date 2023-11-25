<?php
require 'fpdf.php';
class PDF extends FPDF {
	function Footer() {
		$this->SetY ( - 10 );
		$this->SetFont ( 'Arial', 'I', 5 );
		$this->Cell ( 0, 10, 'Time' . date ( 'd' ) . '/' . date ( 'm' ) . '/' . (date ( 'Y' ) + 543) );
	}
}
$pdf = new PDF ();
$pdf->AddPage ();
$pdf->SetFont ( 'Arial', '', 12 );
for($i = 0; $i < 50; $i ++) {
	$pdf->Cell ( 0, 10, 'www.select2web.com #' . $i );
	$pdf->Ln ();
}
$pdf->Output ();
?>