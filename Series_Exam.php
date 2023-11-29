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

function DateThai($strDate)
{
  $strYear = date("Y", strtotime($strDate)) + 543;
  $strMonth = date("n", strtotime($strDate));
  $strDay = date("j", strtotime($strDate));
  $strHour = date("H", strtotime($strDate));
  $strMinute = date("i", strtotime($strDate));
  $strSeconds = date("s", strtotime($strDate));
  $strMonthCut = array("", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค.");
  $strMonthThai = $strMonthCut[$strMonth];
  return "$strHour:$strMinute $strDay/$strMonthThai/$strYear";
}

function DateDiff($strDate1, $strDate2)
{
  return (strtotime($strDate2) - strtotime($strDate1)) /  (60 * 60 * 24);  // 1 day = 60*60*24
}
function TimeDiff($strTime1, $strTime2)
{
  return (strtotime($strTime2) - strtotime($strTime1)) /  (60 * 60); // 1 Hour =  60*60
}
function DateTimeDiff($strDateTime1, $strDateTime2)
{
  return (strtotime($strDateTime2) - strtotime($strDateTime1)) /  (60 * 60); // 1 Hour =  60*60
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <?php header("Cache-Control: public, max-age=60, s-maxage=60"); ?>

  <title>ระบบข้อสอบออนไลน์</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<html lang="en" style="font-size:100%">

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
        <li class="breadcrumb-item active">ชุดข้อสอบ</li>
      </ol>

      <!-- DataTables Example -->
      <div class="card mb-3">
        <div class="card-header form-inline">
          <i class='fas'>&#xf0ae;</i>
          ชุดข้อสอบ
          <div class="form-group">
            <form name='action' action="Series_Exam.php" method="get">
              <select name="term_subject" OnChange="document.action.submit();" style="width:200px" class="form-control ml-2" required="required">
                <!-- <option>==เลือกปีการศึกษา==</option> -->
                <?php
                $term_subject = null;
                if ($status_teacher == 1) {
                  $sql = "SELECT DISTINCT `term_subject` ,
                          SUBSTRING_INDEX(`term_subject`,'/',1) AS term,SUBSTRING_INDEX(`term_subject`,'/',-1) AS term_y
                          FROM manager_subject
                          ORDER BY `term_y` ASC , `term` ASC,`manager_subject`.`id_subject`  ASC";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $term_subject_now = $row['term_subject'];
                  }

                  $sql2 = "SELECT DISTINCT `term_subject` ,
                          SUBSTRING_INDEX(`term_subject`,'/',1) AS term,SUBSTRING_INDEX(`term_subject`,'/',-1) AS term_y
                          FROM manager_subject
                          ORDER BY `term_y` ASC , `term` ASC,`manager_subject`.`id_subject`  ASC";
                } else if ($status_teacher == 2) {
                  $sql = "SELECT DISTINCT `term_subject` ,
                                    SUBSTRING_INDEX(`term_subject`,'/',1) AS term,SUBSTRING_INDEX(`term_subject`,'/',-1) AS term_y
                                    FROM manager_subject
                                    INNER JOIN manager_teacher ON manager_subject.name_teacher_subject=manager_teacher.id_teacher
                      							WHERE name_teacher_subject = $id_teacher
                                    ORDER BY `term_y` ASC , `term` ASC,`manager_subject`.`id_subject`  ASC";
                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $term_subject_now = $row['term_subject'];
                  }
                  $sql2 = "SELECT DISTINCT `term_subject` ,
                                    SUBSTRING_INDEX(`term_subject`,'/',1) AS term,SUBSTRING_INDEX(`term_subject`,'/',-1) AS term_y
                                    FROM manager_subject
                                    INNER JOIN manager_teacher ON manager_subject.name_teacher_subject=manager_teacher.id_teacher
                      							WHERE name_teacher_subject = $id_teacher
                                    ORDER BY `term_y` ASC , `term` ASC,`manager_subject`.`id_subject`  ASC";
                }
                $result2 = mysqli_query($conn, $sql2);
                while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
                  $term_subject = $row2['term_subject'];
                ?>
                  <!-- <option <?php if (isset($_GET["branch_id_series_exam"])) {
                                  if ($branch_id_series_exam == $branch_id) {
                                    echo "selected";
                                  }
                                } else if (isset($_GET["edit"])) {
                                  if ($branch_id_series_exam == $branch_id) {
                                    echo "selected";
                                  }
                                }

                                ?> value="<?php echo $branch_id; ?>"><?php echo $branch_name; ?></option> -->

                  <option <?php if (isset($_GET["term_subject"])) {
                            $term = $_GET["term_subject"];
                            if ($term == $term_subject) {
                              echo "selected";
                            }
                          } else if ($term_subject_now == $term_subject) {
                            echo "selected";
                          }
                          ?> value="<?php echo $term_subject; ?>"><?php echo $term_subject; ?></option>
                <?php }
                if ($term_subject == null) {
                  echo "<option>ยังไม่มีรายวิชา</option>";
                } ?>
              </select>
            </form>
          </div>

        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th width="7%">
                    <center>ลำดับ</center>
                  </th>
                  <th width="33%">ชื่อรายวิชา</th>
                  <!-- <th width="10%">ภาคเรียน</th> -->
                  <th width="13%">จำนวนชุดข้อสอบ</th>
                  <?php if ($status_teacher == 1) { ?>
                    <th width="20%">ชื่ออาจารย์ผู้ออกข้อสอบ</th>
                  <?php } ?>

                  <th width="17%">
                    <center>ตรวจสอบ</center>
                  </th>
                  <!-- <th width="15%"><center>จัดการชุดข้อสอบ</center></th> -->
                  <!-- <th width="12%"><center>ปริ้นคะแนนสอบ</center></th> -->
                </tr>
              </thead>
              <tbody>
                <?php
                if ($status_teacher == 1) {
                  if (isset($_GET["term_subject"])) {
                    $term = $_GET["term_subject"];
                    $sql1 = "SELECT DISTINCT`id_subject_series_exam`,
                        manager_subject.id_subject,
                        manager_subject.genre_subject,
                        manager_subject.term_subject,
                        SUBSTRING_INDEX(`term_subject`,'/',1) AS term,SUBSTRING_INDEX(`term_subject`,'/',-1) AS term_y
                        FROM `manager_series_exam`
                        INNER JOIN manager_subject on manager_subject.id = manager_series_exam.id_subject_series_exam
                        INNER JOIN manager_teacher on manager_teacher.id_teacher = manager_subject.name_teacher_subject
                        WHERE manager_subject.term_subject = '$term'
                        ORDER BY manager_teacher.name_teacher ASC , `term_y` ASC , `term` ASC,`manager_subject`.`id_subject`  ASC, `manager_subject`.`id_subject`  ASC , manager_subject.genre_subject ASC";
                  } else {
                    $sql1 = "SELECT DISTINCT`id_subject_series_exam`,
                    manager_subject.id_subject,
                    manager_subject.genre_subject,
                    manager_subject.term_subject,
                    SUBSTRING_INDEX(`term_subject`,'/',1) AS term,SUBSTRING_INDEX(`term_subject`,'/',-1) AS term_y
                    FROM `manager_series_exam`
                    INNER JOIN manager_subject on manager_subject.id = manager_series_exam.id_subject_series_exam
                    INNER JOIN manager_teacher on manager_teacher.id_teacher = manager_subject.name_teacher_subject
                    WHERE manager_subject.term_subject = '$term_subject_now'
                    ORDER BY manager_teacher.name_teacher ASC , `term_y` ASC , `term` ASC,`manager_subject`.`id_subject`  ASC, `manager_subject`.`id_subject`  ASC , manager_subject.genre_subject ASC";
                  }
                } else if ($status_teacher == 2) {
                  if (isset($_GET["term_subject"])) {
                    $term = $_GET["term_subject"];
                    $sql1 = "SELECT DISTINCT`id_subject_series_exam`,
                        manager_subject.id_subject,
                        manager_subject.genre_subject,
                        manager_subject.term_subject,
                        SUBSTRING_INDEX(`term_subject`,'/',1) AS term,SUBSTRING_INDEX(`term_subject`,'/',-1) AS term_y
                        FROM `manager_series_exam`
                        INNER JOIN manager_subject on manager_subject.id = manager_series_exam.id_subject_series_exam
                        WHERE manager_subject.term_subject = '$term' AND manager_series_exam.`teacher_id_series_exam` = $data_id_teacher
                        ORDER BY `term_y` ASC , `term` ASC,`manager_subject`.`id_subject`  ASC, `manager_subject`.`id_subject`  ASC , manager_subject.genre_subject ASC";
                  } else {
                    $sql1 = "SELECT DISTINCT`id_subject_series_exam`,
                      manager_subject.id_subject,
                      manager_subject.genre_subject
                      FROM `manager_series_exam`
                      INNER JOIN manager_subject on manager_subject.id = manager_series_exam.id_subject_series_exam
                      WHERE manager_subject.term_subject = '$term_subject_now' AND manager_series_exam.`teacher_id_series_exam` = $data_id_teacher
                      ORDER BY `manager_subject`.`id_subject`  ASC , manager_subject.genre_subject ASC";
                  }
                }
                $result1 = mysqli_query($conn, $sql1);
                $number = 1;
                while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
                ?>
                  <script>
                    function buttonDelete<?php echo $number; ?>() {
                      var result = confirm("แน่ใจว่าต้องการชุดข้อสอบ <?php echo $name_series_exam; ?>?");
                      if (result == true) {
                        return true;
                      } else {
                        return false;
                      }
                    }
                  </script>
                  <?php
                  //$id =  $row1['id'];
                  $id_subject_series_exam =  $row1['id_subject_series_exam'];
                  $type_exam =  1;
                  $id_series =  292;

                  $sql2 = "SELECT * FROM `manager_subject` WHERE id = $id_subject_series_exam";
                  $result2 = mysqli_query($conn, $sql2);
                  while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
                    $id_subject =  $row2['id'];
                    $id_subject_id =  $row2['id_subject'];
                    $name_subject =  $row2['name_subject'];
                    $name_teacher_subject =  $row2['name_teacher_subject'];
                    $genre_subject =  $row2['genre_subject'];
                    $term =  $row2['term_subject'];
                  }
                  if ($genre_subject == 1) {
                    $genre_subject = "ปวช";
                  } else if ($genre_subject == 2) {
                    $genre_subject = "ปวส";
                  }

                  $sql3 = "SELECT COUNT(`id`) as num_series_exam FROM `manager_series_exam` WHERE `id_subject_series_exam` = $id_subject_series_exam";
                  $result3 = mysqli_query($conn, $sql3);
                  while ($row3 = mysqli_fetch_array($result3, MYSQLI_ASSOC)) {
                    $num_series_exam =  $row3['num_series_exam'];

                    $sql4 = "SELECT * FROM `manager_teacher` WHERE `id_teacher` = $name_teacher_subject";
                    $result4 = mysqli_query($conn, $sql4);
                    while ($row4 = mysqli_fetch_array($result4, MYSQLI_ASSOC)) {
                      $name_teacher =  $row4['name_teacher'];
                      $gender_teacher =  $row4['gender_teacher'];

                      if ($gender_teacher == 1) {
                        $teacher_gender = "นาย";
                      } else if ($gender_teacher == 2) {
                        $teacher_gender = "นาง";
                      } else if ($gender_teacher == 3) {
                        $teacher_gender = "นางสาว";
                      }
                    }


                  ?>
                    <tr>
                      <td>
                        <center><b><?php echo $number; ?></b></center>
                      </td>
                      <td><a href="Series_Exam_Subject_List.php?id_subject=<?php echo $id_subject_series_exam; ?>"><?php echo $term; ?> <b>(<?php echo $genre_subject; ?>.)</b> <?php echo $id_subject_id . " " . $name_subject; ?></a></td>
                      <!-- <td</td> -->
                      <td><?php echo $num_series_exam; ?> ชุด</td>
                      <?php if ($status_teacher == 1) { ?>
                        <td><?php echo $teacher_gender . $name_teacher; ?></td>
                      <?php } ?>
                      <!-- <td>
						<center>
						  <button type="button" class="btn btn-success"><i style="font-size:20px" class="fa">&#xf013;</i></button></a>
						</center>
					</td> -->
                      <!-- <td>
						<center>
						<form action="print/Print_Subject_Point.php" target="_blank" method="POST">
						<input hidden type="text" name="id_subject_series_exam" value="<?php echo $id_subject_series_exam; ?>"/>
						<input hidden type="text" name="id_name_series_exam" value="<?php echo $id_subject_series_exam; ?>"/>
						<button  type="submit" class="btn btn-warning"><i class="fa fa-print" aria-hidden="true"></i></button>
						</form>
						</center>
					</td> -->

                      <td>
                        <div>
                          สอบกลางภาค : <b>
                            <?php $sql = "SELECT * FROM `manager_subject`
                              INNER JOIN manager_series_exam on manager_series_exam.id_subject_series_exam = manager_subject.id
                              WHERE manager_series_exam.type_exam = 2 AND manager_series_exam.id_subject_series_exam = $id_subject_series_exam";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                              echo '<i style="font-size:15px;color:green" class="fa">&#xf00c;</i>';
                            } else {
                              echo '<i style="font-size:15px;color:gray" class="fa">&#xf056;</i>';
                            } ?>
                          </b>
                        </div>
                        <div>
                          สอบปลายภาค : <b>
                            <?php $sql = "SELECT * FROM `manager_subject`
                              INNER JOIN manager_series_exam on manager_series_exam.id_subject_series_exam = manager_subject.id
                              WHERE manager_series_exam.type_exam = 3 AND manager_series_exam.id_subject_series_exam = $id_subject_series_exam";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                              echo '<i style="font-size:15px;color:green" class="fa">&#xf00c;</i>';
                            } else {
                              echo '<i style="font-size:15px;color:gray" class="fa">&#xf056;</i>';
                            } ?>
                          </b>
                        </div>
                      </td>
                    </tr>
                <?php $number++;
                  }
                } ?>
              </tbody>
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
                    <input type="text" class="form-control" name="" required="required" autofocus="autofocus"></input>
                  </div>
                </div>

                <div class="form-group">
                  <label>ชื่อวิชา</label>
                  <div class="form-label-group">
                    <input type="text" class="form-control" name="" required="required" autofocus="autofocus"></input>
                  </div>
                </div>

                <div class="form-group">
                  <label>ชื่ออาจารย์ผู้สอน</label>
                  <div class="form-label-group">
                    <input type="text" class="form-control" name="" required="required" autofocus="autofocus"></input>
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
                    <input type="text" class="form-control" name="" required="required" autofocus="autofocus"></input>
                  </div>
                </div>

                <div class="form-group">
                  <label>ชื่อวิชา</label>
                  <div class="form-label-group">
                    <input type="text" class="form-control" name="" required="required" autofocus="autofocus"></input>
                  </div>
                </div>

                <div class="form-group">
                  <label>ชื่ออาจารย์ผู้สอน</label>
                  <div class="form-label-group">
                    <input type="text" class="form-control" name="" required="required" autofocus="autofocus"></input>
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
<!--  -->