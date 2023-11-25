<?php
function utf8_strlen($str)
{
  $c = strlen($str);

  $l = 0;
  for ($i = 0; $i < $c; ++$i) {
    if ((ord($str[$i]) & 0xC0) != 0x80) {
      ++$l;
    }
  }
  $list = preg_replace('/[^0-9A-Za-zก-ฮ๐-๙า-า]/', '', $l); // ตัดทุกอย่างนอกเหนือขอบเขตที่ระบุ
  return strlen($list);
}
require('fpdf.php');
$id_sub_series_exam = $_POST["id_subject_series_exam"];
$year_std = $_POST["year_std"];
$branch_id = $_POST["branch_id"];
$branch_name = $_POST["branch_name"];
$id_subject = $_POST["id_subject_series_exam"];
include("../connect.php");
$pdf = new FPDF('L', 'mm', 'A4');

$pdf->AddPage();

// พิมพ์ข้อความลงเอกสาร
//$pdf->setXY( 10, 10  );
//$pdf->Cell( 0  , 0 , iconv( 'UTF-8','cp874' , 'อังสนา ตัวธรรมดา ขนาด 12' ) );

// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวธรรมดา กำหนด ชื่อ เป็น THSarabunNew
$pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');

// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวหนา  กำหนด ชื่อ เป็น THSarabunNew
$pdf->AddFont('THSarabunNew', 'B', 'THSarabunNew Bold.php');

// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวหนา  กำหนด ชื่อ เป็น THSarabunNew
$pdf->AddFont('THSarabunNew', 'I', 'THSarabunNew Italic.php');

// เพิ่มฟอนต์ภาษาไทยเข้ามา ตัวหนา  กำหนด ชื่อ เป็น THSarabunNew
$pdf->AddFont('THSarabunNew', 'BI', 'THSarabunNew.php');

//สร้างหน้าเอกสาร

// กำหนดฟอนต์ที่จะใช้  อังสนา ตัวธรรมดา ขนาด 12
$pdf->SetFont('THSarabunNew', 'B', 14);

/* Move to the right */
$pdf->Cell(60);

$sql2 = "SELECT SUBSTRING_INDEX(`term_subject`,'/',1) AS term,SUBSTRING_INDEX(`term_subject`,'/',-1) AS term_y,
          id_subject,name_subject,name_teacher,genre_subject,term_subject,gender_teacher
          FROM `manager_subject`
				INNER JOIN manager_teacher on manager_teacher.id_teacher = manager_subject.name_teacher_subject
				WHERE id = $id_sub_series_exam";
$result2 = mysqli_query($conn, $sql2);
while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
  $id_subject =  $row2['id_subject'];
  $name_subject =  $row2['name_subject'];
  $name_teacher =  $row2['name_teacher'];
  $genre_subject =  $row2['genre_subject'];
  $term_subject =  $row2['term_subject'];
  $gender_teacher =  $row2['gender_teacher'];
  $term =  $row2['term'];
  $term_y =  $row2['term_y'];
}
if ($genre_subject == 1) {
  $genre_subject = "ปวช.";
} else if ($genre_subject == 2) {
  $genre_subject = "ปวส.";
}

if ($gender_teacher == 1) {
  $teacher_gender = "นาย";
} else if ($gender_teacher == 2) {
  $teacher_gender = "นาง";
} else if ($gender_teacher == 3) {
  $teacher_gender = "นางสาว";
}

//$pdf->Cell(70,10,iconv( 'UTF-8','cp874','หัวกระดาษ',1,0,'C'));
$pdf->Cell(158, 10, iconv('UTF-8', 'cp874', 'ภาคเรียนที่ ' . $term . ' ปีการศึกษา ' . $term_y), 0, 0, 'C');
$pdf->SetY(15);
$pdf->SetX(70);
$pdf->Cell(158, 10, iconv('UTF-8', 'cp874', 'ผลรวมคะแนน รายวิชา ' . $id_subject . ' ' . $name_subject), 0, 0, 'C');


