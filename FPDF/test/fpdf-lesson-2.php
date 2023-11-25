<?php
require 'fpdf.php'; // include file fpdf.php เข้ามา
$pdf = new FPDF (); // สร้าง instant FPDF
$pdf->AddPage (); // เพิ่มหน้ากระดาษ
$pdf->SetFont ( 'Arial', 'B', '16' ); // กำหนดฟ้อนต์ ทีจะใช้ได้ ณ ตอนนี้ัจะใช้ได้เฉพาะฟอนต์ Arial เท่านั้น ถ้าต้องการเพิ่ม Font จะต้องเพิ่มใน Folder Font
// พิมพ์ข้อความลงในเอกสาร
// พิมพ์คำว่า Hello World! ลงในตำแหน่ง
// เยื้องจากขอบกระดาษด้านซ้าย 10 มม.
// เยื้องจากขอบกระดาษด้านบน 10 มม.

$pdf->Text ( 10, 10, 'Hello World!' );
$pdf->Output (); //Output

?>