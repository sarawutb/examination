<?php
require_once 'include/db_functions.php';

// json response array
$response = array("error" => FALSE);

if (isset($_POST['id_std']) && isset($_POST['password'])) {

    // receiving the post params
    $is_std = $_POST['id_std'];
    $password = $_POST['password'];

    // get the user by email and password
    $user = getUserByEmailAndPassword($is_std, $password);

    if ($user != false) {
        // user is found
        $response["error"] = FALSE;
		$response["user"]["id"] = $user["id"];
        $response["user"]["id_std"] = $user["id_std"];
        if($user["gender_std"] == '1'){
          $gender = 'นาย';
        }else if($user["gender_std"] == '2'){
          $gender = 'นางสาว';
        }
        $response["user"]["name_std"] = $gender.$user["name_std"];

        echo json_encode($response);
    } else {
        // user is not found with the credentials
        $response["error"] = TRUE;
        $response["error_msg"] = "ป้อนรหัสนักศึกษาหรือรหัสผ่านผิด! กรุณาลองอีกครั้ง!";
        echo json_encode($response);
    }
} else {
    //required post params is missing
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters missing :(!";
    echo json_encode($response);
}
?>