$pdf->SetY(15);
$pdf->Cell(0, 20, iconv('UTF-8', 'cp874', 'นักศึกษา (' . $genre_subject . ') ' . $branch_name . ' ห้อง ' . $year_std), 0, 0, 'C');
$pdf->SetY(15);
$pdf->Cell(0, 30, iconv('UTF-8', 'cp874', 'วิทยาลัยอาชีวศึกษาจุลมณีอุทุมพรพิสัย จังหวัดศรีสะเกษ'), 0, 0, 'C');


$pdf->Cell(60, 22, '', 0, 1);

$pdf->SetFont('THSarabunNew', 'B', 13);
$pdf->Cell(3);
/*Heading Of the table*/
//$pdf->Cell(10 ,6,'ลำดับ',1,0,'C');
$pdf->Cell(10, 12, iconv('UTF-8', 'cp874', 'ลำดับ'), 1, 0, 'C');
//$pdf->Cell(80 ,6,'รหัสนักศึกษา',1,0,'C');
$pdf->Cell(20, 12, iconv('UTF-8', 'cp874', 'รหัสนักศึกษา'), 1, 0, 'C');
$pdf->Cell(47, 12, iconv('UTF-8', 'cp874', 'ชื่อ-สกุล'), 1, 0, 'C');
//$pdf->Cell(23 ,6,'ชื่อ-สกุล ',1,0,'C');
//$pdf->Cell(30 ,6,'ทดสอบที่ 1 (11)',1,0,'C');
$sumpointHead = 0;
$sumpoint_value = 0;
$list_count1 = 0;
$list_count2 = 0;



// $sql2 = "SELECT DISTINCT manage_std.degree_std FROM `manager_series_exam`
//           INNER JOIN result_exam_std on result_exam_std.id_name_series_exam = manager_series_exam.id_subject_series_exam
//           INNER JOIN manage_std on manage_std.id = result_exam_std.id_std_result_exam
//           WHERE `id_subject_series_exam` = $id_sub_series_exam
//           AND `branch_id_series_exam`= $branch_id;";
// $result2 = mysqli_query($conn, $sql2);
// while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
//   $degree_std =  $row2['degree_std'];
// }
$test = explode("/", $year_std);

$sql2 = "SELECT DISTINCT manager_series_exam.`id_subject_series_exam`,manage_std.year_std FROM `manager_series_exam`
          INNER JOIN result_exam_std on manager_series_exam.id = result_exam_std.id_name_series_exam
          INNER JOIN manage_std on manage_std.id = result_exam_std.id_std_result_exam
          WHERE `id_subject_series_exam` = $id_sub_series_exam
          AND `branch_id_series_exam`= $branch_id
          AND manage_std.year_std LIKE '%/$test[1]%';";
$result2 = mysqli_query($conn, $sql2);
while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
  $year_std_arr =  $row2['year_std'];
}

//$sql2 = "SELECT * FROM `manager_series_exam`
//	INNER JOIN result_exam_std on manager_series_exam.id = result_exam_std.id_name_series_exam
//	WHERE `id_subject_series_exam` = 8
//	GROUP BY manager_series_exam.id,result_exam_std.id_name_series_exam";

//$sql2 = "SELECT * FROM `manager_series_exam` WHERE `id_subject_series_exam` = $id_sub_series_exam";
$sql2 = "SELECT * FROM `manager_series_exam`
                    WHERE `id_subject_series_exam` = $id_sub_series_exam
                    AND `branch_id_series_exam`= $branch_id
                    -- AND `year_std_series_exam` LIKE '%$year_std%';
					-- ORDER BY `manager_series_exam`.`branch_id_series_exam` ASC, manager_series_exam.teacher_id_series_exam ASC";
