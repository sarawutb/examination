﻿<?php
include'connect.php';
if(isset($_POST["add_subject"])){
					$id_subject = $_POST["id_subject"];
					$name_subject = $_POST["name_subject"];
					$name_teacher_subject = $_POST["name_teacher_subject"];
					$genre_subject = $_POST["genre_subject"];
					
					$sql = "INSERT INTO `manager_subject` (`id`, `id_subject`, `name_subject`, `name_teacher_subject`, `genre_subject`) 
					VALUES (NULL, '$id_subject', '$name_subject', '$name_teacher_subject', '$genre_subject');";
				
				if($conn->query($sql)===TRUE){
										echo '<script type="text/javascript">
												javascript:history.go(-1);
											</script>';
											header('Location: ' . $_SERVER['HTTP_REFERER']);
									} 		
					}

if(isset($_POST["update_subject"])){
					$id = $_POST["id"];
					$id_subject = $_POST["id_subject"];
					$name_subject = $_POST["name_subject"];
					$name_teacher_subject = $_POST["name_teacher_subject"];
					$genre_subject = $_POST["genre_subject"];
					
					$sql = "UPDATE `manager_subject` SET 
					`id_subject` = '$id_subject', 
					`name_subject` = '$name_subject', 
					`name_teacher_subject` = '$name_teacher_subject', 
					`genre_subject` = '$genre_subject'
					WHERE `id` = $id;";
				
				if($conn->query($sql)===TRUE){
										//header('Location: ' . $_SERVER['HTTP_REFERER']);
										echo '<script type="text/javascript">
												javascript:history.go(-1);
											</script>';
									} 		
					}

if(isset($_GET["delete_subject"])){
					$id = $_GET["id"];
					
					$sql = "SELECT manager_exam.id,
								   manager_exam.proposition_img_exam,
								   manager_exam.answer1_img_exam,
								   manager_exam.answer2_img_exam,
								   manager_exam.answer3_img_exam,
								   manager_exam.answer4_img_exam 
							FROM manager_chapter 
							INNER JOIN manager_exam ON manager_chapter.id = manager_exam.chapter_id_exam 
							WHERE manager_chapter.name_name_subject = $id";
						$result = mysqli_query($conn, $sql);
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
							$id_exam = $row['id'];
							$proposition_img_exam = $row['proposition_img_exam'];
							$answer1_img_exam = $row['answer1_img_exam'];
							$answer2_img_exam = $row['answer2_img_exam'];
							$answer3_img_exam = $row['answer3_img_exam'];
							$answer4_img_exam = $row['answer4_img_exam'];
			
						if($proposition_img_exam!=null){unlink( "upload/".$proposition_img_exam);}
						if($answer1_img_exam!=null){unlink( "upload/".$answer1_img_exam);}
						if($answer2_img_exam!=null){unlink( "upload/".$answer2_img_exam);}
						if($answer3_img_exam!=null){unlink( "upload/".$answer3_img_exam);}
						if($answer4_img_exam!=null){unlink( "upload/".$answer4_img_exam);}
						
						$sql3 = "DELETE FROM `manager_exam` WHERE `id` = $id_exam;";
						$conn->query($sql3);
						
					}
					
					
					
					$sql = "DELETE FROM `manager_subject` WHERE `manager_subject`.`id` = $id;";
					$conn->query($sql);
					$sql2 = "DELETE FROM `manager_chapter` WHERE `name_name_subject` = $id;";
					$conn->query($sql2);
					
					$sql3 = "DELETE FROM `manager_series_exam` WHERE `id_subject_series_exam` = $id;";
					$conn->query($sql3);
					
					
					
					if($conn->query($sql)=== TRUE && $conn->query($sql2)=== TRUE || $conn->query($sql3)=== TRUE){
			//header('Location: ' . $_SERVER['HTTP_REFERER']);
			echo '<script type="text/javascript">
												javascript:history.go(-1);
											</script>';
	}
					
}					
?>