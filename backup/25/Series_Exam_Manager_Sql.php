<?php
include'connect.php';

if(isset($_POST["add_series_exam"])){

	$num_exam_value = null;
	$num_exam_value1 = null;
	$num_exam_value2 = null;
	$name_score_exam1 = null;
	$name_score_exam2 = null;
	$type_series_exam1 = null;
	$type_series_exam2 = null;

	if(isset($_POST['num_exam_value1'])){
		$num_exam_value1 = $_POST['num_exam_value1'];
		$num_exam_value1 = implode(",",$num_exam_value1);
	}
	if(isset($_POST['num_exam_value2'])){
		$num_exam_value2 = $_POST['num_exam_value2'];
		$num_exam_value2 = implode(",",$num_exam_value2);

	}
	if($num_exam_value1 != null && $num_exam_value2 == null){
		$num_exam_value = $num_exam_value1;
	}else if($num_exam_value1 == null && $num_exam_value2 != null){
		$num_exam_value = $num_exam_value2;
	}else if($num_exam_value1 != null && $num_exam_value2 != null){
		$num_exam_value = $num_exam_value1.";".$num_exam_value2;
	}

	// $num_exam_value = explode(";", $num_exam_value);
	// $num_exam_value1 = $num_exam_value[0];
	// $num_exam_value2 = $num_exam_value[1];

	//////////////////////////////////////

	if(isset($_POST['name_score_exam1'])){
		$name_score_exam1 = $_POST['name_score_exam1'];
		$name_score_exam1 = implode(",",$name_score_exam1);
	}
	if(isset($_POST['name_score_exam2'])){
		$name_score_exam2 = $_POST['name_score_exam2'];
		$name_score_exam2 = implode(",",$name_score_exam2);
	}
	if($name_score_exam1 != null && $name_score_exam2 == null){
		$name_score_exam = $name_score_exam1;
	}else if($name_score_exam1 == null && $name_score_exam2 != null){
		$name_score_exam = $name_score_exam2;
	}else if($name_score_exam1 != null && $name_score_exam2 != null){
		$name_score_exam = $name_score_exam1.";".$name_score_exam2;
	}

	// $name_score_exam = explode(";", $name_score_exam);
	// $name_score_exam1 = $name_score_exam[0];
	// $name_score_exam2 = $name_score_exam[1];

	//////////////////////////////////////

	if(isset($_POST['type_series_exam1'])){
		$type_series_exam1 = $_POST['type_series_exam1'];
		// $type_series_exam1 = implode(",",$type_series_exam1);
	}
	if(isset($_POST['type_series_exam2'])){
		$type_series_exam2 = $_POST['type_series_exam2'];
		// $type_series_exam2 = implode(",",$type_series_exam2);
	}
	if($type_series_exam1 != null && $type_series_exam2 == null){
		$type_series_exam = $type_series_exam1;
	}else if($type_series_exam1 == null && $type_series_exam2 != null){
		$type_series_exam = $type_series_exam2;
	}else if($type_series_exam1 != null && $type_series_exam2 != null){
		$type_series_exam = $type_series_exam1.";".$type_series_exam2;
	}
					// if($type_series == 1){
					$id_subject = $_POST["id_subject"];
					$type_exam = $_POST["type_exam"];
					$branch_id_series_exam = $_POST["branch_id_series_exam"];
					$name_series_exam = $_POST["name_series_exam"];
					$teacher_id_series_exam = $_POST["teacher_id_series_exam"];
					$list_series_exam = $num_exam_value;
					$year_std_series_exam = implode(',',$_POST['year_std_series_exam']);

					if($type_exam == 1){
						$approve_series_exam = 1;
					}else if($type_exam == 2){
						$approve_series_exam = 0;
					}else if($type_exam == 3){
						$approve_series_exam = 0;
					}

					$time = $_POST['Time'];
					$time_count = explode(',',$time);
						for ($i_arr=0; $i_arr < count($time_count); $i_arr++) {
							$time_status = $time_count[$i_arr];
								if($i_arr == 0){
										$datetime_start = $time_status.":00";
										//echo $datetime_start."<br>";
										$datetime_startCreate=date_create($datetime_start);
										$datetime_START =  date_format($datetime_startCreate,"Y-m-d H:i:s");
										//echo $datetime_START."<br>";
									}else if($i_arr == 1){
										$datetime_end = $time_status.":00";
										//echo $datetime_end."<br>";
										$datetime_endCreate=date_create($datetime_end);
										$datetime_END =  date_format($datetime_endCreate,"Y-m-d H:i:s");
										//echo $datetime_END."<br>";
									}
								}
								////////////////////////
								if($type_series_exam1 == null && $type_series_exam2 == null){
									echo"<script language=''>
											var r = confirm('โปรดเลือกข้อสอบมากกว่า 1 ข้อ');
												if (r == true) {
												window.history.back();
												} else {
												window.history.back();
												}
											</script>";
								}
								else{
									// echo $type_series_exam;
									if($type_series_exam1 != null){
										if($num_exam_value1 == null){
											echo"<script language=''>
																	var r = confirm('โปรดเลือกข้อสอบปรนัยมากกว่า 1 ข้อ');
																		if (r == true) {
																		window.history.back();
																		} else {
																		window.history.back();
																		}
																	</script>";
										}else{
											$sql = "INSERT INTO `manager_series_exam`
											(`id`,
											`id_subject_series_exam`,
											`branch_id_series_exam`,
											`year_std_series_exam`,
											`name_series_exam`,
											`type_exam`,
											`teacher_id_series_exam`,
											`datetime_start_series_exam`,
											`datetime_end_series_exam`,
											`list_series_exam`,
											`score_series_exam`,
											`type_series_exam`,
											`approve_series_exam`)
											VALUES (NULL,
											'$id_subject',
											'$branch_id_series_exam',
											'$year_std_series_exam',
											'$name_series_exam',
											'$type_exam',
											'$teacher_id_series_exam',
											'$datetime_START',
											'$datetime_END',
											'$list_series_exam',
											'$name_score_exam',
											'$type_series_exam',
											'$approve_series_exam')";
											if($conn->query($sql)===TRUE){
												 header('Location:Series_Exam_Subject_List.php?id_subject='.$id_subject);
									 		}
										}
									}
									else if($type_series_exam2 != null){
										// print_r($num_exam_value2);
										if($num_exam_value2 == null){
											echo"<script language=''>
																	var r = confirm('โปรดเลือกข้อสอบอัตนัยมากกว่า 1 ข้อ');
																		if (r == true) {
																		window.history.back();
																		} else {
																		window.history.back();
																		}
																	</script>";
										}else{
											$sql = "INSERT INTO `manager_series_exam`
											(`id`,
											`id_subject_series_exam`,
											`branch_id_series_exam`,
											`year_std_series_exam`,
											`name_series_exam`,
											`type_exam`,
											`teacher_id_series_exam`,
											`datetime_start_series_exam`,
											`datetime_end_series_exam`,
											`list_series_exam`,
											`score_series_exam`,
											`type_series_exam`,
											`approve_series_exam`)
											VALUES (NULL,
											'$id_subject',
											'$branch_id_series_exam',
											'$year_std_series_exam',
											'$name_series_exam',
											'$type_exam',
											'$teacher_id_series_exam',
											'$datetime_START',
											'$datetime_END',
											'$list_series_exam',
											'$name_score_exam',
											'$type_series_exam',
											'$approve_series_exam')";

											if($conn->query($sql)===TRUE){
												 header('Location:Series_Exam_Subject_List.php?id_subject='.$id_subject);
									 		}
										}
									}
		 }
}

