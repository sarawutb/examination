<?php
session_start();
error_reporting(0);
  if ($_SESSION['id_teacher']) {
	 include("connect.php");
	 $id_teacher = $_SESSION['id_teacher'];
	 $status_teacher = $_SESSION['status_teacher'];
	 //echo $status_teacher;

	 $sql_teacher = "SELECT * FROM `manager_teacher` WHERE id_teacher=$id_teacher";
                    $result_teacher = mysqli_query($conn, $sql_teacher);
					$number = 1;
                    while ($row_teacher = mysqli_fetch_array($result_teacher,MYSQLI_ASSOC)) {
                        $data_id =  $row_teacher['id_teacher'];
                        $data_id_teacher =  $row_teacher['id_teacher'];
                        $data_name_teacher_subject =  $row_teacher['name_teacher'];
					}
	 //echo  $data_id_teacher;
  }else {
	session_destroy();
    header("location:Login.php");
  }

if(isset($_GET["subject_id"])){
					$subject_id = $_GET['subject_id'];
					$id_std = $_GET['id_std'];
	}else{
	header('Location:Manager_Std.php');
	}
function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
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
?>
<!DOCTYPE html>
<html lang="en" style="font-size:100%">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ระบบข้อสอบออนไลน์</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <?php include("header.php"); ?>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class='fas'>&#xf015;</i>
          <span>หนัาหลัก</span>
        </a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="Subject.php">
          <i class='far'>&#xf15c;</i>
          <span>รายวิชา</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Series_Exam.php">
          <i class='fas'>&#xf0ae;</i>
          <span>ชุดข้อสอบ</span></a>
      </li>
	  <li class="nav-item active">
        <a class="nav-link" href="Manager_Std.php">
          <i class='far'>&#xf2bb;</i>
          <span>จัดการนักศึกษา</span></a>
      </li>
	  <?php if($status_teacher == 1){ ?>
	  <li class="nav-item">
        <a class="nav-link" href="Manager_Teacher.php">
          <i class='fas'>&#xf508;</i>
          <span>จัดการอาจารย์</span></a>
      </li>
	  <?php } ?>
    </ul>

    <div id="content-wrapper">

	<div class="container-fluid">
	<?php
		$sql1 = "SELECT * FROM `manager_series_exam`
		INNER JOIN result_exam_std on manager_series_exam.id = result_exam_std.id_name_series_exam
		INNER JOIN manage_std on result_exam_std.id_std_result_exam = manage_std.id
		INNER JOIN manager_subject on manager_series_exam.id_subject_series_exam = manager_subject.id
		WHERE result_exam_std.id_std_result_exam = $id_std AND manager_series_exam.id_subject_series_exam = $subject_id";
		$result1 = mysqli_query($conn, $sql1);
				while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
        $gender_std =  $row1['gender_std'];
				$name_std =  $row1['name_std'];
				$name_std =  $row1['name_std'];
				$id =  $row1['id_std'];
				$name_subject =  $row1['name_subject'];
		}
        if($gender_std == 1){
          $gender_std = "นาย";
        }else if($gender_std == 2){
          $gender_std = "นางสาว";
        }
	?>

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php">หน้าหลัก</a>
          </li>
		  <li class="breadcrumb-item">
            <a href="Manager_Std.php">จัดการนักศึกษา</a>
          </li>
          <li class="breadcrumb-item active">ผลสอบ <?php echo $name_std; ?></li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
		<div class="card-header">
			<div class="row">
				<div class="col-sm-12">
				<i class='far'>&#xf2bb;</i>
				<b>ผลสอบ </b><u><?php echo $gender_std.$name_std; ?></u> <br><i class='far'>&#xf15c;</i><b> รายวิชา </b><u><?php echo $name_subject; ?></u>
				</div>
			<!---	<div class="col-sm-3">
					<p align="right">
						<button  type="button" class="btn btn-warning"><i class="fa fa-print" aria-hidden="true"></i> ปริ้น</button>
					</p>
				</div> --->
			</div>
		  </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
					<th width="5%"><center>ลำดับ</center></th>
                    <th width="15%">ชื่อชุดข้อสอบ</th>
					<th width="18%">ชื่อรายวิชา</th>
                    <th width="20%">ชื่ออาจารย์ผู้ออกข้อสอบ</th>
                    <th width="10%">คะแนนสอบ</th>
                    <th width="10%">คะแนนสอบที่ได้</th>
                  </tr>
                </thead>
                <tbody>
				<?php
        $exam_count1 = 0;
        $exam_count2 = 0;
        $ans_true = 0;
        $sum_all_point = 0;
        $sum_point = 0;
						$sql1 = "SELECT * FROM `manager_series_exam`
								INNER JOIN result_exam_std on manager_series_exam.id = result_exam_std.id_name_series_exam
								INNER JOIN manage_std on result_exam_std.id_std_result_exam = manage_std.id
								WHERE result_exam_std.id_std_result_exam = $id_std AND manager_series_exam.id_subject_series_exam = $subject_id
                ORDER BY `manager_series_exam`.`branch_id_series_exam` ASC, manager_series_exam.teacher_id_series_exam ASC";
						$result1 = mysqli_query($conn, $sql1);
						$number = 1;
						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
							$id =  $row1['id'];
							$id_subject_series_exam =  $row1['id_subject_series_exam'];
							$name_series_exam =  $row1['name_series_exam'];
							$teacher_id_series_exam =  $row1['teacher_id_series_exam'];
							$datetime_start_series_exam =  $row1['datetime_start_series_exam'];
							$datetime_end_series_exam =  $row1['datetime_end_series_exam'];
							$point_result_exam =  $row1['point_result_exam'];
							$name_std =  $row1['name_std'];
							$id_std =  $row1['id_std'];
              $result_result_exam = $row1['result_result_exam'];

              $score_series_exam =  $row1['score_series_exam'];
              $score_series_exam= explode(";",$score_series_exam);
              $score_series_exam1= $score_series_exam[0];

              if(strstr($row1['exam_result_exam'],";")){
                // echo "in1";
                $exam_result_exam = explode(';',$row1['exam_result_exam']);
                $result_result_exam = explode(';',$result_result_exam);
                $exam_result_exam1 = $exam_result_exam[0];
                $exam_result_exam2 = $exam_result_exam[1];
                $result_result_exam1 = $result_result_exam[0];
                $result_result_exam2 = $result_result_exam[1];
                $exam_count1 = count(explode(',',$exam_result_exam1));
                $exam_count2 = count(explode(',',$exam_result_exam2));
                $sum_result_result_exam = $result_result_exam1.",".$result_result_exam2;
                $result_result_exam = explode(',',$sum_result_result_exam);
              }else{
                // echo "in2";
                $exam_result_exam1 = $row1['exam_result_exam'];
                $result_result_exam = explode(',',$result_result_exam);
                $exam_result_exam2 = 0;
                $exam_count1 = count(explode(',',$exam_result_exam1));
                $exam_count2 = 0;
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
							$dateNow =  date("Y/m/d H:i");
							$TimeNow =  date("H:i");
							$Y_Now =  date("Y");
							$m_Now =  date("m");
							$d_Now =  date("d");
							$H_Now =  date("H");
							$i_Now =  date("i");

							if($i_Start == 0){
								$i_Start = 60;
							}
							if($i_End == 0){
								$i_End = 60;
							}




							$Date_Time_Start = $TimeStart.$dateStart;
							$Date_Time_End = $TimeEnd.$dateEnd;


							$sql2 = "SELECT * FROM `manager_subject` WHERE id = $id_subject_series_exam";
							$result2 = mysqli_query($conn, $sql2);
							while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
								$id_subject =  $row2['id'];
								$name_subject =  $row2['name_subject'];
							}

							$sql3 = "SELECT * FROM `manager_teacher` WHERE `id_teacher` = $teacher_id_series_exam";
							$result3 = mysqli_query($conn, $sql3);
							while ($row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC)){
							$name_teacher =  $row3['name_teacher'];
              $data_teacher_gender =  $row3['gender_teacher'];
              if($data_teacher_gender == 1){
                $teacher_gender = "นาย";
              }else if($data_teacher_gender == 2){
                $teacher_gender = "นาง";
              }else if($data_teacher_gender == 3){
                $teacher_gender = "นางสาว";
              }
							}
				?>
                  <tr>
                    <td><center><b><?php echo $number; ?></b></center></td>
                    <td><?php echo $name_series_exam; ?></td>
                    <td><?php echo $name_subject; ?></td>
                    <td><?php echo $teacher_gender.$name_teacher; ?></td>
					<td>
            <?php
            if($point_result_exam == null){
              echo "รอตรวจ";
            }else{
              echo $ans_true."/";
              echo $exam_count1+$exam_count2." ข้อ";
            }
            ?>
        </td>
					<td><?php
          if($point_result_exam == null){
            echo "รอตรวจ";
          }else{
            if(strstr($point_result_exam,";")){
							$point_result_exam= explode(";",$point_result_exam);
							$point_result_exam1= $point_result_exam[0];
							$point_result_exam2= $point_result_exam[1];
								$point_result_exam2= array_sum(explode(",",$point_result_exam2));
							// echo "- ปรนัย ".$point_result_exam1." คะแนน";
							// echo "<br>";
							// echo "- อัตนัย ".$point_result_exam2;
							$point_result_exam = ($point_result_exam1*$score_series_exam1)+$point_result_exam2;
							echo $point_result_exam." คะแนน";
						}else{
							// $point_result_exam = $point_result_exam*$num_result_result_exam;
							echo array_sum(explode(",", $point_result_exam * $score_series_exam1))." คะแนน";
						}

          } ?></td>
                  </tr>
				<?php $number++; $ans_true = 0; $sum_point=$sum_point+$point_result_exam;} ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>


	<?php include("footer.php"); ?>

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

  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>

<?php
  $i = 1;
	$sql = "SELECT * FROM `manager_series_exam`";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
	$name_series_exam =  $row['name_series_exam'];
  ?>
  <script>
	  function buttonDelete<?php echo $i;?>() {
	  var result = confirm("แน่ใจว่าต้องการชุดข้อสอบ <?php echo $name_series_exam; ?>?");
	  if (result==true) {
	   return true;
	  } else {
	   return false;
	  }
	}
  </script>
	<?php $i++;} ?>
