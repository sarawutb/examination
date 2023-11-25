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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>

</head>
<style>
textarea#note {
	width:50%;
	box-sizing:border-box;
	display:block;
	height:150px;
	background:linear-gradient(#FFFFFF, #FFFFFF);
	background:-ms-linear-gradient(#FFFFFF, #FFFFFF);
	background:-moz-linear-gradient(#FFFFFF, #FFFFFF);
	background:-webkit-linear-gradient(#FFFFFF, #FFFFFF);
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

<?php if(isset($_GET["name_subject_id"])){
	$id_chapter = $_GET["name_subject_id"];
	?>



    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php">หน้าหลัก</a>
          </li>
          <li class="breadcrumb-item">
			<a href="Subject.php">จัดการรายวิชา</a>
		  </li>
		  <?php
				$sql1 = "SELECT * FROM `manager_subject` WHERE id = $id_chapter";
						$result1 = mysqli_query($conn, $sql1);
						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
							$name_subject =  $row1['name_subject'];
						}
		  ?>
		  <li class="breadcrumb-item active"><?php echo $name_subject; ?></li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class='far'>&#xf249;</i>
			<?php
						$sql = "SELECT COUNT(name_name_subject) AS sum_chapter FROM manager_chapter WHERE name_name_subject = $id_chapter";
						$result = mysqli_query($conn, $sql);
						$num_chapter = 1;
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
							$sum_chapter =  $row['sum_chapter'];
						}
						$sql1 = "SELECT * FROM `manager_subject` WHERE id = $id_chapter";
						$result1 = mysqli_query($conn, $sql1);
						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
							$name_subject =  $row1['name_subject'];
						}
						?>
				วิชา : <?php echo $name_subject;?> <?php if($sum_chapter<=0){echo "<font color='red'><b>ยังไม่มีหน่วยเรียน</b></font>";} else{echo "มีอยู่ <b>".$sum_chapter."</b> หน่วย";} ?>
			<a href="#" data-toggle="modal" data-target="#myModal"><button type="button" class="btn btn-success">เพิ่มบทเรียน</button></a>
			</div>
          <div class="card-body">




            <div class=" " >
				<?php
						$sql = "SELECT * FROM `manager_chapter` WHERE name_name_subject = $id_chapter ORDER BY `manager_chapter`.`id` ASC";
						$result = mysqli_query($conn, $sql);
						$num_chapter = 1;
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
							$data_id =  $row['id'];
							$data_name_chapter =  $row['name_chapter'];
							// $data_objective_chapter =  $row['objective_chapter'];
							$data_name_name_subject =  $row['name_name_subject'];

						$sql1 = "SELECT * FROM `manager_chapter` WHERE manager_chapter.id = $data_id ";
						$result1 = mysqli_query($conn, $sql1);
						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
							$edit_id_chapter =  $row1['id'];
							// $edit_num_chapter =  $row1['num_chapter'];
							$edit_name_chapter =  $row1['name_chapter'];
							// $edit_objective_chapter =  $row1['objective_chapter'];

						?>
						<div class="card-header" style="border-radius: 5px 5px 5px 5px;">
						<div class="row">
						<div class="col-sm-12" id="show_up1<?php echo $num_chapter;?>">
						<!-- <div class="col-sm-12" id="show_up1<?php echo $num_chapter;?>" onclick="hideBntUp<?php echo $num_chapter;?>(this)" data-toggle="collapse" aria-expanded="true" aria-controls="collapse1"  data-target="#collapse<?php echo $num_chapter;?>"> -->
              <a id="delete_chapter<?php echo $num_chapter;?>" href="Manager_Exam_Chapter_Sql.php?name_subject_id=<?php echo $id_chapter;?>&id=<?php echo $edit_id_chapter;?>&delete_chapter" onclick="return buttonDelete<?php echo $num_chapter;?>();"><button type="button" class="btn btn-danger"><i style='font-size:15px;' class='fas'>&#xf2ed;</i></button></a>
              <a id="edit_chapter<?php echo $num_chapter;?>" href="#collapse<?php echo $num_chapter;?>" role="button" data-toggle="modal" data-target="#myModal<?php echo $data_id;?>"><button type="button" class="btn btn-warning"><i style='font-size:15px' class='fas'>&#xf303;</i></button></a>

              <!-- <a id="edit_chapter<?php echo $num_chapter;?>" href="#collapse<?php echo $num_chapter;?>" role="button" data-toggle="modal" data-target="#myModal<?php echo $data_id;?>"><button type="button" class="btn btn-warning"><i style='font-size:24px' class='fas'>&#xf303;</i></button></a> -->
							<!-- <a id="delete_chapter<?php echo $num_chapter;?>" href="Manager_Exam_Chapter_Sql.php?name_subject_id=<?php echo $id_chapter;?>&id=<?php echo $edit_id_chapter;?>&delete_chapter" onclick="return buttonDelete<?php echo $num_chapter;?>();"><button type="button" class="btn btn-danger"><i style='font-size:20px;' class='fas'>&#xf2ed;</i></button></a> -->
              <i class='mb-4 far'>&#xf249; <b><?php echo $data_name_chapter; ?></b></i>
              <br>
              <a id="add_chapter<?php echo $num_chapter;?>" href="Manager_Exam_Add.php?id_chapter=<?php echo $data_id;?>"><i style='font-size:15px' class='fas'>&#xf303;</i> ข้อสอบแบบปรนัย</a>
              <br>
              <a id="add_chapter<?php echo $num_chapter;?>" href="Manager_Exam_Add_Annotated.php?id_chapter=<?php echo $data_id;?>"><i style='font-size:15px' class='fas'>&#xf303;</i> ข้อสอบแบบอัตนัย</a>

              <!-- <a id="add_chapter<?php echo $num_chapter;?>" href="Manager_Exam_Add.php?id_chapter=<?php echo $data_id;?>"><button type="button" class="btn btn-success ml-3">เพิ่มข้อสอบบทที่ <?php echo $num_chapter;?></button></a> -->

              <!-- <i style="float:right;font-size:25px" id="down<?php echo $num_chapter;?>" class="fa fa-caret-down" aria-hidden="true"></i>
              <i style="float:right;font-size:25px" hidden id="up<?php echo $num_chapter;?>" class="fa fa-caret-up" aria-hidden="true"></i> -->
            </div>
            <script>
            $('.no-collapsable').on('click', function (e) {
                  e.stopPropagation();
              });
            </script>


									<div class="modal fade" id="myModal<?php echo $data_id;?>" role="dialog">
										<div class="modal-dialog modal-lg">
											<div class="modal-content">
															<div class="modal-header">
															  <h5 class="modal-title">แก้ไขข้อมูล</h5>
															  <button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>
															<div class="modal-body">
															<form action="Manager_Exam_Chapter_Sql.php?name_subject_id=<?php echo $id_chapter; ?>" method="GET">

															<input type="text" hidden class="form-control" name="name_subject_id" value="<?php echo $id_chapter;?>" required="required" autofocus="autofocus"></input>
															<input type="text" hidden class="form-control" name="id_chapter" value="<?php echo $edit_id_chapter;?>" required="required" autofocus="autofocus"></input>
															<!-- <div class="form-group">
															  <label>บทที่</label>
																<div class="form-label-group">
																  <input type="text" class="form-control" name="num_chapter" required="required" spellcheck="false" value="<?php echo $edit_num_chapter; ?>" oninput="this.value = this.value.replace(/[^0-9,]/g, '').replace(/(\..*)\./g, '$1');">
																</div>
															  </div> -->

															  <div class="form-group">
															  <label>ชื่อบทเรียน</label>
																<div class="form-label-group">
																  <input type="text"  class="form-control" name="name_chapter" required="required" value="<?php echo $edit_name_chapter; ?>" autofocus="autofocus"></input>
																</div>
															  </div>

															  <!-- <div class="form-group">
															  <label>วัตถุประสงค์</label>
																<div class="form-label-group">
																  <textarea id="show_txarea" type="text" rows="8" class="form-control" name="objective_chapter" required="required" autofocus="autofocus"><?php echo $edit_objective_chapter; ?></textarea>
																  </div>
															  </div> -->

															  <div class="container">
															  <button type="submit" name="update_chapter" class="btn btn-primary btn-block">อัพเดท</button>
															  </div>




															</form>
															</div>
															<div class="modal-footer">
															  <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
															</div>
														  </div>

														</div>
													  </div>



						<!---<div class="col-sm-3" id="show_up2<?php echo $num_chapter;?>" onclick="hideBntUp<?php echo $num_chapter;?>(this)" href="#collapse<?php echo $num_chapter;?>" role="button" data-toggle="collapse">
								<a id="show<?php echo $num_chapter;?>" onclick="show<?php //echo $i;?>()" href="#collapse<?php //echo $i;?>" role="button" data-toggle="collapse">
									<button id="text_show<?php //echo $i;?>" type="button" class="btn">แสดง</button>
								</a>
								<a hidden id="hide<?php //echo $i;?>" onclick="hide<?php //echo $i;?>()" href="#collapse<?php //echo $i;?>" role="button" data-toggle="collapse">
									<button id="text_hide<?php //echo $i;?>" type="button" class="btn btn-default">ย่อ</button>
								</a>


						</div>----->
						</div>
						</div>


          <div id="collapse<?php echo $num_chapter;?>" class="panel-collapse collapse">
            <div class=" ">
              <table class="" id="dataTable" width="100%" cellspacing="0">
                <!-- <thead> -->

                <!-- </thead> -->
                  <div class="mt-2">
                    <h5><u>วัตถุประสงค์</u>
                    <button id="update_chapter<?php echo $num_chapter;?>" hidden type="submit" class="btn btn-primary">อัพเดท</button>
      							<!-- <a id="add_chapter<?php echo $num_chapter;?>" href="Manager_Exam_Add.php?id_chapter=<?php echo $data_id;?>"><button type="button" class="btn btn-success ml-3">เพิ่มข้อสอบบทที่ <?php echo $num_chapter;?></button></a> -->
      							<a id="edit_chapter<?php echo $num_chapter;?>" href="#collapse<?php echo $num_chapter;?>" role="button" data-toggle="modal" data-target="#myModal<?php echo $data_id;?>"><button type="button" class="btn btn-warning ml-3"><i style='font-size:15px' class='fas'>&#xf303;</i></button></a>
      							<a id="delete_chapter<?php echo $num_chapter;?>" href="Manager_Exam_Chapter_Sql.php?name_subject_id=<?php echo $id_chapter;?>&id=<?php echo $edit_id_chapter;?>&delete_chapter" onclick="return buttonDelete<?php echo $num_chapter;?>();"><button type="button" class="btn btn-danger"><i style='font-size:15px;' class='fas'>&#xf2ed;</i></button></a>
                    </h5>
            </div>
              <div>
					<pre style="height:200px;background-color:white;font-size:15px" class="form-control mt-3" id="show_txarea<?php echo $num_chapter;?>" readonly><?php echo $data_objective_chapter;?></pre>


                  </div>
						</table>
					</div>
				</div>
						<?php $num_chapter++; }} ?>
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
							  <h5 class="modal-title">เพิ่มบทเรียน</h5>
							  <button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							<div class="modal-body">
							<form action="Manager_Exam_Chapter_Sql.php?name_subject_id=<?php echo $id_chapter;?>" method="GET">
							   <input type="text" hidden class="form-control"  name="name_subject_id" value="<?php echo $id_chapter;?>" required="required" autofocus="autofocus"></input>
							  <!-- <div class="form-group">
							  <label>บทที่</label>
								<div class="form-label-group">
								  <input type="text" class="form-control" name="num_chapter" required="required" spellcheck="false" oninput="this.value = this.value.replace(/[^0-9,]/g, '').replace(/(\..*)\./g, '$1');">
								</div>
							  </div> -->

							  <div class="form-group">
							  <label>ชื่อบทเรียน</label>
								<div class="form-label-group">
								  <input type="text"  class="form-control"  name="name_chapter" required="required" autofocus="autofocus"></input>
								</div>
							  </div>

							  <!-- <div class="form-group">
							  <label>วัตถุประสงค์</label>
								<div class="form-label-group">
								  <textarea id="show_txarea" type="text" rows="8" class="form-control"  name="objective_chapter" required="required" autofocus="autofocus"></textarea>
								  </div>
							  </div> -->

							  <div class="container">
							  <button name="add_chapter" type="submit" class="btn btn-success btn-block">บันทึก</button>
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
      </div>
      <!-- /.container-fluid -->
