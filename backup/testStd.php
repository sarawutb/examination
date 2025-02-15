<?php
session_start();
$_SESSION['LOGIN'] = $std_id;
include'connect.php';
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






        <!-- DataTables Example -->
<?php
if(isset($_GET["id_std"])){
					$id = $_GET["id_std"];
		$sql1 = "SELECT * FROM `manage_std` WHERE id_std = $id AND IsUse = 1;";
		$result1 = mysqli_query($conn, $sql1);
		while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
			$id_std =  $row1['id'];
			$std_id =  $row1['id_std'];
			$year_std =  $row1['year_std'];
		}
?>


					<!-- On rows -->
<table class="table table-bordered" width="100%">
  <thead>
  <?php
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
		manager_subject.id_subject,
		manager_series_exam.name_series_exam,
		manager_series_exam.score_series_exam
		FROM `manager_series_exam`
		INNER JOIN manager_teacher on manager_series_exam.teacher_id_series_exam = manager_teacher.id_teacher
		INNER JOIN manager_subject on  manager_series_exam.id_subject_series_exam = manager_subject.id
		WHERE `year_std_series_exam`= '$year_std' AND manager_series_exam.id not in
        (SELECT id_name_series_exam FROM result_exam_std WHERE id_std_result_exam = $id_std)";
		$result = mysqli_query($conn, $sql);
		$num = 1;
		while ($row1 = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
			$status = true;
						$id_series_exam =  $row1['id_series_exam'];
						$id_subject_series_exam =  $row1['id_subject_series_exam'];
						$name_subject =  $row1['name_subject'];
						$name_series_exam =  $row1['name_series_exam'];
						$datetime_start_series_exam =  $row1['datetime_start_series_exam'];
						$datetime_end_series_exam =  $row1['datetime_end_series_exam'];
						$name_teacher =  $row1['name_teacher'];
						$score_series_exam =  $row1['score_series_exam'];
						$id_subject =  $row1['id_subject'];

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


 // substr("59122420", 0, 2);
 if(DateTimeDiff($dateEnd." ".$TimeEnd,$dateNow) < 0 ){
	 $status1 = true;
  ?>
    <tr>
      <th width="70%" >
		<p><?php echo $id_subject." <b>วิชา</b> ".$name_subject;?></p
		<p><?php echo $name_teacher;?></p>
		<p><u><?php echo $name_series_exam;?></u></p>
		<p><u>เริ่มสอบ  <?php echo DateThai($Date_Time_Start)?><br>ถึง <?php echo DateThai($Date_Time_End)?></u></p>
		<p><?php echo $num_list_series_exam." ข้อ <br>".$score_series_exam." คะแนน"; ?></p>

	  <center style="">
		<?php
			if(DateTimeDiff($dateStart." ".$TimeStart,$dateNow) <= 0 ){
						echo '<button type="button" disabled style="font-size:12px" class="btn btn-secondary btn-block">ยังไม่เปิด</button>';
						}
							else{
								echo '<a href="testMobile.php?id='.$id_series_exam.'&id_std='.$id_std.'&std_id='.$std_id.'"><button type="button" style="font-size:12px" class="btn btn-success btn-block">เริ่มทำข้อสอบ</button></a>';
								}
		?>

	  </center>
	  </th>
    </tr>
<?php
}else if($status1 == false){ $status = false?>
<?php } } if($status == false){ ?>
<div style="" class="card-body">
<center>
<a href="Show_Point_Std_Mobile.php?show_subject&id_sid=<?php echo $id_std;?>"><button type="button" class="btn btn-primary btn-block">ดูผลสอบ</button></a>
</center>
</div>

<?php $status = true; } ?>
</thead>
</table>
<?php }else{ ?>

<div style="" class="card-body">
<center>
<a href="Show_Point_Std_Mobile.php?show_subject&id_sid=<?php echo $id_std;?>"><button type="button" class="btn btn-primary btn-block">ดูผลสอบ</button></a>
</center>
</div>
<?php } ?>

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
  <script src="js/demo/datatables-demo.js"></script>



</body>

</html>
