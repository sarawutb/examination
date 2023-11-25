<?php
 	include("connect.php");

 // if(isset($_POST["branch"])){
	$branch =$_REQUEST["branch"];
	$degree =$_REQUEST["degree"];
	$branch_id =$_REQUEST["branch_id"];
	//$degree_after =$_REQUEST["degree_after"];

 	$sql2 = "SELECT DISTINCT `degree_std`,`section_std` FROM `manage_std` WHERE `branch_id_std` = $branch ORDER BY `manage_std`.`degree_std` ASC,`manage_std`.`section_std` + 0 ASC";
	$true = 0;
  $id_num = 1;
	$result2 = mysqli_query($conn, $sql2);
	while($row2 = mysqli_fetch_array($result2)) {
	$true = 1;
	$degree_std = $row2[0]."/".$row2[1];

  $list = (explode("/",$degree_std));
  $list_keys=array_rand($list,2);

  $level = $list[$list_keys[0]];
  $room = $list[$list_keys[1]];


  $inlineCheckbox = "inlineCheckbox".$id_num;
  echo '<div  class="form-check ml-3 test">';
  echo '<input ';
  $year_count = explode(',',$degree);
    for ($i_arr=0; $i_arr < count($year_count); $i_arr++) {
      $year_count_list = $year_count[$i_arr];
  if($degree_std == $year_count_list && $branch_id == $branch){
		echo " checked ";
	}
}
  echo ' class="form-check-input" name="year_std_series_exam[]" type="checkbox" id="'.$inlineCheckbox.'" value="'.$degree_std.'">
  <label class="form-check-label" for="'.$inlineCheckbox.'">ขั้นปีที่'.$level.' ห้อง '.$room.'</label>
  </div>';
	//echo"<option";
	// if($degree_std == $degree){
	// 	echo " selected ";
	// }
	//echo" value='$degree_std'>" .$degree_std."</option>";
	$id_num++; }
	if($true == 0){
		// echo"<option  value='$degree'>ไม่พบห้องเรียน</option>";
    echo '<b class="form-check ml-1" style="color:red">(ไม่พบห้องเรียน)</b>';
	}


 //}
 ?>
