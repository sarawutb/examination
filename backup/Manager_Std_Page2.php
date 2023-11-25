<?php
session_start();
  if ($_SESSION['id_teacher']) {
	 include("connect.php");
	 $id_teacher = $_SESSION['id_teacher'];
	 $status_teacher = $_SESSION['status_teacher'];
	 $genre_std = $_GET['genre_std'];
   $branch_board  = $genre_std;
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

			<?php if($status_teacher == 1){ ?>
			<a href="#" data-toggle="modal" data-target="#myModal"><button type="button" class="btn btn-success">เพิ่มสาขา</button></a>
			<?php } ?>
			</div>
          <div class="card-body">

		  <div class="container-fluid">
  <div class="row">




			<?php
			$sql = "SELECT DISTINCT branch_type FROM manager_branch WHERE branch_genre = $genre_std";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                        $branch_type	  =  $row['branch_type'];
			?>

<div class="col-sm-4" style="">
				 <b><?php
				 if($branch_type == "1"){echo "อุตสาหกรรม";}
				 else if($branch_type == "2"){echo "พาณิชยกรรม";}
				 else if($branch_type == "3"){echo "อุตสาหกรรมการท่องเที่ยว";}
				 else if($branch_type == "4"){echo "บริหารธุระกิจ";}
				 ?>
			</b><br>
			<?php
			$sql1 = "SELECT * FROM `manager_branch` WHERE `branch_genre` = $genre_std AND `branch_type` = $branch_type";
                    $result1 = mysqli_query($conn, $sql1);
					$number = 1;
                    while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
                        $branch_id  =  $row1['branch_id'];
                        $branch_type	  =  $row1['branch_type'];
                        $branch_name	  =  $row1['branch_name'];
			?>
			<?php if($status_teacher == 1){ ?>
			<a class="" data-toggle="modal" data-target="#myModal<?php echo $branch_id; ?>" href="#" style='font-size:24px'> <i class='far fa-edit'></i></a>
			<?php } ?>
			<a href="Manager_Std_Page3.php?branch_genre=<?php echo $genre_std; ?>&branch_id=<?php echo $branch_id; ?>&branch_name=<?php echo $branch_name; ?>"><?php echo $number.".) ".$branch_name; ?></a>
			<br>

					<!-- Modal -->
  <div class="modal fade" id="myModal<?php echo $branch_id; ?>" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		  <h5 class="modal-title">แก้ไข</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
		<form action="Manager_Std_Sql.php" method="POST">
		<input hidden name="branch_id" value="<?php echo $branch_id; ?>"/>
          <div class="form-group">
		  <label>คณะ</label>
            <div class="form-label-group">
			<?php if($genre_std == 1){ ?>
			<select name="Option_branch_type" class="form-control" id="" required="required">
			  <option  value="">===เลือกคณะ===</option>
			  <option <?php if($branch_type == 1){echo "selected";}; ?> value="1">อุตสาหกรรม</option>
			  <option <?php if($branch_type == 2){echo "selected";}; ?> value="2">พาณิชยกรรม</option>
			  <option <?php if($branch_type == 3){echo "selected";}; ?> value="3">อุตสาหกรรมการท่องเที่ยว</option>
			</select>
			<?php }else if($genre_std == 2){ ?>
			<select name="Option_branch_type" class="form-control" id="" required="required">
			  <option value="">===เลือกคณะ===</option>
			  <option <?php if($branch_type == 1){echo "selected";}; ?> value="1">อุตสาหกรรม</option>
			  <option <?php if($branch_type == 4){echo "selected";}; ?> value="4">บริหารธุระกิจ</option>
			</select>
			<?php } ?>
			</div>
          </div>

		  <div class="form-group">
		  <label>ชื่อสาขา</label>
            <div class="form-label-group">
              <input type="text" class="form-control" name="branch_name" required="required" value="<?php echo $branch_name; ?>" autofocus="autofocus"></input>
            </div>
          </div>


		  <div class="container">
          <button type="submit" name="update_branch" class="btn btn-primary btn-block">อัพเดท</button>
          <a href="Manager_Std_Sql.php?delete_branch&branch_id=<?php echo $branch_id ?>" onclick="return btnDelete<?php echo $number;?>()" class="btn btn-danger btn-block">ลบ</a>
		  </div>

        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>
      </div>

    </div>
  </div>
			<?php $number++; } ?>

		  <br>
		  </div>
			<?php } ?>

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
		  <h5 class="modal-title">เพิ่มคณะ</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
		<form action="Manager_Std_Sql.php" method="POST">
		<input hidden name="branch_board" value="<?php echo $branch_board; ?>"/>
          <div class="form-group">
		  <label>คณะ</label>
            <div class="form-label-group">
			<?php if($branch_board == 1){ ?>
			<select name="Option_branch_type" class="form-control" id="" required="required">
			  <option value="">===เลือกคณะ===</option>
			  <option value="1">อุตสาหกรรม</option>
			  <option value="2">พาณิชยกรรม</option>
			  <option value="3">อุตสาหกรรมการท่องเที่ยว</option>
			</select>
			<?php }else if($branch_board == 2){ ?>
			<select name="Option_branch_type" class="form-control" id="" required="required">
			  <option value="">===เลือกคณะ===</option>
			  <option value="1">อุตสาหกรรม</option>
			  <option value="4">บริหารธุระกิจ</option>
			</select>
			<?php } ?>
			</div>
          </div>

		  <div class="form-group">
		  <label>ชื่อสาขา</label>
            <div class="form-label-group">
              <input type="text"  class="form-control" name="branch_name" required="required" autofocus="autofocus"></input>
            </div>
          </div>


		  <div class="container">
          <button type="submit" name="add_branch" class="btn btn-success btn-block">บันทึก</button>
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

	  <?php
	  $sql = "SELECT DISTINCT branch_type FROM manager_branch WHERE branch_genre = $genre_std";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                        $branch_type	  =  $row['branch_type'];
  $x = 1;
	$sql1 = "SELECT * FROM `manager_branch` WHERE `branch_genre` = $genre_std AND `branch_type` = $branch_type";
	$result1 = mysqli_query($conn, $sql1);
	while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
		$branch_name = $row1['branch_name'];
  ?>

  <script>
	  function btnDelete<?php echo $x;?>() {
	  var result = confirm("แน่ใจว่าต้องการลบ สาขา<?= $branch_name; ?> ?");
	  if (result==true) {
	   return true;
	  } else {
	   return false;
	  }
	}
  </script>
	<?php $x++;}
	}	?>

</body>

</html>
