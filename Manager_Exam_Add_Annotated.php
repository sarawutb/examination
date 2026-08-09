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

if(isset($_GET["id_chapter"])){
	$id_chapter = $_GET["id_chapter"];
}
if(isset($_POST["id_chapter"])){
	$id_chapter = $_POST["id_chapter"];
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


  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<style>
ul#menu li {
  display:inline;
}

.remove-image {
display: none;
position: absolute;
top: -10px;
right: 10px;
border-radius: 10em;
padding: 2px 6px 3px;
text-decoration: none;
font: 600 21px/20px sans-serif;
background: #E54E4E;
border: 3px solid #fff;
color: #FFF;
}
</style>

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
          <li class="breadcrumb-item">
			<a href="Subject.php">จัดการรายวิชา</a>
		  </li>
		  <li class="breadcrumb-item">
		  <?php
				$sql1 = "SELECT * FROM `manager_chapter`
						INNER JOIN manager_subject on manager_chapter.name_name_subject = manager_subject.id
						WHERE manager_chapter.id = $id_chapter";
						$result1 = mysqli_query($conn, $sql1);
						while ($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
							$id =  $row1['id'];
							// $num_chapter =  $row1['num_chapter'];
							$name_chapter =  $row1['name_chapter'];
							$name_subject =  $row1['name_subject'];
							$ans_type_subject =  $row1['ans_type_subject'];
						}


            if($ans_type_subject == 1){
              $ans_type_subject = array("ก", "ข", "ค", "ง", "จ");
            }else if($ans_type_subject == 2){
              $ans_type_subject = array("a", "b", "c", "d", "e");
            }else if($ans_type_subject == 3){
              $ans_type_subject = array("1", "2", "3", "4", "5");
            }
              // echo "zzzzzzzzzzzzzzzz".$ans_type_subject;
		  ?>
		  <a href="Manager_Exam_Chapter.php?name_subject_id=<?php echo  $id;?>"><?php echo $name_subject; ?></a>
		  </li>

		  <li class="breadcrumb-item active"><b> <?php echo $name_chapter; ?></b></li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class='far'>&#xf249;</i>
				 <?php echo  $name_chapter; ?>
		  </div>
          <div class="card-body">
		  <div class="row">
		  <div class="col-sm-5">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class='far'>&#xf044;</i> เพิ่มข้อสอบแบบอัตนัย</span>
            <div>
              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#importExcelModal">
                <i class="fas fa-file-excel"></i> นำเข้าด้วย Excel
              </button>
              <button type="button" class="btn btn-primary btn-sm ml-1" data-toggle="modal" data-target="#importWordModal">
                <i class="fas fa-file-word"></i> นำเข้าด้วย Word
              </button>
            </div>
          </div>
          <div class="card mb-3">
          <div class="card-body">

		  <form action="Manager_Exam_Add_Sql.php" id="wash" method="POST" enctype="multipart/form-data">

		  <input hidden type="text" name="id_chapter" value="<?php echo $id_chapter; ?>">
				<div class="form-inline">
					<label>
						<span class="btn btn-warning">
							เลือกรูปภาพ  <input hidden type="file" name="img_proposition" id="img_proposition" class="form-control" autofocus="autofocus" accept="image/*" onchange="loadFile(event)">
						</span>
					</label>
					<font color='black'><p>(ขนาดรูปไม่เกิน 512Kb)</p></font>
				</div>

          <div class="form-group">

            <div class="form-label-group">
			  <center><img hidden id="imgProposition" width="70%" height="70%"/></center>
			<h5>ใส่โจทย์คำถาม</h5>
              <textarea type="text" rows="8" class="form-control"  name="proposition" required="required" autofocus="autofocus"><?php if(isset($_POST["add_exam"])){echo $proposition;} ?></textarea>
			  <font hidden id="img_proposition_size" color='red'><b>*ขนาดรูปภาพใหญ่เกินไป</b></font>

			  <script>
				  var loadFile = function(event) {
					document.getElementById("imgProposition").hidden = false;
					var reader = new FileReader();
					reader.onload = function(){
					  var imgProposition = document.getElementById('imgProposition');
					  imgProposition.src = reader.result;
					};
					reader.readAsDataURL(event.target.files[0]);
				  };
				</script>

            </div>
            </div>
            <div class="form-group">
            <div class="form-label-group">
			<h5>เฉลย</h5>
              <textarea type="text" rows="8" class="form-control"  name="ans_annotated"  autofocus="autofocus"></textarea>
            </div>
          </div>

          <button type="submit" name="add_exam_annotated" class="btn btn-success btn-block">บันทึกข้อสอบ</button>
          <a href="#page-top" class="btn-block"><button type="button" onclick="function_wash()" class="btn btn-info btn-block">ล้าง</button></a>
        </form>

          </div>
        </div>
        </div>





		<div class="col-sm-7">
          <div class="card-header">
            <i class='far'>&#xf022;</i>
			ข้อสอบที่บันทึกแล้ว
			</div>
	<form action="Series_Exam_Manager_DeleteAll.php" method="POST" onsubmit="return all_delete();" >
		<div class="card mb-3">



          <div class="card-body">
            <div class="table-responsive">


              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>


                  <tr>
                    <th width="5%">
					<input type="checkbox"  id="Check_All" onClick="check_uncheck_all()"/>
					</th>
                    <th width="90%">
					ข้อสอบทั้งหมด
					</th>
					<th width="5%">
					ลบ
					</th>
                  </tr>
                </thead>
				<tbody>


                    <div class="panel panel-default">
				  <div class="panel-heading">
					<h4 class="panel-title">
					<input type="submit" name="delete_all_exam_annotated" value="ลบที่เลือก" class="btn btn-danger"></input>
					<hr>
					</h4>
				  </div>
				  </div>
					<?php
          $proposition_img_exam = "null.jpg";
          $answer1_img_exam = "null.jpg";
          $answer2img_exam = "null.jpg";
          $answer3_img_exam = "null.jpg";
          $answer4_img_exam = "null.jpg";
						$sql = "SELECT * FROM `manager_exam_annotated` WHERE `chapter_id_exam` = $id_chapter";
						$result = mysqli_query($conn, $sql);
						$num_chapter = 1;
						while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
							$exam_id =  $row['id'];
							$proposition_exam =  $row['proposition_exam'];
							$proposition_img_exam =  $row['proposition_img_exam'];
							$ans_exam =  $row['ans_exam'];
							$chapter_id_exam =  $row['chapter_id_exam'];
					?>
					<tr>
		  <td>

				<input name="delete_all[]" id="input_Check_num<?php echo $num_chapter;?>"  type="checkbox" value="<?php echo $exam_id; ?>"></input>


		   </td>

		</form>
		  <td>


		  <div class="panel-group">
				<div class="panel panel-default">
				  <div class="panel-heading">
					<h4 class="panel-title">
							<a style="font-size:100%" id="userDropdown" href="#collapse<?php echo $num_chapter;?>" role="button" data-toggle="collapse">
								<font color="black"><?php echo $num_chapter; ?>). <?php echo $proposition_exam; ?></font>
							</a>

					</h4>
				  </div>
				  <div id="collapse<?php echo $num_chapter;?>" class="panel-collapse collapse">
					<div class="card-body">
						  <form action="Manager_Exam_Add_Sql.php" method="POST" enctype="multipart/form-data">
						  <input hidden type="text" name="exam_id" value="<?php echo $exam_id; ?>"/>
						  <input hidden type="text" name="id_chapter" value="<?php echo $id_chapter; ?>">
						  <div class="form-group">
						  <h5>โจทย์คำถาม</h5>
							<div class="form-label-group">

							  <div class="image-area">
								<input hidden id="imgProposition_remove<?php echo $num_chapter;?>" type="text" value="p">
								  <center><img id="imgProposition_sql<?php echo $num_chapter;?>" <?php if($proposition_img_exam==null){echo "hidden";} else{?> src="upload/<?php echo $proposition_img_exam;?>"<?php } ?> style="max-width: auto;height: 350px;"></center>
								  <a id="btn_remove<?php echo $num_chapter;?>" onClick="hid_p<?php echo $num_chapter;?>()" <?php if($proposition_img_exam==null){echo "hidden";} ?>><button class="remove-image"  style="display: inline;" type="button">&#215;</button></a>
								</div>

							  <textarea type="text" rows="8" class="form-control"  name="proposition"  autofocus="autofocus"><?php echo $proposition_exam; ?></textarea>
									<div class="input-group mt-2">
									  <label>
										<span class="btn btn-warning">

										  เลือกรูปภาพ <input onClick="hid_p_img<?php echo $num_chapter;?>()" hidden type="file" name="img_proposition" id="img_proposition_sql<?php echo $num_chapter;?>" class="form-control" autofocus="autofocus" accept="image/*" value="<?php echo $proposition_img_exam; ?>" onchange="loadFiles<?php echo $num_chapter;?>(event)">
										</span>
									  </label>
									  <font color='black'><p>(ขนาดรูปไม่เกิน 512Kb)</p></font>
									</div>
								<script>
								  var loadFiles<?php echo $num_chapter;?> = function(event) {
									document.getElementById("imgProposition_sql<?php echo $num_chapter;?>").hidden = false;
									var reader = new FileReader();
									reader.onload = function(){
									  var imgProposition_sql = document.getElementById('imgProposition_sql<?php echo $num_chapter;?>');
									  imgProposition_sql.src = reader.result;
									};
									reader.readAsDataURL(event.target.files[0]);
								  };
									function hid_p<?php echo $num_chapter; ?>(){
										document.getElementById("imgProposition_sql<?php echo $num_chapter; ?>").hidden = true;
										document.getElementById("btn_remove<?php echo $num_chapter; ?>").hidden = true;
										document.getElementById("imgProposition_remove<?php echo $num_chapter; ?>").setAttribute("name", "img_proposition");
										document.getElementById("img_proposition_sql<?php echo $num_chapter; ?>").setAttribute("name", "");
									}
									function hid_p_img<?php echo $num_chapter; ?>(){
										document.getElementById("imgProposition_remove<?php echo $num_chapter; ?>").setAttribute("name", "");
										document.getElementById("img_proposition_sql<?php echo $num_chapter; ?>").setAttribute("name", "img_proposition");
										document.getElementById("btn_remove<?php echo $num_chapter; ?>").hidden = false;
									}
								</script>
							</div>
						  </div>

						  <div class="form-group">
						  <h5>เฉลย</h5>
							<div class="form-label-group">
							  <textarea type="text" rows="8" class="form-control"  name="ans_annotated" autofocus="autofocus"><?php echo $ans_exam; ?></textarea>
							</div>
						  </div>
						 <hr>
						  <button type="submit" name="edit_exam_annotated" class="btn btn-primary btn-block">อัพเดทข้อสอบ</button>
						</form>



						</div>
						<hr>
				  </div>
				</div>





			  </div>


					</td>
					<td>
					<a href="Manager_Exam_Add_Sql.php?id_chapter=<?php echo $id_chapter;?>&id_exam=<?php echo $exam_id;?>&delete_exam_annotated" onclick="return buttonDelete<?php echo $num_chapter; ?>();"><button type="button" class="btn btn-danger"><b>ลบ<b></button></a>
					</td>
                  </tr>
				  <?php $num_chapter++; } ?>
				 </tbody>
              </table>

            </div>
          </div>


        </div>

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

  <script>
