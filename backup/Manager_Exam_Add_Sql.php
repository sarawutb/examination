<?php 
include'connect.php';
if(isset($_POST["add_exam"])){
					$id_chapter = $_POST["id_chapter"];
					$proposition = $_POST["proposition"];
					$Option1 = $_POST["Option1"];
					$Option2 = $_POST["Option2"];
					$Option3 = $_POST["Option3"];
					$Option4 = $_POST["Option4"];
					$Option_true = $_POST["Option_true"];
					//echo $proposition."<br>";echo $Option1."<br>";echo $Option2."<br>";echo $Option3."<br>";echo $Option4."<br>";echo $img_proposition."<br>";echo $img_Option1."<br>";echo $img_Option2."<br>";echo $img_Option3."<br>";echo $img_Option4."<br>";echo $Option_true."<br>";
					$result = FALSE;
						
						$type_img_proposition = pathinfo(basename($_FILES['img_proposition']['name']), PATHINFO_EXTENSION);
						if($type_img_proposition != null){
						$rand_name_img_type_img_proposition = date("mdy").substr(md5(rand(0, 9999999)), 0, 100).".".$type_img_proposition;
						}else{
							$rand_name_img_type_img_proposition = null;
						}
						$upload_path_img_proposition = "upload/".$rand_name_img_type_img_proposition;
						
						$type_img_Option1 = pathinfo(basename($_FILES['img_Option1']['name']), PATHINFO_EXTENSION);
						if($type_img_Option1 != null){
						$rand_name_img_Option1 = date("mdy").substr(md5(rand(0, 9999999)), 0, 100).".".$type_img_Option1;
						}else{
							$rand_name_img_Option1 =null;
						}
						$upload_path_img_Option1 = "upload/".$rand_name_img_Option1;
						
						$type_img_Option2 = pathinfo(basename($_FILES['img_Option2']['name']), PATHINFO_EXTENSION);
						if($type_img_Option2 != null){
						$rand_name_img_Option2 = date("mdy").substr(md5(rand(0, 9999999)), 0, 100).".".$type_img_Option2;
						}else{
							$rand_name_img_Option2 = null;
						}
						$upload_path_img_Option2 = "upload/".$rand_name_img_Option2;
						
						$type_img_Option3 = pathinfo(basename($_FILES['img_Option3']['name']), PATHINFO_EXTENSION);
						if($type_img_Option3 != null){
						$rand_name_img_Option3 = date("mdy").substr(md5(rand(0, 9999999)), 0, 100).".".$type_img_Option3;
						}else{
							$rand_name_img_Option3 = null;
						}
						$upload_path_img_Option3 = "upload/".$rand_name_img_Option3;
						
						$type_img_Option4 = pathinfo(basename($_FILES['img_Option4']['name']), PATHINFO_EXTENSION);
						if($type_img_Option4 != null){
						$rand_name_img_Option4 = date("mdy").substr(md5(rand(0, 9999999)), 0, 100).".".$type_img_Option4;
						}else{
							$rand_name_img_Option4 = null;
						}
						$upload_path_img_Option4 = "upload/".$rand_name_img_Option4;
		
					    $file_size1 =$_FILES['img_proposition']['size'];
					    $file_size2 =$_FILES['img_Option1']['size'];
					    $file_size3 =$_FILES['img_Option2']['size'];
					    $file_size4 =$_FILES['img_Option3']['size'];
					    $file_size5 =$_FILES['img_Option4']['size'];
						
						$expensions= array("jpeg","jpg","png","gif");
						
					
							  
							  
						//if($type_img_proposition != NULL){
						
						
						//echo $rand_name_img_type_img_proposition;
						//}
						
						if($file_size1 > 512000 || $file_size2 > 512000 || $file_size3 > 512000 || $file_size4 > 512000 || $file_size5 > 512000 ){
								echo"<script language=''>
								
								var r = confirm('ขนาดรูปภาพใหญ่เกินไป');
								  if (r == true) {
									window.history.back();
								  } else {
									window.history.back();
								  }
								</script>";
								header("Refresh:5"); 
								//header('Location: ' . $_SERVER['HTTP_REFERER']);
								 
							  }else{
								  move_uploaded_file($_FILES['img_proposition']['tmp_name'], $upload_path_img_proposition);
								  move_uploaded_file($_FILES['img_Option1']['tmp_name'], $upload_path_img_Option1);
								  move_uploaded_file($_FILES['img_Option2']['tmp_name'], $upload_path_img_Option2);
								  move_uploaded_file($_FILES['img_Option3']['tmp_name'], $upload_path_img_Option3);
								  move_uploaded_file($_FILES['img_Option4']['tmp_name'], $upload_path_img_Option4);
								  
								  $sql = "INSERT INTO `manager_exam` (`id`, `proposition_exam`, `proposition_img_exam`, `answer1_exam`, `answer1_img_exam`, `answer2_exam`, `answer2_img_exam`, `answer3_exam`, `answer3_img_exam`, `answer4_exam`, `answer4_img_exam`, `result_exam`, `chapter_id_exam`) 
								  VALUES (NULL, '$proposition', '$rand_name_img_type_img_proposition', 
												'$Option1', '$rand_name_img_Option1', 
												'$Option2', '$rand_name_img_Option2', 
												'$Option3', '$rand_name_img_Option3', 
												'$Option4', '$rand_name_img_Option4', 
												'$Option_true', 
												'$id_chapter');";
												
									if($conn->query($sql)===TRUE){
										header('Location: ' . $_SERVER['HTTP_REFERER']);
									} 
							  }
		  }
		  
		  
