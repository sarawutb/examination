<?php
include'connect.php'; 
if(isset($_POST['delete_all_exam'])){
	if(isset($_POST['delete_all'])){
					$delete_all = implode(',',$_POST['delete_all']);
					$arr_id_delete_all = explode(',',$delete_all);
						for ($i=0; $i < count($arr_id_delete_all); $i++) {   
						        $id_exam = $arr_id_delete_all[$i];
								$sql = "DELETE FROM `manager_exam` WHERE `manager_exam`.`id` = $id_exam";	
								$conn->query($sql);										
							}
									 if($conn->query($sql)===TRUE){
										header('Location: ' . $_SERVER['HTTP_REFERER']);
									}
	}else{
				echo"<script language=''>
						var r = confirm('ยังไม่เลือกรายการที่จะลบ');
							if (r == true) {
								window.history.back();
								 } else {
								window.history.back();
						}
					</script>";
				header("Refresh:5"); 
}
}
?>