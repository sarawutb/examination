<?php
 	include("connect.php");

 // if(isset($_POST["branch"])){
	$branch =$_REQUEST["branch"];
	$degree =$_REQUEST["degree"];
	$degree_after =$_REQUEST["degree_after"];

 	$sql2 = "SELECT DISTINCT `degree_std`,`section_std` FROM `manage_std` WHERE `branch_id_std` = $branch AND IsUse = 1 ORDER BY `manage_std`.`degree_std` ASC";
	$true = 0;

	$result2 = mysqli_query($conn, $sql2);
	while($row2 = mysqli_fetch_array($result2)) {
	$true = 1;

	$degree_std = $row2[0]."/".$row2[1];
	echo"<option";
	if($degree_std == $degree){
		echo " selected ";
	}
	echo" value='$degree_std'>" .$degree_std."</option>";
	}
	if($true == 0){
		echo"<option  value='$degree'>ไม่พบห้องเรียน</option>";
	}
 //}
 ?>
