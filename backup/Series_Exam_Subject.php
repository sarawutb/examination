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
            <i class='fas'>&#xf0ae;</i>
				<?php echo $name_subject;?>
				<a href="Series_Exam_Manager.php?id_subject=<?php echo $id_subject; ?>" ><button type="button" class="btn btn-success">เพิ่มชุดข้อสอบ</button></a>
				</div>

		   <div class="card-body">
           <div class="container-fluid">
		   <b><?php echo "ห้องเรียน"; ?>
			</b><br>
			<?php
			$sql = "SELECT DISTINCT `branch_id_series_exam`,manager_branch.branch_name FROM `manager_series_exam`
					INNER JOIN manager_branch on manager_branch.branch_id = manager_series_exam.branch_id_series_exam
					WHERE id_subject_series_exam = $id_subject";
                    $result = mysqli_query($conn, $sql);
					//$number = 1;
                    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                        $branch_id_series_exam  =  $row['branch_id_series_exam'];
                        $branch_name  =  $row['branch_name'];

						echo $branch_name."<br>";

			$sql1 = "SELECT DISTINCT `branch_id_series_exam`,`year_std_series_exam`,manager_branch.branch_name
					FROM `manager_series_exam`
					INNER JOIN manager_branch on manager_branch.branch_id = manager_series_exam.branch_id_series_exam
					WHERE `id_subject_series_exam` = $id_subject AND `branch_id_series_exam` = $branch_id_series_exam
          ORDER BY `manager_series_exam`.`year_std_series_exam` ASC";
                    $result1 = mysqli_query($conn, $sql1);
					//$number = 1;
                    while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
                        $branch_id_series_exam  =  $row1['branch_id_series_exam'];
                        $year_std_series_exam  =  $row1['year_std_series_exam'];
			?>
				 <a href="Series_Exam_Subject_List.php?id_subject=<?php echo $id_subject; ?>&branch_id_series_exam=<?php echo $branch_id_series_exam; ?>&year_std_series_exam=<?php echo $year_std_series_exam; ?>"> ห้อง <?php echo $year_std_series_exam; ?></a><br>
					<?php } echo "<br>";}?>

		  <br>
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
