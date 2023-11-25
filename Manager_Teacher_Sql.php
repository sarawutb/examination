<?php
include("connect.php");
if(isset($_POST["add_teacher"])){
					$status = true;
					$name_teacher = $_POST["name_teacher"];
					$last_teacher = $_POST["last_teacher"];
					$email_teacher = $_POST["email_teacher"];
					$password_teacher = $_POST["password_teacher"];
					$status_teacher = $_POST["status_teacher"];
					$gender_teacher = $_POST["gender_teacher"];

					$list_name = $name_teacher." ".$last_teacher;

					$sql = "SELECT * FROM `manager_teacher` WHERE `email_teacher` = '$email_teacher'";
					$result = mysqli_query($conn, $sql);
					while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
						$status = false;
					}
					if($status == false){
						echo "<script language=''>

								var r = confirm('ตรวจพบว่ามีอีเมลนี้ในระบบแล้ว!');
								  if (r == true) {
									window.history.back();
								  } else {
									window.history.back();
								  }
								</script>";
								//header('Location: ' . $_SERVER['HTTP_REFERER']);
					}else{
					$sql = "INSERT INTO `manager_teacher` (`id_teacher`, `name_teacher`, `email_teacher`, `password_teacher`, `status_teacher`, `gender_teacher`)
					VALUES (NULL, '$list_name', '$email_teacher', '$password_teacher', '$status_teacher', '$gender_teacher');";

				if($conn->query($sql)===TRUE){
					//header('Location: ' . $_SERVER['HTTP_REFERER']);
					header('Location:Manager_Teacher.php');
				}
			}
}
if(isset($_POST["update_teacher"])){
					$id = $_POST["id_teacher"];
					$name_teacher = $_POST["name_teacher"];
					$last_teacher = $_POST["last_teacher"];;
					$email_teacher = $_POST["email_teacher"];
					$password_teacher = $_POST["password_teacher"];
					$status_teacher = $_POST["status_teacher"];
					$gender_teacher = $_POST["gender_teacher"];

					$list_name = $name_teacher." ".$last_teacher;

					$sql = "UPDATE `manager_teacher` SET
					`name_teacher` = '$list_name',
					`email_teacher` = '$email_teacher',
					`password_teacher` = '$password_teacher',
					`status_teacher` = '$status_teacher',
					`gender_teacher` = '$gender_teacher'
					WHERE `manager_teacher`.`id_teacher` = '$id';";

				if($conn->query($sql)===TRUE){
					//header('Location: ' . $_SERVER['HTTP_REFERER']);
					// echo '<script type="text/javascript">
					// 							javascript:history.go(-1);
					// 						</script>';
					// header('Location: ' . $_SERVER['HTTP_REFERER']);
					header('Location:Manager_Teacher.php');
			}
}
if(isset($_POST["update_profile"])){
					$id = $_POST["id_teacher"];
					$name_teacher = $_POST["name_teacher"];
					$last_teacher = $_POST["last_teacher"];;
					$email_teacher = $_POST["email_teacher"];
					$password_teacher = $_POST["password_teacher"];
					$status_teacher = $_POST["status_teacher"];
					$gender_teacher = $_POST["gender_teacher"];

					$list_name = $name_teacher." ".$last_teacher;

					$sql = "UPDATE `manager_teacher` SET
					`name_teacher` = '$list_name',
					`email_teacher` = '$email_teacher',
					`password_teacher` = '$password_teacher',
					`status_teacher` = '$status_teacher',
					`gender_teacher` = '$gender_teacher'
					WHERE `manager_teacher`.`id_teacher` = '$id';";

				if($conn->query($sql)===TRUE){
					//header('Location: ' . $_SERVER['HTTP_REFERER']);
					// echo '<script type="text/javascript">
					// 							javascript:history.go(-1);
					// 						</script>';
					header('Location: ' . $_SERVER['HTTP_REFERER']);
					//header('Location:Manager_Teacher.php');
			}
}
if(isset($_GET["delete_teacher"])){
	$id = $_GET["id_teacher"];

		$sql = "SELECT * FROM `manager_teacher` WHERE id_teacher = $id";
			$result = mysqli_query($conn, $sql);
			while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
						$id_teacher = $row['id_teacher'];
						$sql1 = "SELECT * FROM `manager_subject`WHERE name_teacher_subject = $id_teacher";
						$result1 = mysqli_query($conn, $sql1);
						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
							$id_subject = $row1['id'];

							$sql2 = "SELECT * FROM `manager_chapter` WHERE name_name_subject = $id_subject";
							$result2 = mysqli_query($conn, $sql2);
							while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)) {
							$id_chapter = $row2['id'];


									$sql3 = "SELECT * FROM `manager_exam` WHERE `chapter_id_exam` = $id_chapter";
									$result3 = mysqli_query($conn, $sql3);
									while ($row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC)) {
										$exam_id = $row3['id'];
										$proposition_img_exam = $row3['proposition_img_exam'];
										$answer1_img_exam = $row3['answer1_img_exam'];
										$answer2_img_exam = $row3['answer2_img_exam'];
										$answer3_img_exam = $row3['answer3_img_exam'];
										$answer4_img_exam = $row3['answer4_img_exam'];
										echo "in ID ";
										//echo $exam_id;
									if($proposition_img_exam!=null){unlink( "upload/".$proposition_img_exam);}
									if($answer1_img_exam!=null){unlink( "upload/".$answer1_img_exam);}
									if($answer2_img_exam!=null){unlink( "upload/".$answer2_img_exam);}
									if($answer3_img_exam!=null){unlink( "upload/".$answer3_img_exam);}
									if($answer4_img_exam!=null){unlink( "upload/".$answer4_img_exam);}

									$sql4delete = "DELETE FROM `manager_exam` WHERE `manager_exam`.`id`= $exam_id;";
									$conn->query($sql4delete);
									}



							}


						}

						$sql3delete = "DELETE FROM `manager_series_exam` WHERE id_subject_series_exam = $id_subject";
						$conn->query($sql3delete);

						$sql2delete = "DELETE FROM `manager_chapter` WHERE `name_name_subject` = $id_subject";
						$conn->query($sql2delete);

						$sql1delete = "DELETE FROM `manager_subject` WHERE name_teacher_subject = $id_teacher";
						$conn->query($sql1delete);
						}

					$sql = "DELETE FROM `manager_teacher` WHERE `manager_teacher`.`id_teacher` = $id_teacher";
					$conn->query($sql);

					if($conn->query($sql)===TRUE){
							//header('Location: ' . $_SERVER['HTTP_REFERER']);
							// echo '<script type="text/javascript">
							// 					javascript:history.go(-1);
							// 				</script>';
							header('Location:Manager_Teacher.php');
						}


}
?>
