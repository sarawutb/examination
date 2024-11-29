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
            <a href="Manager_Std.php">จัดการนักศึกษา</a>
          </li>
          <li class="breadcrumb-item active">ผลสอบ <?php echo $name_std; ?></li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header form-inline">
            <i class='fas'>&#xf0ae;</i>
				เลือกปีการศึกษา
			<!-- </div>
      <div class="form-group"> -->
        <select id="myTerm" name="term_subject" OnChange="show_term();" style="width:200px" class="form-control ml-2" required="required">
          <?php

          $term_subject = null;
            $sql2 = "SELECT DISTINCT `term_subject` ,
                    SUBSTRING_INDEX(`term_subject`,'/',1) AS term,SUBSTRING_INDEX(`term_subject`,'/',-1) AS term_y
                    FROM `result_exam_std`
                    INNER JOIN manager_series_exam on result_exam_std.id_name_series_exam = manager_series_exam.id
                    INNER JOIN manager_subject on manager_series_exam.id_subject_series_exam = manager_subject.id
                    WHERE result_exam_std.id_std_result_exam = $id_std;";
                      $result2 = mysqli_query($conn, $sql2);
                      while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)) {
                $term_subject = $row2['term_subject'];

                if($_SESSION['term_std'] == null){
                  $_SESSION['term_std'] = $term_subject;
                }
          ?>
          <!-- <option <?php if(isset($_GET["branch_id_series_exam"])){if($branch_id_series_exam == $branch_id){echo "selected";}}
          else if(isset($_GET["edit"])){if($branch_id_series_exam == $branch_id){echo "selected";}}
          ?> value="<?php echo $branch_id;?>"><?php echo $branch_name;?></option> -->
          <option
          <?php if($_SESSION['term_std'] == $term_subject){echo "selected";}
          ?> value="<?php echo $term_subject; ?>"><?php echo $term_subject;?></option>
          <?php }
          if($term_subject == null){
               echo "<option>ไม่พบข้อมูล</option>";
        }

        ?>
        </select>
      </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                    <th width="10%"><center>ลำดับ</center></th>
                    <th width="15%">รหัสวิชา</th>
                    <th width="35%">รายวิชา</th>
                    <th width="30%">อาจารย์ผู้สอน</th>
                    <th width="10%"><center>ดูผลสอบ</center></th>
                            </tr>
                   </thead>
                   <tbody id="show_list_term">
                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

  <!-- <p><?=$_SESSION['term_std'] ?></p> -->


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

  <script>
  // var i = document.getElementById("myTerm").selectedIndex;
  // var term = document.getElementsByTagName("option")[i].value;
  $.ajax({
    url: "show_term_std.php?", //เรียกใช้งานไฟล์นี้
    data: "id_std=<?=$id_std;?>&term_std=<?=$_SESSION['term_std']?>",  //ส่งตัวแปร
    type: "GET",
    async:false,
    success: function(data, status) {
        $("#show_list_term").html(data);
      },
  });

    function show_term() {
      var i = document.getElementById("myTerm").selectedIndex;
      var term = document.getElementsByTagName("option")[i].value;
      $.ajax({
        url: "show_term_std.php?", //เรียกใช้งานไฟล์นี้
        data: "id_std=<?=$id_std;?>&term_std="+term,  //ส่งตัวแปร
        type: "GET",
        async:false,
        success: function(data, status) {
            $("#show_list_term").html(data);
          },
      });
    }
  </script>

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
