<?php
session_start();
  if ($_SESSION['id_teacher']) {
	 include("connect.php");
	 $id_teacher = $_SESSION['id_teacher'];
	 $status_teacher = $_SESSION['status_teacher'];
	 $name_series_exam = $_GET['name_series_exam'];
//$year_std_series_exam = $_GET['year_std_series_exam'];
 $id_subject = $_GET['id_subject'];
$id_list = $_GET['id'];
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
          <?php
    		  $sql4 = "SELECT * FROM `manager_subject` WHERE `id`= $id_subject";
    			$result4 = mysqli_query($conn, $sql4);
    			while ($row4 = mysqli_fetch_array($result4,MYSQLI_ASSOC)){
    			$name_subject =  $row4['name_subject'];
    			$genre_subject =  $row4['genre_subject'];
    			}
          ?>
          <li class="breadcrumb-item"><a href="Series_Exam_Subject_List.php?id_subject=<?php echo $id_subject; ?>"><?php echo $name_subject;?></a></li>
          <li class="breadcrumb-item active"><?php echo $name_series_exam;?></li>
        </ol>
        <?php
        $sql = "SELECT * FROM `manager_subject` WHERE `id` = $id_subject";
                         $result = mysqli_query($conn, $sql);
                         while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                             $name_subject =  $row['name_subject'];
                           }
        ?>

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
               $sql = "SELECT * FROM `manager_series_exam`
                      INNER JOIN manager_branch on manager_branch.branch_id = manager_series_exam.branch_id_series_exam
                      WHERE `id` = $id_list;";
                             $result = mysqli_query($conn, $sql);
                             while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                                 $id  =  $row['id'];
                                 $year_std_series_exam  =  $row['year_std_series_exam'];
                                 $teacher_id_series_exam   =  $row['teacher_id_series_exam'];
                                 $branch_name  =  $row['branch_name'];

                                 $sum_array = $sum_array.$year_std_series_exam.",";


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
        foreach($result_array as $value){
        $list_array[$i] = $value;
        ?>
        <!-- <form action="FPDF/ผลคะแนนสอบ.php?รายวิชา<?php echo $name_subject; ?>" target="_blank" method="POST"> -->
          <a href="Series_Exam_Show_Point.php?id_series_exam=<?php echo $id; ?>&year_std_series_exam=<?php echo $list_array[$i]; ?>&id_subject=<?php echo $id_subject; ?>" class="ml-1">ห้อง <?php echo $list_array[$i]; ?></a><br>
        <!-- </form> -->
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
