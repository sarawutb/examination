<?php
include'connect.php';

$id = $_GET["id"];
$id_std = $_GET['id_std'];
//echo $id_std;

$sql = "SELECT * FROM `manager_series_exam` WHERE id = $id ";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		$id = $row['id'];
		$datetime_end_series_exam = $row['datetime_end_series_exam'];



            $arr_stop = explode(' ', $datetime_end_series_exam);
            $day = substr($arr_stop[0], 8,2);
            $month = substr($arr_stop[0], 5,2)+0;
            $year = substr($arr_stop[0], 0,4);
            if($month == 1){
                $month_name = "January";
            }elseif($month == 2){
                $month_name = "February";
            }elseif($month == 3){
                $month_name = "March";
            }elseif($month == 4){
                $month_name = "April";
            }elseif($month == 5){
                $month_name = "May";
            }elseif($month == 6){
                $month_name = "June";
            }elseif($month == 7){
                $month_name = "July";
            }elseif($month == 8){
                $month_name = "August";
            }elseif($month == 9){
                $month_name = "September";
            }elseif($month == 10){
                $month_name = "October";
            }elseif($month == 11){
                $month_name = "November";
            }else{
                $month_name = "December";
            }
            $times = $month_name." ".$day.", ".$year." ".$arr_stop[1];

        ?>

		<script>
// Set the date we're counting down to
//October 31, 2020 21:06:00
var countDownDate = new Date("<?php echo $times; ?>").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

	if(days > 0){
	document.getElementById("countDownTime").innerHTML = "เหลือเวลา " + days + "วัน " + hours + "ชั่วโมง "
		+ minutes + "นาที " + seconds + "วินาที ";
	}
	else if(days <= 0 && hours > 0){
		document.getElementById("countDownTime").innerHTML = "เหลือเวลา " + hours + "ชั่วโมง "
		+ minutes + "นาที " + seconds + "วินาที ";
	}
	else if(days <= 0 && hours <= 0 && minutes > 0){
		document.getElementById("countDownTime").innerHTML = "เหลือเวลา " + minutes + "นาที " + seconds + "วินาที ";
	}
	else if(days <= 0 && hours <= 0 && minutes <= 0){
		document.getElementById("countDownTime").innerHTML = "เหลือเวลา " + seconds + "วินาที ";
	}
  // Output the result in an element with id="countDownTime"


  // If the count down is over, write some text

  if (distance < 0) {
    clearInterval(x);
<?php
  $arr_list_series_exam = explode(',',$row['list_series_exam']);
				for ($i=1; $i <= count($arr_list_series_exam); $i++) {
						    //$id = $arr_list_series_exam[$i];
?>
    document.getElementById("countDownTime").innerHTML = "หมดเวลา";
	var checkBox1<?php echo $i; ?> = document.getElementById("customRadio1<?php echo $i; ?>");
	var checkBox2<?php echo $i; ?> = document.getElementById("customRadio2<?php echo $i; ?>");
	var checkBox3<?php echo $i; ?> = document.getElementById("customRadio3<?php echo $i; ?>");
	var checkBox4<?php echo $i; ?> = document.getElementById("customRadio4<?php echo $i; ?>");

  if (checkBox1<?php echo $i; ?>.checked != true && checkBox2<?php echo $i; ?>.checked != true
	&& checkBox3<?php echo $i; ?>.checked != true && checkBox4<?php echo $i; ?>.checked != true)
	{
	  checkBox1<?php echo $i; ?>.checked = true;
	  document.getElementById("customRadio1<?php echo $i; ?>").value = 0;
	}
	document.getElementById('frmSend').submit();
	<?php  } ?>
  }
}, 1000);
<?php  } ?>
</script>
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
<body id="page-top">
<header class="static-top fixed-top" style="background-color: #E60000;">
    <center style="padding-top:0px;"><font id="countDownTime" color="white" size="2px">เหลือเวลาทำข้อสอบ</font></center>
