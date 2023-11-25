<?php
session_start();
  if ($_SESSION['id_teacher']) {
	 include("connect.php");
	 $id_teacher = $_SESSION['id_teacher'];
	 $status_teacher = $_SESSION['status_teacher'];
	 $branch_name = $_GET['branch_name'];
	 $branch_id = $_GET['branch_id'];
	 $genre_std = $_GET['branch_genre'];
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
          <li class="breadcrumb-item active">จัดการนักศึกษา</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
			<div class="card-header">
				<i class='far'>&#xf2bb;</i>
				<?php
				if($genre_std == 1){
					echo "ประกาศนียบัตรวิชาชีพ (ปวช.)";
				}else if($genre_std == 2){
					echo "ประกาศนียบัตรวิชาชีพชั้นสูง (ปวส.)";
				}
				?>
				<a href="#" data-toggle="modal" data-target="#myModal"><button type="button" class="btn btn-success">เพิ่มนักศึกษา</button></a>
			</div>
          <div class="card-body">
           <div class="container-fluid">
		   <b><?php echo $branch_name; ?>
			</b><br>

			<?php
			$sql1 = "SELECT DISTINCT `degree_std`,`section_std` FROM `manage_std` WHERE branch_id_std = '$branch_id' AND genre_std = '$genre_std' ORDER BY `manage_std`.`degree_std` ASC";
                    $result1 = mysqli_query($conn, $sql1);
					//$number = 1;
                    while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
                        $degree_std  =  $row1['degree_std'];
                        $section_std  =  $row1['section_std'];
			?>
				<a href="Manager_Std_List.php?genre_std=<?php echo $genre_std; ?>&branch_id=<?php echo $branch_id; ?>&degree_std=<?php echo $degree_std; ?>&section_std=<?php echo $section_std; ?>">ห้อง <?php echo $degree_std."/".$section_std; ?></a><br>
			<?php } ?>

		  <br>
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
		  <h5 class="modal-title">เพิ่มนักศึกษา</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
		<form action="Manager_Std_Sql.php" method="POST">
		<input hidden type="text" name="branch_id" value="<?php echo $branch_id; ?>" />
		<input hidden type="text" name="genre_std" value="<?php echo $genre_std; ?>" />

          <div class="form-group">
		  <label>รหัสนักศึกษา</label>
            <div class="form-label-group">
				<input type="text" class="form-control" id="" name="id_std" spellcheck="false" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
			</div>
          </div>

		  <div class="form-group">
		  <label for="inputEmail">คำนำหน้า</label>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input" name="gender_std" value="1" required="required"> นาย
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input" name="gender_std" value="2" required="required"> นางสาว
				</label>
			</div>
          </div>

		      <div class="form-group">
            <label>ชื่อ-นามสกุล</label>
		      <div class="row">
              <div class="col-sm-5">
                <div class="form-label-group">
                  <input type="text" class="form-control" name="name_std" required="required" autofocus="autofocus"></input>
                </div>
              </div>
              -
              <div class="col-sm-5">
                <div class="form-label-group">
                  <input type="text" class="form-control" name="last_std" required="required" autofocus="autofocus"></input>
                </div>
              </div>
          </div>
          </div>

		  <div class="form-group">
		  <label>ชั้นปี</label>
            <div class="form-label-group">
				          <input type="text" class="form-control" style="width:20%" name="degree_std" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
			      </div>
      </div>

		  <div class="form-group">
		  <label>ห้อง</label>
            <div class="form-label-group">
				<input type="text" class="form-control" style="width:20%" name="section_std" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
			</div>
          </div>

		  <div class="form-group">
		  <label>รหัสผ่าน</label>
            <div class="form-label-group">
              <input type="password"  class="form-control" id="show_hide_pass_add" name="password_std" required="required" autofocus="autofocus"></input>
            </div>
          </div>

		  <div class="form-group">
			<div class="checkbox">
				<label>
					<input type="checkbox" onclick="show_password_add()">
					แสดงรหัสผ่าน
				</label>
			</div>
		  </div>

		  <div class="container">
          <button type="submit" name="add_std" class="btn btn-success btn-block">บันทึก</button>
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

  <?php
  $i = 1;
	$sql = "SELECT * FROM `manage_std`";
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
