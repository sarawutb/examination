<?php 
include'connect.php'; 

if(isset($_POST["add_series_exam"])){
					$id_subject = $_POST["id_subject"];
					$branch_id_series_exam = $_POST["branch_id_series_exam"];
					$year_std_series_exam = $_POST["year_std_series_exam"];
					$name_series_exam = $_POST["name_series_exam"];
					$teacher_id_series_exam = $_POST["teacher_id_series_exam"];
					//$datetime_start = $_POST["datetime_start"];
					//$datetime_end = $_POST["datetime_end"];
					$name_score_exam = $_POST["name_score_exam"];
					//echo $name_score_exam;
					$list_series_exam = implode(',',$_POST['num_exam_value']);
					
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
					
					if($list_series_exam == false){
						echo"<script language=''>
								
								var r = confirm('โปรดเลือกข้อสอบมากกว่า 1 ข้อ');
								  if (r == true) {
									window.history.back();
								  } else {
									window.history.back();
								  }
								</script>";
					}else{
					$sql = "INSERT INTO `manager_series_exam` (`id`, 
					`id_subject_series_exam`, 
					`branch_id_series_exam`, 
					`year_std_series_exam`, 
					`name_series_exam`, 
					`teacher_id_series_exam`, 
					`datetime_start_series_exam`, 
					`datetime_end_series_exam`, 
					`list_series_exam`, 
					`score_series_exam`) 
					VALUES (NULL, '$id_subject', 
					'$branch_id_series_exam', 
					'$year_std_series_exam', 
					'$name_series_exam', 
					'$teacher_id_series_exam', 
					'$datetime_START', 
					'$datetime_END', 
					'$list_series_exam', 
					'$name_score_exam');";
				
				if($conn->query($sql)===TRUE){
				header('Location:Series_Exam_Subject_List.php?id_subject='.$id_subject.'&branch_id_series_exam='.$branch_id_series_exam.'&year_std_series_exam='.$year_std_series_exam);
					//header('Location:Series_Exam_Subject.php?id_subject='.$id_subject);
				//header('Location: ' . $_SERVER['HTTP_REFERER']);
				//echo '<script type="text/javascript">
						//javascript:history.go(-2);
					//</script>';
			}
					
		}			
}
if(isset($_POST["edit_series_exam"])){
					$id_series_exam = $_POST["id_series_exam"];
					$id_subject = $_POST["id_subject"];
					$branch_id_series_exam = $_POST["branch_id_series_exam"];
					$year_std_series_exam = $_POST["year_std_series_exam"];
					$name_series_exam = $_POST["name_series_exam"];
					$teacher_id_series_exam = $_POST["teacher_id_series_exam"];
					//$datetime_start = $_POST["datetime_start"];
					//$datetime_end = $_POST["datetime_end"];
					$name_score_exam = $_POST["name_score_exam"];
					
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
					
					$sql1 = "DELETE FROM `result_exam_std` WHERE `id_name_series_exam` = $id_series_exam;";
					$conn->query($sql1);
					
					
					$list_series_exam = implode(',',$_POST['num_exam_value']);
					if($list_series_exam == false){
						echo"<script language=''>
								
								var r = confirm('โปรดเลือกข้อสอบมากกว่า 1 ข้อ');
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
					`teacher_id_series_exam` = '$teacher_id_series_exam',
					`datetime_start_series_exam` = '$datetime_START',
					`datetime_end_series_exam` = '$datetime_END',
					`list_series_exam` = '$list_series_exam',
					`score_series_exam` = '$name_score_exam'
					 WHERE `manager_series_exam`.`id` = $id_series_exam;";
					$conn->query($sql);
					
				if($conn->query($sql)=== TRUE){
					header('Location:Series_Exam_Subject_List.php?id_subject='.$id_subject.'&branch_id_series_exam='.$branch_id_series_exam.'&year_std_series_exam='.$year_std_series_exam);
				
				//header('Location:Series_Exam_Subject.php?id_subject='.$id_subject);
				//echo '<script type="text/javascript">
				//javascript:history.go(-2);
				//	</script>';
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
?>