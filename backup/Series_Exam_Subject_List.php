<?php
session_start();
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


if(isset($_GET["id_subject"])){
		$id_subject = $_GET["id_subject"];
		$branch_id_series_exam = $_GET["branch_id_series_exam"];
		$year_std_series_exam = $_GET["year_std_series_exam"];
	}else{
		header('Location:Series_Exam.php');
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
?>
<!DOCTYPE html>
<html lang="en" style="font-size:80%">

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
      <li class="nav-item active">
        <a class="nav-link" href="Series_Exam.php">
          <i class='fas'>&#xf0ae;</i>
          <span>ชุดข้อสอบ</span></a>
      </li>
	  <li class="nav-item">
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

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php">หน้าหลัก</a>
          </li>
		  <li class="breadcrumb-item">
            <a href="Series_Exam.php">ชุดข้อสอบ</a>
          </li>
		  <?php
		  $sql4 = "SELECT `name_subject` FROM `manager_subject` WHERE `id`= $id_subject";
			$result4 = mysqli_query($conn, $sql4);
			while ($row4 = mysqli_fetch_array($result4,MYSQLI_ASSOC)){
			$name_subject =  $row4['name_subject'];
							}
		  ?>
          <li class="breadcrumb-item active"><?php echo $name_subject;?></li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <form action="FPDF/index.php" target="_blank" method="POST">
              <i class='fas'>&#xf0ae;</i>
				<?php echo $name_subject;?>
				<b>
				<?php
				$sql3 = "SELECT * FROM `manager_branch` WHERE `branch_id` = $branch_id_series_exam";
							$result3 = mysqli_query($conn, $sql3);
							while ($row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC)){
							$branch_id =  $row3['branch_id'];
							$branch_name =  $row3['branch_name'];
							}
				echo $branch_name;
				?>
				ห้อง
				<?php echo $year_std_series_exam;?>
				</b>
              <a href="Series_Exam_Manager.php?id_subject=<?php echo $id_subject; ?>&branch_id_series_exam=<?php echo $branch_id_series_exam; ?>&year_std_series_exam=<?php echo $year_std_series_exam; ?>" ><button type="button" class="btn btn-success">เพิ่มชุดข้อสอบ</button></a>
              <input hidden type="text" name="name_subject" value="<?php echo $name_subject; ?>"/>
              <input hidden type="text" name="id_subject_series_exam" value="<?php echo $id_subject; ?>"/>
              <input hidden type="text" name="branch_name" value="<?php echo $branch_name; ?>"/>
              <input hidden type="text" name="branch_id" value="<?php echo $branch_id; ?>"/>
              <input hidden type="text" name="year_std" value="<?php echo $year_std_series_exam; ?>"/>
              <button type="submit" style="position: absolute; right: 0;" class="btn btn-warning mr-2"><i class="fa fa-print" aria-hidden="true"> ปริ้น</i></button>
          </form>
        </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
					<th width="5%"><center>ลำดับ</center></th>
                    <th width="15%">ชื่อชุดข้อสอบ</th>
                    <th width="15%">ชื่ออาจารย์ผู้ออกข้อสอบ</th>
                    <th width="27%">เวลาในการสอบ</th>
                    <th width="8%">คะแนนสอบ</th>
                    <th width="8%">สถานะ</th>
                    <th width="8%">ดูผลสอบ</th>
                    <th width="7%">แก้ไข</th>
                    <th width="7%">ลบ</th>
                  </tr>
                </thead>
                <tbody>
				<?php
					if($status_teacher == 1){
					$sql1 = "SELECT * FROM `manager_series_exam`
							 INNER JOIN manager_branch on manager_branch.branch_id = manager_series_exam.branch_id_series_exam
							 WHERE id_subject_series_exam = $id_subject AND `year_std_series_exam`= '$year_std_series_exam'
               AND `branch_id_series_exam` = '$branch_id_series_exam'
							 ORDER BY `manager_series_exam`.`name_series_exam` ASC";
						}else if($status_teacher == 2){
							$sql1 = "SELECT * FROM `manager_series_exam`
									INNER JOIN manager_branch on manager_branch.branch_id = manager_series_exam.branch_id_series_exam
									WHERE manager_series_exam.`teacher_id_series_exam` = $data_id_teacher
									AND id_subject_series_exam = $id_subject AND `year_std_series_exam`= '$year_std_series_exam'
                  AND `branch_id_series_exam` = '$branch_id_series_exam'
									ORDER BY `manager_series_exam`.`name_series_exam` ASC";
							}
              echo $branch_id_series_exam;
						$result1 = mysqli_query($conn, $sql1);
						$number = 1;
						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
							$id =  $row1['id'];
							$id_subject_series_exam =  $row1['id_subject_series_exam'];
							$branch_name =  $row1['branch_name'];
							$name_series_exam =  $row1['name_series_exam'];
							$teacher_id_series_exam =  $row1['teacher_id_series_exam'];
							$datetime_start_series_exam =  $row1['datetime_start_series_exam'];
							$datetime_end_series_exam =  $row1['datetime_end_series_exam'];
							$score_series_exam =  $row1['score_series_exam'];
							$year_std_series_exam =  $row1['year_std_series_exam'];

							$list_series_exam = explode(',',$row1['list_series_exam']);
							for ($num_list_series_exam=1; $num_list_series_exam < count($list_series_exam); $num_list_series_exam++){}

							$score_series_exam = ($score_series_exam*$num_list_series_exam);

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


							}
				?>
                  <tr>
                    <td><center><b><?php echo $number; ?></b></center></td>
                    <td><?php echo $name_series_exam; ?></td>
                    <td><?php echo $name_teacher; ?></td>
                    <td>
					<b>เริ่มสอบ <?php echo DateThai($Date_Time_Start)?></b><br>
					<b>สิ้นสุด <?php echo DateThai($Date_Time_End)?></td><b>
					<td><?php echo $num_list_series_exam." ข้อ <br>".$score_series_exam." คะแนน"; ?></td>
					<td>
					<?php
						if(DateTimeDiff($dateEnd." ".$TimeEnd,$dateNow) >= 0 )
							{
								echo '<font color="red"><b>ปิดสอบ</b></font>';
							}
							else if(DateTimeDiff($dateStart." ".$TimeStart,$dateNow) < 0 )
							{
								echo '<font color="gray"><b">ยังไม่เปิดให้สอบ</b></font>';
							}
							else
							{
								echo '<font color="green"><b>เปิดสอบ</b></font>';
							}
					?>
					</td>
					<td>
						<center>
						  <a href="Series_Exam_Show_Point.php?id_series_exam=<?php echo $id; ?>"><button type="button" class="btn btn-info"><i style="font-size:24px" class="fa">&#xf06e;</i></button></a>
						</center>
					</td>
					<td>
						<center>
							<a href="Series_Exam_Manager.php?edit&id_subject=<?php echo $id_subject;?>&id_series_exam=<?php echo $id;?>"><button type="button" class="btn btn-warning"><i style='font-size:24px' class='fas'>&#xf303;</i></button></a>
						</center>
					</td>
					<td>
						<center>
							<a onclick="return buttonDelete<?php echo $number; ?>()" href="Series_Exam_Manager_Sql.php?id_series_exam=<?php echo $id; ?>&delete_series_exam"><button type="button" class="btn btn-danger"><i style='font-size:24px' class='fas'>&#xf2ed;</i></button></a>
						</center>
					</td>
                  </tr>
				<?php $number++; } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>



		<div class="container">
  <!-- Trigger the modal with a button -->

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		  <h5 class="modal-title">เพิ่มวิชา</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
		<form action="layer3.php" method="GET">

          <div class="form-group">
		  <label>รหัสวิชา</label>
            <div class="form-label-group">
              <input type="text"  class="form-control"  name="" required="required" autofocus="autofocus"></input>
            </div>
          </div>

		  <div class="form-group">
		  <label>ชื่อวิชา</label>
            <div class="form-label-group">
              <input type="text"  class="form-control"  name="" required="required" autofocus="autofocus"></input>
            </div>
          </div>

		  <div class="form-group">
		  <label>ชื่ออาจารย์ผู้สอน</label>
            <div class="form-label-group">
              <input type="text"  class="form-control"  name="" required="required" autofocus="autofocus"></input>
            </div>
          </div>

		  <div class="container">
          <button type="submit" class="btn btn-success btn-block">บันทึกวิชา</button>
		  </div>




        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>
      </div>

    </div>
  </div>

  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		  <h5 class="modal-title">แก้ไขข้อมูล</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
		<form action="layer3.php" method="GET">

          <div class="form-group">
		  <label>รหัสวิชา</label>
            <div class="form-label-group">
              <input type="text"  class="form-control"  name="" required="required" autofocus="autofocus"></input>
            </div>
          </div>

		  <div class="form-group">
		  <label>ชื่อวิชา</label>
            <div class="form-label-group">
              <input type="text"  class="form-control"  name="" required="required" autofocus="autofocus"></input>
            </div>
          </div>

		  <div class="form-group">
		  <label>ชื่ออาจารย์ผู้สอน</label>
            <div class="form-label-group">
              <input type="text"  class="form-control"  name="" required="required" autofocus="autofocus"></input>
            </div>
          </div>

		  <div class="container">
          <button type="submit" class="btn btn-success btn-block">บันทึกข้อสอบ</button>
		  </div>




        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>
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