if(isset($_POST["edit_exam"])){
		  if(isset($_POST["img_proposition"])){
			   $img_proposition = $_POST["img_proposition"];
			   $exam_id = $_POST["exam_id"];
			   //echo  $img_proposition."<br>";
			   $sql = "SELECT * FROM `manager_exam`WHERE `id` = $exam_id";
						$result = mysqli_query($conn, $sql);
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
							$proposition_img_exam = $row['proposition_img_exam'];
						}
						unlink( "upload/".$proposition_img_exam);
						
						$sql = "UPDATE `manager_exam` SET `proposition_img_exam` = ''
								 WHERE `manager_exam`.`id` = $exam_id;";
								  
									if($conn->query($sql)===TRUE){
										header('Location: ' . $_SERVER['HTTP_REFERER']);
										
									}
						
		  }
		  if(isset($_POST["img_Option1"])){
			   $img_Option1 = $_POST["img_Option1"];
			   $exam_id = $_POST["exam_id"];
			   echo  $img_Option1;
			   $sql = "SELECT * FROM `manager_exam`WHERE `id` = $exam_id";
						$result = mysqli_query($conn, $sql);
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
							$answer1_img_exam = $row['answer1_img_exam'];
						}
						unlink( "upload/".$answer1_img_exam);
						
						$sql = "UPDATE `manager_exam` SET `answer1_img_exam` = ''
								 WHERE `manager_exam`.`id` = $exam_id;";
								  
									if($conn->query($sql)===TRUE){
										header('Location: ' . $_SERVER['HTTP_REFERER']);
									}
		  }
		  if(isset($_POST["img_Option2"])){
			   $img_Option2 = $_POST["img_Option2"];
			   $exam_id = $_POST["exam_id"];
			   echo  $img_Option2;
			   $sql = "SELECT * FROM `manager_exam`WHERE `id` = $exam_id";
						$result = mysqli_query($conn, $sql);
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
							$answer2_img_exam = $row['answer2_img_exam'];
						}
						unlink( "upload/".$answer2_img_exam);
						
						$sql = "UPDATE `manager_exam` SET `answer2_img_exam` = ''
								 WHERE `manager_exam`.`id` = $exam_id;";
								  
									if($conn->query($sql)===TRUE){
										header('Location: ' . $_SERVER['HTTP_REFERER']);
									}
						
		  }
		  if(isset($_POST["img_Option3"])){
			   $img_Option3 = $_POST["img_Option3"];
			   $exam_id = $_POST["exam_id"];
			   echo  $img_Option3;
			   $sql = "SELECT * FROM `manager_exam`WHERE `id` = $exam_id";
						$result = mysqli_query($conn, $sql);
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
							$answer3_img_exam = $row['answer3_img_exam'];
						}
						unlink( "upload/".$answer3_img_exam);
						
						$sql = "UPDATE `manager_exam` SET `answer3_img_exam` = ''
								 WHERE `manager_exam`.`id` = $exam_id;";
								  
									if($conn->query($sql)===TRUE){
										header('Location: ' . $_SERVER['HTTP_REFERER']);
									}
		  }
		  if(isset($_POST["img_Option4"])){
			   $img_Option4 = $_POST["img_Option4"];
			   $exam_id = $_POST["exam_id"];
			   echo  $img_Option4;
			   $sql = "SELECT * FROM `manager_exam`WHERE `id` = $exam_id";
						$result = mysqli_query($conn, $sql);
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
							$answer4_img_exam = $row['answer4_img_exam'];
						}
						unlink( "upload/".$answer4_img_exam);
						
						$sql = "UPDATE `manager_exam` SET `answer4_img_exam` = ''
								 WHERE `manager_exam`.`id` = $exam_id;";
								  
									if($conn->query($sql)===TRUE){
										header('Location: ' . $_SERVER['HTTP_REFERER']);
									}
		  }
		  
		 // if(isset($_POST["img_proposition"])||isset($_POST["img_Option1"])||isset($_POST["img_Option2"])||isset($_POST["img_Option3"])||isset($_POST["img_Option4"])){
		  
		  //}
			
		  
		  
		
			
		
				$id_chapter = $_POST["id_chapter"];
				$exam_id = $_POST["exam_id"];
				$proposition = $_POST["proposition"];
				$Option1 = $_POST["Option1"];
				$Option2 = $_POST["Option2"];
				$Option3 = $_POST["Option3"];
				$Option4 = $_POST["Option4"];
				$Option_true = $_POST["Option_true"];
				
				//echo $_FILES['img_proposition']['name'];
			  
				$sql = "SELECT * FROM `manager_exam`WHERE `id` = $exam_id";
						$result = mysqli_query($conn, $sql);
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
							$proposition_img_exam = $row['proposition_img_exam'];
							$answer1_img_exam = $row['answer1_img_exam'];
							$answer2_img_exam = $row['answer2_img_exam'];
							$answer3_img_exam = $row['answer3_img_exam'];
							$answer4_img_exam = $row['answer4_img_exam'];
						}
						
						
						
						$file_size1 =$_FILES['img_proposition']['size'];
					    $file_size2 =$_FILES['img_Option1']['size'];
					    $file_size3 =$_FILES['img_Option2']['size'];
					    $file_size4 =$_FILES['img_Option3']['size'];
					    $file_size5 =$_FILES['img_Option4']['size'];
						
						$expensions= array("jpeg","jpg","png","gif");
						
						if($file_size1 > 512000 || $file_size2 > 512000 || $file_size3 > 512000 || $file_size4 > 512000 || $file_size5 > 512000 ){
								 echo"<script language=''>
								
								var r = confirm('ขนาดรูปภาพใหญ่เกินไป');
								  if (r == true) {
									window.history.back();
								  } else {
									window.history.back();
								  }
								</script>";
								//header("Refresh:5"); 
							  }else{
								  $type_img_proposition = pathinfo(basename($_FILES['img_proposition']['name']), PATHINFO_EXTENSION);
						if($type_img_proposition != null){
						unlink( "upload/".$proposition_img_exam);
						$rand_name_img_type_img_proposition = date("mdy").substr(md5(rand(0, 9999999)), 0, 100).".".$type_img_proposition;
						}else{
							$rand_name_img_type_img_proposition = $proposition_img_exam;
						}
						$upload_path_img_proposition = "upload/".$rand_name_img_type_img_proposition;
						
						$type_img_Option1 = pathinfo(basename($_FILES['img_Option1']['name']), PATHINFO_EXTENSION);
						if($type_img_Option1 != null){
						unlink( "upload/".$answer1_img_exam);
						$rand_name_img_Option1 = date("mdy").substr(md5(rand(0, 9999999)), 0, 100).".".$type_img_Option1;
						}else{
							$rand_name_img_Option1 = $answer1_img_exam;
						}
						$upload_path_img_Option1 = "upload/".$rand_name_img_Option1;
						
						$type_img_Option2 = pathinfo(basename($_FILES['img_Option2']['name']), PATHINFO_EXTENSION);
						if($type_img_Option2 != null){
						$rand_name_img_Option2 = date("mdy").substr(md5(rand(0, 9999999)), 0, 100).".".$type_img_Option2;
						}else{
							$rand_name_img_Option2 = $answer2_img_exam;
						}
						$upload_path_img_Option2 = "upload/".$rand_name_img_Option2;
						
						$type_img_Option3 = pathinfo(basename($_FILES['img_Option3']['name']), PATHINFO_EXTENSION);
						if($type_img_Option3 != null){
						unlink( "upload/".$answer3_img_exam);
						$rand_name_img_Option3 = date("mdy").substr(md5(rand(0, 9999999)), 0, 100).".".$type_img_Option3;
						}else{
							$rand_name_img_Option3 = $answer3_img_exam;
						}
						$upload_path_img_Option3 = "upload/".$rand_name_img_Option3;
						
						$type_img_Option4 = pathinfo(basename($_FILES['img_Option4']['name']), PATHINFO_EXTENSION);
						if($type_img_Option4 != null){
						unlink( "upload/".$answer4_img_exam);
						$rand_name_img_Option4 = date("mdy").substr(md5(rand(0, 9999999)), 0, 100).".".$type_img_Option4;
						}else{
							$rand_name_img_Option4 = $answer4_img_exam;
						}
						$upload_path_img_Option4 = "upload/".$rand_name_img_Option4;
								  move_uploaded_file($_FILES['img_proposition']['tmp_name'], $upload_path_img_proposition);
								  move_uploaded_file($_FILES['img_Option1']['tmp_name'], $upload_path_img_Option1);
								  move_uploaded_file($_FILES['img_Option2']['tmp_name'], $upload_path_img_Option2);
								  move_uploaded_file($_FILES['img_Option3']['tmp_name'], $upload_path_img_Option3);
								  move_uploaded_file($_FILES['img_Option4']['tmp_name'], $upload_path_img_Option4);
								 
								  $sql = "UPDATE `manager_exam` SET 
								  `proposition_exam` = '$proposition', 
								  `proposition_img_exam` = '$rand_name_img_type_img_proposition', 
								  `answer1_exam` = '$Option1', 
								  `answer1_img_exam` = '$rand_name_img_Option1', 
								  `answer2_exam` = '$Option2', 
								  `answer2_img_exam` = '$rand_name_img_Option2', 
								  `answer3_exam` = '$Option3', 
								  `answer3_img_exam` = '$rand_name_img_Option3', 
								  `answer4_exam` = '$Option4', 
								  `answer4_img_exam` = '$rand_name_img_Option4', 
								  `result_exam` = '$Option_true', 
								  `chapter_id_exam` = '$id_chapter' 
								  WHERE `manager_exam`.`id` = $exam_id;";
								  
									if($conn->query($sql)===TRUE){
										header('Location: ' . $_SERVER['HTTP_REFERER']);
									}
							  }
		  
}
		  