<?php include("footer.php"); } ?>

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

  <script>
   <?php $sql = "SELECT * FROM `manager_chapter` WHERE name_name_subject = $id_chapter";
			$result = mysqli_query($conn, $sql);
				$i = 1;
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
	?>
  function hideBntUp<?=$i?>(elem){
	  if (elem.id == "show_up1<?=$i?>"||elem.id == "show_up2<?=$i?>") {
		//	document.getElementById("edit_chapter<?=$i?>").hidden = true;
		//	document.getElementById("delete_chapter<?=$i?>").hidden = true;
		//	document.getElementById("add_chapter<?=$i?>").hidden = true;
			document.getElementById("down<?=$i?>").hidden = true;
			document.getElementById("up<?=$i?>").hidden = false;
			document.getElementById("show_up1<?=$i?>").id  = "hide_up1<?=$i?>";
			document.getElementById("show_up2<?=$i?>").id  = "hide_up2<?=$i?>";

	  }else if(elem.id == "hide_up1<?=$i?>"||elem.id == "hide_up2<?=$i?>"){
		//	document.getElementById("edit_chapter<?=$i?>").hidden = false;
		//	document.getElementById("delete_chapter<?=$i?>").hidden = false;
		//	document.getElementById("add_chapter<?=$i?>").hidden = false;
      document.getElementById("down<?=$i?>").hidden = false;
			document.getElementById("up<?=$i?>").hidden = true;
			document.getElementById("hide_up1<?=$i?>").id  = "show_up1<?=$i?>";
			document.getElementById("hide_up2<?=$i?>").id  = "show_up2<?=$i?>";
	  }

  }

