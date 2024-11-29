<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="user-scalable=no, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="apple-mobile-web-app-capable" content="yes" />

	<title>ระบบสอบออนไลน์ v1.0</title>
	<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
</head>
<style>
	html{
		background-color: black;
	}
</style>

</html>
<?php
session_start();
if (isset($_SESSION['status_sand_exam'])) {
	include 'connect.php';
	unset($_SESSION['status_sand_exam']);
} else {
	header("location:testting_web.php?id_std=" . $_SESSION['id_std']);
}
if (isset($_POST["send_exam"])) {
	$arr_list = "";
	$point_sum = 0;
	$status_exam_std = 1;
	$Ans1 = "";
	$Ans2 = "";
	$List_series_exam1 = "";
	$List_series_exam2 = "";
	$type_exam = null;
	$id_series_exam = $_POST['id'];
	$id_std = $_POST['id_std'];
	$auto_re_series_exam = 0;

	if (isset($_POST["Ans1"])) {
		$Ans1 = implode(',', $_POST['Ans1']);
	}
	if (isset($_POST["Ans2"])) {
		$Ans2 = implode('|=>', $_POST['Ans2']);
	}
	if (isset($_POST["list_series_exam1"])) {
		$List_series_exam1 = implode(',', $_POST['list_series_exam1']);
	}
	if (isset($_POST["list_series_exam2"])) {
		// $status_exam_std = 0;
		$List_series_exam2 = implode(',', $_POST['list_series_exam2']);
	}
	$im_arr_exam = explode(',', $List_series_exam1);
	$im_arr_Ans  = explode(',', $Ans1);

	if (isset($_POST["type_series_exam"])) {
		$type_exam = $_POST["type_series_exam"];
	}

	$arrlength = count($im_arr_exam);
	for ($x = 0; $x < $arrlength; $x++) {
		$im_arr_Ans[$x];
		if ($im_arr_Ans[$x] == 'ก') {
			$im_arr_Ans[$x] = 1;
		} else if ($im_arr_Ans[$x] == 'ข') {
			$im_arr_Ans[$x] = 2;
		} else if ($im_arr_Ans[$x] == 'ค') {
			$im_arr_Ans[$x] = 3;
		} else if ($im_arr_Ans[$x] == 'ง') {
			$im_arr_Ans[$x] = 4;
		} else if ($im_arr_Ans[$x] == 'จ') {
			$im_arr_Ans[$x] = 5;
		} else if ($im_arr_Ans[$x] == 'a') {
			$im_arr_Ans[$x] = 1;
		} else if ($im_arr_Ans[$x] == 'b') {
			$im_arr_Ans[$x] = 2;
		} else if ($im_arr_Ans[$x] == 'c') {
			$im_arr_Ans[$x] = 3;
		} else if ($im_arr_Ans[$x] == 'd') {
			$im_arr_Ans[$x] = 4;
		} else if ($im_arr_Ans[$x] == 'e') {
			$im_arr_Ans[$x] = 5;
		}
	}
	if ($type_exam == 2) {
		$result_point = "";
		$status_exam_std = 0;
	} else {
		$sql = "SELECT * FROM `manager_series_exam` WHERE id = $id_series_exam ";
		$result = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$id = $row['id'];
			$list_series_exam = $row['list_series_exam'];
			$score_series_exam = $row['score_series_exam'];
			$type_series_exam = $row['type_series_exam'];
			$auto_re_series_exam = $row['auto_re_series_exam'];
			if (strstr($score_series_exam, ";")) {
				$arr_score_series_exam = explode(';', $score_series_exam);
				$score_series_exam = $arr_score_series_exam[0];
			} else {
				$score_series_exam = $row['score_series_exam'];
			}
		}

		if ($List_series_exam1 != "") {
			$arrlength = count($im_arr_exam);
			// print_r($arrlength);
			for ($x = 0; $x < $arrlength; $x++) {
				$sql1 = "SELECT * FROM `manager_exam` WHERE `id` = $im_arr_exam[$x];";
				$result1 = mysqli_query($conn, $sql1);
				while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
					$result_exam = $row1['result_exam'];

					if ($im_arr_Ans[$x] == $result_exam) {
						$result_exam = 1;
					} else {
						$result_exam = 0;
					}
					$arr_list = $arr_list . $result_exam . ",";
					$point_sum = $point_sum + $result_exam;
				}
			}
		}
		// $point_sum = $score_series_exam;
		// echo "!!!!!!".$point_sum."!!!!!!!";
		$point = explode(",", $arr_list);
		array_pop($point);
		$result_point = implode($point, ",");
	}
	if ($List_series_exam1 != null && $List_series_exam2 != null) {
		$result_point = $result_point . ";";
		$List_series_exam = $List_series_exam1 . ";" . $List_series_exam2;
		$Ans_list = implode(',', $im_arr_Ans) . ";";
		$Ans_list = $Ans_list . $Ans2;
		// print_r($Ans_list);
		// echo "1";
	} else if ($List_series_exam1 != null && $List_series_exam2 == null) {
		$result_point = implode($point, ",");
		$List_series_exam = $List_series_exam1;
		$Ans_list = implode(',', $im_arr_Ans);
		// echo "2";
	} else {
		$result_point = null;
		$List_series_exam = $List_series_exam2;
		$Ans_list = $Ans2;
		$point_sum = "";
		// echo "3";
	}
	// echo $List_series_exam."<br>".$Ans_list;
	// echo "<br>...........<br>";
	// echo $result_point;
	// echo $status_exam_std;

	$result_add = false;
	$sql11 = "SELECT * FROM `result_exam_std` WHERE `id_std_result_exam` = $id_std AND `id_name_series_exam` = $id_series_exam";
	$result11 = mysqli_query($conn, $sql11);
	while ($row11 = mysqli_fetch_array($result11, MYSQLI_ASSOC)) {
		$result_add = true;
	}
	if ($result_add == true) {
		$sql1 = "SELECT * FROM `manage_std` WHERE id = $id_std AND IsUse = 1;";
		$result1 = mysqli_query($conn, $sql1);
		while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
			$id_std =  $row1['id_std'];
		}
		header('Location:testting_web.php?id_std=' . $id_std);
	} else {
		$status = false;
		if ($type_series_exam == '1' && $auto_re_series_exam == '1') {
			$ScorePass = (count(explode(",", $list_series_exam)) * $score_series_exam) / 2;
			$SumPoint = ($score_series_exam * $point_sum);
			if ($ScorePass > $SumPoint) {
				// echo "สอบได้ : ".$SumPoint;
				// echo "<br>";
				// echo "ผ่าน : ".$ScorePass;
				// echo "<br>";
				// var_dump(explode(",", $list_series_exam));
				echo AlertReExam();
			} else {
				$status = true;
			}
		} else {
			$status = true;
		}
		if ($status) {
			 	$sql = "INSERT INTO `result_exam_std` (`id`, `id_std_result_exam`, `id_name_series_exam`, `exam_result_exam`, `ans_result_exam`, `result_result_exam`, `point_result_exam`, `status_result_exam_std`)
			 VALUES (NULL, '$id_std', '$id_series_exam', '$List_series_exam', '$Ans_list', '$result_point', '$point_sum', '$status_exam_std');";
			 	if ($conn->query($sql) === TRUE) {

			 		$sql1 = "SELECT * FROM `manage_std` WHERE id = $id_std AND IsUse = 1;";
			 		$result1 = mysqli_query($conn, $sql1);
			 		while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
			 			$id_std =  $row1['id_std'];
			 		}
			 		header('Location:testting_web.php?id_std=' . $id_std);
			 	}
		}
	}
} else {
	header("location:testting_web.php?id_std=" . $_SESSION['id_std']);
}
function AlertReExam()
{
	return "<script language=''>
						Swal.fire({
							title: 'แจ้งเตือน',
							text: 'สอบไม่ผ่านเกณฑ์ กรุณาทำการสอบใหม่อีกครั้ง',
							icon: 'info',
							allowOutsideClick: false,
  							allowEscapeKey: false,
							confirmButtonText: 'ตกลง',
    						confirmButtonColor: '#007bff'
							}).then((result) => {
						if (result.isConfirmed) {
								window.location.href = 'testting_web.php?id_std=" . $_SESSION['id_std'] . "';
						} else if (result.isDenied) {
							window.location.href = 'testting_web.php?id_std=" . $_SESSION['id_std'] . "';
						}
						});
		</script>";
}
