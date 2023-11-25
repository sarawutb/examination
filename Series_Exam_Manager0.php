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
<html lang="en" style="font-size:100%">

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
<style>
input[type="checkbox"][readonly] {
  pointer-events: none !important;
}
</style>

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
  $score_series_exam = "";
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
  $list_series_exam = null;
	if(isset($_GET["id_series_exam"])){
		$id_series_exam = $_GET["id_series_exam"];
		$list_series_exam = $_GET["l_list_series_exam"];
// Notice: Undefined variable: list_series_exam in C:\xampp\htdocs\examination\Series_Exam_Manager.php on line 638
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
							$type_series_exam =  $row1['type_series_exam'];

							//$arr_list_series_exam = explode(',',$row1['list_series_exam']);
							//for ($i=0; $i < count($arr_list_series_exam); $i++) {
							//$num_arr = $arr_list_series_exam[$i];
							//}
						}
	}else{
		$id_series_exam = "";
		$year_std_series_exam = "";
		$branch_id_series_exam = "";
    $type_series_exam = 1;
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

		<!-- <input  type="text" name="genre_subject" value="<?php echo $_GET['genre_subject'];?>"> -->
		<!-- <input hidden type="text" name="type_series" value=""> -->
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
        <div id="degree" >

        </div>
        <!-- <option  value="<?php echo $year_std_after; ?>"><?php echo $year_std_after; ?></option> -->

        <?php
        }else{ ?>
          <div id="degree" class="wish_payment_type">

          </div>
      <?php }
      ?>

    </div>



    <!-- <div class="form-group">
			<label>ชั้นปี/ห้องเรียน</label>
      <div class="form-check" id="degree" >

      </div>
    </div> -->


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

		<div id="point_1" class="form-group">
				<label>คะแนนข้อละ</label>
				<input id="name_pointt1" style="width:200px" type="text" name="name_score_exam" class="form-control" value="<?php if($manager=="edit"){echo $score_series_exam;} ?>"   autofocus="autofocus" spellcheck="false" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required="required"></input>
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
					&nbsp; (ตัวอย่าง 01-01-2020 09:00,01-01-2020 09:30)
			</div>

		</div>


		<div class="form-group inline">
      <label>เลือกข้อสอบ</label>
      <div class="form-check">
        <input onclick="exam_type1()" <?php if($type_series_exam==1){echo "checked";} ?> class="form-check-input" type="checkbox" name="inlineRadioOptions" id="ex_t1" value="option1">
        <label class="form-check-label" for="inlineRadio1"> ข้อสอบแบบอัตนัย</label>
        </div>
    <div class="form-check">
        <input onclick="exam_type2()" <?php if($type_series_exam==2){echo "checked";} ?> class="form-check-input" type="checkbox" name="inlineRadioOptions" id="ex_t2" value="option2">
        <label class="form-check-label" for="inlineRadio2"> ข้อสอบแบบปรนัย</label>
      </div>
    </div>
    <div class="table-responsive" id="show">

    </div>
    </div>


    <center class="form-group">
      <button id='submit' type="submit" name="<?php if($manager == "edit"){echo "edit_series_exam";}else{echo "add_series_exam";}?>" <?php if($manager=="edit"){echo "class='btn btn-primary'>อัพเดทชุดข้อสอบ</button>";} else{echo "class='btn btn-success'>สร้างชุดข้อสอบ</button>";}?>
    </center>
  </form>


          </div>
        </div>
      </div>
      <!-- <p id="test">xxxx</p>
      <p id="test2">xxxx</p> -->

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


<script>
var ex_t1 = document.getElementById("ex_t1");
var ex_t2 = document.getElementById("ex_t2");
if (ex_t1.checked == true){
      $.ajax({
      url: "show_chapter_exam_type1.php?", //เรียกใช้งานไฟล์นี้
      data: "id_series_exam=<?=$id_series_exam?>&manager=<?=$manager?>&list_series_exam=<?=$list_series_exam?>&id_subject=<?=$id_subject?>",  //ส่งตัวแปร
      type: "GET",
      async:false,
      success: function(data, status) {
        $("#show").html(data);
      },
  });
  document.getElementById("point_1").hidden = false;
  document.getElementById("name_pointt1").name = "name_score_exam";
  document.getElementById("name_pointt1").required = true;
}
else if (ex_t2.checked == true){
       $.ajax({
       url: "show_chapter_exam_type2.php?", //เรียกใช้งานไฟล์นี้
       data: "id_series_exam=<?=$id_series_exam?>&manager=<?=$manager?>&list_series_exam=<?=$list_series_exam?>&id_subject=<?=$id_subject?>&score_series_exam=<?=$score_series_exam?>",  //ส่งตัวแปร
       type: "GET",
       async:false,
       success: function(data, status) {
         $("#show").html(data);
       },
   });
   document.getElementById("point_1").hidden = true;
   document.getElementById("name_pointt1").name = " ";
   document.getElementById("name_pointt1").required = false;
 }
 function exam_type1(){
            $.ajax({
            url: "show_chapter_exam_type1.php?", //เรียกใช้งานไฟล์นี้
            data: "id_series_exam=<?=$id_series_exam?>&manager=<?=$manager?>&list_series_exam=<?=$list_series_exam?>&id_subject=<?=$id_subject?>",  //ส่งตัวแปร
            type: "GET",
            async:false,
            success: function(data, status) {
              $("#show").html(data);
            },
        });
        document.getElementById("point_1").hidden = false;
        document.getElementById("name_pointt1").name = "name_score_exam";
        document.getElementById("name_pointt1").value = null;
        document.getElementById("name_pointt1").required = true;
        // document.getElementById("type_series").value = "1";

 }
 function exam_type2(){
            $.ajax({
            url: "show_chapter_exam_type2.php?", //เรียกใช้งานไฟล์นี้
            data: "id_series_exam=<?=$id_series_exam?>&manager=<?=$manager?>&list_series_exam=<?=$list_series_exam?>&id_subject=<?=$id_subject?>&score_series_exam=<?=$score_series_exam?>",  //ส่งตัวแปร
            type: "GET",
            async:false,
            success: function(data, status) {
              $("#show").html(data);
            },
        });
        document.getElementById("point_1").hidden = true;
        document.getElementById("name_pointt1").name = " ";
        // document.getElementById("name_pointt1").value = null;
        document.getElementById("name_pointt1").required = false;
        // document.getElementById("type_series").value = "2";

 }
</script>






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



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

		<script>
			$(document).ready(function(){
				$("#branch").change(function(){
					$.ajax({
            url: "select_section.php?degree=<?=$year_std_series_exam?>&branch_id=<?=$branch_id_series_exam?>", //เรียกใช้งานไฟล์นี้
						data: "&branch=" + $("#branch").val(),  //ส่งตัวแปร
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
						url: "select_section.php?degree=<?=$year_std_series_exam?>&branch_id=<?=$branch_id_series_exam?>", //เรียกใช้งานไฟล์นี้
						data: "&branch=" + $("#branch").val(),  //ส่งตัวแปร
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
    <script>
    $('.no-collapsable').on('click', function (e) {
          e.stopPropagation();
      });
    </script>

    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script>
    var verifyPaymentType = function () {
      var checkboxes = $('.wish_payment_type');
      var inputs = checkboxes.find('input');
      var first = inputs.first()[0];

      inputs.on('change', function () {
        this.setCustomValidity('');
      });

      first.setCustomValidity(checkboxes.find('input:checked').length === 0 ? 'กรุณาเลือกห้องเรียน' : '');
    }

    $('#submit').click(verifyPaymentType);
   </script>



</body>

</html>
