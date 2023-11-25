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

		//พิมพ์วัน-เวลา ตรงมุมขวาล่าง
		$this->Cell(0,10,'Time '. date('d').'/'. date('m').'/'.(  date('Y')+543 ).' '. date('H:i:s') ,0,0,'R');

	}

}

//เรียกใช้งาน เราจะเรียกใช้คลาสใหม่ของเราแทน
$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

for( $i=0;$i<20;$i++ ){

	$pdf->Cell(0,10,'www.select2web.com/forums/ #'.$i);
	$pdf->Ln(20);

}

$pdf->Output();
?>