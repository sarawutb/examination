<?php
session_start();
if(isset($_SESSION['id_std'])){
	 include("connect.php");
	 $id_STD = $_SESSION['id'];
	 //echo $id_STD ;
  }else {
	  session_start();
	  session_destroy();
	  header("location:LoginStd.php");
  }
$sql1 = "SELECT * FROM `manage_std` WHERE id = $id_STD AND IsUse = 1;";
      $result1 = mysqli_query($conn, $sql1);
      while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
        $id_std =  $row1['id_std'];
        $gender_std =  $row1['gender_std'];
        $name_std =  $row1['name_std'];
      }
      if($gender_std==1){
        $gender_std = "นาย";
      }else if($gender_std==2){
        $gender_std = "นาง";
      }

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="user-scalable=no, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ระบบข้อสอบออนไลน์</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>

</head>
<style>
pre { white-space:pre-wrap; word-wrap:break-word; overflow:auto; }
</style>
<body id="page-top" style="font-size:13px">

  <nav class="navbar navbar-expand navbar-dark  fixed-top" style="background-color: #2a7ee6;">

      <a class="navbar-brand mr-1" href="#">ระบบสอบออนไลน์ v1.0<br>
  				<h5>
  						<?php echo $id_std; ?><br>
  						<?php echo $gender_std.$name_std; ?>
  			 </h5>
  		</a>

      <!-- Navbar Search -->
      <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

      </div>

      <!-- Navbar -->
      <ul style="margin-bottom:50px" class="navbar-nav ml-auto ml-md-0">

        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <button  class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
  			  <i class="fas fa-bars"></i>
  			</button>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="Change_password_Web.php?true=index&id_std=<?php echo $id_std; ?>">เปลี่ยนรหัสผ่าน</a>
          </div>
        </li>
      </ul>

    </nav>
		<!-- On rows -->

<?php
if(isset($_GET["show_subject"])){
	$id_std = $_GET['id_sid'];
?>
<table style="font-size:14px;margin-top:115px;margin-bottom:10%" class="table table-bordered" width="100%">
  <thead>
  <tr>
				  <th width="70%" >
					<center>รายวิชา</center>
				  </th>
				  <th width="30%" >
					<center>ผลสอบ</center>
				  </th>
				</tr>
				<tr>
				<?php
						$number = 1;
						$sql2 = "SELECT DISTINCT manager_subject.name_subject, manager_subject.id as subject_id , manager_subject.id_subject FROM `result_exam_std`
						INNER JOIN manager_series_exam on result_exam_std.id_name_series_exam = manager_series_exam.id
						INNER JOIN manager_subject on manager_series_exam.id_subject_series_exam = manager_subject.id
						WHERE result_exam_std.id_std_result_exam = $id_std";
						$result2 = mysqli_query($conn, $sql2);
						while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
							$subject_id =  $row2['subject_id'];
							$name_subject =  $row2['name_subject'];
							$id_subject =  $row2['id_subject'];

				?>

      <td >
		<p><?php echo $id_subject." ".$name_subject;?></p>
	  </td>
      <td>
	  <center>
	  <a href="Show_Point_Std.php?show_chapter&id_sid=<?php echo $id_std;?>&subject_id=<?php echo $subject_id;?>"><button type="button" style="font-size:12px" class="btn btn-primary">ดูผลสอบ</button></a>
	  </center>
	  </td>
    </tr>
						<?php } ?>
  </thead>
</table>
<?php }
else if(isset($_GET["show_chapter"])){
$id_std = $_GET['id_sid'];
$subject_id = $_GET['subject_id'];
?>
<table style="font-size:14px;margin-top:115px;margin-bottom:0%" class="table table-bordered" width="100%">
  <thead>
  <tr>
				  <th width="5%" >
					<center>ลำดับ</center>
				  </th>

				<th width="50%">ชื่อชุดข้อสอบ</th>
				<th width="25%">สอบได้</th>
				<th width="20%">คะแนน</th>
	</tr>
			<tr>
				<?php
						$sql2 = "SELECT * FROM `manager_series_exam`
								INNER JOIN result_exam_std on manager_series_exam.id = result_exam_std.id_name_series_exam
								INNER JOIN manage_std on result_exam_std.id_std_result_exam = manage_std.id
								WHERE result_exam_std.id_std_result_exam = $id_std AND manager_series_exam.id_subject_series_exam = $subject_id
								AND status_result_exam_std = 1
								ORDER BY `manager_series_exam`.`name_series_exam` ASC";
						$result2 = mysqli_query($conn, $sql2);
						$number = 1;
						$ans_true = 0;
						$sum_point = 0;
						$show_pount = FALSE;
						while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
							$id =  $row2['id'];
							$id_subject_series_exam =  $row2['id_subject_series_exam'];
							$name_series_exam =  $row2['name_series_exam'];
							$teacher_id_series_exam =  $row2['teacher_id_series_exam'];
							$datetime_start_series_exam =  $row2['datetime_start_series_exam'];
							$datetime_end_series_exam =  $row2['datetime_end_series_exam'];
							$score_series_exam =  $row2['score_series_exam'];
							$point_result_exam =  $row2['point_result_exam'];
							$name_std =  $row2['name_std'];
							$id_std =  $row2['id_std'];
							$show_pount = TRUE;


							$arr_exam_result_exam = explode(',',$row2['exam_result_exam']);
							$arr_result_result_exam = explode(',',$row2['result_result_exam']);

						for ($i=0; $i < count($arr_result_result_exam); $i++) {
							$value = $arr_result_result_exam[$i];
							if($value == 1){
									$result_true = 1;
								}else{
									$result_true = 0;
								}
								$ans_true = ($ans_true+$result_true);

						}

				?>

      <td >
		<center><?php echo $number;?></center>
	  </td>
      <td><?php echo $name_series_exam;?></td>
      <td><center><?php echo $ans_true;?>/<?php echo $i;?></center></td>
      <td><center><?php echo $point_result_exam;?></center></td>
    </tr>
						<?php $number++; $ans_true = 0; $sum_point=$sum_point+$point_result_exam;} ?>
  </thead>
		</table>
		<?php if($show_pount==TRUE){ ?>
		<table style="font-size:14px;margin-bottom:10%" class="table table-bordered" width="100%">
			<tr>
					<th width="80%" >
					<center>รวม</center>
					</th>
				<th width="20%">
					<center><?php echo $sum_point;?></center>
				</th>
			</tr>
		</table>
<?php
}else if($show_pount == FALSE){
	?>
	<table style="font-size:14px;margin-bottom:10%" class="table table-bordered" width="100%">
		<tr>
				<th width="100%" >
				<center>ยังไม่มีผลสอบ</center>
				</th>
		</tr>
	</table>
	<?php
	}
}
 ?>

<footer class="page fixed-bottom text-center" style="background-color:red;">
  <a href="auth/logout_manager_Std.php"><button type="button" class="btn btn-danger btn-block">ออกจากระบบ</button></a>
</footer>



      <!-- /.container-fluid -->

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>



</body>

</html>
