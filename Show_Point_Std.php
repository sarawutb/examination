<?php
session_start();
error_reporting(0);
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
        $gender_std = "นางสาว";
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
	<meta name="apple-mobile-web-app-capable" content="yes">

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

	<nav class="navbar navbar-expand navbar-dark fixed-top py-0" style="background-color: #2a7ee6;">

			<a class="navbar-brand mr-1" href="#">
				สอบออนไลน์ v1.0 <br>
				<?php echo $gender_std.$name_std; ?><br>
				<?php //echo "ชื่อ-สกุล : ".$gender_std.$name_std; ?>
				<?php echo "รหัสนักศึกษา : ".$id_std; ?>

					<h5 class="">

				 </h5>
			</a>

	    <!-- Navbar Search -->
	    <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

	    </div>

	    <!-- Navbar -->
	    <ul  style="margin-bottom:80px" class="navbar-nav ml-auto ml-md-0">

	      <li class="nav-item dropdown no-arrow">
	        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          <button  class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
				  <i class="fas fa-bars"></i>
				</button>
	        </a>
	        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
	          <a class="dropdown-item" href="Change_password_Web.php?true=index&id_std=<?php echo $id_std; ?>">เปลี่ยนรหัสผ่าน</a>

						<div class="dropdown-divider"></div>
	          <a class="dropdown-item" data-toggle="modal" data-target="#Logout" style="text-decoration: none;">ออกจากระบบ</a>
	      </li>
	    </ul>

	  </nav>
		<!-- On rows -->

<?php
if(isset($_GET["show_subject"])){
	$id_std = $_GET['id_sid'];
?>
<table style="font-size:14px;margin-top:127px;margin-bottom:10%" class="table table-bordered" width="100%">
  <thead>
  <tr>
				<th width="100%" class="card-header">
					<center><h6>ผลสอบรายวิชา</h6></center>
				</th>
				</tr>
  			<tr>
				<th width="100%" class="card-header">

					<div class=" form-inline">
					<label class="mr-2">ปีการศึกษา</label>
					<select style="width:200px" class="custom-select my-1 mr-sm-2" id="myTerm" onchange="show_term()">
				    <option selected>เลือกปีการศึกษา</option>
						<?php
							$sql2 = "SELECT DISTINCT SUBSTRING_INDEX(`term_subject`, '/', 1) AS term,SUBSTRING_INDEX(`term_subject`, '/', -1) AS term_y FROM `result_exam_std`
								INNER JOIN manager_series_exam on result_exam_std.id_name_series_exam = manager_series_exam.id
								INNER JOIN manager_subject on manager_series_exam.id_subject_series_exam = manager_subject.id
								WHERE result_exam_std.id_std_result_exam = $id_STD
								ORDER BY `term_y` ASC , `term` ASC";
							$result2 = mysqli_query($conn, $sql2);
							while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
								$term = $row2['term'].'/'.$row2['term_y'];
						?>
				    <option <?php if($_SESSION['term_std'] == $term){echo "selected";} ?> value="<?=$term?>"><?=$term?></option>
						<?php } ?>
				  </select>
				</div>
				</th>
				</tr>
				<thead id="show_list_term">
					<!-- <td>1</td> -->
				</thead>

  </thead>
</table>
<?php }
else if(isset($_GET["show_chapter"])){
$id_std = $_GET['id_sid'];
$subject_id = $_GET['subject_id'];
$sql = "SELECT * FROM `manager_subject`WHERE `id` = $subject_id ";
								 $result = mysqli_query($conn, $sql);
								 while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
										 $name_subject =  $row['name_subject'];
			}

?>
<center class="card-header py-2" style="margin-top:128px;">
			<h6>รายวิชา <?php echo $name_subject; ?></h6>