if(isset($_POST["edit_series_exam"])){
	// $type_series = $_POST["type_series"];

	$num_exam_value1 = null;
	$num_exam_value2 = null;
	$name_score_exam1 = null;
	$name_score_exam2 = null;
	$type_series_exam1 = null;
	$type_series_exam2 = null;
	$type_series_exam1_status = FALSE;
	$type_series_exam2_status = FALSE;

	if(isset($_POST['num_exam_value1'])){
		$num_exam_value1 = $_POST['num_exam_value1'];
		$num_exam_value1 = implode(",",$num_exam_value1);
	}
	if(isset($_POST['num_exam_value2'])){
		$num_exam_value2 = $_POST['num_exam_value2'];
		$num_exam_value2 = implode(",",$num_exam_value2);
	}
	if($num_exam_value1 != null && $num_exam_value2 == null){
		$num_exam_value = $num_exam_value1;
	}else if($num_exam_value1 == null && $num_exam_value2 != null){
		$num_exam_value = $num_exam_value2;
	}else if($num_exam_value1 != null && $num_exam_value2 != null){
		$num_exam_value = $num_exam_value1.";".$num_exam_value2;
	}

	//////////////////////////////////////

	if(isset($_POST['name_score_exam1'])){
		$name_score_exam1 = $_POST['name_score_exam1'];
		$name_score_exam1 = implode(",",$name_score_exam1);
	}
	if(isset($_POST['name_score_exam2'])){
		$name_score_exam2 = $_POST['name_score_exam2'];
		$name_score_exam2 = implode(",",$name_score_exam2);
	}
	if($name_score_exam1 != null && $name_score_exam2 == null){
		$name_score_exam = $name_score_exam1;
	}else if($name_score_exam1 == null && $name_score_exam2 != null){
		$name_score_exam = $name_score_exam2;
	}else if($name_score_exam1 != null && $name_score_exam2 != null){
		$name_score_exam = $name_score_exam1.";".$name_score_exam2;
	}

	//////////////////////////////////////

	if(isset($_POST['type_series_exam1'])){
		$type_series_exam1 = $_POST['type_series_exam1'];
		// $type_series_exam1 = implode(",",$type_series_exam1);
	}
	if(isset($_POST['type_series_exam2'])){
		$type_series_exam2 = $_POST['type_series_exam2'];
		// $type_series_exam2 = implode(",",$type_series_exam2);
	}
	if($type_series_exam1 != null && $type_series_exam2 == null){
		$type_series_exam = $type_series_exam1;
	}else if($type_series_exam1 == null && $type_series_exam2 != null){
		$type_series_exam = $type_series_exam2;
	}else if($type_series_exam1 != null && $type_series_exam2 != null){
		$type_series_exam = $type_series_exam1.";".$type_series_exam2;
	}


					// $type_series = $_POST["type_series"];
					// if($type_series == 1){
					$id_series_exam = $_POST["id_series_exam"];
					$id_subject = $_POST["id_subject"];
					$branch_id_series_exam = $_POST["branch_id_series_exam"];
					//$year_std_series_exam = $_POST["year_std_series_exam"];
					$name_series_exam = $_POST["name_series_exam"];
					$type_exam = $_POST["type_exam"];
					$teacher_id_series_exam = $_POST["teacher_id_series_exam"];
					$list_series_exam = $num_exam_value;
					$year_std_series_exam = implode(',',$_POST['year_std_series_exam']);

					if($type_exam == 1){
						$approve_series_exam = 1;
					}else if($type_exam == 2){
						$approve_series_exam = 0;
					}else if($type_exam == 3){
						$approve_series_exam = 0;
					}

					$time = $_POST['Time'];
					$time_count = explode(',',$time);
						for ($i_arr=0; $i_arr < count($time_count); $i_arr++) {
							$time_status = $time_count[$i_arr];
								if($i_arr == 0){
										$datetime_start = $time_status.":00";
										//echo $datetime_start."<br>";
										$datetime_startCreate=date_create($datetime_start);
										$datetime_START =  date_format($datetime_startCreate,"Y-m-d H:i:s");
										//echo $datetime_START."<br>";
									}else if($i_arr == 1){
										$datetime_end = $time_status.":00";
										//echo $datetime_end."<br>";
										$datetime_endCreate=date_create($datetime_end);
										$datetime_END =  date_format($datetime_endCreate,"Y-m-d H:i:s");
										//echo $datetime_END."<br>";
									}
								}

					// $sql1 = "DELETE FROM `result_exam_std` WHERE `id_name_series_exam` = $id_series_exam;";
					// $conn->query($sql1);

					if(strstr($num_exam_value,";")){
					$num_exam_value_check = explode(";", $num_exam_value);
					$num_exam_value1 = $num_exam_value_check[0];
					$num_exam_value2 = $num_exam_value_check[1];
				}
					if(strstr($type_series_exam,";")){
					$type_series_exam_check = explode(";", $type_series_exam);
					$type_series_exam1 = $type_series_exam_check[0];
					$type_series_exam2 = $type_series_exam_check[1];
				}
				if($type_series_exam1 == null && $type_series_exam2 == null){
					echo"<script language=''>
							var r = confirm('โปรดเลือกข้อสอบมากกว่า 1 ข้อ');
								if (r == true) {
								window.history.back();
								} else {
								window.history.back();
								}
							</script>";
				}
				else{
					// echo $type_series_exam;
					if($type_series_exam1 != null){
						if($num_exam_value1 == null){
							echo"<script language=''>
													var r = confirm('โปรดเลือกข้อสอบปรนัยมากกว่า 1 ข้อ');
														if (r == true) {
														window.history.back();
														} else {
														window.history.back();
														}
													</script>";
						}else{
							$sql = "UPDATE `manager_series_exam` SET
							`branch_id_series_exam` = '$branch_id_series_exam',
							`year_std_series_exam` = '$year_std_series_exam',
							`name_series_exam` = '$name_series_exam',
							`type_exam` = '$type_exam',
							`teacher_id_series_exam` = '$teacher_id_series_exam',
							`datetime_start_series_exam` = '$datetime_START',
							`datetime_end_series_exam` = '$datetime_END',
							`list_series_exam` = '$list_series_exam',
							`score_series_exam` = '$name_score_exam',
							`type_series_exam` = '$type_series_exam',
							`approve_series_exam` = '$approve_series_exam'
							 WHERE `manager_series_exam`.`id` = $id_series_exam";
							if($conn->query($sql)===TRUE){
								 header('Location:Series_Exam_Subject_List.php?id_subject='.$id_subject);
							}
						}
					}
					else if($type_series_exam2 != null){
						// print_r($num_exam_value2);
						if($num_exam_value2 == null){
							echo"<script language=''>
													var r = confirm('โปรดเลือกข้อสอบอัตนัยมากกว่า 1 ข้อ');
														if (r == true) {
														window.history.back();
														} else {
														window.history.back();
														}
													</script>";
						}else{
							$sql = "UPDATE `manager_series_exam` SET
							`branch_id_series_exam` = '$branch_id_series_exam',
							`year_std_series_exam` = '$year_std_series_exam',
							`name_series_exam` = '$name_series_exam',
							`type_exam` = '$type_exam',
							`teacher_id_series_exam` = '$teacher_id_series_exam',
							`datetime_start_series_exam` = '$datetime_START',
							`datetime_end_series_exam` = '$datetime_END',
							`list_series_exam` = '$list_series_exam',
							`score_series_exam` = '$name_score_exam',
							`type_series_exam` = '$type_series_exam',
							`approve_series_exam` = '$approve_series_exam'
							 WHERE `manager_series_exam`.`id` = $id_series_exam";
							if($conn->query($sql)===TRUE){
								 header('Location:Series_Exam_Subject_List.php?id_subject='.$id_subject);
							}
						}
					}
				}
}

