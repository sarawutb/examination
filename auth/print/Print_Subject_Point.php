<?php
if(isset($_POST["id_subject_series_exam"])){
					$id_sub_series_exam = $_POST["id_subject_series_exam"];

include("../connect.php");
require_once 'vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/fonts',
    ]),
    'fontdata' => $fontData + [
        'thsarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
        ]
    ],
    'default_font' => 'thsarabun'
]);

$html = '
    <html>
    <head>
    <style>
    body { 
		font-family: thsarabun; font-size: 10.5pt;
    }
    table{
      border-collapse: collapse;
      width: 100%;
      margin: 1px;
    }
    tr th, table tr td {
      border: 1px solid black;
	  text-align:center;
    }
    </style>
    </head>
';
$html .= '
    <body>
        <div style="text-align:center;">';
		$sql2 = "SELECT * FROM `manager_subject` 
				INNER JOIN manager_teacher on manager_teacher.id_teacher = manager_subject.name_teacher_subject
				WHERE id = $id_sub_series_exam";
				$result2 = mysqli_query($conn, $sql2);
				while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
				$name_subject =  $row2['name_subject'];
				$name_teacher =  $row2['name_teacher'];
			$html .= '<b>ผลรวมคะแนน ภาคเรียนที่........ปีการศึกษาที่...............</b><br>
			<b>วิชา '.$name_subject.' อาจารย์ผู้สอน '.$name_teacher.'</b><br>
			<b>วิทยาลัยอาชีวศึกษาจุลมณีอุทุมพรพิสัย จังหวัดศรีสะเกษ</b>';
			
				}
       $html.= '</div>';
    
      
    $html .= '<table>
                <thead>
                    <tr>
                        <th style="width:5%">ลำดับ</th>
                        <th style="width:10%">รหัสนักศึกษา</th>
                        <th style="width:20%">ชื่อ-สกุล</th>
						';
						$sumpointHead = 0;
						//$sql2 = "SELECT * FROM `manager_series_exam`
								//	INNER JOIN result_exam_std on manager_series_exam.id = result_exam_std.id_name_series_exam
								//	WHERE `id_subject_series_exam` = 8
								//	GROUP BY manager_series_exam.id,result_exam_std.id_name_series_exam";
									
						$sql2 = "SELECT * FROM `manager_series_exam` WHERE `id_subject_series_exam` = $id_sub_series_exam";
						$result2 = mysqli_query($conn, $sql2);
						while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
							$name_series_exam =  $row2['name_series_exam'];
							$id =  $row2['id'];
							$score_series_exam =  $row2['score_series_exam'];
							
							$list_series_exam = explode(',',$row2['list_series_exam']);
							for ($i=1; $i < count($list_series_exam); $i++){}
							$score_series_exam = ($score_series_exam*$i);
			$html .= '			
                        <th>'.$name_series_exam.' ('.$score_series_exam.') </th>';
						 $sumpointHead+=$score_series_exam;
						}
             $html .='<th>รวม ('.$sumpointHead.')</th>
                    </tr>
                </thead>
                <tbody>';
                $num = 1;
                $total = 0;
				//for($i=1;$i<=10;$i++){
                $sql = "SELECT DISTINCT manage_std.id as std_id,manage_std.id_std,manage_std.gender_std,manage_std.name_std FROM `manager_subject`
						INNER JOIN manager_series_exam on manager_series_exam.id_subject_series_exam = manager_subject.id
						INNER JOIN result_exam_std on manager_series_exam.id = result_exam_std.id_name_series_exam
						INNER JOIN manage_std on manage_std.id = result_exam_std.id_std_result_exam
						WHERE manager_subject.id = $id_sub_series_exam 
						ORDER BY `std_id` ASC";
						$result = mysqli_query($conn, $sql);
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
							$id_std =  $row['id_std'];
							$name_std =  $row['name_std'];
							$gender_std =  $row['gender_std'];
							$std_id =  $row['std_id'];
							
							if($gender_std == 1){
								$gender_std = "นาย";
							}else if($gender_std == 2){
								$gender_std = "นางสาว";
							}
                    $html .= '
                        <tr>
                            <td>'.$num++.'</td>
                            <td style="text-align:left">'.$id_std.'</td>
                            <td style="text-align:left">'.$gender_std.$name_std.'</td>';
							
						
						$sumpoint = 0;
						$sql1 = "SELECT * FROM `manager_series_exam` WHERE `id_subject_series_exam` = $id_sub_series_exam";
						$result1 = mysqli_query($conn, $sql1);
						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
							$id =  $row1['id'];
							
						
						
						
						
						$sql3 = "SELECT * FROM `manager_series_exam`
								INNER JOIN result_exam_std on manager_series_exam.id = result_exam_std.id_name_series_exam 
								INNER JOIN manage_std on result_exam_std.id_std_result_exam = manage_std.id
								WHERE `id_subject_series_exam` = $id_sub_series_exam AND manage_std.id = $std_id AND manager_series_exam.id = $id";
						$result3 = mysqli_query($conn, $sql3);
						while($row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC)){
							$point_result_exam =  $row3['point_result_exam'];
							}

							$html.='<td>'.$point_result_exam.'</td>';
					
                       
					   if($point_result_exam == null){
							$sumpoint+=0; 
							$point_result_exam = "";
					   }else{
							$sumpoint+=$point_result_exam;  
							$point_result_exam = "";
					   }
						
						}
                       $html.=' 
					   <td';
						
						if($sumpoint < ($sumpointHead/2)){
							$html.=' style="color:red"';
						}else{
							$html.=' style="color:black"';
						}
						
						
					   $html.=' ><b>'.$sumpoint.'</b></td>
					   </tr>
                    ';
                   // $total += $num;
                
				}
			//}
               /* $html .= '
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>รวม</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>'.$total.'</b></td>
                        </tr>';*/
    $html .= '</tbody>
            </table>';

$html .= '</body></html>';


//$mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
//$mpdf->WriteHTML($html);
//$mpdf->Output('bill', 'I');


//echo $html;

$mpdf->WriteHTML($html);
$mpdf->Output('คะแนนเก็บวิชา '.$name_subject, 'I');
$mpdf->Output();
}
?>