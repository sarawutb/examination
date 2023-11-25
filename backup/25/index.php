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
<style>
.center {
  text-align: center;
}

.center h1 {
text-align: center;
  line-height: 6;
  display: inline-block;
  vertical-align: middle;
}
</style>

<body id="page-top">

<?php include("header.php"); ?>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
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

	<div class="container-fluid" width="100%">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">หน้าหลัก</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-12">
			<div class="card-header">
				ระบบข้อสอบออนไลน์
			</div>
          <div class="card-body">
				<div class="center">

					    <!--<img src="css/logo.png" width="" height="">-->
					  <!--<p style="font-size: 40px;">ยินดีต้อนรับเข้าสู่ระบบสอบออนไลน์ </p> -->
                                                                                                         <h5 style="border:2px solid DodgerBlue;">ยินดีต้อนรับเข้าสู่ระบบสอบออนไลน์</h5>
					<p style="font-size: 20px;">
					วิทยาลัยอาชีวศึกษาจุลมณีอุทุมพรพิสัย จังหวัดศรีสะเกษ
					</p>



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
	if($status_teacher == 1){
					$sql = "SELECT manager_subject.id,
					manager_subject.id_subject,
					manager_subject.name_subject,
					manager_subject.name_teacher_subject,
					manager_teacher.id_teacher,
					manager_teacher.name_teacher
					FROM manager_subject
					INNER JOIN manager_teacher ON manager_subject.name_teacher_subject=manager_teacher.id_teacher
					ORDER BY manager_teacher.`id_teacher` ASC";
				}else if($status_teacher == 2){
					$sql = "SELECT manager_subject.id,
							manager_subject.id_subject,
							manager_subject.name_subject,
							manager_subject.name_teacher_subject,
							manager_teacher.id_teacher,
							manager_teacher.name_teacher
							FROM manager_subject
							INNER JOIN manager_teacher ON manager_subject.name_teacher_subject=manager_teacher.id_teacher
							WHERE name_teacher_subject = $id_teacher
							ORDER BY manager_subject.id ASC";
							}
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		$name_subject =  $row['name_subject'];
  ?>

  <script>
	  function buttonDelete<?php echo $i;?>() {
	  var result = confirm("แน่ใจว่าต้องการลบวิชา <?= $name_subject; ?> ?");
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
