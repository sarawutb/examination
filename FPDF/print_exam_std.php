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
$id_std = $_GET["id_std"];
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
$pdf->AddFont('THSarabunNewBold','B','browab.php');
$pdf->AddFont('THSarabunNewItalic','I','THSarabunNew Italic.php');
$pdf->AddFont('browa','','browa.php');
$pdf->AddFont('browab','B','browab.php');


//สร้างหน้าเอกสาร

// กำหนดฟอนต์ที่จะใช้  อังสนา ตัวธรรมดา ขนาด 12
$pdf->SetFont('THSarabunNewBold','B',16);
$num_exam1 = 0;
$num_exam2 = 0;
$score_series_exam1 = 0;
$score_series_exam2 = 0;
$sql = "SELECT * FROM `manager_series_exam`
INNER JOIN manager_subject on manager_subject.id = manager_series_exam.id_subject_series_exam
INNER JOIN manager_branch on manager_branch.branch_id = manager_series_exam.branch_id_series_exam
INNER JOIN manager_teacher on manager_teacher.id_teacher = manager_series_exam.teacher_id_series_exam
INNER JOIN result_exam_std on result_exam_std.id_name_series_exam = manager_series_exam.id
INNER JOIN manage_std on manage_std.id = result_exam_std.id_std_result_exam
WHERE manager_series_exam.id = $id_series_exam AND manage_std.id_std = $id_std;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $datetime_start_series_exam =  $row['datetime_start_series_exam'];
    $datetime_end_series_exam =  $row['datetime_end_series_exam'];

    $gender_std = $row["gender_std"];
    if($gender_std == 1){
      $gender_std = "นาย";
    }else if($gender_std == 2){
      $gender_std = "นางสาว";
    }
    $name_std = $gender_std.$row["name_std"];

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
    $name_teacher = $gender_std.$row["name_teacher"];

    $name_subject = $row["name_subject"];
    $id_subject = $row["id_subject"];
    $genre_subject = $row["genre_subject"];
    if($genre_subject == 1){
      $genre_subject = "ปวช.";
    }else if($genre_subject == 2){
      $genre_subject = "ปวส.";
    }
    // $term_subject = $row["term_subject"];
    $term_subject = explode("/",$row["term_subject"]);

    $ans_type_subject = $row["ans_type_subject"];

    $list_series_exam = $row["list_series_exam"];

    $exam_result_exam = explode(",",$row['exam_result_exam']);

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


      // print_r($exam_result_exam);
      // $array = array("5","20","10","21","30");

      // echo array_search("10",$array);

      $ans_result_exam = $row["ans_result_exam"];
      $arr_ans_result_exam = explode(";",$ans_result_exam);
      $ans_result_exam1 = explode(",",$arr_ans_result_exam[0]);
      $ans_result_exam2 = null;
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
      $name_series_exam = $row["name_series_exam"];

      $ans_result_exam = $row["ans_result_exam"];
      // $arr_ans_result_exam = explode(";",$ans_result_exam);
      $ans_result_exam1 = null;
      $ans_result_exam2 = explode("|=>",$ans_result_exam);

      // echo $ans_result_exam2[1];
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


    $name_series_exam = $row["name_series_exam"];
    $ans_result_exam = $row["ans_result_exam"];
    $arr_ans_result_exam = explode(";",$ans_result_exam);

    $ans_result_exam1 = explode(",",$arr_ans_result_exam[0]);
    $ans_result_exam2 = explode("|=>",$arr_ans_result_exam[1]);

    // if(strstr($arr_ans_result_exam[0],",")){
    //   $ans_result_exam1 = explode(",",$arr_ans_result_exam[0]);
    // }else{
    //   $ans_result_exam1 = $arr_ans_result_exam[0];
    // }
    //
    // if(strstr($arr_ans_result_exam[1],"|=>")){
    //   $ans_result_exam2 = explode("|=>",$arr_ans_result_exam[1]);
    // }else{
    //   $ans_result_exam2 = $arr_ans_result_exam[0];
    // }
    // $ans_result_exam2 = explode("|=>",$arr_ans_result_exam[1]);
    // print_r($ans_result_exam2);
  }

    // echo $arr_ans_result_exam[1];



  }
  if($ans_type_subject == 1){
    $ans_type_subject = array('ก','ข','ค','ง','จ');
  }else if($ans_type_subject == 2){
    $ans_type_subject = array('1','2','3','4','5');
  }else if($ans_type_subject == 3){
    $ans_type_subject = array('a','b','c','d','e');
  }

  date_default_timezone_set("Asia/Bangkok");
  $date_time_StartCreate=date_create($datetime_start_series_exam);
  $dateStart =  date_format($date_time_StartCreate,"d m Y");
  $TimeStart =  date_format($date_time_StartCreate,"H:i");

  $Y_Start =  date_format($date_time_StartCreate,"Y");
  $m_Start =  date_format($date_time_StartCreate,"m");
  $d_Start =  date_format($date_time_StartCreate,"d")+0;
  $H_Start =  date_format($date_time_StartCreate,"H");
  $i_Start =  date_format($date_time_StartCreate,"i");

  $arr_date_m = array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

  $Date_Time_Start = $d_Start.' '.$arr_date_m[$m_Start-1].' '.$Y_Start.' '.$TimeStart.'น.';
}
// echo $list_series_exam2;

    /* Move to the right */
    // $pdf->MultiCell(170 ,5,iconv('UTF-8','cp874',trim($row['proposition_exam'])),0,'L');
    $pdf->Cell(70);
    //$pdf->setXY( 10, 10  );
    // $pdf->Cell( 0  , 0 , iconv( 'UTF-8','cp874' , 'ชุดข้อสอบ วิชา' ) );
    $pdf->SetFont('THSarabunNewBold','B',16);
    $pdf->Cell( 55  , 7 , iconv( 'UTF-8','cp874' , 'รายงานผลสอบ ภาคเรียนที่ '.$term_subject[0].' ปีการศึกษาที่ '.$term_subject[1] ),0,0,'C' );
    $pdf->SetY(20);

    $pdf->SetFont('THSarabunNewBold','B',16);
    $pdf->SetX(20);
    $pdf->Cell( 0  , 7 , iconv( 'UTF-8','cp874' , 'รหัสนักศึกษา : ' ),0,0,'L' );
    $pdf->SetX(48);
    $pdf->Cell( 0  , 7 , iconv( 'UTF-8','cp874' , $id_std ),0,1,'L' );
    // $pdf->SetX(20);
    // $pdf->Cell( 0  , 7 , iconv( 'UTF-8','cp874' ,'ภาคเรียนที่ '.$term_subject[0].' ปีการศึกษาที่ '.$term_subject[1] ),0,1,'L' );

    $pdf->SetX(20);
    // $pdf->Cell( 0  , 10 , iconv( 'UTF-8','cp874' , 'ข้อสอบวิชา '.$name_subject.' จำนวน '.$num_exam.' ข้อ '.$score_series_exam*$num_exam.' คะแนน' ),0,0,'C' );
    $pdf->Cell( 0  , 7 , iconv( 'UTF-8','cp874' , 'ชื่อ-สกุล : ' ),0,0,'L' );
    $pdf->SetX(38);
    $pdf->Cell( 0  , 7 , iconv( 'UTF-8','cp874' , $name_std ),0,1,'L' );

    // $pdf->SetY(15);
    $pdf->SetX(20);
    $pdf->Cell( 0  , 7 , iconv( 'UTF-8','cp874' , 'รายวิชา : ' ),0,0,'L' );
    $pdf->SetX(38);
    // $pdf->Cell( 0  , 7 , iconv( 'UTF-8','cp874' ,'ภาคเรียนที่ '.$term_subject[0].' ปีการศึกษาที่ '.$term_subject[1] ),0,1,'L' );

    $pdf->Cell( 0  , 7 , iconv( 'UTF-8','cp874' , $id_subject.' '.$name_subject ),0,1,'L' );
    $pdf->SetX(20);

    $pdf->Cell( 0  , 7 , iconv( 'UTF-8','cp874' , 'อาจารย์ผู้สอน : ' ),0,0,'L' );
    $pdf->SetX(48);
    $pdf->Cell( 0  , 7 , iconv( 'UTF-8','cp874' , $name_teacher ),0,1,'L' );

    $pdf->SetX(20);
    $pdf->Cell( 0  , 7 , iconv( 'UTF-8','cp874' , 'วันเวลาที่สอบ : ' ),0,0,'L' );
    $pdf->SetX(48);
    $pdf->Cell( 0  , 7 , iconv( 'UTF-8','cp874' , $Date_Time_Start ),0,0,'L' );

  // $pdf->SetY(15);
  //   // $pdf->Cell( 0  , 20 , iconv( 'UTF-8','cp874' , 'นักศึกษา (ปวส) การตลาด ห้อง 1/1' ),0,0,'C' );
  //   $pdf->SetY(15);
  //   $pdf->Cell( 0  , 20 , iconv( 'UTF-8','cp874' , '('.$genre_subject.')'.$branch_name.' อาจารย์ผู้สอน '.$gender_teacher.$name_teacher ),0,0,'C' );
  //   $pdf->SetY(15);
  //   $pdf->Cell( 0  , 30 , iconv( 'UTF-8','cp874' , 'วิทยาลัยอาชีวศึกษาจุลมณีอุทุมพรพิสัย จังหวัดศรีสะเกษ' ),0,0,'C' );
    $pdf->SetY(35);
      // $pdf->SetTextColor(247, 255, 45);
      // $pdf->SetLineWidth(1);
    $pdf->Cell( 0  , 40 , iconv( 'UTF-8','cp874' , '__________________________________________________________________________________' ),0,0,'C' );

  $pdf->Cell(60 ,25,'',0,1);
  $arr_num = 0;
  $i = 1;
  if($type_series_exam1 == 1){
  $pdf->SetFont('browab','B',16);
  $pdf->SetX(20);
  $pdf->MultiCell(170 ,7,iconv('UTF-8','cp874','แบบปรนัยจำนวน '.$num_exam1.' ข้อ '.$score_series_exam1.' คะแนน'),0,'L');
  $sql = "SELECT * FROM `manager_exam` WHERE `id` IN ($list_series_exam1)";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()) {
    $result_exam = $row['result_exam'];
    $exam_id = $row['id'];
    // $ans_exam = $row['ans_result_exam'];
    if($row['proposition_img_exam'] != null){
      $get_x = 65;
      $MultiCell_x = 135;
    }else{
      $get_x = 25;
      $MultiCell_x = 170;
    }

    // print_r($exam_result_exam);
    // echo $exam_id."=>";
    $ans_exam = explode(",",$ans_result_exam);
    $exam_search = array_search($exam_id,$exam_result_exam);

    // print_r($ans_exam[$exam_search]);


  $pdf->SetFont('browab','B',16);
  $pdf->SetX(20);
  $pdf->Cell(6 ,5,iconv('UTF-8','cp874',$i++.'). '),0,0,'L');
  $pdf->MultiCell(180 ,5,iconv('UTF-8','cp874',trim($row['proposition_exam'])),0,'L');
  // $this->MultiCell($w,5,$this->Image ($data[$i],$ix,$iy,$iw,$ih),0,$a);
  // $pdf->Cell(25 ,2,iconv('UTF-8','cp874',''),0,1,'L');
  // $pdf->Cell(25 ,1,iconv('UTF-8','cp874',''),1,1,'L');
  $pdf->SetX(25);
  if($row['proposition_img_exam'] != null){
  // $pdf->Cell(53,35, $pdf->Image('../upload/'.$row['proposition_img_exam'], 25, $pdf->GetY(), 35,35) ,0,0,'C',0);
  $pdf->Image('../upload/'.$row['proposition_img_exam'],23,$pdf->GetY()+2,35,0);
  $val_x_img = 40;
}else{
  $val_x_img  = 0;
}
  // $pdf->SetX(25);
  // $pdf->Cell(25 ,7,iconv('UTF-8','cp874',''),0,1,'L');
  // $pdf->Image('../upload/101121af895f04314415b4cdfb2c9a5668de43.jpg',17+$i,50*$,50,50,'JPG');
  // $pdf->MultiCell(70 ,30,$pdf->Image('../upload/101121af895f04314415b4cdfb2c9a5668de43.jpg',17+$i,100,50,50,'JPG'),1,'L');
  // $pdf->MultiCell(170 ,5,iconv('UTF-8','cp874',$i++.').'.preg_replace('/[[:space:]]+/', ' ', trim($row['proposition_exam']))),0,'L');

  $pdf->SetFont('THSarabunNew','',16);
  // $pdf->SetFont('THSarabunNewBold','B',16);
  if($ans_exam[$exam_search] == '1'){
    $pdf->Image('img/select1.png', 23.5+$val_x_img, $pdf->GetY(), 7,7);
    if($result_exam == 1){
        $pdf->Image('img/true.png', 25+$val_x_img, $pdf->GetY(), 5,5);
    }else{
      $pdf->Image('img/select.png', 24+$val_x_img, $pdf->GetY(), 6,6);
    }
  }
  if($result_exam == 1){
      $pdf->SetFont('THSarabunNewBold','B',16);
  }
  $pdf->SetX($get_x);
  $pdf->Cell(5 ,6.5,iconv('UTF-8','cp874',$ans_type_subject[0].'. '),0,0,'L');
  $pdf->MultiCell($MultiCell_x ,6.5,iconv('UTF-8','cp874',trim($row['answer1_exam'])),0,'L');

  $pdf->SetFont('THSarabunNew','',16);
  // if($arr_ans_result_exam[$arr_num] == 2){
  //   $pdf->Cell(1,11, $pdf->Image('img/select1.png', 23.5, $pdf->GetY(), 7,7) ,0,0,'C',0);
  //   if($result_exam == 2){
  //       // $pdf->Cell(1,11, $pdf->Image('img/true.png', 25, $pdf->GetY(), 5,5) ,0,0,'C',0);
  //       $pdf->Cell(1,11, $pdf->Image('img/true.png', 26, $pdf->GetY(), 5,5) ,0,0,'C',0);
  //       $pdf->SetFont('THSarabunNewBold','B',16);
  //   }else{
  //     $pdf->Cell(1,11, $pdf->Image('img/select.png', 24, $pdf->GetY(), 6,6) ,0,0,'C',0);
  //     $pdf->SetFont('THSarabunNew','',16);
  //   }
  // }
  // $pdf->SetTextColor(0,0,0);

  if($ans_exam[$exam_search] == '2'){
    $pdf->Image('img/select1.png', 23.5+$val_x_img, $pdf->GetY(), 7,7);
    if($result_exam == 2){
        $pdf->Image('img/true.png', 25+$val_x_img, $pdf->GetY(), 5,5);
    }else{
      $pdf->Image('img/select.png', 24+$val_x_img, $pdf->GetY(), 6,6);
    }
  }
  if($result_exam == 2){
      $pdf->SetFont('THSarabunNewBold','B',16);
  }
  $pdf->SetX($get_x);
  $pdf->Cell(5 ,6.5,iconv('UTF-8','cp874',$ans_type_subject[1].'. '),0,0,'L');
  $pdf->MultiCell($MultiCell_x ,6.5,iconv('UTF-8','cp874',trim($row['answer2_exam'])),0,'L');
  $pdf->SetFont('THSarabunNew','',16);

  if($ans_exam[$exam_search] == '3'){
    $pdf->Image('img/select1.png', 23.5+$val_x_img, $pdf->GetY(), 7,7);
    if($result_exam == 3){
        $pdf->Image('img/true.png', 25+$val_x_img, $pdf->GetY(), 5,5);
    }else{
      $pdf->Image('img/select.png', 24+$val_x_img, $pdf->GetY(), 6,6);
    }
  }
  if($result_exam == 3){
      $pdf->SetFont('THSarabunNewBold','B',16);
  }
  $pdf->SetX($get_x);
  $pdf->Cell(5 ,6.5,iconv('UTF-8','cp874',$ans_type_subject[2].'. '),0,0,'L');
  $pdf->MultiCell($MultiCell_x ,6.5,iconv('UTF-8','cp874',trim($row['answer3_exam'])),0,'L');
  $pdf->SetFont('THSarabunNew','',16);

  if($ans_exam[$exam_search] == '4'){
    $pdf->Image('img/select1.png', 23.5+$val_x_img, $pdf->GetY(), 7,7);
    if($result_exam == 4){
        $pdf->Image('img/true.png', 25+$val_x_img, $pdf->GetY(), 5,5);
    }else{
      $pdf->Image('img/select.png', 24+$val_x_img, $pdf->GetY(), 6,6);
    }
  }
  if($result_exam == 4){
      $pdf->SetFont('THSarabunNewBold','B',16);
  }
  $pdf->SetX($get_x);
  $pdf->Cell(5 ,6.5,iconv('UTF-8','cp874',$ans_type_subject[3].'. '),0,0,'L');
  $pdf->MultiCell($MultiCell_x ,6.5,iconv('UTF-8','cp874',trim($row['answer4_exam'])),0,'L');
  $pdf->SetFont('THSarabunNew','',16);

  if($ans_exam[$exam_search] == '5'){
    $pdf->Image('img/select1.png', 23.5+$val_x_img, $pdf->GetY(), 7,7);
    if($result_exam == 5){
        $pdf->Image('img/true.png', 25+$val_x_img, $pdf->GetY(), 5,5);
    }else{
      $pdf->Image('img/select.png', 24+$val_x_img, $pdf->GetY(), 6,6);
    }
  }
  if($result_exam == 5){
      $pdf->SetFont('THSarabunNewBold','B',16);
  }
  $pdf->SetX($get_x);
  $pdf->Cell(5 ,6.5,iconv('UTF-8','cp874',$ans_type_subject[4].'. '),0,0,'L');
  $pdf->MultiCell($MultiCell_x ,6.5,iconv('UTF-8','cp874',trim($row['answer5_exam'])),0,'L');
  $pdf->SetFont('THSarabunNew','',16);

  $pdf->Cell(25 ,5,iconv('UTF-8','cp874',''),0,1,'L');
  $arr_num++;
  $pdf->SetAutoPageBreak(true,24);
    }
  }
  // $pdf->Cell(25 ,7,iconv('UTF-8','cp874',''),0,1,'L');
  // $pdf->Cell(25 ,7,iconv('UTF-8','cp874',''),0,1,'L');
  // $pdf->Cell(25 ,7,iconv('UTF-8','cp874',''),0,1,'L');
  if($type_series_exam2 == 2){
    $pdf->SetFont('browab','B',16);
    $pdf->SetX(20);
    $pdf->MultiCell(170 ,5,iconv('UTF-8','cp874','แบบอัตนัยจำนวน '.$num_exam2.' ข้อ '.$score_series_exam2.' คะแนน'),0,'L');
    $arr_num = 0;
    $sql2 = "SELECT * FROM `manager_exam_annotated` WHERE `id` IN ($list_series_exam2)";
    $result2 = $conn->query($sql2);
    while($row2 = $result2->fetch_assoc()) {
    $ans_exam_annotated = $row2['ans_exam'];
    $pdf->SetX(20);
    $pdf->SetFont('browab','B',16);
    $arr_score2 = explode(",",$score_exam_2);
    $pdf->MultiCell(158 ,5,iconv('UTF-8','cp874',$i++.'). '.trim($row2['proposition_exam'].' ('.$arr_score2[0].' คะแนน)')),0,'L');
    if($row2['proposition_img_exam'] != null){
    $pdf->Cell(25 ,2,iconv('UTF-8','cp874',''),0,1,'L');
    $pdf->Cell(53,40, $pdf->Image('../upload/'.$row2['proposition_img_exam'], 80, $pdf->GetY(), 40,0) ,0,1,'C',0);
    }


    // $pdf->Cell(170 ,2,iconv('UTF-8','cp874',''),0,'L');
    $pdf->Cell(170 ,3,iconv('UTF-8','cp874',''),0,1,'L');
    $pdf->SetFont('THSarabunNewBold','B',16);
    $pdf->SetX(25);
    $pdf->Cell(170 ,7,iconv('UTF-8','cp874','เฉลย : '),0,0,'L');
    $pdf->SetTextColor(27,156,32);
    $pdf->SetX(40);
    $pdf->MultiCell(158 ,7,iconv('UTF-8','cp874',trim($ans_exam_annotated)),0,'L');

    $pdf->Cell(170 ,3,iconv('UTF-8','cp874',''),0,1,'L');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFont('THSarabunNewBold','B',16);
    $pdf->SetX(25);
    $pdf->Cell(170 ,7,iconv('UTF-8','cp874','ตอบ : '),0,0,'L');
    $pdf->SetFont('THSarabunNew','',16);
    $pdf->SetX(40);
    $pdf->MultiCell(158 ,7,iconv('UTF-8','cp874',$ans_result_exam2[$arr_num]),0,'L');
      // $pdf->Cell(170 ,7,iconv('UTF-8','cp874',''),0,'L');
    $pdf->Cell(25 ,8,iconv('UTF-8','cp874',''),0,1,'L');
    $arr_num++;

    }
  }
  // echo trim(" These are a few words ");






$pdf->Output();?>