if(isset($_GET["delete_series_exam"])){
				$id_series_exam = $_GET["id_series_exam"];

				$sql1 = "DELETE FROM `result_exam_std` WHERE `id_name_series_exam` = $id_series_exam;";
				$conn->query($sql1);

				$sql = "DELETE FROM `manager_series_exam` WHERE `manager_series_exam`.`id` = $id_series_exam;";
				$conn->query($sql);

					if($conn->query($sql)=== TRUE){
			//header('Location: ' . $_SERVER['HTTP_REFERER']);
			echo '<script type="text/javascript">
												javascript:history.go(-1);
											</script>';
	}


}

if(isset($_POST["check_exam_std"])){
	$value = null;
	$id_series_exam_sql = $_POST["id_series_exam_sql"];
	$check_exam = implode(",",$_POST["check_exam"]);
	$arr_check_exam = explode(",",$check_exam);
	for ($i=0; $i < count($arr_check_exam); $i++){
		$list__check_exam = $arr_check_exam[$i];
		if($list__check_exam > 0){
			$result_true = 1;
		}else{
			$result_true = 0;
		}
		$value = $result_true.",".$value;
	}
	$value = explode(",",$value);
	array_pop($value);
	$result_exam = implode(",",$value);

	// echo $id_series_exam_sql;

	$sql2 = "SELECT * FROM `result_exam_std`  WHERE `id`= $id_series_exam_sql";
	$result2 = mysqli_query($conn, $sql2);
	while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
		$exam_result_exam = $row2['exam_result_exam'];
		$point_result_exam = $row2['point_result_exam'];
		$result_result_exam = $row2['result_result_exam'];
			if(strstr($exam_result_exam,";")){
				$exam_result_exam = explode(';',$exam_result_exam);
				$exam_result_exam = $exam_result_exam[1];
				// if($exam_result_exam == null){
					$result_result_exam = explode(';',$result_result_exam);
					$result_result_exam1 = $result_result_exam[0];
					$result_result_exam2 = $result_result_exam[1];

					$arr_point_result_exam = explode(';',$point_result_exam);
					$point_result_exam1 = $arr_point_result_exam[0];
					// $point_result_exam2 = $point_result_exam[1];
					// $exam_result_exam = explode(',',$exam_result_exam);
					// if($exam_result_exam == null){
					// 	$result_exam = $result_result_exam1.";".$result_exam;
					// }else{
						$result_exam = $result_result_exam1.";".$result_exam;
					// }
					$check_exam = $point_result_exam1.";".$check_exam;

				// }
				}
		}
	$sql1 = "UPDATE `result_exam_std` SET `result_result_exam` = '$result_exam',`point_result_exam` = '$check_exam',`status_result_exam_std` = '1' WHERE `result_exam_std`.`id` = $id_series_exam_sql;";
	// $conn->query($sql1);
	if($conn->query($sql1)=== TRUE){
		echo '<script type="text/javascript">
								javascript:history.go(-2);
							</script>';
						}
}

?>