$result2 = mysqli_query($conn, $sql2);
while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
  $name_series_exam =  $row2['name_series_exam'];
  $id =  $row2['id'];
  $score_series_exam_sql =  $row2['score_series_exam'];
  $year_std_series_exam =  $row2['year_std_series_exam'];
  $type_series_exam_sql = $row2['type_series_exam'];
  $l_list_series_exam = $row2['list_series_exam'];
  $type_exam = $row2['type_exam'];

  if (strstr($l_list_series_exam, ";")) {
    $list_series_exam = explode(';', $l_list_series_exam);
    $list_series_exam1 = $list_series_exam[0];
    $list_series_exam2 = $list_series_exam[1];
    $list_series_exam1 = explode(',', $list_series_exam1);
    $list_series_exam2 = explode(',', $list_series_exam2);

    $score_series_exam = explode(';', $score_series_exam_sql);
    $score_series_exam1 = $list_series_exam[1];
    $score_series_exam2 = $list_series_exam[1];
    $score_series_exam1 = explode(',', $score_series_exam1);
    $score_series_exam2 = explode(',', $score_series_exam2);
  } else {
    $list_series_exam = explode(',', $l_list_series_exam); //เปลี่ยนเป็น score
    $score_series_exam = explode(';', $score_series_exam_sql);
  }

  if (strstr($type_series_exam_sql, ";")) {
    $type_series_exam_arr = explode(';', $type_series_exam_sql);
    $type_series_exam1 = $type_series_exam_arr[0];
    $type_series_exam2 = $type_series_exam_arr[1];
    $exam_count1 = count($list_series_exam1);
    $exam_count2 = count($list_series_exam2);

    $score_series_exam1 = $score_series_exam[0];
    $score_series_exam2 = $score_series_exam[1];
    $score_series_exam2 = explode(',', $score_series_exam2);

    $score_series_exam1 = $score_series_exam1 * $exam_count1;
    $score_series_exam2 = array_sum($score_series_exam2);
  } else {
    if ($type_series_exam_sql == 1) {
      // echo "(1)";
      $type_series_exam1 = $type_series_exam_sql;
      $type_series_exam2 = null;
      $exam_count1 = count($list_series_exam);
      $exam_count2 = 0;
      $score_series_exam1 = $row2['score_series_exam'] * $exam_count1;
      $score_series_exam2 = 0;
    }
    if ($type_series_exam_sql == 2) {
      // echo "(2)";
      $type_series_exam1 = null;
      $type_series_exam2 = $type_series_exam_sql;
      $exam_count2 = count($list_series_exam);
      $exam_count1 = 0;
      $score_series_exam2 = array_sum(explode(',', $row2['score_series_exam']));
      $score_series_exam1 = 0;
    }
  }
  $score_series_exam = $score_series_exam1 + $score_series_exam2;
  $sumpoint_value = $sumpoint_value + $score_series_exam;

  $t2 = str_replace(' ', '', $name_series_exam);
  $t2 = str_replace('ี', '', $t2);
  $t2 = str_replace('ิ', '', $t2);
  $t2 = str_replace('ุ', '', $t2);
  $t2 = str_replace('ู', '', $t2);
  $t2 = str_replace('ึ', '', $t2);
  $t2 = str_replace('ื', '', $t2);
  $t2 = str_replace('ํ', '', $t2);
  $t2 = str_replace('่', '', $t2);
  $t2 = str_replace('้', '', $t2);
  $t2 = str_replace('๊', '', $t2);
  $t2 = str_replace('๋', '', $t2);
  $t2 = str_replace('์', '', $t2);
  $t2 = str_replace('็', '', $t2);
  $long_text = mb_strlen($t2, 'utf-8') + 9;
  // $long_text = utf8_strlen($name_series_exam)+15;
  // $test_size = 11;
  // if($long_text >= 25){
  //   $long_text = $long_text+13;
  //   //$test_size = 8.5;
  // }
  // $pdf->SetFont('THSarabunNew','B',$test_size);
  $pdf->SetFont('THSarabunNew', 'B', 11);
  if ($type_exam == 2 || $type_exam == 3) {
    // $pdf->setFillColor(230,230,230);
    // $pdf->Cell( $long_text*2  , 6 , iconv( 'UTF-8','cp874' , $name_series_exam ),1,0,'C',1 );

    $pdf->Cell($long_text * 2, 6, iconv('UTF-8', 'cp874', $name_series_exam), 1, 0, 'C');
    $pdf->Cell(($long_text / $long_text) - 1.000001, 12, iconv('UTF-8', 'cp874', ""), 1, 0, 'C');

    $pdf->Cell(-$long_text, 12, iconv('UTF-8', 'cp874', ""), 0, 0, 'C');
    $pdf->Cell(-$long_text, 18, iconv('UTF-8', 'cp874', 'ปรนัย (' . $score_series_exam1 . ')'), 0, 0, 'C');

    $pdf->Cell($long_text, 12, iconv('UTF-8', 'cp874', ""), 0, 0, 'C');
    $pdf->Cell($long_text, 18, iconv('UTF-8', 'cp874', 'อัตนัย (' . $score_series_exam2 . ')'), 0, 0, 'C');
  } else {
    $pdf->Cell($long_text, 6, iconv('UTF-8', 'cp874', $name_series_exam), 1, 0, 'C');
    $pdf->Cell(-$long_text, 12, iconv('UTF-8', 'cp874', ""), 1, 0, 'C');
    // $pdf->SetFont('THSarabunNew','B',10.5);
    $pdf->Cell($long_text, 18, iconv('UTF-8', 'cp874', '(' . $score_series_exam . ')'), 0, 0, 'C');
  }
}
$pdf->Cell(13, 12, iconv('UTF-8', 'cp874', 'รวม (' . $sumpoint_value . ')'), 1, 0, 'C');
$pdf->Cell(13, 12, iconv('UTF-8', 'cp874', 'เกรด'), 1, 1, 'C');
// $pdf->Cell( 13  , 6 , iconv( 'UTF-8','cp874' , $sumpoint_value),1,0,'C' );
// $pdf->Cell( 13  , 6 , iconv( 'UTF-8','cp874' ,""),0,1,'C' );
/*Heading Of the table end*/
$pdf->SetFont('THSarabunNew', '', 13.5);
// $pdf->Cell(47 ,6,"ddddddddddddddddddddd",1,0,'C');

