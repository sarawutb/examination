<?php
function utf8_strlen($str)
   {
    $c = strlen($str);

     $l = 0;
     for ($i = 0; $i < $c; ++$i)
     {
        if ((ord($str[$i]) & 0xC0) != 0x80)
        {
           ++$l;
        }
     }
     $list = preg_replace('/[^0-9A-Za-zก-ฮ๐-๙า-า]/','',$l); // ตัดทุกอย่างนอกเหนือขอบเขตที่ระบุ
     return strlen($list);
   }
require('fpdf.php');
// $id_subject = 124;
$id_series_exam = $_GET["id_series_exam"];
// $l_list_series_exam = [467,642,2088,643,644];
// $id_sub_series_exam = $_POST["id_subject_series_exam"];
// $year_std = $_POST["year_std"];
// $branch_id = $_POST["branch_id"];
// $branch_name = $_POST["branch_name"];
// $id_subject = $_POST["id_subject_series_exam"];
include("../connect.php");
$pdf = new FPDF('P','mm','A4');

$pdf->AddPage();

// พิมพ์ข้อความลงเอกสาร


	// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวธรรมดา กำหนด ชื่อ เป็น THSarabunNew
$pdf->AddFont('THSarabunNew','','browa.php');
$pdf->AddFont('THSarabunNew','B','browab.php');
$pdf->AddFont('browa','','browa.php');
$pdf->AddFont('browab','B','browab.php');


//สร้างหน้าเอกสาร

