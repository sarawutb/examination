<?php
require 'fpdf.php';
$pdf=new FPDF();
//ไปอ่าน Lesson ก่อนหน้านี้
$pdf->AddPage();
//AddPage($orientation='', $size='')
//$Orientation : กำหนดกระดาษแนวตั้งหรือแนวนอน ค่าที่เป็นได้คือ
// 			p= แนวตั้ง(Default)
// 			L= แนวนอน
//$size = ขนาดกระดาษ
$pdf->SetFont('Arial','B',16);
$pdf->Text(10, 10, 'The person who gives is much loved');
$pdf->Output();
?>