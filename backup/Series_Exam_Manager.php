<?php
session_start();
  if ($_SESSION['id_teacher']) {
	 include("connect.php");
	 $id_teacher = $_SESSION['id_teacher'];
	 $status_teacher = $_SESSION['status_teacher'];
	 //echo $status_teacher;

	 $sql_teacher = "SELECT * FROM `manager_teacher` WHERE id_teacher=$id_teacher";
                    $result_teacher = mysqli_query($conn, $sql_teacher);
					$number = 1;
                    while ($row_teacher = mysqli_fetch_array($result_teacher,MYSQLI_ASSOC)) {
                        $data_id =  $row_teacher['id_teacher'];
                        $data_id_teacher =  $row_teacher['id_teacher'];
                        $data_name_teacher_subject =  $row_teacher['name_teacher'];
					}
	 //echo  $data_id_teacher;
  }else {
	session_destroy();
    header("location:Login.php");
  }
?>

<!DOCTYPE html>
<html lang="en" style="font-size:80%">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ระบบข้อสอบออนไลน์</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">


</head>

<body id="page-top">

  <?php include("header.php"); ?>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class='fas'>&#xf015;</i>
          <span>หนัาหลัก</span>
        </a>
      </li>
	  <li class="nav-item active">
        <a class="nav-link" href="Subject.php">
          <i class='far'>&#xf15c;</i>
          <span>รายวิชา</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Series_Exam.php">
          <i class='fas'>&#xf0ae;</i>
          <span>ชุดข้อสอบ</span></a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="Manager_Std.php">
          <i class='far'>&#xf2bb;</i>
          <span>จัดการนักศึกษา</span></a>
      </li>
	  <?php if($status_teacher == 1){ ?>
	  <li class="nav-item">
        <a class="nav-link" href="Manager_Teacher.php">
          <i class='fas'>&#xf508;</i>
          <span>จัดการอาจารย์</span></a>
      </li>
	  <?php } ?>
    </ul>

	<?php

	if(isset($_GET["id_subject"])){
		$id_subject = $_GET["id_subject"];
		$manager = "add";
	}
	if(isset($_GET["branch_id_series_exam"])){
		$branch_id_series_exam = $_GET["branch_id_series_exam"];
	}
	if(isset($_GET["year_std_series_exam"])){
		$year_std_after = $_GET["year_std_series_exam"];
	}
	if(isset($_GET["id_series_exam"])){
		$id_series_exam = $_GET["id_series_exam"];

		$manager = "edit";
		$sql1 = "SELECT * FROM `manager_series_exam` WHERE id = $id_series_exam";
						$result1 = mysqli_query($conn, $sql1);
						$i = 1;
						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
							$series_exam_id =  $row1['id'];
							$branch_id_series_exam =  $row1['branch_id_series_exam'];
							$year_std_series_exam =  $row1['year_std_series_exam'];
							$name_series_exam =  $row1['name_series_exam'];
							$score_series_exam =  $row1['score_series_exam'];
							$datetime_start_series_exam =  $row1['datetime_start_series_exam'];
							$datetime_end_series_exam =  $row1['datetime_end_series_exam'];

							$list_series_exam =  $row1['list_series_exam'];

							//$arr_list_series_exam = explode(',',$row1['list_series_exam']);
							//for ($i=0; $i < count($arr_list_series_exam); $i++) {
							//$num_arr = $arr_list_series_exam[$i];
							//}
						}
	}else{
		$id_series_exam = "";
		$year_std_series_exam = "";
	}


	?>
    <div id="content-wrapper">
      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php">หน้าหลัก</a>
          </li>
          <li class="breadcrumb-item">
		    <a href="Series_Exam.php">ชุดข้อสอบ</a>
		  </li>
		  <?php
				$sql1 = "SELECT * FROM `manager_subject` WHERE id = $id_subject";
						$result1 = mysqli_query($conn, $sql1);
						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
							$id_subject =  $row1['id'];
							$name_subject =  $row1['name_subject'];
							$name_teacher_subject =  $row1['name_teacher_subject'];
							$genre_subject =  $row1['genre_subject'];
						}
						if($genre_subject == 1){
							$genre_subject_name = "ปวช";
						}else if($genre_subject == 2){
							$genre_subject_name = "ปวส";
						}
		  ?>
          <li class="breadcrumb-item active"><?php echo $name_subject;?></li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class='far'>&#xf044;</i>
				สร้างชุดข้อสอบ</div>
          <div class="card-body">
  <!-- Trigger the modal with a button -->