$num = 1;
$total = 0;
//for($i=1;$i<=30;$i++){
$sql = "SELECT DISTINCT manage_std.id as std_id,manage_std.id_std,manage_std.gender_std,manage_std.name_std FROM manage_std
                        WHERE manage_std.year_std = '$year_std_arr'
                        AND manage_std.branch_id_std = '$branch_id'
                        ORDER BY `manage_std`.`id_std` ASC";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
  $id_std =  $row['id_std'];
  $name_std =  $row['name_std'];
  $gender_std =  $row['gender_std'];
  $std_id =  $row['std_id'];

  if ($gender_std == 1) {
    $gender_std = "นาย";
  } else if ($gender_std == 2) {
    $gender_std = "นางสาว";
  }
  $pdf->Cell(3);
  $pdf->Cell(10, 6, $num++, 1, 0, 'C');
  $pdf->Cell(20, 6, $id_std, 1, 0, 'C');
  $pdf->Cell(47, 6, iconv('UTF-8', 'cp874', $gender_std . $name_std), 1, 0, '');
  $sumpoint = 0;
  $sql1 = "SELECT * FROM `manager_series_exam`
                    WHERE `id_subject_series_exam` = $id_sub_series_exam
                    AND `branch_id_series_exam`= $branch_id
                    AND `year_std_series_exam` LIKE '%$year_std%'";
  $result1 = mysqli_query($conn, $sql1);
  while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
    $id =  $row1['id'];
    $name_series_exam =  $row1['name_series_exam'];
    $type_exam =  $row1['type_exam'];

    $t2 = str_replace(' ', '', $name_series_exam);
    $t2 = str_replace('ี', '', $t2);
    $t2 = str_replace('ิ', '', $t2);
    $t2 = str_replace('ุ', '', $t2);
    $t2 = str_replace('ู', '', $t2);
    $t2 = str_replace('ึ', '', $t2);
    $t2 = str_replace('ื', '', $t2);
    $t2 = str_replace('ํ', '', $t2);
    $t2 = str_replace('่', '', $t2);
    $t2 = str_replace('้', '', $t2);
    $t2 = str_replace('๊', '', $t2);
    $t2 = str_replace('๋', '', $t2);
    $t2 = str_replace('์', '', $t2);
    $t2 = str_replace('็', '', $t2);
    $long_text = mb_strlen($t2, 'utf-8') + 9;
    // if($long_text >= 25){
    //   $long_text = $long_text+13;
    //   //$test_size = 8.5;
    // }
    $exam_point1 = null;
    $exam_point2 = null;
    $point_result_exam = null;
    $sql3 = "SELECT * FROM `manager_series_exam`
								INNER JOIN result_exam_std on manager_series_exam.id = result_exam_std.id_name_series_exam
								INNER JOIN manage_std on result_exam_std.id_std_result_exam = manage_std.id
								WHERE `id_subject_series_exam` = $id_sub_series_exam
                AND manage_std.id = $std_id
                AND manager_series_exam.id = $id";
    $result3 = mysqli_query($conn, $sql3);
    while ($row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
      $point_result_exam =  $row3['point_result_exam'];
      $score_series_exam =  $row3['score_series_exam'];

      if (strstr($point_result_exam, ";")) {
        // echo "in1";
        $point_result_exam = explode(';', $point_result_exam);
        $score_series_exam = explode(';', $score_series_exam);
        $point_result_exam1 = $point_result_exam[0];
        $point_result_exam2 = $point_result_exam[1];

        $score_series_exam1 = $score_series_exam[0];
        $score_series_exam2 = $score_series_exam[1];

        $exam_point1 = $point_result_exam1 * $score_series_exam1;
        $exam_point2 = array_sum(explode(',', $point_result_exam2));
        $point_result_exam =  $exam_point1 + $exam_point2;
      } else {
        if (strstr($point_result_exam, ",")) {
          $point_result_exam = array_sum(explode(',', $row3['point_result_exam']));
          $exam_point2 = $point_result_exam;
        } else {
          $point_result_exam = $row3['point_result_exam'] * $score_series_exam;
          $exam_point1 = $point_result_exam;
        }
      }

      $list_series_exam = explode(',', $row3['list_series_exam']);
      for ($i = 1; $i < count($list_series_exam); $i++) {
      }
      $score_series_exam_half = 0;
      // $score_series_exam_half = ($score_series_exam*$i)/2;
    }

    if ($point_result_exam != null) {
      if ($point_result_exam < $score_series_exam_half) {
        $pdf->SetTextColor(255, 0, 0);
      } else {
        $pdf->SetTextColor(0, 0, 0);
      }
      if ($type_exam == 2 || $type_exam == 3) {
        if ($exam_point1 == null) {
          $exam_point1 = "-";
        }
        if ($exam_point2 == null) {
          $exam_point2 = "-";
        }
        $pdf->Cell($long_text, 6, $exam_point1, 1, 0, 'C'); ///////////////////
        $pdf->Cell($long_text, 6, $exam_point2, 1, 0, 'C'); ///////////////////
        if ($exam_point1 != "-" || $exam_point2 != "-") {
        }
      } else {
        $point_result_exam = $exam_point1 + $exam_point2;
        $pdf->Cell($long_text, 6, $point_result_exam, 1, 0, 'C'); ///////////////////
      }
    } else {
      $pdf->SetTextColor(0, 0, 0);
      if ($type_exam == 2 || $type_exam == 3) {
        $pdf->Cell($long_text, 6, "-", 1, 0, 'C');
        $pdf->Cell($long_text, 6, "-", 1, 0, 'C');
      } else {
        $pdf->Cell($long_text, 6, "-", 1, 0, 'C');
      }
    }
    if ($point_result_exam == null) {
      $sumpoint += 0;
      $point_result_exam = "";
    } else {
      $sumpoint += $point_result_exam;
      $point_result_exam = "";
    }
  }

  if ($sumpoint < ($sumpoint_value / 2)) {
    $pdf->SetTextColor(255, 0, 0);
  } else {
    $pdf->SetTextColor(0, 0, 0);
  }
  // if($sumpoint == 0){
  //   $pdf->SetTextColor(0,0,0);
  // }

  if ($sumpoint_value < 50) {
    $pdf->Cell(13, 6, $sumpoint, 1, 0, 'C');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(13, 6, "", 1, 1, 'C');
  } else {
    $pdf->Cell(13, 6, $sumpoint, 1, 0, 'C');
    $pdf->SetTextColor(0, 0, 0);
    if (($sumpoint >= 79.5) && ($sumpoint <= 100)) {
      $grade = "4";
    } else if (($sumpoint >= 74.5) && ($sumpoint <= 79.4)) {
      $grade = "3.5";
    } else if (($sumpoint >= 69.5) && ($sumpoint <= 74.4)) {
      $grade = "3";
    } else if (($sumpoint >= 64.5) && ($sumpoint <= 69.4)) {
      $grade = "2.5";
    } else if (($sumpoint >= 59.5) && ($sumpoint <= 64.4)) {
      $grade = "2";
    } else if (($sumpoint >= 54.5) && ($sumpoint = 59.4)) {
      $grade = "1.5";
    } else if (($sumpoint >= 49.5) && ($sumpoint <= 54.4)) {
      $grade = "1";
    } else if ($sumpoint <= 49.4) {
      $grade = "0";
    }
    $pdf->SetFont('THSarabunNew', 'B', 13.5);
    $pdf->Cell(13, 6, $grade, 1, 1, 'C');
    $pdf->SetFont('THSarabunNew', '', 13.5);
  }
  // $grade = null;
}
// $pdf->SetY(90);
// $pdf->SetX(114);
// $pdf->SetFont('THSarabunNew','B',13);
// $pdf->Cell( 10  , 1 , iconv( 'UTF-8','cp874' , 'ลงชื่่อ' ),0,1,'' );
// $pdf->SetX(168);
// $pdf->Cell( 10  , 1 , iconv( 'UTF-8','cp874' , 'อาจารย์ผู้สอน' ),0,1,'' );
// $pdf->SetY(87);
// $pdf->SetX(121);
// $pdf->Cell( 1  , 26 , iconv( 'UTF-8','cp874' , '(.........................................................)' ),0,1,'' );
//}
$name_teacher_1 = 25;
$name_teacher_2 = -13;
// if($num <= 32){
// $name_teacher_1 = 20;
// $name_teacher_2 = -8;
// }
// else if($num >= 33 && $num <= 35){
//   $name_teacher_1 = 15;
//   $name_teacher_2 = -3;
// }
// else if($num <= 64 && $num >=63){
// $name_teacher_1 = 20;
// $name_teacher_2 = -8;
// }
// else if($num >= 66 && $num <= 70){
//   $name_teacher_1 = 15;
//   $name_teacher_2 = -3;
// }
//
// else{
//   $name_teacher_1 = 80;
//   $name_teacher_2 = -68;
// }

// if($num >= 30 && $num <= 34){
//   $name_teacher_1 = 20;
//   $name_teacher_2 = -8;
// }
$pdf->SetFont('THSarabunNew', '', 15);
$pdf->Cell(209);
$pdf->Cell(10, $name_teacher_1, iconv('UTF-8', 'cp874', 'ลงชื่่อ ........................................................'), 0, 1, '');

$pdf->Cell(222);
$pdf->Cell(1, $name_teacher_2, iconv('UTF-8', 'cp874', '(' . $teacher_gender . $name_teacher . ')'), 0, 1, '');
$pdf->Cell(225);
$pdf->Cell(0, $name_teacher_1, iconv('UTF-8', 'cp874', 'อาจารย์ประจำวิชา'), 0, 1, '');


$pdf->Output();
