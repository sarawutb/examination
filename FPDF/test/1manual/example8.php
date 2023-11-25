<?php
require('../fpdf.php');

//ทำการสืบทอดคลาส FPDF ให้เป็นคลาสใหม่
class PDF extends FPDF
{
	//Override คำสั่ง (เมธอด) Footer
	function Footer()	{

		//นับจากขอบกระดาษด้านล่างขึ้นมา 10 มม.
		$this->SetY( -10 );

		//กำหนดใช้ตัวอักษร Arial ตัวเอียง ขนาด 5
		$this->SetFont('Arial','I',5);

		$this->Cell(0,10, 'Create by www.select2web.com' ,0,0,'L');

		//พิมพ์ หมายเลขหน้า ตรงมุมขวาล่าง
		$this->Cell(0,10, 'page '.$this->PageNo().' of  tp' ,0,0,'R');

	}

}

//เรียกใช้งาน เราจะเรียกใช้คลาสใหม่ของเราแทน
$pdf=new PDF();
$pdf->AliasNbPages( 'tp' );
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

for( $i=0;$i<20;$i++ ){

	$pdf->Cell(0,10,'Overcome evil by virtue. '.$i);
	$pdf->Ln(20);

}

$pdf->Output();
?>