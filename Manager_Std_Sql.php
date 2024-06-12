<?php
include'connect.php';
if(isset($_POST["add_std"])){
    $status = true;
    $id_std = $_POST["id_std"];
    $name_std = $_POST["name_std"];
    $last_std = $_POST["last_std"];
    $branch_id_std = $_POST["branch_id"];
    $genre_std = $_POST["genre_std"];
    $degree_std = $_POST["degree_std"];
    $section_std = $_POST["section_std"];
    $password_std = $_POST["password_std"];
    $gender_std = $_POST["gender_std"];

    $name = $name_std." ".$last_std;

    $sql = "SELECT * FROM `manage_std` WHERE `id_std` = $id_std";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
        $status = false;
    }
    if($status == false){
        echo "<script language=''>

								var r = confirm('ตรวจพบว่ามีบัญชีนักศึกษาในระบบแล้ว!');
								  if (r == true) {
									window.history.back();
								  } else {
									window.history.back();
								  }
								</script>";
        //header('Location: ' . $_SERVER['HTTP_REFERER']);
    }else{
        //$year_std = substr($id_std,0,2);
        $year_std = $degree_std."/".$section_std;
        $sql = "INSERT INTO `manage_std` (`id`, `id_std`,  `year_std`, `gender_std`, `name_std`, `password_std`, `branch_id_std`, `genre_std`, `degree_std`, `section_std`)
						VALUES (NULL, '$id_std', '$year_std', '$gender_std', '$name', '$password_std', '$branch_id_std', '$genre_std', '$degree_std', '$section_std');";

        if($conn->query($sql)===TRUE){
            header('Location:Manager_Std_List.php?genre_std='.$genre_std.'&branch_id='.$branch_id_std.'&degree_std='.$degree_std.'&section_std='.$section_std);
        }
    }

}
if(isset($_POST["update_std"])){
    $status = true;
    $id = $_POST["id"];
    $id_std = $_POST["id_std"];
    $gender_std = $_POST["gender_std"];
    $name_std = $_POST["name_std"];
    $last_std = $_POST["last_std"];
    $password_std = $_POST["password_std"];

    $branch_id_std = $_POST["branch_id"];
    $genre_std = $_POST["genre_std"];
    $degree_std = $_POST["degree_std"];
    $section_std = $_POST["section_std"];

    $name = $name_std." ".$last_std;

    $sql = "SELECT * FROM `manage_std` WHERE `id_std` = $id_std";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
        $status = false;
    }

    //$year_std = substr($id_std,0,2);
    $year_std = $degree_std."/".$section_std;
    $sql = "UPDATE `manage_std` SET
					`id_std` = '$id_std',
					`year_std` = '$year_std',
					`gender_std` = '$gender_std',
					`name_std` = '$name',
					`branch_id_std` = '$branch_id_std',
					`genre_std` = '$genre_std',
					`degree_std` = '$degree_std',
					`section_std` = '$section_std',
					`password_std` = '$password_std'
					WHERE id = '$id';";

    if($conn->query($sql)===TRUE){
        header('Location:Manager_Std_List.php?genre_std='.$genre_std.'&branch_id='.$branch_id_std.'&degree_std='.$degree_std.'&section_std='.$section_std);

        //echo '<script type="text/javascript">
        //						javascript:history.go(-1);
        //					</script>';
        //header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

}
if(isset($_GET["delete_std"])){
    $id_std = $_GET["id"];
    $sql = "DELETE FROM `manage_std` WHERE `manage_std`.`id` = $id_std";

    if($conn->query($sql)===TRUE){
        //header('Location: ' . $_SERVER['HTTP_REFERER']);
        echo '<script type="text/javascript">
												javascript:history.go(-1);
											</script>';
    }
}
if(isset($_POST["add_branch"])){
    $status = true;
    $Option_branch_type = $_POST["Option_branch_type"];
    $branch_name = $_POST["branch_name"];
    $genre_std = $_POST["branch_board"];
    $sql = "INSERT INTO `manager_branch` (`branch_id`, `branch_genre`, `branch_type`, `branch_name`) VALUES (NULL, '$genre_std', '$Option_branch_type', '$branch_name');";

    if($conn->query($sql)===TRUE){
        header('Location:Manager_Std_Page2.php?genre_std='.$genre_std);
    }
}
if(isset($_POST["update_branch"])){
    //$status = true;
    $branch_id = $_POST["branch_id"];
    $branch_name = $_POST["branch_name"];
    $Option_branch_type = $_POST["Option_branch_type"];

    $sql = "UPDATE `manager_branch` SET `branch_name` = '$branch_name',`branch_type` = '$Option_branch_type' WHERE `manager_branch`.`branch_id` = $branch_id;";

    if($conn->query($sql)===TRUE){
        //header('Location: ' . $_SERVER['HTTP_REFERER']);
        echo '<script type="text/javascript">
												javascript:history.go(-1);
											</script>';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

}
if(isset($_GET["delete_branch"])){
    $branch_id = $_GET["branch_id"];
    $sql = "DELETE FROM `manager_branch` WHERE `manager_branch`.`branch_id` = $branch_id";

    if($conn->query($sql)===TRUE){
        //header('Location: ' . $_SERVER['HTTP_REFERER']);
        echo '<script type="text/javascript">
												javascript:history.go(-1);
											</script>';
    }
}

if(isset($_POST["UploadCSVStd"])) {
    header("Content-Type: application/json");
    $dataJson = new stdClass();
    try{
        $dataJson->code = 200;
        $target_dir = "upload/csv/";
        $target_file = $target_dir . basename($_FILES["csvFileInput"]["name"]);
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if file is a CSV file
        if($fileType != "csv" && $fileType != "txt") {
            throw new ErrorException("Only .csv and .txt files are allowed.");
            exit();
        }

        // Move the file from temporary location to target directory
        if (!move_uploaded_file($_FILES["csvFileInput"]["tmp_name"], $target_file)) {
            throw new ErrorException("Sorry, there was an error uploading your file.");
            exit();
        }

        $csvFile = fopen($target_file, "r");
        $index = 0;
        if ($csvFile !== FALSE) {
            while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
                $id_std = $data[0];
                $name = $data[1];
                $branch_id_std = $data[2];
                $genre_std = $data[3];
                $degree_std = $data[4];
                $section_std = $data[5];
                $password_std = $data[6];
                $gender_std = $data[7];
                $year_std = $degree_std."/".$section_std;
                $sql = "INSERT INTO `manage_std` (`id`, `id_std`,  `year_std`, `gender_std`, `name_std`, `password_std`, `branch_id_std`, `genre_std`, `degree_std`, `section_std`)
					VALUES (NULL, '$id_std', '$year_std', '$gender_std', '$name', '$password_std', '$branch_id_std', '$genre_std', '$degree_std', '$section_std');";
                $conn->query($sql);
            }
            fclose($csvFile);
            unlink($target_file);
            $dataJson->error = null;
            $dataJson->data = null;
            $dataJson->msg = "successfully";
            echo json_encode($dataJson);
        } else {
            throw new ErrorException("Error reading the CSV file.");
        }
    }
    catch (Exception $ex){
        $dataJson->code = 500;
        $dataJson->error = $ex;
        $dataJson->data = null;
        $dataJson->msg = $ex->getMessage();
        echo json_encode($dataJson);
    }
}
?>
