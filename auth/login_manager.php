<?php
    include("../connect.php");
    session_start();

    $username = $_POST['Username'];
    $password = $_POST['Password'];
	
	//echo $username."<br>";
	//echo $password."<br>";

    // isAdmin: 1=admin 0=user
	
	$strSQL = "SELECT * FROM `manager_teacher` WHERE `email_teacher`='$username' AND `password_teacher`='$password'";
    $result = mysqli_query($conn, $strSQL);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            $_SESSION["id_teacher"] = $row['id_teacher'];
            $_SESSION["username"] = $row['email_teacher'];
            $_SESSION["status_teacher"] = $row['status_teacher'];
        }
        session_write_close();
        header("location:../index.php");
    }else {
      echo ("<script language='JavaScript'>
                window.alert('อีเมลหรือรหัสผ่าน ไม่ถูกต้อง');
                window.location.href='../Login.php';
             </script>");
    }

    

 ?>