// กำหนดฟอนต์ที่จะใช้  อังสนา ตัวธรรมดา ขนาด 12
$pdf->SetFont('THSarabunNew','B',16);
$num_exam1 = 0;
$num_exam2 = 0;
$score_series_exam1 = 0;
$score_series_exam2 = 0;
$sql = "SELECT * FROM `manager_series_exam`
INNER JOIN manager_subject on manager_subject.id = manager_series_exam.id_subject_series_exam
INNER JOIN manager_branch on manager_branch.branch_id = manager_series_exam.branch_id_series_exam
INNER JOIN manager_teacher on manager_teacher.id_teacher = manager_series_exam.teacher_id_series_exam
WHERE manager_series_exam.id = $id_series_exam";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $branch_name = $row["branch_name"];
    $year_std_series_exam = $row["year_std_series_exam"];
    $gender_teacher = $row["gender_teacher"];
    if($gender_teacher == 1){
      $gender_teacher = "นาย";
    }else if($gender_teacher == 2){
        $gender_teacher = "นาง";
    }else if($gender_teacher == 3){
        $gender_teacher = "นางสาว";
    }
    $year_std_series_exam = explode("/",$row["year_std_series_exam"]);
    $year_std_series_exam = $year_std_series_exam[0];

    $name_teacher = $row["name_teacher"];
    $name_subject = $row["name_subject"];
    $id_subject = $row["id_subject"];
    $genre_subject = $row["genre_subject"];
    if($genre_subject == 1){
      $genre_subject = "ปวช";
    }else if($genre_subject == 2){
      $genre_subject = "ปวส";
    }
    // $term_subject = $row["term_subject"];
    $term_subject = explode("/",$row["term_subject"]);

    $ans_type_subject = $row["ans_type_subject"];

    $list_series_exam = $row["list_series_exam"];

    $type_series_exam = $row["type_series_exam"];
    if($type_series_exam == '1'){
      $list_series_exam1 = $list_series_exam;
      $list_series_exam2 = null;
      $type_series_exam1 = $type_series_exam;
      $type_series_exam2 = null;
      $num_exam = count(explode(",",$list_series_exam1));
      $num_exam1 = count(explode(",",$list_series_exam1));
      $score_series_exam = $row["score_series_exam"]*$num_exam;
      $score_series_exam1 = $row["score_series_exam"]*$num_exam1;
    }else if($type_series_exam == '2'){
      $score_series_exam_arr = explode(';',$row["score_series_exam"]);
      $type_series_exam1 = null;
      $type_series_exam2 = $type_series_exam;
      $list_series_exam1 = null;
      $list_series_exam2 = $list_series_exam;
      $num_exam = count(explode(",",$list_series_exam2));
      $num_exam2 = count(explode(",",$list_series_exam2));
      $score_series_exam = array_sum(explode(",",$row["score_series_exam"]));
      $score_series_exam2 = array_sum(explode(",",$row["score_series_exam"]));
      $score_series_exam_arr = explode(';',$row["score_series_exam"]);
      $score_exam_2 = $score_series_exam_arr[0];
    }
    if(strstr($type_series_exam,";")){
    $type_series_exam_arr = explode(';',$type_series_exam);
    $type_series_exam1 = $type_series_exam_arr[0];
    $type_series_exam2 = $type_series_exam_arr[1];
    }
    if(strstr($list_series_exam,";")){
    $list_series_exam_arr = explode(';',$list_series_exam);
    $list_series_exam1 = $list_series_exam_arr[0];
    $list_series_exam2 = $list_series_exam_arr[1];

    $num_exam1 = count(explode(",",$list_series_exam1));
    $num_exam2 = count(explode(",",$list_series_exam2));
    $num_exam = $num_exam1+$num_exam2;

    $score_series_exam_arr = explode(';',$row["score_series_exam"]);
    $score_series_exam1 = $score_series_exam_arr[0]*$num_exam1;
    $score_series_exam2 = array_sum(explode(",",$score_series_exam_arr[1]));
    $score_series_exam = $score_series_exam1+$score_series_exam2;
    $score_exam_2 = $score_series_exam_arr[1];
    }

    $name_series_exam = $row["name_series_exam"];


    // echo $list_series_exam1;



  }
  if($ans_type_subject == 1){
    $ans_type_subject = array('ก','ข','ค','ง','จ');
  }else if($ans_type_subject == 2){
    $ans_type_subject = array('1','2','3','4','5');
  }else if($ans_type_subject == 3){
    $ans_type_subject = array('a','b','c','d','e');
  }
}
// echo $list_series_exam2;

    /* Move to the right */
    // $pdf->MultiCell(170 ,5,iconv('UTF-8','cp874',trim($row['proposition_exam'])),0,'L');
    $pdf->Cell(70);
    //$pdf->setXY( 10, 10  );
    // $pdf->Cell( 0  , 0 , iconv( 'UTF-8','cp874' , 'ชุดข้อสอบ วิชา' ) );
    $pdf->Cell( 55  , 6.5 , iconv( 'UTF-8','cp874' , 'ภาคเรียนที่ '.$term_subject[0].' ปีการศึกษาที่ '.$term_subject[1] ),0,1,'C' );
  // $pdf->SetY(16);
    // $pdf->Cell( 0  , 10 , iconv( 'UTF-8','cp874' , 'ข้อสอบวิชา '.$name_subject.' จำนวน '.$num_exam.' ข้อ '.$score_series_exam*$num_exam.' คะแนน' ),0,0,'C' );
    $pdf->Cell( 0  , 6.5 , iconv( 'UTF-8','cp874' , 'ข้อสอบวิชา '.$name_subject.' จำนวน '.$num_exam.' ข้อ '.$score_series_exam.' คะแนน' ),0,1,'C' );
    // $pdf->Cell( 0  , 20 , iconv( 'UTF-8','cp874' , 'นักศึกษา (ปวส) การตลาด ห้อง 1/1' ),0,0,'C' );
    // $pdf->SetY(17.5);
    $pdf->Cell( 0  , 6.5 , iconv( 'UTF-8','cp874' , '('.$genre_subject.$year_std_series_exam.'.) '.$branch_name.' อาจารย์ผู้สอน '.$gender_teacher.$name_teacher ),0,1,'C' );
    // $pdf->SetY(17.5);
    $pdf->Cell( 0  , 6.5 , iconv( 'UTF-8','cp874' , 'วิทยาลัยอาชีวศึกษาจุลมณีอุทุมพรพิสัย จังหวัดศรีสะเกษ' ),0,0,'C' );
      $pdf->SetY(17.5);
      $pdf->Cell( 0  , 40 , iconv( 'UTF-8','cp874' , '__________________________________________________________________________________' ),0,0,'C' );

  $pdf->Cell(60 ,25,'',0,1);

  $i = 1;
  if($type_series_exam1 == 1){
  $pdf->SetFont('browab','B',16);
  $pdf->SetX(20);
  $pdf->MultiCell(170 ,7,iconv('UTF-8','cp874','แบบปรนัยจำนวน '.$num_exam1.' ข้อ '.$score_series_exam1.' คะแนน'),0,'L');
  $sql = "SELECT * FROM `manager_exam` WHERE `id` IN ($list_series_exam1)";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()) {
    if($row['proposition_img_exam'] != null){
      $get_x = 65;
      $MultiCell_x = 135;
    }else{
      $get_x = 25;
      $MultiCell_x = 170;
    }

  $pdf->SetFont('browab','B',16);
  $pdf->SetX(20);
  $pdf->Cell(6 ,5,iconv('UTF-8','cp874',$i++.'). '),0,0,'L');
  $pdf->MultiCell(180 ,5,iconv('UTF-8','cp874',trim($row['proposition_exam'])),0,'L');
  // $this->MultiCell($w,5,$this->Image ($data[$i],$ix,$iy,$iw,$ih),0,$a);
  // $pdf->Cell(25 ,2,iconv('UTF-8','cp874',''),0,1,'L');
  $pdf->SetX(25);
  if($row['proposition_img_exam'] != null){
  // $pdf->Cell(53,35, $pdf->Image('../upload/'.$row['proposition_img_exam'], 25, $pdf->GetY(), 35,0) ,0,0,'C',0);
  $pdf->Image('../upload/'.$row['proposition_img_exam'],23,$pdf->GetY()+2,35,0);
  }
  // $pdf->SetX(25);
  // $pdf->Cell(25 ,7,iconv('UTF-8','cp874',''),0,1,'L');
  // $pdf->Image('../upload/101121af895f04314415b4cdfb2c9a5668de43.jpg',17+$i,50*$,50,50,'JPG');
  // $pdf->MultiCell(70 ,30,$pdf->Image('../upload/101121af895f04314415b4cdfb2c9a5668de43.jpg',17+$i,100,50,50,'JPG'),1,'L');
  // $pdf->MultiCell(170 ,5,iconv('UTF-8','cp874',$i++.').'.preg_replace('/[[:space:]]+/', ' ', trim($row['proposition_exam']))),0,'L');
  $pdf->SetX($get_x);
  $pdf->SetFont('THSarabunNew','',16);
  $pdf->Cell(5 ,7,iconv('UTF-8','cp874',$ans_type_subject[0].'. '),0,0,'L');
  $pdf->MultiCell($MultiCell_x ,7,iconv('UTF-8','cp874',trim($row['answer1_exam'])),0,'L');
  $pdf->SetX($get_x);
  $pdf->Cell(5 ,7,iconv('UTF-8','cp874',$ans_type_subject[1].'. '),0,0,'L');
  $pdf->MultiCell($MultiCell_x ,7,iconv('UTF-8','cp874',trim($row['answer2_exam'])),0,'L');
  $pdf->SetX($get_x);
  $pdf->Cell(5 ,7,iconv('UTF-8','cp874',$ans_type_subject[2].'. '),0,0,'L');
  $pdf->MultiCell($MultiCell_x ,7,iconv('UTF-8','cp874',trim($row['answer3_exam'])),0,'L');
  $pdf->SetX($get_x);
  $pdf->Cell(5 ,7,iconv('UTF-8','cp874',$ans_type_subject[3].'. '),0,0,'L');
  $pdf->MultiCell($MultiCell_x ,7,iconv('UTF-8','cp874',trim($row['answer4_exam'])),0,'L');
  $pdf->SetX($get_x);
  $pdf->Cell(5 ,7,iconv('UTF-8','cp874',$ans_type_subject[4].'. '),0,0,'L');
  $pdf->MultiCell($MultiCell_x ,7,iconv('UTF-8','cp874',trim($row['answer5_exam'])),0,'L');
  $pdf->Cell(25 ,5,iconv('UTF-8','cp874',''),0,1,'L');

  $pdf->SetAutoPageBreak(true,20);
    }
  }
  // $pdf->Cell(25 ,7,iconv('UTF-8','cp874',''),0,1,'L');
  // $pdf->Cell(25 ,7,iconv('UTF-8','cp874',''),0,1,'L');
  // $pdf->Cell(25 ,7,iconv('UTF-8','cp874',''),0,1,'L');
  if($type_series_exam2 == 2){
    $pdf->SetFont('browab','B',16);
    $pdf->SetX(20);
    $pdf->MultiCell(170 ,5,iconv('UTF-8','cp874','แบบอัตนัยจำนวน '.$num_exam2.' ข้อ '.$score_series_exam2.' คะแนน'),0,'L');
    $sql2 = "SELECT * FROM `manager_exam_annotated` WHERE `id` IN ($list_series_exam2)";
    $result2 = $conn->query($sql2);
    while($row2 = $result2->fetch_assoc()) {
    $pdf->SetX(20);
    $pdf->SetFont('browab','B',16);
    $arr_score2 = explode(",",$score_exam_2);
    $pdf->MultiCell(158 ,5,iconv('UTF-8','cp874',$i++.'). '.trim($row2['proposition_exam'].' ('.$arr_score2[0].' คะแนน)')),0,'L');
    if($row2['proposition_img_exam'] != null){
    $pdf->Cell(25 ,2,iconv('UTF-8','cp874',''),0,1,'L');
    $pdf->Cell(53,40, $pdf->Image('../upload/'.$row2['proposition_img_exam'], 80, $pdf->GetY(), 40,0) ,0,1,'C',0);
    }

    $pdf->SetFont('THSarabunNew','',21);
    // $pdf->Cell(170 ,2,iconv('UTF-8','cp874',''),0,'L');
    $pdf->SetX(20);
    $pdf->Cell(170 ,7,iconv('UTF-8','cp874','...............................................................................................................................'),0,1,'L');
    $pdf->SetX(20);
    $pdf->Cell(170 ,7,iconv('UTF-8','cp874','...............................................................................................................................'),0,1,'L');
    $pdf->SetX(20);
    $pdf->Cell(170 ,7,iconv('UTF-8','cp874','...............................................................................................................................'),0,1,'L');
    $pdf->SetX(20);
    $pdf->Cell(170 ,7,iconv('UTF-8','cp874','...............................................................................................................................'),0,1,'L');
    $pdf->SetX(20);
    $pdf->Cell(170 ,7,iconv('UTF-8','cp874','...............................................................................................................................'),0,1,'L');
    $pdf->SetX(20);
    $pdf->Cell(170 ,7,iconv('UTF-8','cp874','...............................................................................................................................'),0,1,'L');
    $pdf->SetX(20);
    $pdf->Cell(170 ,7,iconv('UTF-8','cp874','...............................................................................................................................'),0,1,'L');
    $pdf->SetX(20);
    $pdf->Cell(170 ,7,iconv('UTF-8','cp874','...............................................................................................................................'),0,1,'L');
    $pdf->SetX(20);
    $pdf->Cell(170 ,7,iconv('UTF-8','cp874','...............................................................................................................................'),0,1,'L');
    // $pdf->Cell(170 ,7,iconv('UTF-8','cp874',''),0,'L');
      $pdf->Cell(25 ,8,iconv('UTF-8','cp874',''),0,1,'L');
    }
  }
  // echo trim(" These are a few words ");

$pdf->Output();?>
