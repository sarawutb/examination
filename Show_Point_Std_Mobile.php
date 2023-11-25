<?php
include("connect.php");
$id_std = $_GET['id_std'];
// echo "id=".$id_std;
$sql1 = "SELECT * FROM `manage_std` WHERE id = $id_std ";
      $result1 = mysqli_query($conn, $sql1);
      while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
        $id_std =  $row1['id'];
        $gender_std =  $row1['gender_std'];
        $name_std =  $row1['name_std'];
      }
      if($gender_std==1){
        $gender_std = "นาย";
      }else if($gender_std==2){
        $gender_std = "นาง";
      }

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="user-scalable=no, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ระบบข้อสอบออนไลน์</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>

</head>
<style>
pre { white-space:pre-wrap; word-wrap:break-word; overflow:auto; }
</style>
<body id="page-top" style="font-size:13px">
<?php
if(isset($_GET["show_subject"])){
	$id_std = $_GET['id_std'];
  if(isset($_GET["id_STD"])){
    $id_std = $_GET["id_STD"];
    $sql1 = "SELECT * FROM `manage_std` WHERE id_std = $id_std ";
          $result1 = mysqli_query($conn, $sql1);
          while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
            $id_std =  $row1['id'];
          }
  }
?>
<table class="table table-bordered" width="100%">
  <thead>
  <tr>
				  <th width="100%" class="card-header">
					<h6><center>ผลสอบรายวิชา</center></h6>
				  </th>
				  <!-- <th width="30%" >
					<center>ผลสอบ</center>
				  </th> -->
				</tr>
				<tr>
				<?php
						$number = 1;
						$sql2 = "SELECT DISTINCT manager_subject.name_subject, manager_subject.id as subject_id , manager_subject.id_subject FROM `result_exam_std`
						INNER JOIN manager_series_exam on result_exam_std.id_name_series_exam = manager_series_exam.id
						INNER JOIN manager_subject on manager_series_exam.id_subject_series_exam = manager_subject.id
						WHERE result_exam_std.id_std_result_exam = $id_std
            ORDER BY `manager_subject`.`id_subject` ASC";
						$result2 = mysqli_query($conn, $sql2);
						while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
							$subject_id =  $row2['subject_id'];
							$name_subject =  $row2['name_subject'];
							$id_subject =  $row2['id_subject'];

				?>

      <td>
        <div class="list-group">
          <a style="color:black" class="list-group-item list-group-item-action list-group-item-warning" href="Show_Point_Std_Mobile.php?show_chapter&id_std=<?php echo $id_std;?>&subject_id=<?php echo $subject_id;?>">
            <!-- <button type="button" class="list-group-item list-group-item-action"> -->
            <?php echo $number.") ".$id_subject." ".$name_subject;?>
          <!-- </button> -->
          </a>
        </div>
      </td>
      <!-- <td>
	  <center>
	  <a href="Show_Point_Std_Mobile.php?show_chapter&id_std=<?php echo $id_std;?>&subject_id=<?php echo $subject_id;?>"><button type="button" style="font-size:12px" class="btn btn-primary">ดูผลสอบ</button></a>
	  </center>
	  </td> -->
    </tr>
						<?php
            $number++;
          }
          ?>
  </thead>
</table>
<?php }
else if(isset($_GET["show_chapter"])){
$id_std = $_GET['id_std'];
$subject_id = $_GET['subject_id'];
$sql = "SELECT * FROM `manager_subject`WHERE `id` = $subject_id ";
								 $result = mysqli_query($conn, $sql);
								 while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
										 $name_subject =  $row['name_subject'];
			}
?>
<center class="card-header py-2">
			<h6>รายวิชา <?php echo $name_subject; ?></h6>
