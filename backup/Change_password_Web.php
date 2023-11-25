<?php
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

  <div class="container mx-auto mt-5">
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
          </div>
		  
		<?php }else{ ?>
		<form action="manager_send_exam.php" method="POST">
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
		  <div class="float-right"> <button style="float-right" type="submit" name="change_pass_web" class="btn btn-primary" href="Forgot_new_password.php">ยืนยัน</button></div>
         
         
        </form>
		<?php } ?>
        <div class="text-center">
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
