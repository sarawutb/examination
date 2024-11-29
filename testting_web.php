<?php
session_start();
error_reporting(0);
if(isset($_SESSION['id_std'])){
	 include("connect.php");
	 $id_STD = $_SESSION['id'];
	 $_SESSION['term_std'] = null;
  }else {
	  session_start();
	  session_destroy();
	  header("location:LoginStd.php");
  }

	if(isset($_GET["id_std"])){
						$id = $_GET["id_std"];
			$sql1 = "SELECT * FROM `manage_std` WHERE id_std = $id AND IsUse = 1;";
			$result1 = mysqli_query($conn, $sql1);
			while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
				$id_std =  $row1['id'];
				$year_std =  $row1['year_std'];
				$branch_id_std =  $row1['branch_id_std'];
			}
			if($id_STD!=$id_std){
				session_start();
			  session_destroy();
			  header("location:LoginStd.php");
			}


function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate));
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strHour:$strMinute $strDay/$strMonthThai/$strYear";
	}

	function DateDiff($strDate1,$strDate2)
	 {
				return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 }
	 function TimeDiff($strTime1,$strTime2)
	 {
				return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
	 }
	 function DateTimeDiff($strDateTime1,$strDateTime2)
	 {
				return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
	 }


 // substr("59122420", 0, 2);

					$sql1 = "SELECT * FROM `manage_std` WHERE id = $id_STD AND IsUse = 1;";
								$result1 = mysqli_query($conn, $sql1);
								while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
									$id =  $row1['id'];
									$id_std =  $row1['id_std'];
									$num_id_std =  $row1['id_std'];
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
	<meta name="apple-mobile-web-app-capable" content="yes" />

  <title>ระบบสอบออนไลน์ v1.0</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
img{
	 max-width: 30%;
	 }
	 .modal-header{
	 border-bottom: 0px solid;
	 }
	 h1,p{
	 /* padding: 20px; */
	 }
	 p{
	 text-align: center;
	 }
	 .fa{
	 text-align: center;
	 font-size: 40px;
	 color: red;
	 }
	 .btn-primary{
	 margin: 20px auto;
	 display: block;
	 }
	 .close{
	 cursor: pointer;
	 }

pre { white-space:pre-wrap; word-wrap:break-word; overflow:auto; }
.button {
  border: none;
  color: white;
  padding: 16px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
}

.button1 {
  background-color: #4CAF50;
  color: black;
  border: 5px solid green;
}

.button1:hover {
  background-color: #a6d8a8;
  color: black;
}

.button2 {
  background-color: #DCDCDC;
  color: black;
  border: 5px solid #BEBEBE;
}

.button2:hover {
  background-color: #F5F5F5;
  color: white;
}
</style>
<body id="page-top" class="sidebar-toggled">
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
          <a class="dropdown-item" href="Show_Point_Std.php?show_subject&id_sid=<?php echo $id_std;?>">ดูผลสอบ</a>
					<div class="dropdown-divider"></div>
          <a class="dropdown-item" data-toggle="modal" data-target="#Logout" style="text-decoration: none;">ออกจากระบบ</a>
        </div>
      </li>
    </ul>

  </nav>
					<!-- On rows -->
