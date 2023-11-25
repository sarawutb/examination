<?php
require 'fpdf.php';
class PDF extends FPDF {
	function Header() {
		$this->Setfont ( 'Arial', 'I', 5 );
		$this->Text ( 5, 5, 'Create by iT_mod' );
		$this->Ln ( 20 );
	}
}
$pdf = new PDF ();
$pdf->SetFont ( 'Arial', '', 12 );
for($i = 0; $i < 50; $i ++) {
	$pdf->Cell ( 0, 10, 'select2web #' . $i );
	$pdf->Ln ( 20 );
}
$pdf->Output ();
?>