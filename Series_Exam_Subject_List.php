<?php
session_start();
error_reporting(0);
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


if(isset($_GET["id_subject"])){
		$id_subject = $_GET["id_subject"];
		$year_std_series_exam = isset($_GET["year_std_series_exam"]);
		// $genre_subject = $_GET["genre_subject"];
	}else{
		header('Location:Series_Exam.php');
	}
function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate));
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return $strHour.':'.$strMinute.'น. '.$strDay.'/'.$strMonthThai.'/'.$strYear;
	}

	function DateDiff($strDate1,$strDate2)
	 {
				return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 }
	 function TimeDiff($strTime1,$strTime2)
	 {
				return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
	 }
	 function DateTimeDiff($strDateTime1,$strDateTime2)
	 {
				return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
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


<!-- ^^^ scripts ^^^ -->
<!-- Global site tag (gtag.js) - Google Analytics -->


  <title>ระบบข้อสอบออนไลน์</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <link href="css/switch.css" rel="stylesheet">

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
		  $sql4 = "SELECT * FROM `manager_subject` WHERE `id`= $id_subject";
			$result4 = mysqli_query($conn, $sql4);
			while ($row4 = mysqli_fetch_array($result4,MYSQLI_ASSOC)){
			$name_subject =  $row4['name_subject'];
			$genre_subject =  $row4['genre_subject'];
			}

      if($genre_subject == 1){
        $genre_subject = "ปวช";
      }else if($genre_subject == 2){
        $genre_subject = "ปวส";
      }

		  ?>
          <li class="breadcrumb-item active"><?php echo $name_subject;?></li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <!-- <form action="FPDF/index.php" target="_blank" method="POST"> -->
              <i class='fas'>&#xf0ae;</i>
				ชุดข้อสอบ วิชา<?php echo $name_subject;?>
				<!-- <b>
				<?php
				$sql3 = "SELECT * FROM `manager_branch`";
							$result3 = mysqli_query($conn, $sql3);
							while ($row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC)){
							$branch_id =  $row3['branch_id'];
							$branch_name =  $row3['branch_name'];
							}
				//echo $branch_name;
				?>
				</b> -->
              <a href="Series_Exam_Manager.php?id_subject=<?php echo $id_subject; ?>&genre_subject=<?php echo $genre_subject; ?>" ><button type="button" class="btn btn-success">เพิ่มชุดข้อสอบ</button></a>
              <input hidden type="text" name="name_subject" value="<?php echo $name_subject; ?>"/>
              <input hidden type="text" name="id_subject_series_exam" value="<?php echo $id_subject; ?>"/>
              <!-- <input hidden type="text" name="branch_name" value="<?php echo $branch_name; ?>"/> -->
              <input hidden type="text" name="branch_id" value="<?php echo $branch_id; ?>"/>
              <input hidden type="text" name="year_std" value="<?php echo $year_std_series_exam; ?>"/>
              <a href="Page_print_list.php?id_subject_series_exam=<?php echo $id_subject; ?>" type="button" style="position: absolute; right: 0;" class="btn btn-warning mr-2 px-5"><i class="fa fa-print" aria-hidden="true"> ปริ้นคะแนนสอบ</i></a>
          <!-- </form> -->
        </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
					<th width="4%"><center>ลำดับ</center></th>
                    <th width="18%">ชื่อชุดข้อสอบ</th>
                    <?php
                      if($status_teacher == 3){
                     ?>
                    <th width="23%">ชื่ออาจารย์ผู้ออกข้อสอบ</th>
                    <?php } ?>
                    <th width="10%">ห้อง</th>
                    <th width="15%">เวลาในการสอบ</th>
                    <th width="12%">คะแนนสอบ</th>
                    <th width="8%"><center>สถานะ</center></th>
                    <!-- <th width="8%">ลบ</th> -->
                    <!-- <th width="8%">ดูผลสอบ</th>
                    <th width="7%">แก้ไข</th>
                    <th width="7%">ลบ</th> -->
                  </tr>
                </thead>
                <tbody>
				<?php
        $list_series_exam1 = null;
        $list_series_exam2 = null;
        $score_series_exam1 = 0;
        $score_series_exam2 = 0;
        $exam_count1 = 0;
        $exam_count2 = 0;
					if($status_teacher == 1){
            $sql1 = "SELECT DISTINCT name_series_exam ,
                    `manager_series_exam`.id,
                    id_subject_series_exam,
                    branch_name,
                    teacher_id_series_exam,
                    datetime_start_series_exam,
                    datetime_end_series_exam,
                    score_series_exam,
                    year_std_series_exam,
                    list_series_exam,
                    type_series_exam,
                    type_exam,
                    approve_series_exam
                    FROM `manager_series_exam`
                    INNER JOIN manager_branch on manager_branch.branch_id = manager_series_exam.branch_id_series_exam
                    INNER JOIN manager_subject on manager_subject.genre_subject = manager_branch.branch_genre
                    WHERE id_subject_series_exam = $id_subject
                    ORDER BY `manager_series_exam`.`branch_id_series_exam` ASC, manager_series_exam.teacher_id_series_exam ASC";
						}else if($status_teacher == 2){
							$sql1 = "SELECT DISTINCT name_series_exam ,
                      `manager_series_exam`.id,
                      id_subject_series_exam,
                      branch_name,
                      teacher_id_series_exam,
                      datetime_start_series_exam,
                      datetime_end_series_exam,
                      score_series_exam,
                      year_std_series_exam,
                      list_series_exam,
                      type_series_exam,
                      approve_series_exam
                      FROM `manager_series_exam`
                      INNER JOIN manager_branch on manager_branch.branch_id = manager_series_exam.branch_id_series_exam
                      INNER JOIN manager_subject on manager_subject.genre_subject = manager_branch.branch_genre
                      WHERE id_subject_series_exam = $id_subject AND manager_series_exam.`teacher_id_series_exam` = $id_teacher
                      ORDER BY `manager_series_exam`.`branch_id_series_exam` ASC, manager_series_exam.teacher_id_series_exam ASC
                    ";
							}
						$result1 = mysqli_query($conn, $sql1);
						$number = 1;
						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
							$id =  $row1['id'];
							$id_subject_series_exam =  $row1['id_subject_series_exam'];
							$branch_name =  $row1['branch_name'];
              $branch_name = "<b>".$branch_name."</b></br>";
							$name_series_exam =  $row1['name_series_exam'];
							$teacher_id_series_exam =  $row1['teacher_id_series_exam'];
							$datetime_start_series_exam =  $row1['datetime_start_series_exam'];
							$datetime_end_series_exam =  $row1['datetime_end_series_exam'];

							$year_std_series_exam =  $row1['year_std_series_exam'];
              $l_list_series_exam = $row1['list_series_exam'];
              $type_series_exam_sql = $row1['type_series_exam'];
              $score_series_exam_sql = $row1['score_series_exam'];

              $approve_series_exam = $row1['approve_series_exam'];
              $type_exam = $row1['type_exam'];

              if(strstr($l_list_series_exam,";")){
              $list_series_exam = explode(';',$l_list_series_exam);
              $list_series_exam1 = $list_series_exam[0];
  						$list_series_exam2 = $list_series_exam[1];
              $list_series_exam1 = explode(',',$list_series_exam1);
  						$list_series_exam2 = explode(',',$list_series_exam2);

              $score_series_exam = explode(';',$score_series_exam_sql);
              $score_series_exam1 = $list_series_exam[1];
  						$score_series_exam2 = $list_series_exam[1];
  						$score_series_exam1 = explode(',',$score_series_exam1);
  						$score_series_exam2 = explode(',',$score_series_exam2);
            }else{
              $list_series_exam = explode(',',$l_list_series_exam);//เปลี่ยนเป็น score
              $score_series_exam = explode(';',$score_series_exam_sql);
            }

  						if(strstr($type_series_exam_sql,";")){
  						$type_series_exam_arr = explode(';',$type_series_exam_sql);
  						$type_series_exam1 = $type_series_exam_arr[0];
  						$type_series_exam2 = $type_series_exam_arr[1];
              $exam_count1 = count($list_series_exam1);
              $exam_count2 = count($list_series_exam2);

              $score_series_exam1 = $score_series_exam[0];
              $score_series_exam2 = $score_series_exam[1];
              $score_series_exam2 = explode(',',$score_series_exam2);

              $score_series_exam1 = $score_series_exam1*$exam_count1;
              $score_series_exam2 = array_sum($score_series_exam2);
            }else{
              if($type_series_exam_sql == 1){
                // echo "(1)";
  							$type_series_exam1 = $type_series_exam_sql;
  							$type_series_exam2 = null;
                $exam_count1 = count($list_series_exam);
                $exam_count2 = 0;
                $score_series_exam1 = $row1['score_series_exam']*$exam_count1;
                $score_series_exam2 = 0;

  						}
               if($type_series_exam_sql == 2){
                // echo "(2)";
  							$type_series_exam1 = null;
  							$type_series_exam2 = $type_series_exam_sql;
                $exam_count2 = count($list_series_exam);
                $exam_count1 = 0;
                $score_series_exam2 = array_sum(explode(',',$row1['score_series_exam']));
                $score_series_exam1 = 0;
  						}
            }

							$date_time_StartCreate=date_create($datetime_start_series_exam);
							$dateStart =  date_format($date_time_StartCreate,"Y/m/d");
							$TimeStart =  date_format($date_time_StartCreate,"H:i");

							$Y_Start =  date_format($date_time_StartCreate,"Y");
							$m_Start =  date_format($date_time_StartCreate,"m");
							$d_Start =  date_format($date_time_StartCreate,"d");
							$H_Start =  date_format($date_time_StartCreate,"H");
							$i_Start =  date_format($date_time_StartCreate,"i");

							$date_time_EndCreate=date_create($datetime_end_series_exam);
							$dateEnd =  date_format($date_time_EndCreate,"Y/m/d");
							$TimeEnd =  date_format($date_time_EndCreate,"H:i");

							$Y_End =  date_format($date_time_EndCreate,"Y");
							$m_End =  date_format($date_time_EndCreate,"m");
							$d_End =  date_format($date_time_EndCreate,"d");
							$H_End =  date_format($date_time_EndCreate,"H");
							$i_End =  date_format($date_time_EndCreate,"i");

							date_default_timezone_set("Asia/Bangkok");
							$dateNow =  date("/m/d H:i");
							$TimeNow =  date("H:i");
							$Y_Now =  date("Y");
							$m_Now =  date("m");
							$d_Now =  date("d");
							$H_Now =  date("H");
							$i_Now =  date("i");

							$dateNow = ($Y_Now+543).$dateNow;


							if($i_Start == 0){
								$i_Start = 60;
							}
							if($i_End == 0){
								$i_End = 60;
							}




							$Date_Time_Start = $TimeStart.$dateStart;
							$Date_Time_End = $TimeEnd.$dateEnd;


							$sql2 = "SELECT * FROM `manager_subject` WHERE id = $id_subject_series_exam";
							$result2 = mysqli_query($conn, $sql2);
							while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
								$id_subject =  $row2['id'];
								$name_subject =  $row2['name_subject'];
							}

							$sql3 = "SELECT * FROM `manager_teacher` WHERE `id_teacher` = $teacher_id_series_exam";
							$result3 = mysqli_query($conn, $sql3);
							while ($row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC)){
							$name_teacher =  $row3['name_teacher'];


							}
				?>
                  <tr>
                    <td><center><b><?php echo $number; ?></b></center></td>
                    <td>
                      <a onclick="return buttonDelete<?php echo $number; ?>()" href="Series_Exam_Manager_Sql.php?id_series_exam=<?php echo $id; ?>&delete_series_exam"><button type="button" class="btn btn-danger"><i style='font-size:15px' class='fas'>&#xf2ed;</i></button></a>
                      <a href="Series_Exam_Manager.php?edit&id_subject=<?php echo $id_subject;?>&id_series_exam=<?php echo $id;?>&l_list_series_exam=<?php echo $l_list_series_exam; ?>"><button type="button" class="btn btn-warning"><i style='font-size:15px' class='fas'>&#xf303;</i></button></a>
                      <a href="FPDF/print_exam.php?id_series_exam=<?php echo $id;?>"><button type="button" class="btn btn-info"><i style="font-size:15px" class="fa fa-print"> </i></button></a>
                      <a href="Series_Exam_Subject_List_page1.php?id=<?php echo $id; ?>&name_series_exam=<?php echo $name_series_exam; ?>&id_subject=<?php echo $id_subject; ?>"><b><?php echo $name_series_exam; ?></b></a>
                     </td>
                     <?php
                       if($status_teacher == 3){
                      ?>
                      <td><?php echo $name_teacher; ?></td>
                      <?php } ?>
                      <td>
                      <?php
                        $year_count = explode(',',$year_std_series_exam);
          							for ($i_arr=0; $i_arr < count($year_count); $i_arr++) {
          							$year_count_list = $year_count[$i_arr];
                      ?>
                      <?php
                      echo $branch_name."ห้อง ".$year_count_list."</br>"; ?>
                    <?php $branch_name = ""; } ?>
                    </td>
                    <td>
					              <b>เริ่มสอบ <?php echo DateThai($Date_Time_Start)?></b><br>
					              <b>สิ้นสุด <?php echo DateThai($Date_Time_End)?><b>
                    </td>
					<td>
            <?php
            if($type_series_exam1 != null){
              echo "<p><b>ปรนัย : </b>".$exam_count1." ข้อ ";
              print_r($score_series_exam1); echo " คะแนน</p>";
            }
            if($type_series_exam2 != null){
              echo "<p><b>อัตนัย : </b>".$exam_count2." ข้อ ";
              print_r($score_series_exam2); echo " คะแนน</p>";
          }
            ?>
          </td>
					<td><center>
            <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
            <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
          <!-- <br> -->

            <?php if($type_exam == 2 || $type_exam == 3){ ?>
              <div <?php if(DateTimeDiff($dateEnd." ".$TimeEnd,$dateNow) >= 0 ){ echo "hidden ";} ?> class="form-check form-switch">
              <input
              <?php
                if($approve_series_exam == 1){echo "checked";}
              ?>
              class="form-check-input" type="checkbox" id="check<?=$number?>">
                <br>
              </div>
           <?php } ?>
          <!-- <br> -->

         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript">
        $('#check<?=$number?>').on('change', function() {
          var checked = this.checked
          var status_exam = document.getElementById('check<?=$number?>');
          var test = document.getElementById('show_status<?=$number?>').checked;
           var var_status = null;
           if(status_exam.checked == true){
             var_status = 1;
           }else{
             var_status = 0;
           }
             $.ajax({
               url: "show_update_status.php?", //เรียกใช้งานไฟล์นี้
               data: "id_exam=<?=$id?>&approve_series_exam="+var_status+"&dateNow=<?=$dateNow?>&dateStart=<?=$dateStart?>&TimeStart=<?=$TimeStart?>&dateEnd=<?=$dateEnd?>&TimeEnd=<?=$TimeEnd?>",  //ส่งตัวแปร
               type: "GET",
               async:false,
               success: function(data, status) {
                   $("#show_status<?=$number?>").html(data);
                 },
             });
        });
        </script>

         <center id="show_status<?=$number?>">
           <?php
             if($approve_series_exam == 0){
               if(DateTimeDiff($dateEnd." ".$TimeEnd,$dateNow) >= 0 )
               {
                 echo '<font color="red"><b>ปิดสอบ</b></font>';
               }
               else if(DateTimeDiff($dateStart." ".$TimeStart,$dateNow) < 0 )
               {
                 echo '<font color="gray"><b">ยังไม่เปิดให้สอบ</b></font>';
               }
               else
               {
                 echo '<font color="gray"><b>รออนุมัติ</b></font>';
               }

             }else{
               if(DateTimeDiff($dateEnd." ".$TimeEnd,$dateNow) >= 0 )
                 {
                   echo '<font color="red"><b>ปิดสอบ</b></font>';
                 }
                 else if(DateTimeDiff($dateStart." ".$TimeStart,$dateNow) < 0 )
                 {
                   echo '<font color="gray"><b">ยังไม่เปิดให้สอบ</b></font>';
                 }
                 else
                 {
                   echo '<font color="green"><b>เปิดสอบ</b></font>';
                 }
             }
           ?>
        </center>



       </center></td>
					<!-- <td>
						<center>
						  <a href="Series_Exam_Show_Point.php?id_series_exam=<?php echo $id; ?>"><button type="button" class="btn btn-info"><i style="font-size:24px" class="fa">&#xf06e;</i></button></a>
						</center>
					</td>--->
					<!-- <td>
						<center>
								<a onclick="return buttonDelete<?php echo $number; ?>()" href="Series_Exam_Manager_Sql.php?id_series_exam=<?php echo $id; ?>&delete_series_exam"><button type="button" class="btn btn-danger"><i style='font-size:15px' class='fas'>&#xf2ed;</i></button></a>
						</center>
					</td> -->
                  </tr>
          </tbody>
				<?php $number++;$score_series_exam1=0;$score_series_exam2=0;
        // $exam_count1 = 0;
        // $exam_count2 = 0;
      }
        // echo $score_series_exam1;
        // echo $score_series_exam2;
        ?>
              </table>
            </div>
          </div>
        </div>
      </div>



		<div class="container">
  <!-- Trigger the modal with a button -->

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		  <h5 class="modal-title">เพิ่มวิชา</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
		<form action="layer3.php" method="GET">

          <div class="form-group">
		  <label>รหัสวิชา</label>
            <div class="form-label-group">
              <input type="text"  class="form-control"  name="" required="required" autofocus="autofocus"></input>
            </div>
          </div>

		  <div class="form-group">
		  <label>ชื่อวิชา</label>
            <div class="form-label-group">
              <input type="text"  class="form-control"  name="" required="required" autofocus="autofocus"></input>
            </div>
          </div>

		  <div class="form-group">
		  <label>ชื่ออาจารย์ผู้สอน</label>
            <div class="form-label-group">
              <input type="text"  class="form-control"  name="" required="required" autofocus="autofocus"></input>
            </div>
          </div>

		  <div class="container">
          <button type="submit" class="btn btn-success btn-block">บันทึกวิชา</button>
		  </div>




        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>
      </div>

    </div>
  </div>

  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		  <h5 class="modal-title">แก้ไขข้อมูล</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
		<form action="layer3.php" method="GET">

          <div class="form-group">
		  <label>รหัสวิชา</label>
            <div class="form-label-group">
              <input type="text"  class="form-control"  name="" required="required" autofocus="autofocus"></input>
            </div>
          </div>

		  <div class="form-group">
		  <label>ชื่อวิชา</label>
            <div class="form-label-group">
              <input type="text"  class="form-control"  name="" required="required" autofocus="autofocus"></input>
            </div>
          </div>

		  <div class="form-group">
		  <label>ชื่ออาจารย์ผู้สอน</label>
            <div class="form-label-group">
              <input type="text"  class="form-control"  name="" required="required" autofocus="autofocus"></input>
            </div>
          </div>

		  <div class="container">
          <button type="submit" class="btn btn-success btn-block">บันทึกข้อสอบ</button>
		  </div>




        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>
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
	$sql = "SELECT DISTINCT name_series_exam ,
          `manager_series_exam`.id,
          id_subject_series_exam,
          branch_name,
          teacher_id_series_exam,
          datetime_start_series_exam,
          datetime_end_series_exam,
          score_series_exam,
          year_std_series_exam,
          list_series_exam,
          type_series_exam,
          type_exam,
          approve_series_exam
          FROM `manager_series_exam`
          INNER JOIN manager_branch on manager_branch.branch_id = manager_series_exam.branch_id_series_exam
          INNER JOIN manager_subject on manager_subject.genre_subject = manager_branch.branch_genre
          WHERE id_subject_series_exam = $id_subject
          ORDER BY `manager_series_exam`.`branch_id_series_exam` ASC, manager_series_exam.teacher_id_series_exam ASC";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
	$name_series_exam =  $row['name_series_exam'];
  ?>
  <script>
	  function buttonDelete<?php echo $i;?>() {
	  var result = confirm("แน่ใจว่าต้องการลบชุดข้อสอบ <?php echo $name_series_exam; ?>?");
	  if (result==true) {
	   return true;
	  } else {
	   return false;
	  }
	}
  </script>
	<?php $i++;} ?>
