<?php
 require('../library/fpdf16/fpdf_thai.php');
 require_once('./PDFNew.php');
 
class HDtest extends PDFNew {
	function Header (){}
}

 $StartX = 3;
 $StartY = 10;
 $pdf=new HDtest('L');
 $pdf->AddFont('AngsanaNew','','angsa.php');
 $pdf->AddFont('AngsanaNew','B','angsab.php');
 $pdf->AddFont('THSarabunPSK-Bold','B','THSarabunB.php');
 $pdf->AddPage();
 //สร้างหัวตารางชั้นเดียว
 $pdf->arrHeadT = array("เลขประจำตัว","ชื่อ-นามสกุล","ตำแหน่ง","หน่วยงาน","เลขที่อัตรา","วันที่มีผลบังคับ");
 $pdf->arrHeadTWidth = array(30,50,42,97,38,29);
 $pdf->SetFont('THSarabunPSK-Bold','B',16);
 $allW = array_sum($pdf->arrHeadTWidth);
 $pdf->SetXY($StartX,$StartY);
 $pdf->Cell($allW,$pdf->cellH,$pdf->ConvToThai('การสร้างหัวตารางแบบ 1  ชั้น'),0,1,'C');
 $pdf->SetFont('THSarabunPSK-Bold','B',14);
 $pdf->CreateHeadTableMulti($StartX,$pdf->GetY(),$pdf->cellH);
 //สร้างหัวตาราง 2  ชั้น
 $pdf->arrHeadT = array("กอง ฝ่าย และงาน","ต่ำกว่าปริญญาตรี","ปริญญาตรี","ปริญญาโท","ปริญญาเอก","รวม");
 $pdf->arrHeadT2 = array("1" => "จำนวน","2" => "จำนวน","3" => "จำนวน","4" => "จำนวน","5" => "จำนวน");
 $pdf->arrHeadTWidth = array(120,45,30,30,30,30);
 $allW = array_sum($pdf->arrHeadTWidth);
 $pdf->SetXY($StartX,$pdf->GetY()+15);
 $pdf->SetFont('THSarabunPSK-Bold','B',16);
 $pdf->Cell($allW,$pdf->cellH,$pdf->ConvToThai('การสร้างหัวตารางแบบ 2  ชั้น'),0,1,'C');
 $pdf->SetFont('THSarabunPSK-Bold','B',14);
 $pdf->CreateHeadTableMulti2($StartX,$pdf->GetY(),$pdf->cellH);
 
 //สร้างหัวตาราง 3 ชั้น
 $pdf->arrHeadT = array("หน่วยงาน/คณะ","คุณวุฒิ","รวมทั้งหมด");
 $pdf->arrHeadT2 = array("1" => "ต่ำกว่าปริญญาตรี:ปริญญาตรี:ปริญญาโท:ปริญญาเอก", "2" => "");
 $pdf->arrHeadT3 = array("10" => "ชาย:หญิง:รวม","11" => "ชาย:หญิง:รวม","12" => "ชาย:หญิง:รวม","13" => "ชาย:หญิง:รวม","20" => "ชาย:หญิง:รวม");
 $pdf->arrHeadTWidth = array(125,11,11,11,11,11,11,11,11,11,11,11,11,22);
 $allW = array_sum($pdf->arrHeadTWidth);
 $pdf->SetXY($StartX,$pdf->GetY()+15);
 $pdf->SetFont('THSarabunPSK-Bold','B',16);
 $pdf->Cell($allW,$pdf->cellH,$pdf->ConvToThai('การสร้างหัวตารางแบบ 3  ชั้น'),0,1,'C');
 $pdf->SetFont('THSarabunPSK-Bold','B',14);
 $pdf->CreateHeadTableMulti2($StartX,$pdf->GetY(),$pdf->cellH);
 
 $pdf->Output();
 ?><html xmlns:mso="urn:schemas-microsoft-com:office:office" xmlns:msdt="uuid:C2F41010-65B3-11d1-A29F-00AA00C14882"><head>
<!--[if gte mso 9]><xml>
<mso:CustomDocumentProperties>
<mso:Keywords msdt:dt="string"></mso:Keywords>
<mso:wic_System_Copyright msdt:dt="string"></mso:wic_System_Copyright>
<mso:_Author msdt:dt="string"></mso:_Author>
<mso:_Comments msdt:dt="string"></mso:_Comments>
<mso:VideoHeightInPixels msdt:dt="string"></mso:VideoHeightInPixels>
<mso:display_urn_x003a_schemas-microsoft-com_x003a_office_x003a_office_x0023_Editor msdt:dt="string">Vichaya Sunsern</mso:display_urn_x003a_schemas-microsoft-com_x003a_office_x003a_office_x0023_Editor>
<mso:VideoWidthInPixels msdt:dt="string"></mso:VideoWidthInPixels>
<mso:Order msdt:dt="string">1400.00000000000</mso:Order>
<mso:PublishingStartDate msdt:dt="string"></mso:PublishingStartDate>
<mso:PublishingExpirationDate msdt:dt="string"></mso:PublishingExpirationDate>
<mso:display_urn_x003a_schemas-microsoft-com_x003a_office_x003a_office_x0023_Author msdt:dt="string">Vichaya Sunsern</mso:display_urn_x003a_schemas-microsoft-com_x003a_office_x003a_office_x0023_Author>
<mso:AlternateThumbnailUrl msdt:dt="string"></mso:AlternateThumbnailUrl>
<mso:_SourceUrl msdt:dt="string"></mso:_SourceUrl>
<mso:_SharedFileIndex msdt:dt="string"></mso:_SharedFileIndex>
<mso:MediaLengthInSeconds msdt:dt="string"></mso:MediaLengthInSeconds>
</mso:CustomDocumentProperties>
</xml><![endif]-->
<title></title></head>