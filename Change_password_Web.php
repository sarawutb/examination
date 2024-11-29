<?php
session_start();
if(isset($_SESSION['id_std'])){
	 include("connect.php");
	 $id_STD = $_SESSION['id'];
	 //echo $id_STD ;
  }else {
	  session_start();
	  session_destroy();
	  header("location:LoginStd.php");
  }
$id_std = $_GET['id_std'];
if(isset($_GET['true'])){
	if($_GET['true'] == 'index'){
		$value_true = 'index';
	}else{
		$value_true = 'true';
	}
}
if(isset($_GET['true2'])){
	$value_true = 'true';
}

if(isset($_GET['false2'])){
	$value_true = 'false2';
}
if(isset($_GET['false'])){
	$value_true = 'false';
}

$sql1 = "SELECT * FROM `manage_std` WHERE id = $id_STD AND IsUse = 1;";
			$result1 = mysqli_query($conn, $sql1);
			while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
				$id =  $row1['id'];
				$id_std =  $row1['id_std'];
				$num_id_std =  $row1['id_std'];
				$gender_std =  $row1['gender_std'];
				$name_std =  $row1['name_std'];
			}
			if($gender_std==1){
				$gender_std = "นาย";
			}else if($gender_std==2){
				$gender_std = "นางสาว";
			}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ระบบข้อสอบออนไลน์</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>
<style>

</style>

<body class="text-drak">
	<nav class="navbar navbar-expand navbar-dark fixed-top py-0" style="background-color: #2a7ee6;">

			<a class="navbar-brand mr-1" href="#">
				สอบออนไลน์ v1.0 <br>
				<?php echo $gender_std.$name_std; ?><br>
				<?php //echo "ชื่อ-สกุล : ".$gender_std.$name_std; ?>
				<?php echo "รหัสนักศึกษา : ".$id_std; ?>

					<h5 class="">

				 </h5>
			</a>

	    <!-- Navbar Search -->
	    <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

	    </div>

	    <!-- Navbar -->
	    <ul  style="margin-bottom:80px" class="navbar-nav ml-auto ml-md-0">

	      <li class="nav-item dropdown no-arrow">
	        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	          <button  class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
				  <i class="fas fa-bars"></i>
				</button>
	        </a>
	        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
						<a class="dropdown-item" href="Show_Point_Std.php?show_subject&id_sid=<?php echo $id_std;?>">ดูผลสอบ</a>
						<div class="dropdown-divider"></div>
	          <a class="dropdown-item" data-toggle="modal" data-target="#Logout" style="text-decoration: none;">ออกจากระบบ</a>
	       </li>
	    </ul>

	  </nav>

  <div class="container mx-auto" style="margin-top:150px">
    <div class="card">
      <div class="card-body">
        <div class="text-center mb-4">
          <h4>เปลี่ยนรหัสผ่าน</h4>
        </div>
		<?php
		if($value_true == 'true'){
		?>
          <div class="form-group">
              <h1><center>สำเร็จ</center></h1>
							<a href="testting_web.php?id_std=<?php echo $id_std; ?>"><button class="btn btn-success btn-block">ตกลง</button></a>
          </div>

		<?php }else{ ?>
		<form action="manager_send_exam_web.php" method="POST">
          <div class="form-group">
              <input hidden type="text" name="id_std" class="form-control" readonly value="<?php echo $id_std; ?>" placeholder="ใส่รหัสนักศึกษา" required ></input>
          </div>
		  <div class="form-group">
              <input type="text" name="pass_old" class="form-control" placeholder="รหัสผ่านเดิม" required ></input>
			  <font <?php if($value_true == 'false2' || $value_true == 'index'){echo "hidden";}?> color="red" size="2px"><p>*รหัสผ่านไม่ถูกต้อง<p></font>
          </div>
		  <div class="form-group">
              <input type="text" name="pass_new" class="form-control" placeholder="รหัสผ่านใหม่" required ></input>
			  </div>
		  <div class="form-group">
              <input type="text" name="pass_new2" class="form-control" placeholder="ยืนรหัสผ่านอีกครั้ง" required ></input>
              <font <?php if($value_true == 'false' || $value_true == 'index'){echo "hidden";} if($value_true == 'false2'){echo "";}?> color="red" size="2px"><p>*รหัสผ่านไม่ตรงกัน<p></font>
         </div>
				 <div class="float-center">
 					<button style="float-center" type="submit" name="change_pass" class="btn btn-success btn-block" href="Forgot_new_password.php">ยืนยัน</button>
 					<a style="float-center;text-decoration: none;color:white"  class="btn btn-danger btn-block" onclick="goBack()">ยกเลิก</a>
 				</div>
					<script>
						function goBack() {
						  window.history.back();
						}
						</script>
        </form>
		<?php } ?>

      </div>
    </div>
  </div>

	<!-- <footer class="page fixed-bottom text-center" style="background-color:red;">
		<a data-toggle="modal" data-target="#Logout" style="text-decoration: none;" href=""><button type="button" class="btn btn-danger btn-block">ออกจากระบบ</button></a>
	</footer> -->

	<div class="modal" id="Logout" style="margin-top : 250px">
				<div class="modal-dialog">
					<div class="modal-content">
						<!-- Modal Header -->
						<div class="modal-header">
							<h3>ออกจากระบบ</h3>
							<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
						</div>
						<!-- Modal body -->
						<div class="modal-body">
							<!-- <img src="right.png" class="img-responsive"> -->
							<h6 class="text-left">แน่ใจว่าต้องการออกจากระบบ ?</h6>
							<div class="text-right" trxt-align="right">
								<a style="text-decoration: none;color:red" type="button" data-dismiss="modal">ไม่ใช่</a>
								<a class="mr-2 ml-3" style="text-decoration: none;" href="auth/logout_manager_Std.php">ใช่<a>
							</div>
						</div>
					</div>
				</div>
			</div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
