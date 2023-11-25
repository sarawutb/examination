<script type="text/javascript">
					 function noBack(){
							 window.history.forward()
					 }

					 noBack();
					 window.onload = noBack;
					 window.onpageshow = function(evt) { if (evt.persisted) noBack() }
					 window.onunload = function() { void (0) }
			 </script>
<?php
include'connect.php';

$id_subject_get = $_GET["id"];
$id_std = $_GET['id_std'];


$sql = "SELECT * FROM `manager_series_exam` WHERE id = $id_subject_get ";
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
            $times = $month_name." ".$day.", ".($year-543)." ".$arr_stop[1];

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
	var checkBox1<?php echo $i; ?> = document.getElementById("radio1<?php echo $i; ?>");
	var checkBox2<?php echo $i; ?> = document.getElementById("radio2<?php echo $i; ?>");
	var checkBox3<?php echo $i; ?> = document.getElementById("radio3<?php echo $i; ?>");
	var checkBox4<?php echo $i; ?> = document.getElementById("radio4<?php echo $i; ?>");

  if (checkBox1<?php echo $i; ?>.checked != true && checkBox2<?php echo $i; ?>.checked != true
	&& checkBox3<?php echo $i; ?>.checked != true && checkBox4<?php echo $i; ?>.checked != true)
	{
	  checkBox1<?php echo $i; ?>.checked = true;
	  document.getElementById("radio1<?php echo $i; ?>").value = 0;
	}
	<?php  } ?>
	document.getElementById('frmSend').submit();
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
.radio-toolbar input[type="radio"] {
  opacity: 0;
  position: fixed;
  width: 0;
}

.radio-toolbar label {
    padding: 10px 30px;
    border: 2px solid #444;
    border-radius: 4px;
}

.radio-toolbar label:hover {
  background-color: white;
}

.radio-toolbar input[type="radio"]:focus + label {
    border: 2px dashed #444;
}

.radio-toolbar input[type="radio"]:checked + label {
    background-color: #a6d8a8;
}

pre { white-space:pre-wrap; word-wrap:break-word; overflow:auto; }
/* The container-fluid */
.container-fluid {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 10px;
  cursor: pointer;
  font-size: 14px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.container-fluid input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
	margin: 10px 3px;
  height: 20px;
  width: 20px;
  background-color: #eee;
  border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container-fluid:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.container-fluid input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.container-fluid input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.container-fluid .checkmark:after {
 	top: 6px;
	left: 6px;
	width: 8px;
	height: 8px;
	border-radius: 50%;
	background: white;
}
</style>
<body id="page-top">
<header class="static-top fixed-top" style="background-color: #E60000;">
    <center style="padding-top:0px;"><font id="countDownTime" color="white" size="2px">เหลือเวลาทำข้อสอบ</font></center>
</header>


<form style="font-size:14px;margin-top: 20px;padding-bottom:27px" id="frmSend" action="manager_send_exam_mobile.php" method="GET">
<input hidden type="text" name="send_exam" value="send_exam"/>
<input hidden type="text" name="type_series_exam" value="2"/>
<?php
$i = 1;
$test = "";
$sql = "SELECT * FROM `manager_series_exam`
INNER JOIN manager_subject on manager_subject.id = manager_series_exam.id_subject_series_exam
WHERE manager_series_exam.id = $id_subject_get";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
$id = $row['id'];
$list_series_exam = $row['list_series_exam'];
$ans_type_subject = $row['ans_type_subject'];

if($ans_type_subject == 1){
	$ans_type_subject = array("ก", "ข", "ค", "ง", "จ");
}else if($ans_type_subject == 2){
	$ans_type_subject = array("a", "b", "c", "d", "e");
}else if($ans_type_subject == 3){
	$ans_type_subject = array("1", "2", "3", "4", "5");
}

?>

<input hidden name="id_std" value="<?php echo $id_std; ?>"/>
<input hidden name="id" value="<?php echo $id_subject_get; ?>"/>
​<?php
$arr_list_series_exam = explode(',',$row['list_series_exam']);
shuffle($arr_list_series_exam);
$list_exam = implode(",",$arr_list_series_exam);
?>
		<input hidden name="list_series_exam[]" value="<?php echo $list_exam; ?>"/>
<?php
//	print_r ($arr_list_series_exam);
		for ($i_arr=0; $i_arr < count($arr_list_series_exam); $i_arr++) {
						$id = $arr_list_series_exam[$i_arr];
		$sql1 = "SELECT * FROM `manager_exam_annotated`WHERE id = $id";
		$result1 = mysqli_query($conn, $sql1);
		while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
					$proposition_exam =  $row1['proposition_exam'];
					$proposition_img_exam =  $row1['proposition_img_exam'];
					$chapter_id_exam =  $row1['chapter_id_exam'];


		?>
		<!-- DataTables Example -->
			<div style="font-size:17px;">
								<div class="card-header">
						<center ><img class="mb-2" style="border-radius: 10px;" <?php if($proposition_img_exam==null){echo "hidden";} ?> src="upload/<?php echo $proposition_img_exam;?>" height="200px"></center>
						<?php echo "ข้อที่ ".$i; ?>). <?php echo $proposition_exam; ?>
						</div>

							<div class="radio-toolbar" >
									<div class="card-body" >
											<textarea class="form-control" name="Ans[]" rows="10" cols="80"></textarea>

									</div>

							</div>


<?php  }
$i++;
}
}
?>
</div>


		<div class="fixed-bottom">
			<!-- <input type="submit" value="ส่งข้อสอบ" class="btn btn-success btn-block"><image src="css/send.png" height="10px"></image></input> -->
			<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-success btn-block">ส่งข้อสอบ <image src="css/ic-send.png" height="25px"></image></button>
		</div>
      <!-- /.container-fluid -->
			<div class="modal mt-5" id="myModal">
						<div class="modal-dialog">
							<div class="modal-content">
								<!-- Modal Header -->
								<!-- <div class="modal-header"> -->
									<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
								<!-- </div> -->
								<!-- Modal body -->
								<div class="modal-body text-center mb-2 mt-5">
									<!-- <img src="right.png" class="img-responsive"> -->
									<h2>แน่ใจว่าต้องการส่งข้อสอบ ?</h2>
									<div class="btn-group mt-4">
										<button type="button" class="btn btn-secondary btn-lg mr-2 rounded-lg" data-dismiss="modal">ยกเลิก</button>
										<button type="submit" data-toggle="modal" data-target="#myModal" class="btn btn-success btn-lg mr-2 rounded-lg">ยืนยัน</button>
									</div>
								</div>
							</div>
						</div>
					</div>

					</form>
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

	<script type="text/javascript" >
	//disable back button
	history.pushState(null, null, '');
	window.addEventListener('popstate', function(event) {
	  history.pushState(null, null, '');
	});
	</script>



</body>

</html>