<table style="font-size:16px;margin-top:115px;margin-bottom:0%" class="table table-bordered" width="100%">
  <thead>
  <?php
	$list_series_exam1 = null;
	$list_series_exam2 = null;
	$score_series_exam1 = 0;
	$score_series_exam2 = 0;
	$type_series_exam1 = null;
	$type_series_exam2 = null;
	$exam_count1 = 0;
	$exam_count2 = 0;
		$status = false;
		$status1 = false;
		$sql = "SELECT manager_series_exam.id as id_series_exam,
		manager_series_exam.name_series_exam,
		manager_series_exam.id_subject_series_exam,
		manager_series_exam.datetime_start_series_exam,
		manager_series_exam.datetime_end_series_exam,
		manager_series_exam.list_series_exam,
		manager_teacher.name_teacher,
		manager_subject.name_subject,
		manager_subject.term_subject,
		manager_subject.id_subject,
		manager_series_exam.name_series_exam,
		manager_series_exam.score_series_exam,
		manager_series_exam.approve_series_exam,
		manager_series_exam.type_series_exam
		FROM `manager_series_exam`
		INNER JOIN manager_subject on  manager_series_exam.id_subject_series_exam = manager_subject.id
		INNER JOIN manager_teacher on manager_teacher.id_teacher = manager_subject.name_teacher_subject
		WHERE year_std_series_exam LIKE '%$year_std%'
		AND manager_series_exam.branch_id_series_exam = '$branch_id_std'
		AND manager_series_exam.id not in
        (SELECT id_name_series_exam FROM result_exam_std WHERE id_std_result_exam = $id)
				ORDER BY `manager_subject`.`id_subject` ASC";
		$result = mysqli_query($conn, $sql);
		$num = 1;
		while ($row1 = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
			$status = true;
						$id_series_exam =  $row1['id_series_exam'];
						$id_subject_series_exam =  $row1['id_subject_series_exam'];
						$name_subject =  $row1['name_subject'];
						$term_subject =  $row1['term_subject'];
						$name_series_exam =  $row1['name_series_exam'];
						$datetime_start_series_exam =  $row1['datetime_start_series_exam'];
						$datetime_end_series_exam =  $row1['datetime_end_series_exam'];
						$name_teacher =  $row1['name_teacher'];
						$score_series_exam =  $row1['score_series_exam'];
						$type_series_exam_sql =  $row1['type_series_exam'];
						$id_subject =  $row1['id_subject'];
						$l_list_series_exam =  $row1['list_series_exam'];

						$approve_series_exam = $row1['approve_series_exam'];
						// echo "<br>";
						// echo "<br>";
						// echo "<br>";
						// echo "<br>";
						// echo "<br>";
						// echo "<br>";
						// echo "<br>";
						// echo "<br>";
						// echo "<br>";
						// echo "<br>";
						// echo "<br>";
						// echo "<br>";
						// echo "<br>";
						// echo "<br>";
						// echo "<br>";
						// echo $approve_series_exam;

						if(strstr($l_list_series_exam,";")){
						$list_series_exam = explode(';',$l_list_series_exam);
						$list_series_exam1 = $list_series_exam[0];
						$list_series_exam2 = $list_series_exam[1];
						$list_series_exam1 = explode(',',$list_series_exam1);
						$list_series_exam2 = explode(',',$list_series_exam2);

						$score_series_exam = explode(';',$score_series_exam);
						$score_series_exam1 = $list_series_exam[1];
						$score_series_exam2 = $list_series_exam[1];
						$score_series_exam1 = explode(',',$score_series_exam1);
						$score_series_exam2 = explode(',',$score_series_exam2);
					}else{
						$list_series_exam = explode(',',$l_list_series_exam);//เปลี่ยนเป็น score
						$score_series_exam = explode(';',$score_series_exam_sql);
					}

						if(strstr($type_series_exam_sql,";")){
						$type_series_exam_arr = explode(';',$type_series_exam_sql);
						$type_series_exam1 = $type_series_exam_arr[0];
						$type_series_exam2 = $type_series_exam_arr[1];
						$exam_count1 = count($list_series_exam1);
						$exam_count2 = count($list_series_exam2);

						$score_series_exam1 = $score_series_exam[0];
						$score_series_exam2 = $score_series_exam[1];
						$score_series_exam2 = explode(',',$score_series_exam2);

						$score_series_exam1 = $score_series_exam1*$exam_count1;
						$score_series_exam2 = array_sum($score_series_exam2);
					}else{
						if($type_series_exam_sql == 1){
							// echo "(1)";
							$type_series_exam1 = $type_series_exam_sql;
							$type_series_exam2 = null;
							$exam_count1 = count($list_series_exam);
							$exam_count2 = 0;
							$score_series_exam1 = $row1['score_series_exam']*$exam_count1;
							$score_series_exam2 = 0;

						}
						 if($type_series_exam_sql == 2){
							// echo "(2)";
							$type_series_exam1 = null;
							$type_series_exam2 = $type_series_exam_sql;
							$exam_count2 = count($list_series_exam);
							$exam_count1 = 0;
							$score_series_exam2 = explode(',',$row1['score_series_exam']);
							$score_series_exam2 = array_sum($score_series_exam2);
							$score_series_exam1 = 0;
						}
					}

							$date_time_StartCreate=date_create($datetime_start_series_exam);
							$dateStart =  date_format($date_time_StartCreate,"Y/m/d");
							$TimeStart =  date_format($date_time_StartCreate,"H:i");

							$Y_Start =  date_format($date_time_StartCreate,"Y");
							$m_Start =  date_format($date_time_StartCreate,"m");
							$d_Start =  date_format($date_time_StartCreate,"d");
							$H_Start =  date_format($date_time_StartCreate,"H");
							$i_Start =  date_format($date_time_StartCreate,"i");

							$date_time_EndCreate=date_create($datetime_end_series_exam);
							$dateEnd =  date_format($date_time_EndCreate,"Y/m/d");
							$TimeEnd =  date_format($date_time_EndCreate,"H:i");

							$Y_End =  date_format($date_time_EndCreate,"Y");
							$m_End =  date_format($date_time_EndCreate,"m");
							$d_End =  date_format($date_time_EndCreate,"d");
							$H_End =  date_format($date_time_EndCreate,"H");
							$i_End =  date_format($date_time_EndCreate,"i");

							date_default_timezone_set("Asia/Bangkok");
							$dateNow =  date("/m/d H:i");
							$TimeNow =  date("H:i");
							$Y_Now =  date("Y");
							$m_Now =  date("m");
							$d_Now =  date("d");
							$H_Now =  date("H");
							$i_Now =  date("i");

							$dateNow = ($Y_Now+543).$dateNow;


							if($i_Start == 0){
								$i_Start = 60;
							}
							if($i_End == 0){
								$i_End = 60;
							}

							$Date_Time_Start = $TimeStart.$dateStart;
							$Date_Time_End = $TimeEnd.$dateEnd;


 // substr("59122420", 0, 2);

 if(DateTimeDiff($dateEnd." ".$TimeEnd,$dateNow) < 0 && $approve_series_exam == 1){
	 $status1 = true;
  ?>
    <tr>
      <th width="100%" >
				<center>
				<?php
					if(DateTimeDiff($dateStart." ".$TimeStart,$dateNow) <= 0 ){
								 echo '<a data-toggle="modal" data-target="#close_exam'.$num.'" class="button button2" type="button" disabled style="width:100%;font-size:16px;text-decoration:none;border-radius:10px;">';
								}
									else{
										 echo '<a data-toggle="modal" data-target="#myModal'.$num.'" class="button button1 mx-1 my-3" style="width:100%; font-size:16px;text-decoration:none;border-radius:10px;" href="">';
										}
				?>
					<!-- <a class="button button1" style="text-decoration:none;border-radius:10px;" href="#"> -->
		<p><?php echo "<b>รายวิชา</b> ".$id_subject." ".$name_subject." ภาคเรียนที่ ".$term_subject;?></p>
		<p><?php echo "อ.".$name_teacher;?></p>
		<p><?php echo "(".$name_series_exam.")";?></p>
		<p><u>เริ่มสอบ  <?php echo DateThai($Date_Time_Start)?><br>ถึง <?php echo DateThai($Date_Time_End)?></u></p>
		<p><?php
		if($type_series_exam1 == 1){
			echo " (แบบปรนัย) ";
			echo $exam_count1." ข้อ ";
			echo $score_series_exam1." คะแนน";
		}
		if($type_series_exam2 == 2){
			echo " <br>(แบบอัตนัย) ";
			echo $exam_count2." ข้อ ";
			echo $score_series_exam2." คะแนน";
		}
		?></p>
		</a>
	</center>
	  </th>
    </tr>
		<div class="modal" id="myModal<?php echo $num; ?>" style="margin-top : 200px">
		      <div class="modal-dialog">
		        <div class="modal-content">
		          <!-- Modal Header -->
		          <div class="modal-header">
		            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
		          </div>
		          <!-- Modal body -->
		          <div class="modal-body text-center mb-5">
		            <!-- <img src="right.png" class="img-responsive"> -->
		            <h1>เริ่มทำข้อสอบ ?</h1>
		            <p>เมื่อกดตกลงเวลาจะเริ่มทันที</p>
		            <div class="btn-group mt-4">
		              <button type="button" class="btn btn-secondary btn-lg mr-2 rounded-lg" data-dismiss="modal">ยกเลิก</button>
									<a href="test_exam_type.php?type_series_exam=<?=$type_series_exam_sql?>&id=<?php echo $id_series_exam?>&id_std=<?php echo $id_std; ?>" type="button" class="btn btn-success btn-lg rounded-lg">ตกลง</a>
								</div>
		          </div>
		        </div>
		      </div>
		    </div>

				<div class="modal" id="close_exam<?php echo $num; ?>" style="margin-top : 200px">
				      <div class="modal-dialog">
				        <div class="modal-content">
				          <!-- Modal Header -->
				          <div class="modal-header pb-0">
					            <center><img src="css/close.png" class="img-responsive"></center>
				          </div>
				          <!-- Modal body -->
				          <div class="modal-body text-center">
				            <h2>ระบบยังไม่เปิดให้สอบ</h2>
				            <div class="btn-group mt-4">
				              <button type="button" class="btn btn-secondary btn-lg mr-2 rounded-lg" data-dismiss="modal">ปิด</button>
				              </div>
				          </div>
				        </div>
				      </div>
				    </div>
<?php
		}else if($status1 == false){ $status = false?>
		<?php }
$num++;	} print_r($type_series_exam);
	if($status == false){
		?>
<div style="margin-top:95px" class="card-body">
	<center>
		<a href="Show_Point_Std.php?show_subject&id_sid=<?php echo $id_std;?>"><button type="button" class="btn btn-primary"><image src="css/showpoint.png" height="25px"></image> ดูผลสอบ</button></a>
	</center>
</div>

<?php $status = true; } ?>
  </thead>
</table>
<?php }else{ ?>

<div style="margin-top:95px;" class="card-body">
	<center>
		<a href="Show_Point_Std.php?show_subject&id_sid=<?php echo $id_std;?>"><button type="button" class="btn btn-primary"><image src="css/showpoint.png" height="25px"></image> ดูผลสอบ</button></a>
	</center>
</div>
<?php } ?>



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

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script> -->
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script> -->

</body>
</html>