<form action="Series_Exam_Manager_Sql.php" method="POST">

		<input hidden type="text" name="id_subject" value="<?php echo $id_subject;?>">
		<input hidden type="text" name="teacher_id_series_exam" value="<?php echo $name_teacher_subject;?>">

		<div class="form-group">
		<label>ระดับการศึกษา</label>
			<input readonly style="width:200px" class="form-control" type="text" name="" value="<?php echo $genre_subject_name; ?>" required="required"></input>
			<input hidden style="width:200px" class="form-control" type="text" name="genre_series_exam" value="<?php echo $genre_subject; ?>" required="required"></input>
		</div>

		<div class="form-group">
				<label>ชื่อชุดข้อสอบ</label>
				<textarea rows="5" style="width:100%" type="text" name="name_series_exam" class="form-control" autofocus="autofocus" required="required"><?php if($manager=="edit"){echo $name_series_exam;} ?></textarea>
		</div>

		<div class="form-group">
			<label>สาขา</label>
			<select style="width:200px" name="branch_id_series_exam" id="branch" class="form-control" required="required">

				<?php
					$sql2 = "SELECT DISTINCT `branch_name`,`branch_id` FROM `manager_branch` WHERE `branch_genre` = $genre_subject ORDER BY `manager_branch`.`branch_name` ASC";
                    $result2 = mysqli_query($conn, $sql2);
                    while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)) {
							$branch_name = $row2['branch_name'];
							$branch_id = $row2['branch_id'];
				?>
				<option <?php if(isset($_GET["branch_id_series_exam"])){if($branch_id_series_exam == $branch_id){echo "selected";}}
        else if(isset($_GET["edit"])){if($branch_id_series_exam == $branch_id){echo "selected";}}
        ?> value="<?php echo $branch_id;?>"><?php echo $branch_name;?></option>
				<?php } ?>
			</select>
		</div>

		<div class="form-group">
			<label>ชั้นปี/ห้องเรียน</label>
			<?php
				if(isset($_GET["year_std_series_exam"])){
				$year_std_after = $_GET["year_std_series_exam"];
				?>
				<select style="width:200px" name="year_std_series_exam" id="degree" class="form-control" required="required">
					<option  value="<?php echo $year_std_after; ?>"><?php echo $year_std_after; ?></option>
				</select>
				<?php
				}else{ ?>
				<select style="width:200px" name="year_std_series_exam" id="degree" onclick="enable()" class="form-control" required="required"></select>
				<?php }
			?>

		</div>


		<!---<div class="form-group">
			<label>รหัสปีการศึกษา</label>
			<select style="width:300px" name="year_std_series_exam" class="form-control"  >
				<option value="">เลือกรหัสปีการศึกษา</option>
				<?php
					//$sql2 = "SELECT DISTINCT `year_std` FROM `manage_std` ORDER BY `manage_std`.`year_std` ASC";
                   // $result2 = mysqli_query($conn, $sql2);
                  //  while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)) {
						//	$year_std = $row2['year_std'];
				?>
				<option <?php //if($manager=="edit"){if($year_std == $year_std_series_exam){echo "selected";}} ?> value="<?php //echo $year_std;?>"><?php //echo $year_std;?></option>
				<?php// } ?>
			</select>
		</div>--->

		<div class="form-group">
				<label>คะแนนข้อละ</label>
				<input style="width:200px" type="text" name="name_score_exam" class="form-control" value="<?php if($manager=="edit"){echo $score_series_exam;} ?>"   autofocus="autofocus" spellcheck="false" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required="required"></input>
		</div>

		<div class="form-group">
			<div class="form-inline">
			<label for="">เวลา/วัน/เดือน/ปี เริ่มสอบ   &nbsp; </label>
			<input required="required" style="width:400px" type="text" class="form-control" name="Time" id="reservationtime" value="<?php
				$dateStartCreate=date_create($datetime_start_series_exam);
				$TimeStartCreate=date_create($datetime_start_series_exam);
				$dateStart =  date_format($dateStartCreate,"d-m-Y");
				$TimeStart =  date_format($TimeStartCreate,"H:i");
				$Date_Time_Start = $dateStart.$TimeStart;
				$dateEndCreate=date_create($datetime_end_series_exam);
				$TimeEndCreate=date_create($datetime_end_series_exam);
				$dateEnd =  date_format($dateEndCreate,"d-m-Y");
				$TimeEnd =  date_format($TimeEndCreate,"H:i");
				$Date_Time_End = $dateEnd.$TimeEnd;
			if($manager=="edit"){
					echo $Date_Time_Start.",".$Date_Time_End;
					}  ?>"/>
					&nbsp; (ตัวอย่าง 01-01-2020 00:00,12-12-2020 23:30)
			</div>

		</div>



		<div class="form-group">

            <div class="table-responsive" >
				<?php
				$sql = "SELECT * FROM `manager_chapter` WHERE name_name_subject = '$id_subject' ORDER BY `manager_chapter`.`num_chapter` ASC";
						$result = mysqli_query($conn, $sql);
						$i = 1;
						$a = 0;
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
							$data_id =  $row['id'];
							$data_num_chapter =  $row['num_chapter'];
							$data_name_chapter =  $row['name_chapter'];
							$data_objective_chapter =  $row['objective_chapter'];
				?>
						<div class="card-header">
						<div class="row">
						<div class="col-sm-12" href="#collapse<?php echo $i;?>" role="button" data-toggle="collapse">
							<i class="fas fa-table" id="txt_chapter<?php echo $i;?>"><a href="#collapse<?php echo $i;?>" role="button" data-toggle="collapse"> บทที่ <?php echo $data_num_chapter." ".$data_name_chapter; ?> </a></i>
						</div>


						</div>
						</div>
          <!---<div id="collapse<?php// echo $i;?>" class="panel-collapse collapse">----->
          <div id="collapse<?php echo $i;?>" class="panel-collapse collapse">

			<div class="form-group">
		<h4><u>วัตถุประสงค์</u></h4>
