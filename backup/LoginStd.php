<?php 
  session_start();
  if(isset($_SESSION['id_std'])){
	 include("connect.php");
	 header("Location:testting_web.php?id_std=".$_SESSION["id_std"]);
	 //echo  $_SESSION['id_teacher'];
  }else {
	  session_destroy();
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

<body class="text-drak" style="
background-color: #0669E3;
  background-image: linear-gradient(to top right, #BEBEBE, #0669E3);">
<div class="container mx-auto mt-5">
<center style="padding-bottom:10px;">
<img src="css/logo.png"  width="130px" height="130px">
</center>
<div class="card">
	<center>
		<h4 class="card-header" style="background-color: #2a7ee6;color:white;">ระบบสอบออนไลน์ V1.0</h4>
	</center>

	<div class="card-body">
    <form action="auth/login_manager_std.php" method="POST" class="needs-validation" novalidate>
          <div class="form-group">
              <input type="text" name="id_std" class="form-control" placeholder="กรอกรหัสนักศึกษา" required="required" spellcheck="false" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
				<div class="invalid-feedback">
					ยังไม่กรอกรหัสนักศึกษา
				</div>
		  </div>
          <div class="form-group">
          <input type="password" name="password" id="show_hide_pass_login" class="form-control" placeholder="กรอกรหัสผ่าน" required="required">
			  <div class="invalid-feedback">
					ยังไม่กรอกรหัสผ่าน
			  </div>
          </div>
          <div class="form-group">
            <div class="checkbox">
            </div>
          </div>
	</div>
 </div>
		<div class="text-center" style="padding-top:30px;">
		  <input type="image" src="css/login.png" alt="Submit" width="120px" height="45px">
		</div>
    </form>

<center style="padding-top:20px;">
<font color="white"><p>!!!หากลืมรหัสผ่านติดต่ออาจารย์ผู้สอน</p></font>
</center>
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
  <script>
  (function() {
'use strict';
window.addEventListener('load', function() {
// Fetch all the forms we want to apply custom Bootstrap validation styles to
var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
var validation = Array.prototype.filter.call(forms, function(form) {
form.addEventListener('submit', function(event) {
if (form.checkValidity() === false) {
event.preventDefault();
event.stopPropagation();
}
form.classList.add('was-validated');
}, false);
});
}, false);
})();
  </script>

</body>

</html>