</center>
<table class="table table-bordered" width="100%">
  <thead>
  <tr>
				  <th width="5%" >
					<center>ลำดับ</center>
				  </th>

				<th width="50%">ชื่อชุดข้อสอบ</th>
				<th width="25%">สอบได้</th>
				<th width="20%">คะแนน</th>
				<tr>
				<?php
        $sql2 = "SELECT * FROM `manager_series_exam`
            INNER JOIN result_exam_std on manager_series_exam.id = result_exam_std.id_name_series_exam
            INNER JOIN manage_std on result_exam_std.id_std_result_exam = manage_std.id
            WHERE result_exam_std.id_std_result_exam = $id_std AND manager_series_exam.id_subject_series_exam = $subject_id
            AND status_result_exam_std = 1
            ORDER BY `manager_series_exam`.`branch_id_series_exam` ASC, manager_series_exam.teacher_id_series_exam ASC";
        $result2 = mysqli_query($conn, $sql2);
        $number = 1;
        $ans_true = 0;
        $sum_point = 0;
        $sum_all_point = 0;
        $show_pount = FALSE;
        while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
          $id =  $row2['id'];
          $id_subject_series_exam =  $row2['id_subject_series_exam'];
          $name_series_exam =  $row2['name_series_exam'];
          $teacher_id_series_exam =  $row2['teacher_id_series_exam'];
          $datetime_start_series_exam =  $row2['datetime_start_series_exam'];
          $datetime_end_series_exam =  $row2['datetime_end_series_exam'];
          $score_series_exam =  $row2['score_series_exam'];
          $point_result_exam =  $row2['point_result_exam'];
          $name_std =  $row2['name_std'];
          $id_std =  $row2['id_std'];
          $show_pount = TRUE;



          						if($row2['result_result_exam'] != null){
                        $result_result_exam = explode(',',$row2['result_result_exam']);
            							for ($num_result_result_exam=0; $num_result_result_exam < count($result_result_exam); $num_result_result_exam++){
            							if($result_result_exam[$num_result_result_exam] == 1){
            									$result_true = 1;
            								}else{
            									$result_true = 0;
            								}
            								$ans_true = ($ans_true+$result_true);
            							}
                        }else{
                          $result_result_exam = $row2['result_result_exam'];
                        }
          							$sum_all_point = $sum_all_point + $num_result_result_exam;


    ?>

  <td >
<center><?php echo $number;?></center>
</td>
  <td><?php echo $name_series_exam;?></td>
  <td>
    <center>
    <?php
    	echo $ans_true; ?>/<?php echo $num_result_result_exam." ข้อ";
      // print_r($result_result_exam);
    ?></center>
  </td>
  <td>
    <center>
    <?php
    if(strstr($point_result_exam,",")){
      $point_result_exam= explode(",",$point_result_exam);
      $point_result_exam= array_sum($point_result_exam);
      echo $point_result_exam;
    }
    else{
      echo $point_result_exam;
    }
    ?>
  </center>
</td>
</tr>
        <?php $number++; $ans_true = 0; $sum_point=$sum_point+$point_result_exam;} ?>
</thead>
</table>
<?php if($show_pount==TRUE){ ?>
  <table style="font-size:14px;margin-top:-5%" class="table table-bordered table-primary" width="100%">
    <thead class="">
    <tr>
        <th width="80%" >
        <center>รวม(<?php echo $sum_all_point; ?>)</center>
        </th>
      <th width="20%">
        <center><?php echo $sum_point;?></center>
      </th>
    </tr>
  </thead>
  </table>
  <?php
  }else if($show_pount == FALSE){
  ?>
  <table style="border:none; border-collapse:collapse; cellspacing:0; cellpadding:0;font-size:14px;margin-top:0%"  width="100%">
  <tr>
      <th width="100%" >
      <center>ยังไม่มีผลสอบ</center>
      </th>
  </tr>
</table>
<?php
}
}
?>


  <!-- /.container-fluid -->

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Page level plugin JavaScript-->
<script src="vendor/datatables/jquery.dataTables.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin.min.js"></script>

<!-- Demo scripts for this page-->
<script src="js/demo/datatables-demo.js"></script>



</body>

</html>
