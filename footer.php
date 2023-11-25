<div class="modal fade" id="myAccount" role="dialog">
					<div class="modal-dialog modal-lg">

					  <!-- Modal content-->
					  <div class="modal-content">
						<div class="modal-header">
						  <h5 class="modal-title">ข้อมูลบัญชี</h5>
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">
						<form action="Manager_Teacher_Sql.php" method="POST">
						  <?php
							$empty = null;
									$sql1 = "SELECT * FROM `manager_teacher` WHERE id_teacher = '$id_teacher'";
									$result1 = mysqli_query($conn, $sql1);
									while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)) {
											$data_id =  $row1['id_teacher'];
											$data_teacher_name =  $row1['name_teacher'];
											$data_teacher_email =  $row1['email_teacher'];
											$data_teacher_password =  $row1['password_teacher'];
											$data_teacher_status =  $row1['status_teacher'];
											$data_teacher_gender =  $row1['gender_teacher'];

											$list_empty_name = substr_count($data_teacher_name, ' ');
                      for($i=1;$i<=$list_empty_name;$i++){
                          $empty = $empty.' ';
                        //  echo $i;
                      }
                    //  echo $empty;

										if($empty != null){
                      list($name_list, $lname_list) = explode(' ', $data_teacher_name);
                    }else{
                      $name_list = $data_teacher_name;
                      $lname_list = "";
                    }
										?>


						  <input type="text" hidden class="form-control"  name="id_teacher" value="<?php echo $data_id; ?>" required="required" autofocus="autofocus"></input>

							<div class="form-group">
                <label>คำนำหน้า</label>
              <div class="row">
                <div class="col-sm-2">
            			<div class="form-check">
            				<label class="form-check-label">
            					<input type="radio" <?php if($data_teacher_gender == 1){echo "checked";} ?> class="form-check-input" name="gender_teacher" value="1" required="required"> นาย
            				</label>
            			</div>
                  <div class="form-check">
            				<label class="form-check-label">
            					<input type="radio" <?php if($data_teacher_gender == 2){echo "checked";} ?> class="form-check-input" name="gender_teacher" value="2" required="required"> นาง
            				</label>
            			</div>
                  <div class="form-check">
            				<label class="form-check-label">
            					<input type="radio" <?php if($data_teacher_gender == 3){echo "checked";} ?> class="form-check-input" name="gender_teacher" value="3" required="required"> นางสาว
            				</label>
            			</div>
                </div>
                </div>
                </div>

								<div class="form-group">
	                <label>ชื่อ-นามสกุล</label>
	              <div class="row">
	              <div class="col-sm-6">
	                <div class="form-label-group input-group mb-2">
	                  <div class="input-group-prepend">
	                    <div class="input-group-text">อาจารย์</div>
	                  </div>
	                  <input type="text" class="form-control" name="name_teacher" value="<?php echo $name_list; ?>" required="required" autofocus="autofocus"></input>
	                </div>
	              </div>
	              <div class="mt-2">
	                -
	              </div>
	                <div class="col-sm-5">
	                  <div class="form-label-group">
	                    <input type="text" class="form-control" name="last_teacher" value="<?php echo $lname_list; ?>" required="required" autofocus="autofocus"></input>
	                  </div>
	                </div>
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
							  <input type="password"  class="form-control" id="show_hide_pass" name="password_teacher" value="<?php echo $data_teacher_password; ?>" required="required" autofocus="autofocus"></input>
							</div>
						  </div>

						  <div class="form-group">
							<div class="checkbox">
							  <label>
								<input type="checkbox" onclick="show_password()">
								 แสดงรหัสผ่าน
							  </label>
							</div>
						  </div>


						  <div <?php if($status_teacher != 1){ echo "hidden"; }?> class="form-group">
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
						  <?php //} ?>

						  <div class="container">
						  <button type="submit" name="update_profile" class="btn btn-primary btn-block">อัพเดท</button>
						  </div>

						</form>
						<?php } ?>
						</div>
						<div class="modal-footer">
						  <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
						</div>
					  </div>

					</div>
	</div>
	 <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer" style="height: 60px;">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <h6>
			<span>	<b>สงวนลิขสิทธิ์ © <?php echo date("Y"); ?>  วิทยาลัยอาชีวศึกษาจุลมณีอุทุมพรพิสัย จังหวัดศรีสะเกษ </b>
			</span>
			</h6>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">แน่ใจว่าต้องการออกจากระบบ ?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
          <a class="btn btn-primary" href="auth/logout_manager.php">ออกจากระบบ</a>
        </div>
      </div>
    </div>
  </div>

  <script>
function show_password() {
  var input1 = document.getElementById("show_hide_pass");
  if (input1.type === "password") {
    input1.type = "text";
  } else {
    input1.type = "password";
  }
}
function show_password_add() {
  var input2 = document.getElementById("show_hide_pass_add");
  if (input2.type === "password") {
    input2.type = "text";
  } else {
    input2.type = "password";
  }
}

</script>
