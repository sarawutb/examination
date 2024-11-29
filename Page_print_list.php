<?php
session_start();
  if ($_SESSION['id_teacher']) {
	 include("connect.php");
	 $id_teacher = $_SESSION['id_teacher'];
	 $status_teacher = $_SESSION['status_teacher'];
   $branch_name = "";
	// $branch_name = $_GET['branch_name'];
	 //$branch_id = $_GET['branch_id'];
$id_subject_series_exam = $_GET['id_subject_series_exam'];
// $genre_subject = $_GET['genre_subject'];
	// $genre_std = $_GET['branch_genre'];
	 //echo $status_teacher;

	 $sql_teacher = "SELECT * FROM `manager_teacher` WHERE id_teacher=$id_teacher";
                    $result_teacher = mysqli_query($conn, $sql_teacher);
					$number = 1;
                    while ($row_teacher = mysqli_fetch_array($result_teacher,MYSQLI_ASSOC)) {
                        $data_id =  $row_teacher['id_teacher'];
                        $data_id_teacher =  $row_teacher['id_teacher'];
                        $data_name_teacher_subject =  $row_teacher['name_teacher'];
					}

          $sql = "SELECT * FROM `manager_subject`WHERE `id` = $id_subject_series_exam ";
                           $result = mysqli_query($conn, $sql);
                           while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                               $name_subject =  $row['name_subject'];
                               $genre_subject =  $row['genre_subject'];
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
          </li>
          <li class="breadcrumb-item">
            <a href="Series_Exam_Subject_List.php?id_subject=<?php echo $id_subject_series_exam; ?>"><?php echo $name_subject; ?></a>
          </li>
          <li class="breadcrumb-item active">ปริ้นคะแนนสอบ</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
			<div class="card-header py-3">
        <i class='fas'>&#xf0ae;</i>
        ชุดข้อสอบ วิชา<?php echo $name_subject;?>
			</div>
          <div class="card-body">
           <div class="container-fluid">
             <div class="row">
               <?php
               $sum_array = null;
               $sql = "SELECT DISTINCT `branch_id_series_exam` , manager_branch.branch_name , branch_genre
                      FROM `manager_series_exam`
                      INNER JOIN manager_branch on manager_branch.branch_id = manager_series_exam.branch_id_series_exam
                      WHERE branch_genre = $genre_subject AND manager_series_exam.id_subject_series_exam = $id_subject_series_exam
                      ORDER BY `manager_branch`.`branch_name` ASC";
                             $result = mysqli_query($conn, $sql);
                             while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                                 $branch_id  =  $row['branch_id_series_exam'];
                            //     $teacher_id_series_exam   =  $row['teacher_id_series_exam'];
if($status_teacher == 1){
               $sql1 = "SELECT * FROM `manager_series_exam`
                         INNER JOIN manager_branch on manager_branch.branch_id = manager_series_exam.branch_id_series_exam
                         INNER JOIN manager_subject on manager_subject.id = manager_series_exam.id_subject_series_exam
                        WHERE `id_subject_series_exam` = $id_subject_series_exam
                        AND `branch_id_series_exam`= $branch_id
                        ORDER BY `manager_series_exam`.`year_std_series_exam` ASC";
                      }else if($status_teacher == 2){
                        $sql1 = "SELECT * FROM `manager_series_exam`
                                 INNER JOIN manager_branch on manager_branch.branch_id = manager_series_exam.branch_id_series_exam
                                 INNER JOIN manager_subject on manager_subject.id = manager_series_exam.id_subject_series_exam
                                 WHERE `id_subject_series_exam` = $id_subject_series_exam
                                 AND teacher_id_series_exam = $data_id_teacher
                                 AND `branch_id_series_exam`= $branch_id
                                 ORDER BY `manager_series_exam`.`year_std_series_exam` ASC";
                               }
                             $result1 = mysqli_query($conn, $sql1);
                   //$number = 1;
                             while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
                                 $year_std_series_exam  =  $row1['year_std_series_exam'];
                                 $id_subject_series_exam  =  $row1['id_subject_series_exam'];
                                 $branch_id  =  $row1['branch_id'];
                                 $branch_name  =  $row1['branch_name'];
                                 $name_subject  =  $row1['name_subject'];

                                $sum_array = $sum_array.$year_std_series_exam.",";
                                  //echo $year_std_series_exam;

                                }
                            //      echo $sum_array."<br>";
                              //   if($branch_name == ""){
                              // //    break;
                              //   }
                                 $im_arr = explode(",",$sum_array);
                                 array_pop($im_arr);

                     						for ($i=0; $i < count($im_arr); $i++) {
                     						    $im_arr_1 = $im_arr[$i].",";
                                    //print_r ($im_arr_1);
                                //    array_unique($im_arr_1);
                                  $sum_array = $sum_array.$im_arr_1;
                                  }
                                  $im_arr_2 = explode(",",$sum_array);

                                  $i=0;
                                  $list_array = array();
                                  $result_array= array_unique ($im_arr_2);
                                  array_pop($result_array);






                                  //print_r($result_array);


                                //  array_unique($im_arr_1);
                                //  echo $sum_array;;
                                  // array_unique($sum_array);


               ?>
  <div class="col-md-4">
		   <b>
       <?php
          echo $branch_name;
       ?>
     </b><hr>
        <?php
        natsort($result_array);
        // print_r($result_array);

        foreach($result_array as $value){
        $list_array[$i] = $value;
        ?>
        <form action="FPDF\point_student.php?รายวิชา<?php echo $name_subject; ?>" target="_blank" method="POST">
				<p class="ml-1">
          <div class="row">
            <div class="col-md-5">
          ห้อง
          <?php echo $list_array[$i]; ?>
        </div>
          <div class="col-md-7">
          <input hidden type="text" name="name_subject" value="<?php echo $name_subject; ?>"/>
          <input hidden type="text" name="id_subject_series_exam" value="<?php echo $id_subject_series_exam; ?>"/>
          <input hidden type="text" name="branch_name" value="<?php echo $branch_name; ?>"/>
          <input hidden type="text" name="branch_id" value="<?php echo $branch_id; ?>"/>
          <input hidden type="text" name="year_std" value="<?php echo $list_array[$i];; ?>"/>
        <button type="submit"  class="btn btn-warning"><i class="fa fa-print" aria-hidden="true"> ปริ้น</i></button>
      </div>
      </div>
        </p>
        </form>
        <?php
        $i++;
        }
        ?>
		  <br>
        </div>
        <?php
        $sum_array = null;
       }
         ?>
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

  <?php
  $i = 1;
	$sql = "SELECT * FROM `manage_std` WHERE IsUse = 1;";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
  ?>

  <script>
	  function buttonDelete<?php echo $i;?>() {
	  var result = confirm("แน่ใจว่าต้องการลบ ?");
	  if (result==true) {
	   return true;
	  } else {
	   return false;
	  }
	}
  </script>
	<?php $i++;} ?>

</body>

</html>
