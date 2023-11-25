<?php 
include'connect.php'; 
if(isset($_GET["send_exam"])){		
					
					$id_series_exam = $_GET['id'];
					
					$id_std = $_GET['id_std'];


					$Ans = implode(',',$_GET['Ans']);
					$List_series_exam = implode(',',$_GET['list_series_exam']);
					
					$arr_list = "";
					$point_sum = 0;
					
					$sql = "SELECT * FROM `manager_series_exam` WHERE id = $id_series_exam ";
					$result = mysqli_query($conn, $sql);
					while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
						$id = $row['id'];
						$list_series_exam = $row['list_series_exam'];
						$score_series_exam = $row['score_series_exam'];
						
						$arr_list_series_exam = explode(',',$row['list_series_exam']);
						$arr_Ans = explode(',',$Ans);
						for ($i_arr=0; $i_arr < count($arr_list_series_exam); $i_arr++) {   
						    $id = $arr_list_series_exam[$i_arr];
						    $num_arr_Ans = $arr_Ans[$i_arr];
							//echo $num_arr_Ans;
							
							
							$sql1 = "SELECT * FROM `manager_exam` WHERE `id` = $id";
							$result1 = mysqli_query($conn, $sql1);
							while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
								$result_exam = $row1['result_exam'];
								
								if($num_arr_Ans == $result_exam){
									$result_exam = 1;
								}else{
									$result_exam = 0;
								}
								$arr_list = $arr_list.$result_exam.",";
								$point_sum = $point_sum+$result_exam;
								}
							
						}
						
					}
					$point_sum = ($point_sum*$score_series_exam);
					
					$point = explode(",",$arr_list);
					array_pop($point);
					$result_point = implode($point,",");
			
			
			$result_add = false;
			$sql11 = "SELECT * FROM `result_exam_std` WHERE `id_std_result_exam` = $id_std AND `id_name_series_exam` = $id_series_exam";
					$result11 = mysqli_query($conn, $sql11);
					while ($row11 = mysqli_fetch_array($result11,MYSQLI_ASSOC)) {
						$result_add = true;
					}
					if($result_add == true){
						$sql1 = "SELECT * FROM `manage_std` WHERE id = $id_std";
								$result1 = mysqli_query($conn, $sql1);
								while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
									$id_std =  $row1['id_std'];
								}
						//header('Location:testting_web.php?id_std='.$id_std);
						echo '<script type="text/javascript">
								javascript:history.go(-2);
								location.reload();
							</script>';
							//header('Location: ' . $_SERVER['HTTP_REFERER']);
						
					}	
					else{
						$sql = "INSERT INTO `result_exam_std` (`id`, `id_std_result_exam`, `id_name_series_exam`, `exam_result_exam`, `and_result_exam`, `result_result_exam`, `point_result_exam`, `status_result_exam_std`) 
						VALUES (NULL, '$id_std', '$id_series_exam', '$List_series_exam', '$Ans', '$result_point', '$point_sum', '0');";
						if($conn->query($sql)===TRUE){
							
							$sql1 = "SELECT * FROM `manage_std` WHERE id = $id_std";
								$result1 = mysqli_query($conn, $sql1);
								while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
									$id_std =  $row1['id_std'];
								}
								echo '<script type="text/javascript">
								javascript:history.go(-2);
								location.reload();
							</script>';
							//header('Location: ' . $_SERVER['HTTP_REFERER']);
							//header('Location:testting_web.php?id_std='.$id_std);
							
						}
					}
}


if(isset($_GET["update_status"])){	
		$id_series_exam = $_GET['id_series_exam'];
		$value = $_GET['value'];
		$sql = "UPDATE `result_exam_std` SET `status_result_exam_std` = '$value' WHERE result_exam_std.id_name_series_exam = $id_series_exam";
			if($conn->query($sql)===TRUE){
				//header('Location:Series_Exam_Show_Point.php?id_series_exam='.$id_series_exam);
				echo '<script type="text/javascript">
						javascript:history.go(-1);
					</script>';
			}
}

if(isset($_GET["delete_result_exam_std"])){	
		$id_result_exam_std = $_GET['id'];
		$id_series_exam = $_GET['id_series_exam'];
		$sql = "DELETE FROM `result_exam_std` WHERE `result_exam_std`.`id` = $id_result_exam_std";
			if($conn->query($sql)===TRUE){
				//header('Location:Series_Exam_Show_Point.php?id_series_exam='.$id_series_exam);
				echo '<script type="text/javascript">
						javascript:history.go(-1);
					</script>';
			}
}

if(isset($_POST["change_pass"])){	
		$id_std = $_POST['id_std'];
		$pass_old = $_POST['pass_old'];
		$pass_new = $_POST['pass_new'];
		$pass_new2 = $_POST['pass_new2'];
		
		$strSQL = "SELECT * FROM `manage_std` WHERE `id_std` = '$id_std' AND `password_std` = '$pass_old'";
		$result = mysqli_query($conn, $strSQL);
		if($pass_new != $pass_new2 ){
			header('Location:Change_password.php?false2=false2&id_std='.$id_std);	
		}
		else if(mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
				$id = $row['id'];
			}
			$sql = "UPDATE `manage_std` SET `password_std` = '$pass_new' WHERE `manage_std`.`id` = $id;";
			if($conn->query($sql)===TRUE){
			header('Location:Change_password.php?true=true2&id_std='.$id_std);				
			}
			
		}
		else {
			header('Location:Change_password.php?false=false&id_std='.$id_std);
				
		}
		
}

if(isset($_POST["change_pass_web"])){	
		$id_std = $_POST['id_std'];
		$pass_old = $_POST['pass_old'];
		$pass_new = $_POST['pass_new'];
		$pass_new2 = $_POST['pass_new2'];
		
		$strSQL = "SELECT * FROM `manage_std` WHERE `id_std` = '$id_std' AND `password_std` = '$pass_old'";
		$result = mysqli_query($conn, $strSQL);
		if($pass_new != $pass_new2 ){
			header('Location:Change_password_Web.php?false2=false2&id_std='.$id_std);	
		}
		else if(mysqli_num_rows($result) > 0) {
			while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
				$id = $row['id'];
			}
			$sql = "UPDATE `manage_std` SET `password_std` = '$pass_new' WHERE `manage_std`.`id` = $id;";
			if($conn->query($sql)===TRUE){
			header('Location:testting_web.php?id_std='.$id_std);			
			}
			
		}
		else {
			header('Location:Change_password_Web.php?false=false&id_std='.$id_std);
				
		}
		
}
					
					
		
					
?>