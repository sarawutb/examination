<?php
include'connect.php';
if(isset($_GET["add_chapter"])){
	$id = $_GET["name_subject_id"];
	// $num_chapter = $_GET["num_chapter"];
	$name_chapter = $_GET["name_chapter"];
	// $objective_chapter = $_GET["objective_chapter"];

	// $sql = "INSERT INTO `manager_chapter` (`id`, `num_chapter`, `name_chapter`, `objective_chapter`, `name_name_subject`)
	// VALUES (NULL,'$num_chapter', '$name_chapter', '$objective_chapter', '$id');";
	$sql = "INSERT INTO `manager_chapter` (`id`, `name_chapter`, `name_name_subject`)
	VALUES (NULL,'$name_chapter', '$id');";

	if($conn->query($sql)===TRUE){
		echo '<META HTTP-EQUIV="Refresh" CONTENT="0.1;URL=Manager_Exam_Chapter.php?name_subject_id='.$id.'">';
		//echo '<script type="text/javascript">
		//				javascript:history.go(-2);
		//			</script>';
	}
}

 if(isset($_GET["update_chapter"])){
					$id = $_GET["id_chapter"];
					$subject_id = $_GET["name_subject_id"];
					// $num_chapter = $_GET["num_chapter"];
					$name_chapter = $_GET["name_chapter"];
					// $objective_chapter = $_GET["objective_chapter"];

					// $sql = "UPDATE `manager_chapter` SET `num_chapter` = '$num_chapter', `name_chapter` = '$name_chapter', `objective_chapter` = '$objective_chapter'
					// WHERE `manager_chapter`.`id` = $id;";
					$sql = "UPDATE `manager_chapter` SET `name_chapter` = '$name_chapter'	WHERE `manager_chapter`.`id` = $id;";

				if($conn->query($sql)===TRUE){
					//echo '<META HTTP-EQUIV="Refresh" CONTENT="0.01;URL=Manager_Exam_Chapter.php?name_subject_id='.$id_chapter.'">';
					//header('Location: ' . $_SERVER['HTTP_REFERER']);
					echo '<META HTTP-EQUIV="Refresh" CONTENT="0.1;URL=Manager_Exam_Chapter.php?name_subject_id='.$subject_id.'">';
	}
}

if(isset($_GET["delete_chapter"])){
					$id = $_GET["id"];
					$name_subject_id = $_GET["name_subject_id"];
					$sql = "SELECT * FROM manager_chapter INNER JOIN manager_exam ON manager_chapter.id=manager_exam.chapter_id_exam WHERE manager_chapter.id = $id";
						$result = mysqli_query($conn, $sql);
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
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
					}
					$sql = "DELETE FROM `manager_chapter` WHERE `manager_chapter`.`id` = $id;";
					$conn->query($sql);
					$sql2 = "DELETE FROM `manager_exam` WHERE `chapter_id_exam` = $id;";
					$conn->query($sql2);

					if($conn->query($sql)=== TRUE && $conn->query($sql2)=== TRUE){
			//header('Location: ' . $_SERVER['HTTP_REFERER']);
			echo '<META HTTP-EQUIV="Refresh" CONTENT="0.1;URL=Manager_Exam_Chapter.php?name_subject_id='.$name_subject_id.'">';
	}

}
?>
