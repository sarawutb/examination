<?php
define('FPDF_FONTPATH','../font/');

require('../fpdf.php');

$pdf=new FPDF();

//สร้างหน้าเอกสาร
$pdf->AddPage();

// กำหนดฟ้อนต์ที่จะใช้  time new roman ตัวธรรมดา ขนาด 14
$pdf->SetFont('times','',14);

// พิมพ์ข้อความลงเอกสาร
$pdf->Cell( 0  , 5 , iconv( 'UTF-8','cp874' , 'Print   center text' ) , 0 , 1 , 'C' );

$pdf->Output( 'report.pdf' , 'F' );
?>