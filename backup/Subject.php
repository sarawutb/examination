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
      <li class="nav-item">
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

    <div id="content-wrapper">

	<div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php">หน้าหลัก</a>
          </li>
          <li class="breadcrumb-item active">รายวิชา</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card sm-3">
          <div class="card-header">
            <i class='far'>&#xf15c;</i>
				รายวิชา
				<a href="#" data-toggle="modal" data-target="#myModal"><button type="button" class="btn btn-success">เพิ่มวิชา</button></a>
				</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
					          <th width="7%"><center>ลำดับ</center></th>
					          <!-- <th width="15%">รหัสวิชา</th> -->
                    <th width="47%">ชื่อรายวิชา</th>
                    <th width="10%">ระดับ</th>
                    <th width="20%">ชื่ออาจารย์ผู้สอน</th>
                    <!-- <th width="12%">จัดการวิชา</th> -->
                    <th width="16%">สร้างชุดข้อสอบ</th>
                    <!-- <th width="7%"><center>แก้ไข</center></th>
                    <th width="7%"><center>ลบ</center></th> -->
                   <!--- <th width="10%"><center>ปริ้นคะแนน</center></th> --->
                  </tr>
                </thead>
                <tbody>
				<?php
				if($status_teacher == 1){
					$sql = "SELECT manager_subject.id,
					manager_subject.id_subject,
					manager_subject.name_subject,
					manager_subject.name_teacher_subject,
					manager_subject.genre_subject,
					manager_teacher.id_teacher,
					manager_teacher.name_teacher
					FROM manager_subject
					INNER JOIN manager_teacher ON manager_subject.name_teacher_subject=manager_teacher.id_teacher
					ORDER BY `manager_subject`.`genre_subject` ASC";
				}else if($status_teacher == 2){
					$sql = "SELECT manager_subject.id,
							manager_subject.id_subject,
							manager_subject.name_subject,
							manager_subject.name_teacher_subject,
							manager_subject.genre_subject,
							manager_teacher.id_teacher,
							manager_teacher.name_teacher
							FROM manager_subject
							INNER JOIN manager_teacher ON manager_subject.name_teacher_subject=manager_teacher.id_teacher
							WHERE name_teacher_subject = $id_teacher
							ORDER BY manager_subject.id ASC";
							}
                    $result = mysqli_query($conn, $sql);
					$number = 1;
                    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                        $data_id =  $row['id'];
                        $data_id_subject =  $row['id_subject'];
                        $data_name_subject =  $row['name_subject'];
                        $data_id_teacher =  $row['id_teacher'];
                        $data_name_teacher_subject =  $row['name_teacher'];
                        $genre_subject =  $row['genre_subject'];

				?>
                  <tr>
                    <td><center><b><?php echo $number; ?></b></center></td>
                    <!-- <td><?php echo $data_id_subject; ?></td> -->
                    <td>
                      <a href="#" data-toggle="modal" data-target="#myModal<?php echo $data_id;?>"><button type="button" class="btn btn-warning"><i style='font-size:20px' class='fas'>&#xf303;</i></button></a>
        						  <a href="Manager_Exam_Chapter.php?name_subject_id=<?php echo $data_id;?>"><?php echo $data_id_subject." ".$data_name_subject; ?></a>
                      <a style="float:right" href="Manager_Subject.php?id=<?php echo $data_id;?>&delete_subject"><button type="button" onclick="return buttonDelete<?php echo $number;?>()" class="btn btn-danger"><i style='font-size:20px' class='fas'>&#xf2ed;</i></button></a>
                    </td>
                    <td>
					<?php if($genre_subject == 1){
						echo "ปวช";
					}else if($genre_subject == 2){
						echo "ปวส";
					}
					?>
					</td>
                    <td><?php echo $data_name_teacher_subject; ?></td>
            <!-- <td>
						<center>
						  <a href="Manager_Exam_Chapter.php?name_subject_id=<?php echo $data_id;?>"><button type="button" class="btn btn-success"><i style="font-size:20px" class="fa">&#xf013;</i></button></a>
						 </center>
					</td> -->
					<td>
						<center>
						  <a href="Series_Exam_Manager.php?id_subject=<?php echo $data_id; ?>"><button type="button" class="btn btn-info"><i style="font-size:20px" class="fa">&#xf0fe;</i></button></a>
						</center>
					</td>
					<!-- <td>
						<center>
						  <a href="#" data-toggle="modal" data-target="#myModal<?php echo $data_id;?>"><button type="button" class="btn btn-warning"><i style='font-size:20px' class='fas'>&#xf303;</i></button></a>
						 </center>
					</td>
					<td>
						<center>
						<a href="Manager_Subject.php?id=<?php echo $data_id;?>&delete_subject"><button type="button" onclick="return buttonDelete<?php echo $number;?>()" class="btn btn-danger"><i style='font-size:20px' class='fas'>&#xf2ed;</i></button></a>
						</center>
					</td> -->
				<!----	<td>
						<center>
						<form action="print/Print_Subject_Point.php" target="_blank" method="POST">
						<input hidden type="text" name="id_subject_series_exam" value="<?php echo $data_id; ?>"/>
						<input hidden type="text" name="id_name_series_exam" value="<?php echo $data_id; ?>"/>
						<button  type="submit" class="btn btn-info"><i class="fa fa-print" aria-hidden="true"></i></button>
						</form>
						</center>
					</td> --->
                  </tr>
				    <div class="modal fade" id="myModal<?php echo $data_id;?>" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		  <h5 class="modal-title">แก้ไขรายวิชา</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
		<form action="Manager_Subject.php" method="POST">
		  <?php
				$sql1 = "SELECT * FROM `manager_subject` WHERE id = '$data_id'";
                    $result1 = mysqli_query($conn, $sql1);
                    while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
                        $data_id =  $row1['id'];
                        $data_id_subject =  $row1['id_subject'];
                        $data_name_subject =  $row1['name_subject'];
                        $data_name_teacher_subject =  $row1['name_teacher_subject'];
		  ?>
		  <input type="text" hidden class="form-control" value="<?php echo $data_id; ?>" name="id" required="required" autofocus="autofocus"></input>
          <div class="form-group">
		  <label>รหัสวิชา</label>
            <div class="form-label-group">
              <input type="text"  class="form-control" value="<?php echo $data_id_subject; ?>" name="id_subject" required="required" autofocus="autofocus"></input>
            </div>
          </div>

		  <div class="form-group">
		  <label>ชื่อวิชา</label>
            <div class="form-label-group">
              <input type="text"  class="form-control" value="<?php echo $data_name_subject; ?>" name="name_subject" required="required" autofocus="autofocus"></input>
            </div>
          </div>
		<?php if($status_teacher == 1){ ?>
		  <div class="form-group">
		  <label for="inputEmail">ชื่ออาจารย์ผู้สอน</label>
            <div class="form-label-group">
			<select name="name_teacher_subject" class="form-control" required="required">
			  <option value="">===เลือกชื่ออาจารย์ผู้สอน===</option>
			 <?php
					$sql2 = "SELECT * FROM `manager_teacher` ORDER BY `name_teacher` ASC";
                    $result2 = mysqli_query($conn, $sql2);
                    while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)) {
                        $name_teacher_id =  $row2['id_teacher'];
                        $name_teacher =  $row2['name_teacher'];
				?>
			  <option <?php if($data_name_teacher_subject==$name_teacher_id){echo "selected";}?> value="<?php echo $name_teacher_id; ?>"><?php echo $name_teacher; ?></option>
					<?php
						}

					?>
			</select>
            </div>
          </div>
					<?php }else{ ?>
						<input hidden name="name_teacher_subject" type="text" value="<?php echo $data_id_teacher; ?>"/>
					<?php
						}
					} ?>

		  <div class="form-group">
		  <label>ระดับการศึกษา</label>
		  <select name="genre_subject" class="form-control" id="" required="required">
			  <option value="">===เลือกระดับการศึกษา===</option>
			  <option <?php if($genre_subject == 1){ echo "selected";}?> value="1">ประกาศนียบัตรวิชาชีพ (ปวช)</option>
			  <option <?php if($genre_subject == 2){ echo "selected";}?> value="2">ประกาศนียบัตรวิชาชีพชั้นสูง (ปวส)</option>
			</select>
		  </div>

		  <div class="container">
          <button type="submit" name="update_subject" class="btn btn-primary btn-block">อัพเดทข้อสอบ</button>
		  </div>

        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>
      </div>

    </div>
  </div>
				<?php $number++;} ?>
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
		<form action="Manager_Subject.php" method="POST">
          <div class="form-group">
		  <label>รหัสวิชา</label>
            <div class="form-label-group">
              <input type="text"  class="form-control"  name="id_subject" required="required" autofocus="autofocus"></input>
            </div>
          </div>

		  <div class="form-group">
		  <label>ชื่อวิชา</label>
            <div class="form-label-group">
              <input type="text"  class="form-control"  name="name_subject" required="required" autofocus="autofocus"></input>
            </div>
          </div>

			<?php if($status_teacher == 1){ ?>
		  <div class="form-group">
		  <label for="inputEmail">ชื่ออาจารย์ผู้สอน</label>
            <div class="form-label-group">
			<select name="name_teacher_subject" class="form-control" required="required">
			  <option value="">===เลือกชื่ออาจารย์ผู้สอน===</option>
			 <?php
					$sql = "SELECT * FROM `manager_teacher` ORDER BY `name_teacher` ASC";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                        $name_teacher_id =  $row['id_teacher'];
                        $name_teacher =  $row['name_teacher'];
				?>
			  <option value="<?php echo $name_teacher_id; ?>"><?php echo $name_teacher; ?></option>
			<?php } ?>
			</select>
            </div>
          </div>
			<?php }else{ ?>
				<input hidden name="name_teacher_subject" type="text" value="<?php echo $data_id_teacher; ?>"/>
			<?php } ?>

		  <div class="form-group">
		  <label>ระดับการศึกษา</label>
		  <select name="genre_subject" class="form-control" id="" required="required">
			  <option value="">===เลือกระดับการศึกษา===</option>
			  <option <?php  ?> value="1">ประกาศนียบัตรวิชาชีพ (ปวช)</option>
			  <option <?php  ?> value="2">ประกาศนียบัตรวิชาชีพชั้นสูง (ปวส)</option>
			</select>
		  </div>

		  <div class="container">
          <button type="submit" name="add_subject" class="btn btn-success btn-block">บันทึกวิชา</button>
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


<?php
  $i = 1;
	if($status_teacher == 1){
					$sql = "SELECT manager_subject.id,
					manager_subject.id_subject,
					manager_subject.name_subject,
					manager_subject.name_teacher_subject,
					manager_teacher.id_teacher,
					manager_teacher.name_teacher
					FROM manager_subject
					INNER JOIN manager_teacher ON manager_subject.name_teacher_subject=manager_teacher.id_teacher
					ORDER BY manager_teacher.`id_teacher` ASC";
				}else if($status_teacher == 2){
					$sql = "SELECT manager_subject.id,
							manager_subject.id_subject,
							manager_subject.name_subject,
							manager_subject.name_teacher_subject,
							manager_teacher.id_teacher,
							manager_teacher.name_teacher
							FROM manager_subject
							INNER JOIN manager_teacher ON manager_subject.name_teacher_subject=manager_teacher.id_teacher
							WHERE name_teacher_subject = $id_teacher
							ORDER BY manager_subject.id ASC";
							}
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		$name_subject =  $row['name_subject'];
  ?>

  <script>
	  function buttonDelete<?php echo $i;?>() {
	  var result = confirm("แน่ใจว่าต้องการลบวิชา <?= $name_subject; ?> ?");
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
