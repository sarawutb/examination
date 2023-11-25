<?php

require('../fpdf.php');

$pdf=new FPDF();

//กำหนดคุณสมบัติของเอกสาร pdf
$pdf->SetAuthor( 'select2web.com' );
$pdf->SetCreator( 'fpdf version 1.6' );
$pdf->SetDisplayMode( 'fullwidth' , 'two' );
$pdf->SetKeywords( 'php mysql jquery' );
$pdf->SetSubject( 'this document for testing.' );
$pdf->SetTitle( 'Showme' );


//สร้างหน้าเอกสาร
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

$string = '';

for($i=0;$i<30;++$i){

	$string .= <<<HEREDOC
When CSS was introduced to web technologies in order to separate design from
content, a way was needed to refer to groups of page elements from external
style sheets. The method developed was through the use of selectors, which concisely
represent elements based upon their attributes or position within the
HTML document.
HEREDOC;

}

$pdf->MultiCell( 0  , 7 , $string );
$pdf->Output();
?>