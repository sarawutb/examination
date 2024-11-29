<?php
session_start();
  if ($_SESSION['id_teacher']) {
	 include("connect.php");
	 $id_teacher = $_SESSION['id_teacher'];
	 $status_teacher = $_SESSION['status_teacher'];

	 $branch_id_std = $_GET['branch_id'];
	 $genre_std = $_GET['genre_std'];

	 $degree_std = $_GET['degree_std'];
	 $section_std = $_GET['section_std'];
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
	  <li class="nav-item">
        <a class="nav-link" href="Subject.php">
          <i class='far'>&#xf15c;</i>
          <span>รายวิชา</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Series_Exam.php">
          <i class='fas'>&#xf0ae;</i>
          <span>ชุดข้อสอบ</span></a>
      </li>
	  <li class="nav-item active">
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
          <li class="breadcrumb-item active">จัดการนักศึกษา</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class='far'>&#xf2bb;</i>
			<?php
			$sql = "SELECT * FROM `manager_branch` WHERE `branch_id` = '$branch_id_std' AND `branch_genre` ='$genre_std'";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
						$branch_id =  $row['branch_id'];
						$genre_std =  $row['branch_genre'];
						$branch_name =  $row['branch_name'];
					}
			?>
				รายชื่อนักศึกษา
			<b>
			<?php
				echo $branch_name;
				echo " ห้อง ";
				echo $degree_std."/";
				echo $section_std;
			?>
			</b>
				<a href="#" data-toggle="modal" data-target="#myModal"><button type="button" class="btn btn-success">เพิ่มนักศึกษา</button></a>
				</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
					<th width="7%"><center>ลำดับ</center></th>
					<th width="15%">รหัสนักศึกษา</th>
                    <th width="48%">ชื่อ-นามสกุล</th>
                    <th width="10%">ดูผลสอบ</th>
                    <th width="10%">แกไข</th>
                    <th width="10%">ลบ</th>
                  </tr>
                </thead>
                <tbody>
				<?php
					$sql = "SELECT * FROM `manage_std` WHERE `branch_id_std` = '$branch_id_std' AND `genre_std` = '$genre_std' AND `degree_std`= '$degree_std' AND `section_std` ='$section_std' AND IsUse = 1 ORDER BY `manage_std`.`id_std` ASC";
                    $result = mysqli_query($conn, $sql);
					$number = 1;
                    while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
                        $data_id =  $row['id'];
                        $data_std_id =  $row['id_std'];
                        $gender_std =  $row['gender_std'];
                        $data_std_name =  $row['name_std'];
                        $data_std_password =  $row['password_std'];

						if($gender_std == 1){
							$gender_std = "นาย";
						}else if($gender_std == 2){
							$gender_std = "นางสาว";
						}
				?>
                  <tr>
                    <td><center><b><?php echo $number; ?></b></center></td>
                    <td><?php echo $data_std_id; ?></td>
                    <td><?php echo $gender_std.$data_std_name; ?></td>
					<td>
					<center>
					  <a href="Manager_Std_Subject.php?id_sid=<?php echo $data_id; ?>"><button type="button" class="btn btn-info"><i style="font-size:24px" class="fa">&#xf06e;</i></button></a>
                    </center>
					</td>
                    <td>
						<center>
							<a href="#" data-toggle="modal" data-target="#myModal<?php echo $data_id;?>"><button type="button" class="btn btn-warning"><i style='font-size:24px' class='fas'>&#xf303;</i></button></a>
						</center>
					</td>
					<td>
						<center>
							<a href="Manager_Std_Sql.php?id=<?php echo $data_id;?>&delete_std"><button onclick="return buttonDelete<?php echo $number;?>()" type="button" class="btn btn-danger"><i style='font-size:24px' class='fas'>&#xf2ed;</i></button></a>
						</center>
					</td>
                  </tr>
				   <div class="modal fade" id="myModal<?php echo $data_id;?>" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		  <h5 class="modal-title">แก้ไขข้อมูล</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
		<form action="Manager_Std_Sql.php" method="POST">
		<input hidden type="text" name="branch_id" value="<?php echo $branch_id; ?>" />
		<input hidden type="text" name="genre_std" value="<?php echo $genre_std; ?>" />
		<?php
					$sql1 = "SELECT * FROM `manage_std` WHERE id = '$data_id' AND IsUse = 1;";
                    $result1 = mysqli_query($conn, $sql1);
                    while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
                        $data_id1 =  $row1['id'];
                        $data_std_id1 =  $row1['id_std'];
                        $data_std_name1 =  $row1['name_std'];
                        $gender_std1 =  $row1['gender_std'];
                        $data_std_password1 =  $row1['password_std'];

                        list($name_list, $lname_list) = explode(" ", $data_std_name1);
				?>
          <div class="form-group">
		  <label>รหัสนักศึกษา</label>
            <div class="form-label-group">
              <input hidden type="text" class="form-control" name="id" value="<?php echo $data_id1;?>">
              <input type="text" class="form-control" name="id_std" spellcheck="false" value="<?php echo $data_std_id1;?>" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
			</div>

          </div>

		  <div class="form-group">
		  <label for="inputEmail">คำนำหน้า</label>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input" name="gender_std" <?php if($gender_std1==1){echo "checked";}?> value="1"> นาย
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input" name="gender_std" <?php if($gender_std1==2){echo "checked";}?> value="2"> นางสาว
				</label>
			</div>
          </div>

          <div class="form-group">
            <label>ชื่อ-นามสกุล</label>
          <div class="row">
              <div class="col-sm-5">
                <div class="form-label-group">
                  <input type="text"  class="form-control"  name="name_std" required="required" value="<?php echo $name_list;?>" autofocus="autofocus"></input>
                </div>
              </div>
              -
              <div class="col-sm-5">
                <div class="form-label-group">
                  <input type="text"  class="form-control"  name="last_std" required="required" value="<?php echo $lname_list;?>" autofocus="autofocus"></input>

                </div>
              </div>
          </div>
          </div>

		  <div class="form-group">
		  <label>ชั้นปี</label>
            <div class="form-label-group">
				<input value="<?php echo $degree_std ?>" type="text" class="form-control" style="width:20%" name="degree_std" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
			</div>
          </div>

		  <div class="form-group">
		  <label>ห้อง</label>
            <div class="form-label-group">
				<input value="<?php echo $section_std ?>" type="text" class="form-control" style="width:20%" name="section_std" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
			</div>
          </div>

		  <div class="form-group">
		  <label>รหัสผ่าน</label>
            <div class="form-label-group">
              <input type="password"  class="form-control" id="show_hide_pass_edit<?php echo $number;?>" name="password_std" required="required" value="<?php echo $data_std_password1;?>" autofocus="autofocus"></input>
            </div>
          </div>

		  <div class="form-group">
			<div class="checkbox">
				<label>
					<input type="checkbox" onclick="show_password_edit<?php echo $number;?>()">
					แสดงรหัสผ่าน
				</label>
			</div>
		  </div>

		  <script>
		  function show_password_edit<?php echo $number;?>(){
			  var input3 = document.getElementById("show_hide_pass_edit<?php echo $number;?>");
				if(input3.type === "password"){
				  input3.type = "text";
				}else{
				  input3.type = "password";
				}
			}
		  </script>
					<?php } ?>

		  <div class="container">
          <button type="submit" name="update_std" class="btn btn-primary btn-block">อัพเดท</button>
		  </div>

        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>
      </div>

    </div>
  </div>
				<?php $number++; } ?>
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
		  <h5 class="modal-title">เพิ่มนักเรียน</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
		<form action="Manager_Std_Sql.php" method="POST">
		<input hidden type="text" name="branch_id" value="<?php echo $branch_id; ?>" />
		<input hidden type="text" name="genre_std" value="<?php echo $genre_std; ?>" />

          <div class="form-group">
		  <label>รหัสนักเรียน</label>
            <div class="form-label-group">
				<input type="text" class="form-control" id="" name="id_std" spellcheck="false" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
			</div>
          </div>

		  <div class="form-group">
		  <label for="inputEmail">คำนำหน้า</label>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input" name="gender_std" value="1" required="required"> นาย
				</label>
			</div>
			<div class="form-check">
				<label class="form-check-label">
					<input type="radio" class="form-check-input" name="gender_std" value="2" required="required"> นางสาว
				</label>
			</div>
          </div>

          <div class="form-group">
            <label>ชื่อ-นามสกุล</label>
          <div class="row">
              <div class="col-sm-5">
                <div class="form-label-group">
                  <input type="text" class="form-control" name="name_std" required="required" autofocus="autofocus"></input>
                </div>
              </div>
              -
              <div class="col-sm-5">
                <div class="form-label-group">
                  <input type="text" class="form-control" name="last_std" required="required" autofocus="autofocus"></input>
                </div>
              </div>
          </div>
          </div>

		  <div class="form-group">
		  <label>ชั้นปี</label>
            <div class="form-label-group">
				<input value="<?php echo $degree_std ?>" type="text" class="form-control" style="width:20%" name="degree_std" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
			</div>
          </div>

		  <div class="form-group">
		  <label>ห้อง</label>
            <div class="form-label-group">
				<input value="<?php echo $section_std ?>" type="text" class="form-control" style="width:20%" name="section_std" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
			</div>
          </div>

		  <div class="form-group">
		  <label>รหัสผ่าน</label>
            <div class="form-label-group">
              <input type="password"  class="form-control" id="show_hide_pass_add" name="password_std" required="required" autofocus="autofocus"></input>
            </div>
          </div>

		  <div class="form-group">
			<div class="checkbox">
				<label>
					<input type="checkbox" onclick="show_password_add()">
					แสดงรหัสผ่าน
				</label>
			</div>
		  </div>

		  <div class="container">
          <button type="submit" name="add_std" class="btn btn-success btn-block">บันทึก</button>
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
