<?php 
session_start();
if ($_SESSION['id_teacher']){
	 include("connect.php");
	 $id_teacher = $_SESSION['id_teacher'];
	 $email_teacher = $_SESSION['email'];
	 //echo $email_teacher;
  }else{
	session_start();
	session_destroy();
    header("location:Forgot_password.php");
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

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<style>
body {
  background-image: url('css/BG.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;  
  background-size: cover;
}
</style>

<body class="text-drak">
  <div class="container mx-auto mt-5">
<div class="card"><h2 class="card-header">ระบบข้อสอบออนไลน์</h2>  
	<div class="card-body">
    <form action="auth/forgot_password_manager.php" method="POST">
          <div class="form-group">
		   <label>ตั้งรหัสผ่านใหม่</label>
              <input type="password" name="password1" id="show_hide_pass_login1" class="form-control" placeholder="ใส่รหัสผ่าน" required="required">
          </div>
          <div class="form-group">
		   <label>ยืนยันรหัสผ่าน</label>
              <input type="password" name="password2" id="show_hide_pass_login2" class="form-control" placeholder="ยืนยันรหัสผ่านอีกครั้ง" required="required">
          </div>
          <div class="form-group">
            <div class="checkbox">
            </div>
          </div>
		  <div class="form-group">
			<div class="checkbox">
				<label>
					<input type="checkbox" onclick="show_password_login()">
					 แสดงรหัสผ่าน
				</label>
			</div>
		  </div>
          <button type="submit" name="confirm" class="btn btn-primary" >ยืนยัน</button>
          <a class="btn btn-success" href="Login.php">เข้าสู่ระบบ</a>
        </form>
  </div>
</div>
</div>


   

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script>
  function show_password_login() {
  var input = document.getElementById("show_hide_pass_login1");
    if(input.type === "password"){
      input.type = "text";
    }else{
      input.type = "password";
    }
var input = document.getElementById("show_hide_pass_login2");
    if(input.type === "password"){
      input.type = "text";
    }else{
      input.type = "password";
    }
  }
  </script>

</body>

</html>
