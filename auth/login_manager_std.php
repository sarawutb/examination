<?php
    include("../connect.php");
    session_start();

    $id_std = $_POST['id_std'];
    $password = $_POST['password'];

	//echo $username."<br>";
	//echo $password."<br>";

    // isAdmin: 1=admin 0=user

	$strSQL = "SELECT * FROM `manage_std` WHERE id_std = '$id_std' AND password_std = '$password' AND IsUse = 1;";
    $result = mysqli_query($conn, $strSQL);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            $genre_std = $row['genre_std'];
            $degree_std = $row['degree_std'];
            $id = $row['id'];
            $id_std = $row['id_std'];
            $name_std = $row['name_std'];
        }

        // if($genre_std = '1' AND $degree_std > 3){
        //   echo ("<script language='JavaScript'>
        //             window.alert('รหัสนักศึกษาหรือรหัสผ่าน ไม่ถูกต้อง');
        //             window.history.back();
        //          </script>");
        // }else if($genre_std = '2' AND $degree_std > 2){
        //   echo ("<script language='JavaScript'>
        //             window.alert('รหัสนักศึกษาหรือรหัสผ่าน ไม่ถูกต้อง');
        //             window.history.back();
        //          </script>");
        // }else{
          $_SESSION["id"] = $id;
          $_SESSION["id_std"] = $id_std;
          $_SESSION["name_std"] = $name_std;
          $_SESSION["status"] = 2;
          session_write_close();
          header("location:../testting_web.php?id_std=".$_SESSION["id_std"]);
        // }

    }else {
      echo ("<script language='JavaScript'>
                window.alert('รหัสนักศึกษาหรือรหัสผ่าน ไม่ถูกต้อง');
                window.location.href='../LoginStd.php';
             </script>");
    }



 ?>
