<?php
// $type_series_exam = $_GET['type_series_exam'];
// print_r($type_series_exam);
// echo implode(",",$type_series_exam);
$num_exam_value1 = null;
$num_exam_value2 = null;
$name_score_exam1 = null;
$name_score_exam2 = null;
$type_series_exam1 = null;
$type_series_exam2 = null;

if(isset($_GET['num_exam_value1'])){
  $num_exam_value1 = $_GET['num_exam_value1'];
  $num_exam_value1 = implode(",",$num_exam_value1);
}
if(isset($_GET['num_exam_value2'])){
  $num_exam_value2 = $_GET['num_exam_value2'];
  $num_exam_value2 = implode(",",$num_exam_value2);
}
if($num_exam_value1 != null && $num_exam_value2 == null){
  $num_exam_value = $num_exam_value1;
}else if($num_exam_value1 == null && $num_exam_value2 != null){
  $num_exam_value = $num_exam_value2;
}else if($num_exam_value1 != null && $num_exam_value2 != null){
  $num_exam_value = $num_exam_value1.";".$num_exam_value2;
}

// $num_exam_value = explode(";", $num_exam_value);
// $num_exam_value1 = $num_exam_value[0];
// $num_exam_value2 = $num_exam_value[1];

//////////////////////////////////////

$name_score_exam1 = null;
$name_score_exam2 = null;

if(isset($_GET['num_exam_value1'])){
  $name_score_exam1 = $_GET['name_score_exam1'];
  $name_score_exam1 = implode(",",$name_score_exam1);
}
if(isset($_GET['num_exam_value2'])){
  $name_score_exam2 = $_GET['name_score_exam2'];
  $name_score_exam2 = implode(",",$name_score_exam2);
}
if($name_score_exam1 != null && $name_score_exam2 == null){
  $name_score_exam = $name_score_exam1;
}else if($name_score_exam1 == null && $name_score_exam2 != null){
  $name_score_exam = $name_score_exam2;
}else if($name_score_exam1 != null && $name_score_exam2 != null){
  $name_score_exam = $name_score_exam1.";".$name_score_exam2;
}

// $name_score_exam = explode(";", $name_score_exam);
// $name_score_exam1 = $name_score_exam[0];
// $name_score_exam2 = $name_score_exam[1];

//////////////////////////////////////

if(isset($_GET['num_exam_value1'])){
  $type_series_exam1 = $_GET['type_series_exam1'];
  $type_series_exam1 = implode(",",$type_series_exam1);
}
if(isset($_GET['num_exam_value2'])){
  $type_series_exam2 = $_GET['type_series_exam2'];
  $type_series_exam2 = implode(",",$type_series_exam2);
}
if($type_series_exam1 != null && $type_series_exam2 == null){
  $type_series_exam = $type_series_exam1;
}else if($type_series_exam1 == null && $type_series_exam2 != null){
  $type_series_exam = $type_series_exam2;
}else if($type_series_exam1 != null && $type_series_exam2 != null){
  $type_series_exam = $type_series_exam1.";".$type_series_exam2;
}

// $type_series_exam = explode(";", $type_series_exam);
// $type_series_exam1 = $type_series_exam[0];
// $type_series_exam2 = $type_series_exam[1];

echo $type_series_exam;
echo "<br>";
echo $num_exam_value;
echo "<br>";
echo $name_score_exam;
echo "<br>";
// print_r($type_series_exam);
// echo implode(",",$type_series_exam);
?>
