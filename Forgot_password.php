<?php
session_start();
session_destroy();
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
body {
  background-image: url('css/BG.jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;  
  background-size: cover;
}
</style>

<html lang="en" style="font-size:80%">

  <div class="container mx-auto mt-5">
    <div class="card">
      <div class="card-header"><h2>ระบบข้อสอบออนไลน์</h2></div>
      <div class="card-body">
        <div class="text-center mb-4">
          <h4>ลืมรหัสผ่านใช่หรือไม่ ?</h4>
          <p>โปรดป้อนอีเมลเพื่อรีเซ็ตรหัสผ่าน</p>
        </div>
        <form action="auth/forgot_password_manager.php" method="POST">
          <div class="form-group">
              <input type="text" name="Email" class="form-control" placeholder="ใส่อีเมล" required="required" ></input>
          </div>
          <button type="submit" name="check_email" class="btn btn-primary" href="Forgot_new_password.php">รีเซ็ตรหัสผ่าน</button>
          <a class="btn btn-success" href="Login.php">เข้าสู่ระบบ</a>
        </form>
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