<pre><h5><?php echo $data_objective_chapter;?><h5></pre>
			</div>
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="50%" cellspacing="0">
                <!-- <thead> -->

                <!-- </thead> -->
                  <tr>
                    <th width="5%"><input type="checkbox" id="Check_All<?php echo $a; ?>" onclick="check_uncheck_all<?php echo $a; ?>()"></th>
                    <th width="10%">ข้อสอบที่</th>

                    <th  width="85%">โจทย์</th>
                  </tr>
				  <?php


						$sql1 = "SELECT manager_exam.id,manager_exam.proposition_exam FROM `manager_chapter`
								INNER JOIN manager_exam on manager_exam.chapter_id_exam = manager_chapter.id
								WHERE manager_exam.chapter_id_exam = $data_id";
						$result1 = mysqli_query($conn, $sql1);
						$num_chapter = 1;
						$b = 0;
						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
							$exam_id =  $row1['id'];
							$proposition_exam =  $row1['proposition_exam'];




				  ?>
				  <tr>
                    <td>
					<input hidden type="text" name="id_series_exam" value="<?php echo $id_series_exam;?>">
					<input id="id<?php echo $a.$b; ?>" <?php if($manager=="edit"){
										$arr_list_series_exam = explode(',',$list_series_exam);
										for ($i=0; $i < count($arr_list_series_exam); $i++) {
						                  $id = $arr_list_series_exam[$i];
												if($id == $exam_id){
													echo "checked";
													}
									 }
					}
					?> type="checkbox" name="num_exam_value[]" value="<?php echo $exam_id; ?>"></input></td>
					<td><?php echo $num_chapter++; ?></td>
                    <td><?php echo $proposition_exam; ?></td>
                  </tr>
							<?php $b++; } ?>
                </table>
            </div>
          </div>
	<?php $i++; $a++; } ?>
            </div>

    </div>


	<div class="form-group">
    <button type="submit" name="<?php if($manager == "edit"){echo "edit_series_exam";}else{echo "add_series_exam";}?>" <?php if($manager=="edit"){echo "class='btn btn-primary btn-block'>อัพเดทชุดข้อสอบ</button>";} else{echo "class='btn btn-success btn-block'>สร้างชุดข้อสอบ</button>";}?>
	</div>




  </form>


          </div>
        </div>
      </div>

