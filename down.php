<?php
date_default_timezone_set("Asia/Bangkok");
include ('connect.php');
$sql = "SELECT * FROM `manage_std`";
$result = $conn->query($sql);
$year = date("Y")+543;

  while($row = $result->fetch_assoc()) {
    $id_std = $row["id"];
    $degree_std = $row["degree_std"]-1;
    $section_std = $row["section_std"];

    $sql = "UPDATE `manager_status` SET `year_std` = $year-1 WHERE `manager_status`.`id` = 1;";
    $conn->query($sql);

    $sqlUPdegree = "UPDATE `manage_std` SET `year_std` = '$degree_std/$section_std', `degree_std` = '$degree_std' WHERE `manage_std`.`id` = $id_std;";
    $conn->query($sqlUPdegree);
  }



?>
<!-- <script type="text/javascript">
  history.back()
</script> -->
