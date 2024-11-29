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

	if(isset($_GET["id_sid"])){
					$id_std = $_GET['id_sid'];
	}else{
	header('Location:Manager_Std.php');
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
      <li class="nav-item">
        <a class="nav-link" href="Series_Exam.php">
          <i class='fas'>&#xf0ae;</i>
          <span>ชุดข้อสอบ</span></a>
      </li>
	  <li class="nav-item active">
        <a class="nav-link" href="Manager_Std.php">
          <i class='far'>&#xf2bb;</i>
          <span>จัดการนักเรียน</span></a>
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
			$sql1 = "SELECT * FROM `manage_std` WHERE `id`= $id_std AND IsUse = 1;";
			$result1 = mysqli_query($conn, $sql1);
					while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
					$name_std =  $row1['name_std'];
			}
		?>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php">หน้าหลัก</a>
          </li>
		  <li class="breadcrumb-item">
            <a href="Manager_Std.php">จัดการนักเรียน</a>
          </li>
          <li class="breadcrumb-item active">ผลสอบ <?php echo $name_std; ?></li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class='fas'>&#xf0ae;</i>
				เลือกรายวิชา
			</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
					<th width="10%"><center>ลำดับ</center></th>
					<th width="10%">รหัสวิชา</th>
					<th width="70%">รายวิชา</th>
					<th width="10%"><center>ดูผลสอบ</center></th>
                  </tr>
				 </thead>
				 <tbody>
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
				  <tr>
					<td><center><?php echo $number; ?></center></td>
					<td><?php echo $id_subject; ?></td>
					<td><?php echo $name_subject; ?></td>
					<td>
					<center>
						<a href="Manager_Std_Subject_Series_Exam.php?subject_id=<?php echo $subject_id;?>&id_std=<?php echo $id_std;?>"><button type="button" class="btn btn-info"><i style="font-size:24px" class="fa">&#xf06e;</i></button></a>
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

  <?php
  $i = 1;
	$sql = "SELECT * FROM `manage_std` WHERE IsUse = 1;";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
  ?>

  <script>
	  function buttonDelete<?php echo $i;?>() {
	  var result = confirm("แน่ใจว่าต้องการลบ ?");
	  if (result==true) {
	   return true;
	  } else {
	   return false;
	  }
	}
  </script>
	<?php $i++;} ?>

</body>

</html>