if(isset($_GET["delete_exam"])){
			  $exam_id = $_GET["id_exam"];
				$sql = "SELECT * FROM `manager_exam`WHERE `id` = $exam_id";
						$result = mysqli_query($conn, $sql);
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
							$proposition_img_exam = $row['proposition_img_exam'];
							$answer1_img_exam = $row['answer1_img_exam'];
							$answer2_img_exam = $row['answer2_img_exam'];
							$answer3_img_exam = $row['answer3_img_exam'];
							$answer4_img_exam = $row['answer4_img_exam'];
						}
						if($proposition_img_exam!=null){unlink( "upload/".$proposition_img_exam);}
						if($answer1_img_exam!=null){unlink( "upload/".$answer1_img_exam);}
						if($answer2_img_exam!=null){unlink( "upload/".$answer2_img_exam);}
						if($answer3_img_exam!=null){unlink( "upload/".$answer3_img_exam);}
						if($answer4_img_exam!=null){unlink( "upload/".$answer4_img_exam);}
		  
					$sql = "DELETE FROM `manager_exam` WHERE `manager_exam`.`id` = $exam_id";
					if($conn->query($sql)===TRUE){
					//header('Location: ' . $_SERVER['HTTP_REFERER']);
					echo '<script type="text/javascript">
							javascript:history.go(-1);
						</script>';
					}
										
}



		  
			
?>