</center>
<table style="font-size:14px;margin-bottom:0%" class="table table-bordered" width="100%">
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
				$exam_count1 = 0;
				$exam_count2 = 0;
						$sql2 = "SELECT * FROM `manager_series_exam`
								INNER JOIN result_exam_std on manager_series_exam.id = result_exam_std.id_name_series_exam
								INNER JOIN manage_std on result_exam_std.id_std_result_exam = manage_std.id
								WHERE result_exam_std.id_std_result_exam = $id_STD AND manager_series_exam.id_subject_series_exam = $subject_id
								AND status_result_exam_std = 1
								ORDER BY `manager_series_exam`.`branch_id_series_exam` ASC, manager_series_exam.teacher_id_series_exam ASC";
						$result2 = mysqli_query($conn, $sql2);
						$number = 1;
						$sum_true = 0;
						$sum_point = 0;
						$sum_all_point = 0;
						$show_pount = FALSE;
						$i = 1;
						while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
							$ans_true = 0;
							$id =  $row2['id'];
							$id_subject_series_exam =  $row2['id_subject_series_exam'];
							$name_series_exam =  $row2['name_series_exam'];
							$teacher_id_series_exam =  $row2['teacher_id_series_exam'];
							$datetime_start_series_exam =  $row2['datetime_start_series_exam'];
							$datetime_end_series_exam =  $row2['datetime_end_series_exam'];
							$point_result_exam =  $row2['point_result_exam'];
							$result_result_exam = $row2['result_result_exam'];
							$name_std =  $row2['name_std'];
							$id_std =  $row2['id_std'];
							$show_pount = TRUE;

							$score_series_exam =  $row2['score_series_exam'];
              $score_series_exam= explode(";",$score_series_exam);
              $score_series_exam1= $score_series_exam[0];

							if(strstr($row2['exam_result_exam'],";")){
                // echo "in1";
                $exam_result_exam = explode(';',$row2['exam_result_exam']);
                $result_result_exam = explode(';',$result_result_exam);
                $exam_result_exam1 = $exam_result_exam[0];
                $exam_result_exam2 = $exam_result_exam[1];
                $result_result_exam1 = $result_result_exam[0];
                $result_result_exam2 = $result_result_exam[1];
                $exam_count1 = count(explode(',',$exam_result_exam1));
                $exam_count2 = count(explode(',',$exam_result_exam2));
                // echo "<br>";
                // print_r($result_result_exam1);
                // echo "<br>";
                // print_r($result_result_exam2);
                $sum_result_result_exam = $result_result_exam1.",".$result_result_exam2;
                $result_result_exam = explode(',',$sum_result_result_exam);
                // echo "<br>";
                // print_r($result_result_exam);
              }else{
                // echo "in2";
                $result_result_exam1 = $result_result_exam;
                $result_result_exam2 = $result_result_exam;
                $exam_result_exam1 = $row2['exam_result_exam'];
                $result_result_exam = explode(',',$result_result_exam);
                $exam_result_exam2 = 0;
                $exam_count1 = count(explode(',',$exam_result_exam1));
                $exam_count2 = 0;
                // echo "<br>";
                // print_r($exam_count1);
                // echo "<br>";
                // print_r($exam_count2);
              }

							for ($num_result_result_exam=0; $num_result_result_exam < count($result_result_exam); $num_result_result_exam++){
								if($result_result_exam[$num_result_result_exam] == 1){
									$result_true = 1;
								}else{
									$result_true = 0;
								}
								$ans_true = ($ans_true+$result_true);
							}

							$sum_all_point = $sum_all_point + $num_result_result_exam;


				?>

      <td >
		<center><?php echo $number;?></center>
	  </td>
      <td><?php echo $name_series_exam;?></td>
      <td>
				<center>
				<?php
				if($result_result_exam2 == null && $result_result_exam1 != null || $point_result_exam == null){
					echo "รอตรวจ";
				}else{
		 echo $ans_true; ?>/<?php echo $exam_count1+$exam_count2." ข้อ";
	 }
				?></center>
			</td>
      <td>
				<center>
					<?php
					if($point_result_exam == null){
						echo "รอตรวจ";
					}else{
						if(strstr($point_result_exam,";")){
							$point_result_exam= explode(";",$point_result_exam);
							$point_result_exam1= $point_result_exam[0];
							$point_result_exam2= $point_result_exam[1];
							if($point_result_exam2 == null){
								$point_result_exam2 = '<a href="Series_Exam_Show_Point_check.php?id_std='.$id_std.'&id_series_exam='.$id_series_exam.'&year_std_series_exam='.$year_std_series_exam.'&id_subject='.$id_subject.'"><button type="button" class="btn btn-primary"></i> ตรวจข้อสอบ</button></a>';
							}else{
								$point_result_exam2= array_sum(explode(",",$point_result_exam2));
							}
							// echo "- ปรนัย ".$point_result_exam1." คะแนน";
							// echo "<br>";
							// echo "- อัตนัย ".$point_result_exam2;
							$point_result_exam = ($point_result_exam1*$score_series_exam1)+$point_result_exam2;
							echo $point_result_exam;
						}else{
							if($result_result_exam2 == null && $result_result_exam1 != null){
								echo "รอตรวจ";
							}else{
								$point_result_exam = array_sum(explode(",",$point_result_exam));
								echo $point_result_exam;
							}
							// $point_result_exam = $point_result_exam*$num_result_result_exam;
						}
					}
					 ?>
			</center>
		</td>
    </tr>
						<?php $number++;  $sum_point=$sum_point+$point_result_exam; $sum_true = $sum_true+$ans_true;} ?>
  </thead>
		</table>
		<?php if($show_pount==TRUE){ ?>
		<table style="font-size:14px;margin-bottom:10%" class="table table-bordered table-primary" width="100%">
			<thead class="">
			<tr>
					<th width="80%" >
					<!-- <b style="text-align:right">รวม (<?php //echo $sum_true."/".$sum_all_point." ข้อ"; ?>)</b> -->
					<b style="float:right">รวม</b>
					</th>
				<th width="20%">
					<center><?php echo $sum_point;?></center>
				</th>
			</tr>
		</thead>
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

 <!-- <footer class="page fixed-bottom text-center" style="background-color:red;">
 	<a data-toggle="modal" data-target="#Logout" style="text-decoration: none;" href=""><button type="button" class="btn btn-danger btn-block">ออกจากระบบ</button></a>
 </footer> -->

 <div class="modal" id="Logout" style="margin-top : 250px">
 			<div class="modal-dialog">
 				<div class="modal-content">
 					<!-- Modal Header -->
 					<div class="modal-header">
 						<h3>ออกจากระบบ</h3>
 						<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
 					</div>
 					<!-- Modal body -->
 					<div class="modal-body">
 						<!-- <img src="right.png" class="img-responsive"> -->
 						<h6 class="text-left">แน่ใจว่าต้องการออกจากระบบ ?</h6>
 						<div class="text-right" trxt-align="right">
 							<a style="text-decoration: none;color:red" type="button" data-dismiss="modal">ไม่ใช่</a>
 							<a class="mr-2 ml-3" style="text-decoration: none;" href="auth/logout_manager_Std.php">ใช่<a>
 						</div>
 					</div>
 				</div>
 			</div>
 		</div>



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

	<script type="text/javascript">
			$.ajax({
				url: "show_term.php?", //เรียกใช้งานไฟล์นี้
				data: "std_id=<?=$id_STD;?>&term_std=<?=$_SESSION['term_std']?>",  //ส่งตัวแปร
				type: "GET",
				async:false,
				success: function(data, status) {
						$("#show_list_term").html(data);
					},
			});
		</script>
		<script>
				// var i = document.getElementById("myTerm").selectedIndex;
				// var term = document.getElementsByTagName("option")[i].value;

			function show_term() {
				var i = document.getElementById("myTerm").selectedIndex;
				var term = document.getElementsByTagName("option")[i].value;
				$.ajax({
					url: "show_term.php?", //เรียกใช้งานไฟล์นี้
					data: "std_id=<?=$id_STD;?>&term_std="+term,  //ส่งตัวแปร
					type: "GET",
					async:false,
					success: function(data, status) {
							$("#show_list_term").html(data);
						},
				});
			}
		</script>

</body>

</html>