$(document).ready(function(){
  $("#hide<?=$num_chapter?>").click(function(){
	  document.getElementById("hide<?=$num_chapter?>").hidden = true;
	  document.getElementById("show<?=$num_chapter?>").hidden = false;
  });


  $("#show<?=$num_chapter?>").click(function(){
    document.getElementById("hide<?=$num_chapter?>").hidden = false;
	document.getElementById("show<?=$num_chapter?>").hidden = true;
  });
});


  $(document).ready(function(){
  $("#edit_chapter<?=$num_chapter?>").click(function(){


	 // document.getElementById("bnt_1<?=$i?>").hidden = true;
	// document.getElementById("bnt_2<?=$i?>").hidden = true;
	 // document.getElementById("bnt_3<?=$i?>").hidden = true;
	  //document.getElementById("hide<?=$i?>").hidden = true;
	 // document.getElementById("update_chapter<?=$i?>").hidden = false;
	 // document.getElementById("input_chapter<?=$i?>").hidden = false;
	 // document.getElementById("hide_txarea<?=$i?>").hidden = false;
	  //document.getElementById("show_txarea<?=$i?>").hidden = true;

	 // document.getElementById("txt_chapter<?=$i?>").hidden = true;
	 // document.getElementById("edit_chapter<?=$i?>").hidden = true;
	 // document.getElementById("delete_chapter<?=$i?>").hidden = true;
	 // document.getElementById("show<?=$i?>").hidden = true;
	 // document.getElementById("text_hide<?=$i?>").hidden = true;
	  //document.getElementById("show<?=$i?>").checked  = true;
	  //document.getElementById("show_txarea<?=$i?>").hidden = false;
  });

});


  <?php $i++;} ?>
  </script>
  <?php
  $i = 1;
	$sql = "SELECT * FROM `manager_chapter` WHERE name_name_subject = $id_chapter";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
  ?>
  <script>
	  function buttonDelete<?php echo $i;?>() {
	  var result = confirm("แน่ใจว่าต้องการลบบทที่ "+<?php echo $i; ?>+"?");
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
