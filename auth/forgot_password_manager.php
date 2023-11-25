<?php
session_start();
include("../connect.php");
if(isset($_POST["check_email"])){
    $email = $_POST['Email'];
	
	$strSQL = "SELECT * FROM `manager_teacher` WHERE email_teacher='$email'";
    $result = mysqli_query($conn, $strSQL);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            $_SESSION["id_teacher"] = $row['id_teacher'];
            $_SESSION["email"] = $row['email_teacher'];
        }
        session_write_close();
        header("location:../Forgot_new_password.php");
    }else {
      echo ("<script language='JavaScript'>
                window.alert('ไม่พบอีเมลดังกล่าว');
                window.location.href='../Forgot_password.php';
             </script>");
    }
}
if(isset($_POST["confirm"])){
	$id = $_SESSION["id_teacher"];
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	if($password1 != $password2){
		echo ("<script language='JavaScript'>
                window.alert('รหัสผ่านไม่ตรงกัน');
                window.location.href='../Forgot_new_password.php';
             </script>");
	}
	else{
		$sql = "UPDATE `manager_teacher` SET `password_teacher` = '$password2' WHERE `manager_teacher`.`id_teacher` = $id;";
				if($conn->query($sql)===TRUE){
					session_start();
					session_destroy();
					header("location:../Login.php");
			}
	}
	
}
?>