</header>
<form style="font-size:14px;margin-top: 17px;" id="frmSend" action="manager_send_exam.php" method="GET">
<input hidden type="text" name="send_exam" value="send_exam"/>

    <?php
	$i = 1;
	//$sql = "SELECT * FROM `manager_exam` WHERE `chapter_id_exam` = 77 order by RAND()";
	//$result = mysqli_query($conn, $sql);
	//while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
			//	$proposition_exam =  $row['proposition_exam'];
			//	$answer1_exam =  $row['answer1_exam'];
				//$answer2_exam =  $row['answer2_exam'];
			//	$answer3_exam =  $row['answer3_exam'];
			////	$answer4_exam =  $row['answer4_exam'];
		$test = "";
	$sql = "SELECT * FROM `manager_series_exam` WHERE id = $id ";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		$id = $row['id'];
		$list_series_exam = $row['list_series_exam'];





		?>
		<input hidden name="list_series_exam[]" value="<?php echo $list_series_exam; ?>"/>
		<input hidden name="id_std" value="<?php echo $id_std; ?>"/>
		<input hidden name="id" value="<?php echo $id; ?>"/>
		<?php
		$arr_list_series_exam = explode(',',$row['list_series_exam']);
				for ($i_arr=0; $i_arr < count($arr_list_series_exam); $i_arr++) {
						    $id = $arr_list_series_exam[$i_arr];
		$sql1 = "SELECT DISTINCT`chapter_id_exam`,
				manager_chapter.name_chapter,
				manager_chapter.objective_chapter,
				manager_chapter.num_chapter
				FROM `manager_exam`
				INNER JOIN manager_chapter on manager_exam.chapter_id_exam = manager_chapter.id
				WHERE manager_exam.id = $id";
	$result1 = mysqli_query($conn, $sql1);
	while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
		$name_chapter =  $row1['name_chapter'];
		$objective_chapter =  $row1['objective_chapter'];
		$num_chapter =  $row1['num_chapter'];

		if($test == $name_chapter){
			break;
		}
		$test = $name_chapter;
		?>
		<div class="card-header"><h5><u>วัตถุประสงค์บทที่ <?php echo $num_chapter; ?></u></h5><b><pre style="font-size:12px"><?php echo $objective_chapter; ?></pre></b></div>
	<?php } ?>
	<?php




	$sql1 = "SELECT * FROM `manager_exam`WHERE id = $id";
	$result1 = mysqli_query($conn, $sql1);
	while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
				$proposition_exam =  $row1['proposition_exam'];
				$proposition_img_exam =  $row1['proposition_img_exam'];
				$answer1_exam =  $row1['answer1_exam'];
				$answer1_img_exam =  $row1['answer1_img_exam'];
				$answer2_exam =  $row1['answer2_exam'];
				$answer2_img_exam =  $row1['answer2_img_exam'];
				$answer3_exam =  $row1['answer3_exam'];
				$answer3_img_exam =  $row1['answer3_img_exam'];
				$answer4_exam =  $row1['answer4_exam'];
				$answer4_img_exam =  $row1['answer4_img_exam'];
				$result_exam =  $row1['result_exam'];
				$chapter_id_exam =  $row1['chapter_id_exam'];

	?>
        <!-- DataTables Example -->

          <div class="card-header">
		  <center><img <?php if($proposition_img_exam==null){echo "hidden";} ?> src="upload/<?php echo $proposition_img_exam;?>" width="200px" height="200px"></center>
		  <?php echo $i; ?>). <?php echo $proposition_exam; ?>
			</div>

			<div class="card-body">
			<div class="custom-control custom-radio" type="button">
				<center><img <?php if($answer1_img_exam==null){echo "hidden";} ?> src="upload/<?php echo $answer1_img_exam;?>" width="150px%" height="150px"></center>
				<input required type="radio" id="customRadio1<?php echo $i; ?>" name="Ans[<?php echo $i; ?>]" class="custom-control-input" value="1">
				<label class="custom-control-label" for="customRadio1<?php echo $i; ?>"><?php echo $answer1_exam; ?></label>
				</input>
			</div>
			<hr>

			<center><img <?php if($answer2_img_exam==null){echo "hidden";} ?> src="upload/<?php echo $answer2_img_exam;?>" width="150px" height="150px"></center>
			<div class="custom-control custom-radio" type="button">
				<input required type="radio" id="customRadio2<?php echo $i; ?>" name="Ans[<?php echo $i; ?>]" class="custom-control-input" value="2">
				<label class="custom-control-label" for="customRadio2<?php echo $i; ?>"><?php echo $answer2_exam; ?></label>
				</input>
			</div>
			<hr>

			<center><img <?php if($answer3_img_exam==null){echo "hidden";} ?> src="upload/<?php echo $answer3_img_exam;?>" width="150px" height="150px"></center>
			<div class="custom-control custom-radio" type="button">
				<input required type="radio" id="customRadio3<?php echo $i; ?>" name="Ans[<?php echo $i; ?>]" class="custom-control-input" value="3">
				<label class="custom-control-label" for="customRadio3<?php echo $i; ?>"><?php echo $answer3_exam; ?></label>
				</input>
			</div>
			<hr>

			<center><img <?php if($answer4_img_exam==null){echo "hidden";} ?> src="upload/<?php echo $answer4_img_exam;?>" width="150px" height="150px"></center>
			<div class="custom-control custom-radio" type="button">
				<input required type="radio" id="customRadio4<?php echo $i; ?>" name="Ans[<?php echo $i; ?>]" class="custom-control-input" value="4">
				<label class="custom-control-label" for="customRadio4<?php echo $i; ?>"><?php echo $answer4_exam; ?></label>
				</input>
			</div>
			<hr>







          </div>

	<?php  }$i++;}}?>

		<div class="fixed-bottom">
			<input type="submit" value="ส่งข้อสอบ" class="btn btn-success btn-block"></input>
		</div>
		</form>
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
