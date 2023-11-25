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
	  <li class="nav-item">
        <a class="nav-link" href="Manager_Std.php">
          <i class='far'>&#xf2bb;</i>
          <span>จัดการนักศึกษา</span></a>
      </li>
	  <?php if($status_teacher == 1){ ?>
	  <li class="nav-item active">
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
          <li class="breadcrumb-item active">จัดการอาจารย์</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class='fas'>&#xf508;</i>
				รายชื่ออาจารย์
				<a href="#" data-toggle="modal" data-target="#myModal"><button type="button" class="btn btn-success">เพิ่มอาจารย์</button></a>
				</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
					<th width="7%"><center>ลำดับ</center></th>
                    <th width="24%">ชื่อ-นามสกุล</th>
                    <th width="25%">อีเมล</th>
                    <th width="20%">รหัสผ่าน</th>
					<th width="10%">สถานะ</th>
                    <th width="7%">แกไข</th>
                    <th width="7%">ลบ</th>
                  </tr>
                </thead>
                <tbody>
				<?php 
					$sql = "SELECT * FROM `manager_teacher`";
						$result = mysqli_query($conn, $sql);
						$number = 1;
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
							$data_id =  $row['id_teacher'];
							$data_teacher_name =  $row['name_teacher'];
							$data_teacher_email =  $row['email_teacher'];
							$data_teacher_password =  $row['password_teacher'];
							$data_teacher_status =  $row['status_teacher'];
						?>
                  <tr>
                    <td><center><b><?php echo $number; ?></b></center></td>
                    <td><?php echo $data_teacher_name; ?></td>
                    <td><?php echo $data_teacher_email; ?></td>
                    <td>
					<input 
					style="border:0;outline:0;" 
					readonly type="password" value="<?php echo $data_teacher_password; ?>" 
					/>
					</td>
                    <td>
						<?php if($data_teacher_status==1){
							echo '<font color="white"><a disabled class="btn btn-success">แอดมิน</a></font>';
								}else{
									echo '<font color="white"><a disabled class="btn btn-primary">อาจารย์</a></font>';
								} 
						?>
					</td>
                    <td>
						<center>
							<a href="#" data-toggle="modal" data-target="#myModal<?php echo $data_id;?>"><button type="button" class="btn btn-warning"><i style='font-size:24px' class='fas'>&#xf303;</i></button></a>
						</center>
					</td>
					<td>
						<center>
						 <?php if($data_teacher_status==1){ ?>
							<button type="button" disabled class="btn btn-danger"><i style='font-size:24px' class='fas'>&#xf2ed;</i></button>
						 <?php }else{?>
							<a href="Manager_Teacher_Sql.php?id_teacher=<?php echo $data_id; ?>&delete_teacher" onclick="return buttonDelete<?php echo $number; ?>()"><button type="button" class="btn btn-danger"><i style='font-size:24px' class='fas'>&#xf2ed;</i></button></a>
						 <?php }?>
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
						<form action="Manager_Teacher_Sql.php" method="POST">
						  <?php 
									$sql1 = "SELECT * FROM `manager_teacher` WHERE id_teacher = '$data_id'";
									$result1 = mysqli_query($conn, $sql1);
									while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
											$data_id =  $row1['id_teacher'];
											$data_teacher_name =  $row1['name_teacher'];
											$data_teacher_email =  $row1['email_teacher'];
											$data_teacher_password =  $row1['password_teacher'];
											$data_teacher_status =  $row1['status_teacher'];
										?>
						  <div class="form-group">
						  
						  <input type="text" hidden class="form-control"  name="id_teacher" value="<?php echo $data_id; ?>" required="required" autofocus="autofocus"></input>    
							
						  <label>ชื่อ-นามสกุล</label>
							<div class="form-label-group">
							  <input type="text"  class="form-control"  name="name_teacher" value="<?php echo $data_teacher_name; ?>" required="required" autofocus="autofocus"></input>    
							</div>
						  </div>
						  
						  <div class="form-group">
						  <label>อีเมล</label>
							<div class="form-label-group">
							  <input type="email"  class="form-control"  name="email_teacher" value="<?php echo $data_teacher_email; ?>" required="required" autofocus="autofocus"></input>    
							</div>
						  </div>
						  
						  <div class="form-group">
						  <label>รหัสผ่าน</label>
							<div class="form-label-group">
							  <input type="password"  class="form-control" id="show_hide_pass_edit<?php echo $number;?>" name="password_teacher" value="<?php echo $data_teacher_password; ?>" required="required" autofocus="autofocus"></input>    
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
						  
						   <div class="form-group">
						  <label for="inputEmail">สถานะ</label>
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" class="form-check-input" name="status_teacher" <?php if($data_teacher_status==1){echo "checked";}?> value="1" checked> แอดมิน
								</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" class="form-check-input" name="status_teacher" <?php if($data_teacher_status==2){echo "checked";}?> value="2"> อาจารย์
								</label>
							</div>
						</div>
						  
						  <div class="container">
						  <button type="submit" name="update_teacher" class="btn btn-primary btn-block">อัพเดท</button>
						  </div>
						  
						</form>
						</div>
						<div class="modal-footer">
						  <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
						</div>
					  </div>
					  
					</div>
				</div>
					<?php 
						}
					$number++;
					} 
					?>
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
		  <h5 class="modal-title">เพิ่มอาจารย์</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
		<form action="Manager_Teacher_Sql.php" method="POST">
		  
		  <div class="form-group">
		  <label>ชื่อ-นามสกุล</label>
            <div class="form-label-group">
              <input type="text"  class="form-control"  name="name_teacher" required="required" autofocus="autofocus"></input>    
            </div>
          </div>
		  
		  <div class="form-group">
		  <label>อีเมล</label>
            <div class="form-label-group">
              <input type="email"  class="form-control"  name="email_teacher" required="required" autofocus="autofocus"></input>    
            </div>
          </div>
		  
		  <div class="form-group">
		  <label>รหัสผ่าน</label>
            <div class="form-label-group">
              <input type="password"  class="form-control" id="show_hide_pass_add";  name="password_teacher" required="required" autofocus="autofocus"></input>    
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
		 
              <input type="password" hidden  class="form-control"  name="status_teacher" value="2" autofocus="autofocus"></input>    
          
		  <div class="container">
          <button type="submit" name="add_teacher" class="btn btn-success btn-block">บันทึก</button>
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

<?php 
  $i = 1;
	$sql = "SELECT * FROM `manager_teacher`";
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

</html>