<?php include("footer.php"); ?>

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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <!-- Include Required Prerequisites -->
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="js/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

<script type="text/javascript">
var d = new Date();
var y = d.getFullYear()+543;
$('#reservationtime').daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 1,
        locale: {
            format: ' DD-MM-'+(d.getFullYear()+543)+' HH:mm',
            //format: ' DD-MM-YYYY HH:mm',
            separator: ',',
            applyLabel: 'ตกลง',
            cancelLabel: 'ยกเลิก',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
			language: 'th',
            weekLabel: 'W',
            daysOfWeek: ['อา','จ','อ','พ','พฤ','ศ','ส'],
            monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน',
                          'กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
            firstDay: 0
        },
    });
</script>

<script type="text/javascript">
<?php
			$sql = "SELECT * FROM `manager_chapter` WHERE name_name_subject = '$id_subject' ORDER BY `manager_chapter`.`num_chapter` ASC";
						$result = mysqli_query($conn, $sql);
						$a = 0;
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
							$data_id =  $row['id'];
 ?>
function check_uncheck_all<?php echo $a; ?>(){
	 var checkedVal = document.getElementById("Check_All<?php echo $a; ?>");
	 <?php
					$sql1 = "SELECT manager_exam.id,manager_exam.proposition_exam FROM `manager_chapter`
								INNER JOIN manager_exam on manager_exam.chapter_id_exam = manager_chapter.id
								WHERE manager_exam.chapter_id_exam = $data_id";
						$result1 = mysqli_query($conn, $sql1);
						$i = 0;
						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
	 ?>
 if(checkedVal.checked==true){
		document.getElementById("id<?php echo $a.$i; ?>").checked = true;
 }else{
		document.getElementById("id<?php echo $a.$i; ?>").checked = false;

 }
<?php $i++; }?>
}
<?php $a++; } ?>
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

		<script>
			$(document).ready(function(){
				$("#branch").change(function(){
					$.ajax({
						url: "select_section.php", //เรียกใช้งานไฟล์นี้
						data: "?degree=<?=$year_std_series_exam?>&branch=" + $("#branch").val(),  //ส่งตัวแปร
						type: "POST",
						async:false,
						success: function(data, status) {
								$("#degree").html(data);
							},
					});
					//return flag;
				});
			});
		</script>



		<script>
		$.ajax({
						url: "select_section.php?degree=<?=$year_std_series_exam?>", //เรียกใช้งานไฟล์นี้
						data: "?degree=<?=$year_std_series_exam?>&branch=" + $("#branch").val(),  //ส่งตัวแปร
						type: "POST",
						async:false,
						success: function(data, status) {
								$("#degree").html(data);
							},
					});
		//function enable() {
		//	var x = document.getElementById("degree").value;
		//	if(x > 0){
			//	document.getElementById("room").disabled=false;
			//}else{
			//	document.getElementById("room").disabled=true;
			//}
		//}

		</script>


</body>

</html>
