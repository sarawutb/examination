<?php
session_start();
  if ($_SESSION['id_teacher']) {
	 include("connect.php");
	 $id_teacher = $_SESSION['id_teacher'];
	 $status_teacher = $_SESSION['status_teacher'];
	 //echo $status_teacher;
   error_reporting(0);

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

	if(isset($_GET["id_series_exam"])){
					$id_std = $_GET['id_std'];
					$id_series_exam = $_GET['id_series_exam'];
					$year_std_series_exam = $_GET['year_std_series_exam'];
					$id_subject = $_GET['id_subject'];
	}else{
	header('Location:Series_Exam.php');
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

<body id="page-top">

  <?php include("header.php"); ?>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class='fas'>&#xf015;</i>
          <span>หนัาหลัก</span>
        </a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="Subject.php">
          <i class='far'>&#xf15c;</i>
          <span>รายวิชา</span></a>
      </li>
      <li class="nav-item active">
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
		  $status_result_exam_std = 3;
						$sql1 = "SELECT * FROM `manager_series_exam`
						INNER JOIN manager_subject on manager_series_exam.id_subject_series_exam = manager_subject.id
						INNER JOIN result_exam_std on manager_series_exam.id = result_exam_std.id_name_series_exam
						WHERE manager_series_exam.id = $id_series_exam";
						$result1 = mysqli_query($conn, $sql1);
						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
							$name_subject =  $row1['name_subject'];
							$name_series_exam =  $row1['name_series_exam'];
							$status_result_exam_std =  $row1['status_result_exam_std'];

							if($status_result_exam_std == 0){
								break;
							}

						}
						if($status_result_exam_std == 3){
								$sql1 = "SELECT * FROM `manager_series_exam`
								INNER JOIN manager_subject on manager_series_exam.id_subject_series_exam = manager_subject.id
								WHERE manager_series_exam.id = $id_series_exam";
								$result1 = mysqli_query($conn, $sql1);
								while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
									$name_subject =  $row1['name_subject'];
									$name_series_exam =  $row1['name_series_exam'];
								}
						}
		  ?>
          <li class="breadcrumb-item"><a href="Series_Exam_Subject_List.php?id_subject=<?php echo $id_subject; ?>"><?php echo $name_subject;?></a></li>
          <li class="breadcrumb-item"><a href="Series_Exam_Subject_List_page1.php?id=<?php echo $id_series_exam; ?>&name_series_exam=<?php echo $name_series_exam; ?>&id_subject=<?php echo $id_subject; ?>"><?php echo $name_series_exam;?></a>
          <li class="breadcrumb-item active">ห้อง <?php echo $year_std_series_exam;?></li>


        </ol>




        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header py-3">
            <!-- <form action="FPDF/index.php" target="_blank" method="POST"> -->
              <i class='fas'>&#xf0ae;</i>
				ตรวจข้อสอบรายวิชา<?php echo $name_subject;?> <b><?php echo $name_series_exam;?></b>

        </div>
          <div class="card-body">
            <div class="table-responsive">
            <form id="form" action="Series_Exam_Manager_Sql.php" method="POST">
              <table class="table table-bordered"  width="100%" cellspacing="0">
                <thead>
                  <tr>
          					<th width="7%"><center>ข้อที่</center></th>
          					<th width="70%">โจทย์</th>
          					<th width="13%">คะแนนเต็ม</th>
                    <th width="10%">กรอกคะแนน</th>
                  </tr>
                </thead>
                <tbody>
					<?php
            $arr_point_result_exam = "";
						$number = 1;
						$ans_true = 0;
						$sql2 = "SELECT result_exam_std.id,result_exam_std.point_result_exam,result_exam_std.id as id_series_exam_sql,manager_series_exam.list_series_exam,manager_series_exam.score_series_exam,result_exam_std.ans_result_exam FROM `result_exam_std`
                    INNER JOIN manager_series_exam on manager_series_exam.id = result_exam_std.id_name_series_exam
                    INNER JOIN manage_std on manage_std.id = result_exam_std.id_std_result_exam
                    WHERE manage_std.id_std = $id_std AND manager_series_exam.id = $id_series_exam";
						$result2 = mysqli_query($conn, $sql2);
						while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
              // echo $row2['id'];;
              // echo "<br>";
							$id_series_exam_sql =  $row2['id_series_exam_sql'];
							$list_series_exam =  $row2['list_series_exam'];
							$score_series_exam =  $row2['score_series_exam'];
							$ans_result_exam =  $row2['ans_result_exam'];
							$point_result_exam =  $row2['point_result_exam'];

              if(strstr($ans_result_exam,";")){
                $ans_result_exam = explode(';',$ans_result_exam);
                $arr_ans_result_exam = $ans_result_exam[1];
                $ans_result_exam = explode('|=>',$arr_ans_result_exam);
              }else{
                $arr_ans_result_exam = $ans_result_exam;
                $ans_result_exam = explode('|=>',$ans_result_exam);
                // $arr_ans_result_exam = explode(',',$ans_result_exam);
              }
              // print_r($ans_result_exam);

              if(strstr($list_series_exam,";")){
                $arr_list_series_exam = explode(';',$list_series_exam);
                $arr_list_series_exam = $arr_list_series_exam[1];
                $arr_list_series_exam = explode(',',$arr_list_series_exam);
              }else{
                $arr_list_series_exam = explode(',',$list_series_exam);
              }

              if(strstr($score_series_exam,";")){
                $arr_score_series_exam = explode(';',$score_series_exam);
                $arr_score_series_exam = $arr_score_series_exam[1];
                $arr_score_series_exam = explode(',',$arr_score_series_exam);
              }else{
                $arr_score_series_exam = explode(',',$score_series_exam);
              }
              if(strstr($score_series_exam,";")){
                // echo "xx1";
                $arr_point_result_exam = explode(';',$point_result_exam);
                $arr_point_result_exam = $arr_point_result_exam[1];
                $arr_point_result_exam = explode(',',$arr_point_result_exam);
              }else{
                // echo "xx2";
                $arr_point_result_exam = explode(',',$point_result_exam);
              }
                 $arr_ans_result_exam = explode('|=>',$arr_ans_result_exam);

                  // print_r($arr_point_result_exam);
  							for ($num_result_result_exam=0; $num_result_result_exam < count($arr_list_series_exam); $num_result_result_exam++){
  								$int_list_series_exam = $arr_list_series_exam[$num_result_result_exam];
  								$score_series_exam = $arr_score_series_exam[$num_result_result_exam];
  								$ans_result_exam = $arr_ans_result_exam[$num_result_result_exam];
                  if($point_result_exam == null){
                    $point_result_exam = null;
                  }else{
                    $point_result_exam = $arr_point_result_exam[$num_result_result_exam];
                  }



                  $sql = "SELECT * FROM `manager_exam_annotated` WHERE `id` = $int_list_series_exam";
                    $result = $conn->query($sql);
                      while($row = $result->fetch_assoc()) {
                        $proposition_exam = $row["proposition_exam"];
                        $ans_exam = $row["ans_exam"];
                      }
					?>
                  <tr>
                    <td><center><b><?php echo $number; ?></b></center></td>
                    <td>
                      <b><?=$proposition_exam;?></b></br>
                      <u><b style="color:red">คำตอบ</b></u><textarea readonly class="form-control" name="name" style="height:200px;border:none" cols="80"><?=$ans_result_exam;?></textarea>
                      <u><b style="color:geen">เฉลย</b></u><textarea readonly class="form-control" name="name" style="height:200px;border:none;background-color:#b8e0b9" cols="80"><?=$ans_exam;?></textarea>
                    </td>
                    <td><?=$score_series_exam." คะแนน";?></td>
                    <td>
                      <input name="check_exam[]" id="myInput<?php echo $number; ?>" value="<?=$point_result_exam;?>" onchange="limit<?php echo $number; ?>(this);" class="form-control" type="text" spellcheck="false" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required></input>
                      <script>
                              function limit<?=$number?>(input)
                              {
                                  var maxinput = parseFloat(<?=$score_series_exam;?>);
                                  var number = parseFloat(document.getElementById("myInput<?=$number;?>").value);



                                  //if(element.value.length > max_chars) {
                                  if(number > maxinput){
                                      document.getElementById("myInput<?=$number;?>").value = maxinput;
                                      number = maxinput;
                                  }
                                  // if(number>max){
                                  //   document.getElementById("myInput1<?=$number;?>").value = max;
                                  //   number=max;
                                  // }
                                }
                      </script>
                    </td>
                  </tr>
					<?php $number++; } } ?>
                </tbody>
              </table>
              <input hidden type="text" name="id_series_exam_sql" value="<?=$id_series_exam_sql?>">
              <center>
                <button type="submit" name="check_exam_std" class="btn btn-success">ยืนยัน</button>
                <button type="button" onclick="back()" class="btn btn-danger">ยกเลิก</button>
                <script>
                function back(){
                  javascript:history.go(-1);
                }
                </script>
              </center>
            </form>
            </div>
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

  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</body>

</html>

<?php
  $i = 1;
	$sql = "SELECT * FROM `result_exam_std`
			INNER JOIN manage_std on result_exam_std.id_std_result_exam = manage_std.id
			WHERE `id_name_series_exam` = 25";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
  ?>

  <script>
	  function buttonDelete<?php echo $i;?>() {
	  var result = confirm("แน่ใจว่าต้องการลบ");
	  if (result==true) {
	   return true;
	  } else {
	   return false;
	  }
	}
  </script>
	<?php $i++;} ?>
