<?php
require 'fpdf.php';
class PDF extends FPDF {
	function Footer() {
		$this->SetY ( - 10 );
		$this->SetFont ( 'Arial', 'I', 5 );
		$this->Cell ( 0, 10, 'Create by www.select2web.com', 0, 0, 'L' );
		$this->Cell ( 0, 10, 'page ' . $this->PageNo () . ' of  tp ', 0, 0, 'R' );
	}
}
$pdf = new PDF ();
$pdf->AliasNbPages ( 'tp' );
$pdf->AddPage ();
$pdf->SetFont ( 'Arial', '', 12 );
for($i = 0; $i < 20; $i ++) {
	$pdf->Cell ( 0, 10, 'Overcome evil by virtue. ' . $i );
	$pdf->Ln ( 20 );
}
$pdf->Output ();
?>