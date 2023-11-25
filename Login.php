<?php
  session_start();
  //session_destroy();
  if(isset($_SESSION['id_teacher'])){
	 include("connect.php");
	 header("Location:index.php");
	 echo  $_SESSION['id_teacher'];
  }else {
	 // session_start();
	  session_destroy();
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
  background-size: cover;
}
</style>

<body class="text-drak">
<div class="container mt-5" style="padding : 0% 13%">

<div class="navbar-dark bg-dark card">
	<h2 class="card-header" style="color:white">ระบบข้อสอบออนไลน์</h2>
</div>
<div class="card" style="background-color:rgba(255,255,255,0.7);">
	<div class="card-body">
    <form action="auth/login_manager.php" method="POST">
          <div class="form-group">
		  <label>อีเมล</label>
              <input type="email" name="Username" class="form-control" placeholder="ใส่อีเมล" required="required">
          </div>
          <div class="form-group">
		   <label>รหัสผ่าน</label>
              <input type="password" name="Password" id="show_hide_pass_login" class="form-control" placeholder="ใส่รหัสผ่าน" required="required">
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
          <button type="submit" class="btn btn-success" >เข้าส่ระบบ</button>
          <a class="btn btn-link" href="Forgot_password.php">ลืมรหัสผ่าน?</a>
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
  var input = document.getElementById("show_hide_pass_login");
    if(input.type === "password"){
      input.type = "text";
    }else{
      input.type = "password";
    }
  }
  </script>

</body>

</html>
