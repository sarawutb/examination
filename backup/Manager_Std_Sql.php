<?php
include'connect.php';
if(isset($_POST["add_std"])){
					$status = true;
					$id_std = $_POST["id_std"];
					$name_std = $_POST["name_std"];
					$last_std = $_POST["last_std"];
					$branch_id_std = $_POST["branch_id"];
					$genre_std = $_POST["genre_std"];
					$degree_std = $_POST["degree_std"];
					$section_std = $_POST["section_std"];
					$password_std = $_POST["password_std"];
					$gender_std = $_POST["gender_std"];

					$name = $name_std." ".$last_std;

					$sql = "SELECT * FROM `manage_std` WHERE `id_std` = $id_std";
					$result = mysqli_query($conn, $sql);
					while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
						$status = false;
					}
					if($status == false){
						echo "<script language=''>

								var r = confirm('ตรวจพบว่ามีบัญชีนักศึกษาในระบบแล้ว!');
								  if (r == true) {
									window.history.back();
								  } else {
									window.history.back();
								  }
								</script>";
								//header('Location: ' . $_SERVER['HTTP_REFERER']);
					}else{
						//$year_std = substr($id_std,0,2);
						$year_std = $degree_std."/".$section_std;
						$sql = "INSERT INTO `manage_std` (`id`, `id_std`,  `year_std`, `gender_std`, `name_std`, `password_std`, `branch_id_std`, `genre_std`, `degree_std`, `section_std`)
						VALUES (NULL, '$id_std', '$year_std', '$gender_std', '$name', '$password_std', '$branch_id_std', '$genre_std', '$degree_std', '$section_std');";

							if($conn->query($sql)===TRUE){
								header('Location:Manager_Std_List.php?genre_std='.$genre_std.'&branch_id='.$branch_id_std.'&degree_std='.$degree_std.'&section_std='.$section_std);
							}
						}

}
if(isset($_POST["update_std"])){
					$status = true;
					$id = $_POST["id"];
					$id_std = $_POST["id_std"];
					$gender_std = $_POST["gender_std"];
					$name_std = $_POST["name_std"];
					$last_std = $_POST["last_std"];
					$password_std = $_POST["password_std"];

					$branch_id_std = $_POST["branch_id"];
					$genre_std = $_POST["genre_std"];
					$degree_std = $_POST["degree_std"];
					$section_std = $_POST["section_std"];

					$name = $name_std." ".$last_std;

					$sql = "SELECT * FROM `manage_std` WHERE `id_std` = $id_std";
					$result = mysqli_query($conn, $sql);
					while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
						$status = false;
					}

					//$year_std = substr($id_std,0,2);
					$year_std = $degree_std."/".$section_std;
					$sql = "UPDATE `manage_std` SET
					`id_std` = '$id_std',
					`year_std` = '$year_std',
					`gender_std` = '$gender_std',
					`name_std` = '$name',
					`branch_id_std` = '$branch_id_std',
					`genre_std` = '$genre_std',
					`degree_std` = '$degree_std',
					`section_std` = '$section_std',
					`password_std` = '$password_std'
					WHERE id = '$id';";

				if($conn->query($sql)===TRUE){
					header('Location:Manager_Std_List.php?genre_std='.$genre_std.'&branch_id='.$branch_id_std.'&degree_std='.$degree_std.'&section_std='.$section_std);

					//echo '<script type="text/javascript">
						//						javascript:history.go(-1);
						//					</script>';
					//header('Location: ' . $_SERVER['HTTP_REFERER']);
			}

}
if(isset($_GET["delete_std"])){
					$id_std = $_GET["id"];
					$sql = "DELETE FROM `manage_std` WHERE `manage_std`.`id` = $id_std";

				if($conn->query($sql)===TRUE){
					//header('Location: ' . $_SERVER['HTTP_REFERER']);
					echo '<script type="text/javascript">
												javascript:history.go(-1);
											</script>';
			}
}
if(isset($_POST["add_branch"])){
					$status = true;
					$Option_branch_type = $_POST["Option_branch_type"];
					$branch_name = $_POST["branch_name"];
					$genre_std = $_POST["branch_board"];
					$sql = "INSERT INTO `manager_branch` (`branch_id`, `branch_genre`, `branch_type`, `branch_name`) VALUES (NULL, '$genre_std', '$Option_branch_type', '$branch_name');";

								if($conn->query($sql)===TRUE){
									header('Location:Manager_Std_Page2.php?genre_std='.$genre_std);
								}
}
if(isset($_POST["update_branch"])){
					//$status = true;
					$branch_id = $_POST["branch_id"];
					$branch_name = $_POST["branch_name"];
					$Option_branch_type = $_POST["Option_branch_type"];

					$sql = "UPDATE `manager_branch` SET `branch_name` = '$branch_name',`branch_type` = '$Option_branch_type' WHERE `manager_branch`.`branch_id` = $branch_id;";

				if($conn->query($sql)===TRUE){
					//header('Location: ' . $_SERVER['HTTP_REFERER']);
					echo '<script type="text/javascript">
												javascript:history.go(-1);
											</script>';
					header('Location: ' . $_SERVER['HTTP_REFERER']);
			}

}
if(isset($_GET["delete_branch"])){
					$branch_id = $_GET["branch_id"];
					$sql = "DELETE FROM `manager_branch` WHERE `manager_branch`.`branch_id` = $branch_id";

				if($conn->query($sql)===TRUE){
					//header('Location: ' . $_SERVER['HTTP_REFERER']);
					echo '<script type="text/javascript">
												javascript:history.go(-1);
											</script>';
				}
}
?>
