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

	if(isset($_GET["id_series_exam"])){
					$id_series_exam = $_GET['id_series_exam'];
	}else{
	header('Location:Series_Exam.php');
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

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php">หน้าหลัก</a>
          </li>
		  <li class="breadcrumb-item">
            <a href="Series_Exam.php">ชุดข้อสอบ</a>
          </li>
		  <?php
		  $status_result_exam_std = 3;
						$sql1 = "SELECT * FROM `manager_series_exam`
						INNER JOIN manager_subject on manager_series_exam.id_subject_series_exam = manager_subject.id
						INNER JOIN result_exam_std on manager_series_exam.id = result_exam_std.id_name_series_exam
						WHERE manager_series_exam.id = $id_series_exam";
						$result1 = mysqli_query($conn, $sql1);
						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
							$name_subject =  $row1['name_subject'];
							$name_series_exam =  $row1['name_series_exam'];
							$status_result_exam_std =  $row1['status_result_exam_std'];

							if($status_result_exam_std == 0){
								break;
							}

						}
						if($status_result_exam_std == 3){
								$sql1 = "SELECT * FROM `manager_series_exam`
								INNER JOIN manager_subject on manager_series_exam.id_subject_series_exam = manager_subject.id
								WHERE manager_series_exam.id = $id_series_exam";
								$result1 = mysqli_query($conn, $sql1);
								while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
									$name_subject =  $row1['name_subject'];
									$name_series_exam =  $row1['name_series_exam'];
								}
						}
		  ?>
          <li class="breadcrumb-item active">ผลสอบรายวิชา<?php echo $name_subject;?> / <?php echo $name_series_exam;?> </li>
        </ol>




        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
			<div class="row">
				<div class="col-sm-9">
				<i class='fas'>&#xf0ae;</i>
				<?php echo $name_series_exam;?>
				</div>
				<div class="col-sm-3">
					<p align="right">
					<?php if($status_result_exam_std == 0) {?>
						<a href="manager_send_exam_web.php?id_series_exam=<?php echo $id_series_exam; ?>&value=1&update_status"><button  type="button" class="btn btn-success">ยืนยันรายงานผลสอบ</button></a>
					<?php }else if($status_result_exam_std == 1){ ?>
						<a href="manager_send_exam_web.php?id_series_exam=<?php echo $id_series_exam; ?>&value=0&update_status"><button type="button" class="btn btn-danger"> ยกเลิกรายงานผลสอบ</button></a>
					<?php } ?>
						<!---<button  type="button" class="btn btn-warning"><i class="fa fa-print" aria-hidden="true"></i> ปริ้น</button>--->
					</p>
				</div>
			</div>
		  </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
					<th width="10%"><center>ลำดับ</center></th>
					<th width="30%">รหัสนักศึกษา</th>
                    <th width="20%">ชื่อ-นามสกุล</th>
                    <th width="10%">คะแนนสอบ</th>
                    <th width="10%">คะแนนสอบที่ได้</th>
                    <th width="10%"><center>สถานะ</center></th>
                    <th width="10%"><center>ลบ</center></th>
                  </tr>
                </thead>
                <tbody>
					<?php
						$number = 1;
						$ans_true = 0;
						$sql2 = "SELECT manage_std.id_std,manage_std.name_std,
								result_exam_std.status_result_exam_std,
								result_exam_std.id as id_result_exam_std,
								result_exam_std.point_result_exam,
								result_exam_std.result_result_exam
								FROM `result_exam_std`
								INNER JOIN manage_std on result_exam_std.id_std_result_exam = manage_std.id
								WHERE `id_name_series_exam` = $id_series_exam";
						$result2 = mysqli_query($conn, $sql2);
						while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
							$id =  $row2['id_result_exam_std'];
							$id_std =  $row2['id_std'];
							$name_std =  $row2['name_std'];
							$point_result_exam =  $row2['point_result_exam'];
							$status_exam_std =  $row2['status_result_exam_std'];

							$result_result_exam = explode(',',$row2['result_result_exam']);
							for ($num_result_result_exam=0; $num_result_result_exam < count($result_result_exam); $num_result_result_exam++){
								if($result_result_exam[$num_result_result_exam] == 1){
									$result_true = 1;
								}else{
									$result_true = 0;
								}
								$ans_true = ($ans_true+$result_true);
							}


					?>

                  <tr>
                    <td><center><b><?php echo $number; ?></b></center></td>
                    <td><?php echo $id_std; ?></td>
                    <td><?php echo $name_std; ?></td>
                    <td><?php echo $ans_true; ?>/<?php echo $num_result_result_exam; ?> ข้อ</td>
                    <td><?php echo $point_result_exam; ?></td>
                    <td>
						<center>
								<?php if($status_exam_std == 0) {?>
								<button disabled type="button" class="btn btn-secondary"></i> รอการยืนยัน</button>
							<?php }else{ ?>
								<button disabled type="button" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> ยืนยันแล้ว</button>
							<?php } ?>
						</center>
					</td>
					<td>
						<center>
							<?php if($status_exam_std == 0) {?>
								<a href="manager_send_exam.php?id=<?php echo $id; ?>&id_series_exam=<?php echo $id_series_exam; ?>&delete_result_exam_std" onclick="return buttonDelete<?php echo $number; ?>();"><button type="button" class="btn btn-danger"><b>ลบ<b></button></a>
							<?php }else{ ?>
								<button disabled type="button" class="btn btn-danger"><b>ลบ<b></button></a>
							<?php } ?>
						</center>
					</td>
                  </tr>
					<?php $number++; $ans_true = 0; } ?>
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
	$sql = "SELECT * FROM `result_exam_std`
			INNER JOIN manage_std on result_exam_std.id_std_result_exam = manage_std.id
			WHERE `id_name_series_exam` = 25";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
  ?>

  <script>
	  function buttonDelete<?php echo $i;?>() {
	  var result = confirm("แน่ใจว่าต้องการลบ");
	  if (result==true) {
	   return true;
	  } else {
	   return false;
	  }
	}
  </script>
	<?php $i++;} ?>