function function_wash() {
  document.getElementById("wash").reset();
  document.getElementById("imgProposition").hidden = true;
  document.getElementById("imgOption1").hidden = true;
  document.getElementById("imgOption2").hidden = true;
  document.getElementById("imgOption3").hidden = true;
  document.getElementById("imgOption4").hidden = true;
  document.getElementById("imgOption5").hidden = true;
}

// function myFunction1() {
//   document.getElementById("show").hidden = false;
//   document.getElementById("Option1").hidden = false;
//   document.getElementById("Option2").hidden = false;
//   document.getElementById("Option3").hidden = false;
//   document.getElementById("Option4").hidden = false;
//   document.getElementById("Option5").hidden = false;
//   document.getElementById("Option_true").hidden = false;
// }
// function myFunction2() {
//   document.getElementById("show").hidden = true;
//   document.getElementById("Option1").required = false;
//   document.getElementById("Option2").required = false;
//   document.getElementById("Option3").required = false;
//   document.getElementById("Option4").required = false;
//   document.getElementById("Option4").required = false;
//   document.getElementById("Option5").required = false;
//   document.getElementById("Option_true").required = false;
//   document.getElementById("Option1").name = "";
//   document.getElementById("Option2").name = "";
//   document.getElementById("Option3").name = "";
//   document.getElementById("Option4").name = "";
//   document.getElementById("Option5").name = "";
//   document.getElementById("Option_true").name = "";
//   document.getElementById("img_Option1").name = "";
//   document.getElementById("img_Option2").name = "";
//   document.getElementById("img_Option3").name = "";
//   document.getElementById("img_Option4").name = "";
//   document.getElementById("img_Option5").name = "";
// }
</script>


