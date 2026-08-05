<?php
include("connect.php");

if (isset($_POST['delete_all_exam'])) {
	if (isset($_POST['delete_all']) && is_array($_POST['delete_all'])) {
		foreach ($_POST['delete_all'] as $id_exam) {
			$id_exam = (int)$id_exam;
			
			// Select and unlink associated images
			$sql_img = "SELECT * FROM `manager_exam` WHERE `id` = $id_exam";
			$res_img = mysqli_query($conn, $sql_img);
			if ($res_img && $row = mysqli_fetch_array($res_img, MYSQLI_ASSOC)) {
				$imgs = array(
					$row['proposition_img_exam'],
					$row['answer1_img_exam'],
					$row['answer2_img_exam'],
					$row['answer3_img_exam'],
					$row['answer4_img_exam'],
					$row['answer5_img_exam']
				);
				foreach ($imgs as $img) {
					if (!empty($img) && file_exists("upload/" . $img)) {
						@unlink("upload/" . $img);
					}
				}
			}

			$sql = "DELETE FROM `manager_exam` WHERE `id` = $id_exam";
			$conn->query($sql);
		}
		if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
		exit();
	} else {
		echo "<script language='JavaScript'>
				alert('ยังไม่ได้เลือกรายการที่จะลบ!');
				window.history.back();
			  </script>";
		exit();
	}
}

if (isset($_POST['delete_all_exam_annotated'])) {
	if (isset($_POST['delete_all']) && is_array($_POST['delete_all'])) {
		foreach ($_POST['delete_all'] as $id_exam) {
			$id_exam = (int)$id_exam;

			$sql_img = "SELECT * FROM `manager_exam_annotated` WHERE `id` = $id_exam";
			$res_img = mysqli_query($conn, $sql_img);
			if ($res_img && $row = mysqli_fetch_array($res_img, MYSQLI_ASSOC)) {
				$img = $row['proposition_img_exam'];
				if (!empty($img) && file_exists("upload/" . $img)) {
					@unlink("upload/" . $img);
				}
			}

			$sql = "DELETE FROM `manager_exam_annotated` WHERE `id` = $id_exam";
			$conn->query($sql);
		}
		if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
		exit();
	} else {
		echo "<script language='JavaScript'>
				alert('ยังไม่ได้เลือกรายการที่จะลบ!');
				window.history.back();
			  </script>";
		exit();
	}
}
?>
