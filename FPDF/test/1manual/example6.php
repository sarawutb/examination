<?php
require('../fpdf.php');

//ทำการสืบทอดคลาส FPDF ให้เป็นคลาสใหม่
class PDF extends FPDF
{
	//Override คำสั่ง (เมธอด) Header
	function Header(){

		//ใช้ตัวอักษร Arial ตัวเอียง ขนาด 5
		$this->SetFont('Arial','I',5);

		//พิมพ์ตัวหนังสือตัวเอียงๆ ที่ตำแหน่งเยื้องขอบกระดาษซ้าย 5หน่วย ขอบกระดาษบน 5หน่วย
		$this->Text(5,5,'Created by select2web.com' );

		//ปัดบรรทัด กำหนดความกว้างของบรรทัด 20หน่วย
		$this->Ln(20);
	}

}

//เรียกใช้งาน เราจะเรียกใช้คลาสใหม่ของเราแทน
$pdf=new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','',12);

for( $i=0;$i<20;$i++ ){

	$pdf->Cell(0,10,'select2web #'.$i);
	$pdf->Ln(20);

}

$pdf->Output();
?>