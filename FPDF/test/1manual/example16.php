<?php
define('FPDF_FONTPATH','../font/');

require('../fpdf.php');

$pdf=new FPDF();

// เพิ่มฟ้อนต์ภาษาไทยเข้ามา ตัวธรรมดา กำหนด ชื่อ เป็น angsana
$pdf->AddFont('angsana','','angsa.php');

//สร้างหน้าเอกสาร
$pdf->AddPage();

// กำหนดฟ้อนต์ที่จะใช้  อังสนา ตัวธรรมดา ขนาด 14
$pdf->SetFont('angsana','',14);

//+ พิมพ์ hyper link ด้วยคำัสั่ง Write ลงไปในเอกสาร
$pdf->Write( 5  , iconv( 'UTF-8','cp874' , 'www.select2web.com ' ) , 'http://www.select2web.com' );

//+ พิมพ์ hyper link ด้วยคำัสั่ง Cell ลงไปในเอกสาร
$pdf->Cell( 50  , 5 , iconv( 'UTF-8','cp874' , 'www.select2web.com' ) , 0 ,1,'L',false,'http://www.select2web.com');

$pdf->Output();
?>