<?php
		$sql = "SELECT * FROM `manager_exam_annotated` WHERE `chapter_id_exam` = $id_chapter";
		$result = mysqli_query($conn, $sql);
		$i = 1;
		while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
?>
  <script>
	  function buttonDelete<?php echo $i; ?>() {
	  var result = confirm("แน่ใจว่าต้องการลบข้อที่ "+<?php echo $i; ?>+" ?");
	  if (result==true) {
	   return true;
	  } else {
	   return false;
	  }
	}
  </script>
<?php
$i++;}
?>

<script type="text/javascript">
function check_uncheck_all(){
	 var checkedVal = document.getElementById("Check_All");
	 <?php
				$sql = "SELECT * FROM `manager_exam_annotated` WHERE `chapter_id_exam` = $id_chapter";
				$result = mysqli_query($conn, $sql);
				$i = 1;
				while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
	 ?>
   var input_Check_num = document.getElementById("input_Check_num<?php echo $i; ?>");
 if(checkedVal.checked==true){
		input_Check_num.checked = true;
 }else{
		input_Check_num.checked = false;
 }
<?php $i++; }?>
}
function all_delete()
{ // begin function: check form
	if (!confirm("แน่ใจว่าต้องการลบ ?")) { // start if
		return (false);
	} // end if
	return (true);
} // end function: check form
</script>
<script>

