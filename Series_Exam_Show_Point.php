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
  while ($row_teacher = mysqli_fetch_array($result_teacher, MYSQLI_ASSOC)) {
    $data_id =  $row_teacher['id_teacher'];
    $data_id_teacher =  $row_teacher['id_teacher'];
    $data_name_teacher_subject =  $row_teacher['name_teacher'];
  }
  //echo  $data_id_teacher;
} else {
  session_destroy();
  header("location:Login.php");
}

if (isset($_GET["id_series_exam"])) {
  $id_series_exam = $_GET['id_series_exam'];
  $year_std_series_exam = $_GET['year_std_series_exam'];
  $id_subject = $_GET['id_subject'];
} else {
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
      <?php if ($status_teacher == 1) { ?>
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
          while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
            $name_subject =  $row1['name_subject'];
            $name_series_exam =  $row1['name_series_exam'];
            $status_result_exam_std =  $row1['status_result_exam_std'];
            $type_series_exam_sql =  $row1['type_series_exam'];
            $score_series_exam =  $row1['score_series_exam'];


            $score_series_exam = explode(";", $score_series_exam);
            $score_series_exam1 = $score_series_exam[0];

            // if($status_result_exam_std == 0){
            // 	break;
            // }

            if (strstr($type_series_exam_sql, ";")) {
              $type_series_exam_arr = explode(';', $type_series_exam_sql);
              $type_series_exam1 = $type_series_exam_arr[0];
              $type_series_exam2 = $type_series_exam_arr[1];
            } else {
              if ($type_series_exam_sql == 1) {
                $type_series_exam1 = 1;
                $type_series_exam2 = null;
              }
              if ($type_series_exam_sql == 2) {
                $type_series_exam2 = 2;
                $type_series_exam1 = null;
              }
            }
            // echo $type_series_exam1;
            // echo $type_series_exam2;

          }
          if ($status_result_exam_std == 3) {
            $sql1 = "SELECT * FROM `manager_series_exam`
								INNER JOIN manager_subject on manager_series_exam.id_subject_series_exam = manager_subject.id
								WHERE manager_series_exam.id = $id_series_exam";
            $result1 = mysqli_query($conn, $sql1);
            while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
              $name_subject =  $row1['name_subject'];
              $name_series_exam =  $row1['name_series_exam'];
            }
          }
          ?>
          <li class="breadcrumb-item"><a href="Series_Exam_Subject_List.php?id_subject=<?php echo $id_subject; ?>"><?php echo $name_subject; ?></a></li>
          <li class="breadcrumb-item"><a href="Series_Exam_Subject_List_page1.php?id=<?php echo $id_series_exam; ?>&name_series_exam=<?php echo $name_series_exam; ?>&id_subject=<?php echo $id_subject; ?>"><?php echo $name_series_exam; ?></a>
          <li class="breadcrumb-item active">ห้อง <?php echo $year_std_series_exam; ?></li>


        </ol>




        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header py-3">
            <!-- <form action="FPDF/index.php" target="_blank" method="POST"> -->
            <i class='fas'>&#xf0ae;</i>
            ผลสอบรายวิชา<?php echo $name_subject; ?> <b><?php echo $name_series_exam; ?></b>

            <?php if ($status_result_exam_std == 0) { ?>
              <a style="float:right" href="manager_send_exam_web.php?id_series_exam=<?php echo $id_series_exam; ?>&value=1&update_status"><button type="button" class="btn btn-success">ยืนยันรายงานผลสอบ</button></a>
            <?php } else if ($status_result_exam_std == 1) { ?>
              <a style="float:right" href="manager_send_exam_web.php?id_series_exam=<?php echo $id_series_exam; ?>&value=0&update_status"><button type="button" class="btn btn-danger"> ยกเลิกรายงานผลสอบ</button></a>
            <?php } ?>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th width="7%">
                      <center>ลำดับ</center>
                    </th>
                    <th width="15%">รหัสนักศึกษา</th>
                    <th width="19%">ชื่อ-นามสกุล</th>
                    <!-- <th width="10%">ห้องเรียน</th> -->
                    <th width="18%">สอบได้</th>
                    <th width="10%">รวม</th>
                    <th width="15%">
                      <center>สถานะ</center>
                    </th>
                    <th width="7%">
                      <center>ลบ</center>
                    </th>
                    <th width="7%">
                      <center>ปริ้น</center>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // echo "<br>";
                  // echo "<br>";
                  // echo "<br>";
                  // echo "<br>";
                  // echo "<br>";
                  // echo "<br>";
                  // echo "<br>";
                  // echo "<br>";
                  // echo "<br>";
                  // echo "<br>";
                  // echo "<br>";
                  // echo "<br>";
                  $num_result_result_exam = 0;
                  $exam_result_exam1 = 0;
                  $exam_result_exam1 = 0;
                  $exam_count1 = 0;
                  $exam_count2 = 0;
                  $result_exam2 = null;
                  $number = 1;
                  $ans_true = 0;
                  $i = 1;
                  $sql2 = "SELECT manage_std.id_std,
                    manage_std.gender_std,
                    manage_std.name_std,
                    manage_std.year_std,
                    result_exam_std.status_result_exam_std,
                    result_exam_std.id as id_result_exam_std,
                    result_exam_std.exam_result_exam,
                    result_exam_std.point_result_exam,
                    result_exam_std.result_result_exam
                    FROM `result_exam_std`
                    INNER JOIN manage_std on result_exam_std.id_std_result_exam = manage_std.id
                    WHERE `id_name_series_exam` = $id_series_exam AND year_std = '$year_std_series_exam'";

                  $result2 = mysqli_query($conn, $sql2);
                  while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
                    $id =  $row2['id_result_exam_std'];
                    $id_std =  $row2['id_std'];
                    $gender_std =  $row2['gender_std'];
                    $name_std =  $row2['name_std'];
                    $point_result_exam =  $row2['point_result_exam'];
                    $status_exam_std =  $row2['status_result_exam_std'];
                    $result_result_exam = $row2['result_result_exam'];

                    if ($gender_std == 1) {
                      $gender_std_name = "นาย";
                    } else if ($gender_std == 2) {
                      $gender_std_name = "นางสาว";
                    }

                    // print_r($row2['exam_result_exam']);
                    if (strstr($row2['exam_result_exam'], ";")) {
                      // echo "in1";
                      $exam_result_exam = explode(';', $row2['exam_result_exam']);
                      $result_result_exam = explode(';', $result_result_exam);
                      $exam_result_exam1 = $exam_result_exam[0];
                      $exam_result_exam2 = $exam_result_exam[1];
                      $result_result_exam1 = $result_result_exam[0];
                      $result_result_exam2 = $result_result_exam[1];
                      $exam_count1 = count(explode(',', $exam_result_exam1));
                      $exam_count2 = count(explode(',', $exam_result_exam2));

                      $sum_result_result_exam = $result_result_exam1 . "," . $result_result_exam2;
                      $result_result_exam = explode(',', $sum_result_result_exam);
                      $result_result_exam1 = explode(',', $result_result_exam1);
                      $result_result_exam2 = explode(',', $result_result_exam2);
                    } else {
                      if ($type_series_exam1 != null) {
                        $result_result_exam1 = $result_result_exam;
                        $result_result_exam1 = explode(',', $result_result_exam1);
                        $exam_result_exam1 = $row2['exam_result_exam'];
                        $exam_count1 = count(explode(',', $exam_result_exam1));
                      }
                      if ($type_series_exam2 != null) {

                        $result_result_exam2 = explode(',', $result_result_exam);
                        $exam_result_exam2 = $row2['exam_result_exam'];
                        $exam_count2 = count(explode(',', $exam_result_exam2));
                      }
                    }
                    //
                    for ($num_result_result_exam1 = 0; $num_result_result_exam1 < count($result_result_exam1); $num_result_result_exam1++) {
                      if ($result_result_exam1[$num_result_result_exam1] == 1) {
                        $result_true1 = 1;
                      } else {
                        $result_true1 = 0;
                      }
                      $ans_true1 = ($ans_true1 + $result_true1);
                    }
                    for ($num_result_result_exam2 = 0; $num_result_result_exam2 < count($result_result_exam2); $num_result_result_exam2++) {
                      if ($result_result_exam2[$num_result_result_exam2] == 1) {
                        $result_true2 = 1;
                      } else {
                        $result_true2 = 0;
                      }
                      $ans_true2 = ($ans_true2 + $result_true2);
                    }
                  ?>
                    <tr>
                      <td>
                        <center><b><?php echo $number; ?></b></center>
                      </td>
                      <td><?php echo $id_std; ?></td>
                      <td><?php echo $gender_std_name . $name_std; ?></td>
                      <!-- <td><?php echo $row2['result_result_exam']; ?></td> -->
                      <!-- <td><?php echo $year_std_series_exam; ?></td> -->
                      <td><?php
                          $point_result_exam2 = array_sum($point_result_exam2);
                          $point_result_exam =  $row2['point_result_exam'];
                          $arr_point_result_exam = explode(';', $point_result_exam);
                          $arr_point_result_exam = $arr_point_result_exam[1];

                          $result_result_exam =  $row2['result_result_exam'];
                          $arr_result_result_exam = explode(';', $result_result_exam);
                          $arr_result_result_exam1 = $arr_result_result_exam[0];
                          $arr_result_result_exam2 = $arr_result_result_exam[1];
                          if ($point_result_exam == null) {
                            $point_result_exam = explode(";", $point_result_exam);
                            if ($type_series_exam1 != null) {
                              $point_result_exam1 = $point_result_exam[0];
                              if ($point_result_exam1 == null) {
                                $point_result_exam1 = 0;
                              }
                              echo "<p><b>ปรนัย : </b>";
                              echo $ans_true1; ?>/<?php echo $exam_count1 . " ข้อ ";
                                                  echo "<b>" . $point_result_exam1 * $score_series_exam1 . " คะแนน</b>";
                                                  echo "</p>";
                                                }
                                                if ($type_series_exam2 != null) {
                                                  if (strstr($row2['result_result_exam'], ";")) {
                                                    $point_result_exam2 = explode(",", $point_result_exam[1]);
                                                  } else {
                                                    $point_result_exam2 = explode(",", $row2['point_result_exam']);
                                                  }
                                                  echo "<p><b>อัตนัย : </b>";
                                                  echo $ans_true2; ?>/<?php echo $exam_count2 . " ข้อ ";
                                                                          $point_result_exam2 = array_sum($point_result_exam2);
                                                                          if ($point_result_exam2 == 0) {
                                                                            echo "<b style='color:#1a53ff'>รอตรวจ</b>";
                                                                          } else {
                                                                            echo "<b>" . $point_result_exam2 . " คะแนน</b>";
                                                                            echo "</p>";
                                                                          }
                                                                        }
                                                                        // echo "รอตรวจ";
                                                                      } else {
                                                                        $point_result_exam = explode(";", $point_result_exam);
                                                                        if ($type_series_exam1 != null) {
                                                                          $point_result_exam1 = $point_result_exam[0];
                                                                          if ($point_result_exam1 == null) {
                                                                            $point_result_exam1 = 0;
                                                                          }
                                                                          echo "<p><b>ปรนัย : </b>";
                                                                          echo $ans_true1; ?>/<?php echo $exam_count1 . " ข้อ ";
                                                                          echo "<b>" . $point_result_exam1 * $score_series_exam1 . " คะแนน</b>";
                                                                          echo "</p>";
                                                                        }
                                                                        if ($type_series_exam2 != null) {
                                                                          if (strstr($row2['result_result_exam'], ";")) {
                                                                            $point_result_exam2 = explode(",", $point_result_exam[1]);
                                                                          } else {
                                                                            $point_result_exam2 = explode(",", $row2['point_result_exam']);
                                                                          }
                                                                          echo "<p><b>อัตนัย : </b>";

                                                                          $point_result_exam =  $row2['point_result_exam'];
                                                                          $arr_point_result_exam = explode(';', $point_result_exam);
                                                                          $arr_point_result_exam = $arr_point_result_exam[1];
                                                                          // echo "arr_point_result_exam==".$arr_point_result_exam;echo "<br>";
                                                                          // echo "result_result_exam==".$result_result_exam;echo "<br>";
                                                                          // echo "arr_result_result_exam2==".$arr_result_result_exam2;echo "<br>";
                                                                          // echo "arr_result_result_exam1==".$arr_result_result_exam1;echo "<br>";
                                                                          if ($arr_point_result_exam == null && $result_result_exam == null || $arr_result_result_exam2 == null && $arr_result_result_exam1 == null) {
                                                                            echo $ans_true2; ?>/<?php echo $exam_count2 . " ข้อ ";
                                                                            echo "<b style='color:#1a53ff'>รอตรวจ</b>";
                                                                          } else {
                                                                            $point_result_exam2 = array_sum($point_result_exam2);
                                                                            echo $ans_true2; ?>/<?php echo $exam_count2 . " ข้อ ";
                                                                            echo "<b>" . $point_result_exam2 . " คะแนน</b>";
                                                                            // echo "</p>";
                                                                          }
                                                                        }

                                                                        // }

                                                                      }
                                                                            ?></td>

                      <td>
                        <?php
                        $point_result_exam =  $row2['point_result_exam'];
                        // if($point_result_exam == null ){
                        //   echo "รอตรวจ";
                        // }else{
                        if (strstr($point_result_exam, ";")) {
                          $point_result_exam = explode(";", $point_result_exam);
                          $point_result_exam1 = $point_result_exam[0];
                          $point_result_exam2 = $point_result_exam[1];
                          if ($point_result_exam2 == null) {
                            $point_result_exam2 = '<a href="Series_Exam_Show_Point_check.php?id_std=' . $id_std . '&id_series_exam=' . $id_series_exam . '&year_std_series_exam=' . $year_std_series_exam . '&id_subject=' . $id_subject . '"><button type="button" class="btn btn-primary"></i> ตรวจข้อสอบ</button></a>';
                          } else {
                            $point_result_exam2 = array_sum(explode(",", $point_result_exam2));
                          }
                          // echo "- ปรนัย ".$point_result_exam1." คะแนน";
                          // echo "<br>";
                          // echo "- อัตนัย ".$point_result_exam2;
                          $point_result_exam = ($point_result_exam1 * $score_series_exam1) + $point_result_exam2;
                          // $point_result_exam = $score_series_exam;
                          echo "<b>" . $point_result_exam . " คะแนน</b>";
                        } else {
                          if ($result_result_exam2 == null && $result_result_exam1 == null) {
                            echo "รอตรวจ";
                          } else {
                            $point_result_exam = ($point_result_exam1 * $score_series_exam1) + $point_result_exam2;
                            echo "<b>" . array_sum(explode(",", $point_result_exam)) . " คะแนน</b>";
                          }
                          // $point_result_exam = $point_result_exam*$num_result_result_exam;
                        }
                        // }
                        ?>
                      </td>

                      <td>
                        <center>
                          <?php
                          $point_result_exam2 = array_sum($point_result_exam2);
                          $point_result_exam =  $row2['point_result_exam'];
                          $arr_point_result_exam = explode(';', $point_result_exam);
                          $arr_point_result_exam = $arr_point_result_exam[1];

                          $result_result_exam =  $row2['result_result_exam'];
                          $arr_result_result_exam = explode(';', $result_result_exam);
                          $arr_result_result_exam1 = $arr_result_result_exam[0];
                          $arr_result_result_exam2 = $arr_result_result_exam[1];
                          // echo $arr_result_result_exam1;
                          // echo $arr_result_result_exam2;
                          // echo "<br>";
                          // print_r($result_result_exam);
                          if ($status_exam_std == 0) {
                            $sql = "SELECT * FROM `manager_series_exam`
                          INNER JOIN result_exam_std on result_exam_std.id_name_series_exam = manager_series_exam.id
                          WHERE manager_series_exam.type_series_exam = 2 AND result_exam_std.id = $id";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0 || strstr($row2['exam_result_exam'], ";")) {
                              echo '<a href="Series_Exam_Show_Point_check.php?id_std=' . $id_std . '&id_series_exam=' . $id_series_exam . '&year_std_series_exam=' . $year_std_series_exam . '&id_subject=' . $id_subject . '"><button type="button" class="btn btn-primary"></i> ตรวจข้อสอบ</button></a>';
                            } else {
                              echo '<button disabled type="button" class="btn btn-secondary"></i> รอการยืนยัน</button>';
                            }
                          ?>
                            <?php } else {
                            // echo $arr_point_result_exam;
                            if ($arr_point_result_exam == null && $result_result_exam == null || $arr_result_result_exam2 == null && $arr_result_result_exam1 == null) {
                              echo '<a href="Series_Exam_Show_Point_check.php?id_std=' . $id_std . '&id_series_exam=' . $id_series_exam . '&year_std_series_exam=' . $year_std_series_exam . '&id_subject=' . $id_subject . '"><button type="button" class="btn btn-primary"></i> ตรวจข้อสอบ</button></a>';
                            } else {
                            ?>
                              <button disabled type="button" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i> ยืนยันแล้ว</button>
                          <?php
                            }
                          } ?>
                        </center>
                      </td>
                      <td>
                        <center>
                          <?php //if($status_exam_std == 0) {
                          ?>
                          <a href="manager_send_exam_web.php?id=<?php echo $id; ?>&id_series_exam=<?php echo $id_series_exam; ?>&delete_result_exam_std" onclick="return buttonDelete<?php echo $number; ?>();"><button type="button" class="btn btn-danger"><b>ลบ<b></button></a>
                          <? php // }else{ 
                          ?>
                          <!-- <button disabled type="button" class="btn btn-danger"><b>ลบ<b></button></a> -->
                          <?php //} 
                          ?>
                        </center>
                      </td>
                      <td>
                        <center>
                          <a href="FPDF/print_exam_std.php?id_std=<?= $id_std; ?>&id_series_exam=<?= $id_series_exam; ?>"><button type="button" class="btn btn-warning"><i style="font-size:15px" class="fa fa-print"></i></button></a>
                        </center>
                      </td>
                    </tr>
                  <?php $number++;
                    $ans_true1 = 0;
                    $ans_true2 = 0;
                  } ?>
                </tbody>
              </table>
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
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
?>

  <script>
    function buttonDelete<?php echo $i; ?>() {
      var result = confirm("แน่ใจว่าต้องการลบ");
      if (result == true) {
        return true;
      } else {
        return false;
      }
    }
  </script>
<?php $i++;
} ?>