</script>







  <!-- Modal นำเข้าข้อสอบด้วย Excel -->
  <div class="modal fade" id="importExcelModal" tabindex="-1" role="dialog" aria-labelledby="importExcelModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="importExcelModalDialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="importExcelModalTitle"><i class="fas fa-file-excel"></i> นำเข้าข้อสอบอัตนัยผ่าน Excel</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!-- Step 1: Upload File Form -->
        <div id="excelUploadStep">
          <form id="formImportExcelAnnotated" action="Manager_Exam_Import_Sql.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <input type="hidden" name="id_chapter" value="<?php echo $id_chapter; ?>">
              <input type="hidden" name="import_type" value="annotated">
              
              <div class="upload-container" style="background-color: #f8f9fa; border-radius: 8px; padding: 15px;">
                <div class="border-container text-center" style="border: 3px dashed #cbd5e1; border-radius: 6px; padding: 25px;">
                  <div class="icons text-muted mb-2">
                    <i class="fas fa-file-excel fa-4x" style="color: #28a745; opacity: 0.85;"></i>
                  </div>
                  <div id="nameFileAnnotated" class="mb-2" style="display:none;">
                    <h5 id="fileNameAnnotated" class="text-success font-weight-bold"></h5>
                  </div>
                  <input type="file" name="excel_file" id="excelFileInputAnnotated" accept=".xlsx, .csv" style="display: none;" required onchange="showExcelFileNameAnnotated(this)">
                  <p class="mb-1" style="font-size: 1.1em; font-weight: 600; color: #1e293b;">
                    กรุณา 
                    <label for="excelFileInputAnnotated" class="btn btn-primary btn-sm mx-1 mb-0" style="cursor:pointer;">
                      <i class="fas fa-folder-open"></i> เลือกไฟล์
                    </label>
                    สกุล .XLSX หรือ .CSV
                  </p>
                  <small class="text-muted d-block mt-2">
                    *โครงสร้างคอลัมน์: A=ข้อที่, B=โจทย์คำถาม, C=แนวทางเฉลย/คำตอบ
                  </small>
                </div>
              </div>

              <div class="alert alert-info mt-3 mb-0">
                <i class="fas fa-info-circle"></i> ท่านสามารถดาวน์โหลดไฟล์ตัวอย่าง Template สำหรับกรอกข้อสอบได้ที่นี่:
                <br>
                <a href="templates/exam_import_template_annotated.xlsx" class="btn btn-warning btn-sm mt-2" download>
                  <i class="fas fa-download"></i> ดาวน์โหลด Template Excel ข้อสอบอัตนัย
                </a>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
              <button type="submit" id="btnCheckExcelAnnotated" class="btn btn-success" disabled><i class="fas fa-search"></i> ตรวจสอบข้อสอบก่อนนำเข้า</button>
            </div>
          </form>
        </div>

        <!-- Step 2: Preview & Confirm (Hidden by default) -->
        <div id="excelPreviewStep" style="display: none;" class="modal-body p-4">
          <!-- HTML สกัดจาก AJAX จะมาแสดงตรงนี้ -->
        </div>

      </div>
    </div>
  </div>

  <script>
  function showExcelFileNameAnnotated(input) {
    if (input.files && input.files[0]) {
      document.getElementById('fileNameAnnotated').innerText = 'ไฟล์ที่เลือก: ' + input.files[0].name;
      document.getElementById('nameFileAnnotated').style.display = 'block';
      $('#btnCheckExcelAnnotated').prop('disabled', false);
    } else {
      document.getElementById('nameFileAnnotated').style.display = 'none';
      $('#btnCheckExcelAnnotated').prop('disabled', true);
    }
  }

  function resetExcelModalAnnotated() {
    $('#excelPreviewStep').hide().empty();
    $('#excelUploadStep').show();
    $('#importExcelModalDialog').removeClass('modal-xl').addClass('modal-lg');
    $('#importExcelModalTitle').html('<i class="fas fa-file-excel"></i> นำเข้าข้อสอบอัตนัยผ่าน Excel');
    $('#excelFileInputAnnotated').val('');
    $('#fileNameAnnotated').text('');
    $('#nameFileAnnotated').hide();
    $('#btnCheckExcelAnnotated').prop('disabled', true).html('<i class="fas fa-search"></i> ตรวจสอบข้อสอบก่อนนำเข้า');
  }

  $(document).ready(function() {
    $('#importExcelModal').on('hidden.bs.modal', function() {
      resetExcelModalAnnotated();
    });

    $(document).on('click', '.btn-cancel-excel-preview', function() {
      resetExcelModalAnnotated();
    });

    $('#formImportExcelAnnotated').on('submit', function(e) {
      e.preventDefault();
      var formData = new FormData(this);
      formData.append('ajax_parse_excel', '1');

      $('#btnCheckExcelAnnotated').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> กำลังอ่านไฟล์ Excel...');

      $.ajax({
        url: 'Manager_Exam_Import_Sql.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(res) {
          $('#btnCheckExcelAnnotated').prop('disabled', false).html('<i class="fas fa-search"></i> ตรวจสอบข้อสอบก่อนนำเข้า');
          if (res.status) {
            $('#excelUploadStep').hide();
            $('#excelPreviewStep').html(res.html).show();
            $('#importExcelModalDialog').removeClass('modal-lg').addClass('modal-xl');
            $('#importExcelModalTitle').html('<i class="fas fa-search"></i> ตรวจสอบข้อสอบจากไฟล์ Excel ก่อนนำเข้า');
          } else {
            Swal.fire({
              icon: 'error',
              title: 'เกิดข้อผิดพลาด',
              text: res.error,
              confirmButtonColor: '#dc3545'
            });
          }
        },
        error: function(xhr) {
          $('#btnCheckExcelAnnotated').prop('disabled', false).html('<i class="fas fa-search"></i> ตรวจสอบข้อสอบก่อนนำเข้า');
          Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาดในการส่งข้อมูล',
            text: xhr.responseText || 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
            confirmButtonColor: '#dc3545'
          });
        }
      });
    });
  });
  </script>

  <!-- Modal นำเข้าข้อสอบด้วย Word -->
  <div class="modal fade" id="importWordModal" tabindex="-1" role="dialog" aria-labelledby="importWordModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" id="importWordModalDialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="importWordModalTitle"><i class="fas fa-file-word"></i> นำเข้าข้อสอบอัตนัยผ่าน Microsoft Word (.docx)</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!-- Step 1: Upload File Form -->
        <div id="wordUploadStep">
          <form id="formImportWordAnnotated" action="Manager_Exam_Import_Word_Sql.php" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <input type="hidden" name="id_chapter" value="<?php echo $id_chapter; ?>">
              <input type="hidden" name="import_type" value="annotated">
              
              <div class="upload-container" style="background-color: #f8f9fa; border-radius: 8px; padding: 15px;">
                <div class="border-container text-center" style="border: 3px dashed #cbd5e1; border-radius: 6px; padding: 25px;">
                  <div class="icons text-muted mb-2">
                    <i class="fas fa-file-word fa-4x" style="color: #007bff; opacity: 0.85;"></i>
                  </div>
                  <div id="nameFileWordAnnotated" class="mb-2" style="display:none;">
                    <h5 id="fileNameWordAnnotated" class="text-primary font-weight-bold"></h5>
                  </div>
                  <input type="file" name="word_file" id="wordFileInputAnnotated" accept=".docx" style="display: none;" required onchange="showWordFileNameAnnotated(this)">
                  <p class="mb-1" style="font-size: 1.1em; font-weight: 600; color: #1e293b;">
                    กรุณา 
                    <label for="wordFileInputAnnotated" class="btn btn-primary btn-sm mx-1 mb-0" style="cursor:pointer;">
                      <i class="fas fa-folder-open"></i> เลือกไฟล์ Word
                    </label>
                    สกุล .DOCX
                  </p>
                  <small class="text-muted d-block mt-2">
                    *รองรับไฟล์ Word ที่พิมพ์ข้อสอบเรียงข้อ (1. โจทย์..., ตอบ: แนวทางการตอบ)
                  </small>
                </div>
              </div>

              <div class="alert alert-info mt-3 mb-0">
                <i class="fas fa-info-circle"></i> ท่านสามารถดาวน์โหลดไฟล์ตัวอย่าง Template สำหรับพิมพ์ข้อสอบ Word ได้ที่นี่:
                <br>
                <a href="templates/exam_import_template_annotated.docx" class="btn btn-warning btn-sm mt-2" download>
                  <i class="fas fa-download"></i> ดาวน์โหลด Template Word ข้อสอบอัตนัย (.docx)
                </a>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
              <button type="submit" id="btnCheckWordAnnotated" class="btn btn-primary" disabled><i class="fas fa-search"></i> ตรวจสอบข้อสอบก่อนนำเข้า</button>
            </div>
          </form>
        </div>

        <!-- Step 2: Preview & Confirm (Hidden by default) -->
        <div id="wordPreviewStep" style="display: none;" class="modal-body p-4">
          <!-- HTML สกัดจาก AJAX จะมาแสดงตรงนี้ -->
        </div>

      </div>
    </div>
  </div>

  <script>
  function showWordFileNameAnnotated(input) {
    if (input.files && input.files[0]) {
      document.getElementById('fileNameWordAnnotated').innerText = 'ไฟล์ที่เลือก: ' + input.files[0].name;
      document.getElementById('nameFileWordAnnotated').style.display = 'block';
      $('#btnCheckWordAnnotated').prop('disabled', false);
    } else {
      document.getElementById('nameFileWordAnnotated').style.display = 'none';
      $('#btnCheckWordAnnotated').prop('disabled', true);
    }
  }

  function resetWordModalAnnotated() {
    $('#wordPreviewStep').hide().empty();
    $('#wordUploadStep').show();
    $('#importWordModalDialog').removeClass('modal-xl').addClass('modal-lg');
    $('#importWordModalTitle').html('<i class="fas fa-file-word"></i> นำเข้าข้อสอบอัตนัยผ่าน Microsoft Word (.docx)');
    $('#wordFileInputAnnotated').val('');
    $('#fileNameWordAnnotated').text('');
    $('#nameFileWordAnnotated').hide();
    $('#btnCheckWordAnnotated').prop('disabled', true).html('<i class="fas fa-search"></i> ตรวจสอบข้อสอบก่อนนำเข้า');
  }

  $(document).ready(function() {
    $('#importWordModal').on('hidden.bs.modal', function() {
      resetWordModalAnnotated();
    });

    $(document).on('click', '.btn-cancel-word-preview', function() {
      resetWordModalAnnotated();
    });

    $('#formImportWordAnnotated').on('submit', function(e) {
      e.preventDefault();
      var formData = new FormData(this);
      formData.append('ajax_parse_word', '1');

      $('#btnCheckWordAnnotated').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> กำลังสกัดข้อสอบ...');

      $.ajax({
        url: 'Manager_Exam_Import_Word_Sql.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(res) {
          $('#btnCheckWordAnnotated').prop('disabled', false).html('<i class="fas fa-search"></i> ตรวจสอบข้อสอบก่อนนำเข้า');
          if (res.status) {
            $('#wordUploadStep').hide();
            $('#wordPreviewStep').html(res.html).show();
            $('#importWordModalDialog').removeClass('modal-lg').addClass('modal-xl');
            $('#importWordModalTitle').html('<i class="fas fa-search"></i> ตรวจสอบข้อสอบจากไฟล์ Word ก่อนนำเข้า');
          } else {
            Swal.fire({
              icon: 'error',
              title: 'เกิดข้อผิดพลาด',
              text: res.error,
              confirmButtonColor: '#dc3545'
            });
          }
        },
        error: function(xhr) {
          $('#btnCheckWordAnnotated').prop('disabled', false).html('<i class="fas fa-search"></i> ตรวจสอบข้อสอบก่อนนำเข้า');
          Swal.fire({
            icon: 'error',
            title: 'เกิดข้อผิดพลาดในการส่งข้อมูล',
            text: xhr.responseText || 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
            confirmButtonColor: '#dc3545'
          });
        }
      });
    });
  });
  </script>

</body>

</html>
