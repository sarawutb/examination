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
		$data_id = $row_teacher['id_teacher'];
		$data_id_teacher = $row_teacher['id_teacher'];
		$data_name_teacher_subject = $row_teacher['name_teacher'];
	}
	//echo  $data_id_teacher;
} else {
	session_destroy();
	header("location:Login.php");
}

if (isset($_GET["id_chapter"])) {
	$id_chapter = $_GET["id_chapter"];
}
if (isset($_POST["id_chapter"])) {
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

</head>
<style>
	ul#menu li {
		display: inline;
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
						<a href="Subject.php">จัดการรายวิชา</a>
					</li>
					<li class="breadcrumb-item">
						<?php
						$sql1 = "SELECT * FROM `manager_chapter`
						INNER JOIN manager_subject on manager_chapter.name_name_subject = manager_subject.id
						WHERE manager_chapter.id = $id_chapter";
						$result1 = mysqli_query($conn, $sql1);
						while ($row1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
							$id = $row1['id'];
							// $num_chapter =  $row1['num_chapter'];
							$name_chapter = $row1['name_chapter'];
							$name_subject = $row1['name_subject'];
							$ans_type_subject = $row1['ans_type_subject'];
						}


						if ($ans_type_subject == 1) {
							$ans_type_subject = array("ก", "ข", "ค", "ง", "จ");
						} else if ($ans_type_subject == 2) {
							$ans_type_subject = array("a", "b", "c", "d", "e");
						} else if ($ans_type_subject == 3) {
							$ans_type_subject = array("1", "2", "3", "4", "5");
						}
						// echo "zzzzzzzzzzzzzzzz".$ans_type_subject;
						?>
						<a href="Manager_Exam_Chapter.php?name_subject_id=<?php echo $id; ?>"><?php echo $name_subject; ?></a>
					</li>

					<li class="breadcrumb-item active"><b>
							<?php echo $name_chapter; ?>
						</b></li>
				</ol>

				<!-- DataTables Example -->
				<div class="card mb-3">
					<div class="card-header">
						<i class='far'>&#xf249;</i>
						<?php echo $name_chapter; ?>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-sm-5">
								<div class="card-header">
									<i class='far'>&#xf044;</i>
									เพิ่มข้อสอบแบบปรนัย
								</div>
								<div class="card mb-3">
									<div class="card-body">

										<form action="Manager_Exam_Add_Sql.php" id="wash" method="POST"
											enctype="multipart/form-data">

											<input hidden type="text" name="id_chapter"
												value="<?php echo $id_chapter; ?>">
											<div class="form-inline">
												<label>
													<span class="btn btn-warning">
														เลือกรูปภาพ <input hidden type="file" name="img_proposition"
															id="img_proposition" class="form-control"
															autofocus="autofocus" accept="image/*"
															onchange="loadFile(event)">
													</span>
												</label>
												<font color='black'>
													<p>(ขนาดรูปไม่เกิน 512Kb)</p>
												</font>
											</div>

											<div class="form-group">

												<div class="form-label-group">
													<center><img hidden id="imgProposition" width="70%" height="70%" />
													</center>
													<h5>ใส่โจทย์คำถาม</h5>
													<textarea type="text" rows="8" class="form-control"
														name="proposition" required="required" autofocus="autofocus"><?php if (isset($_POST["add_exam"])) {
															echo $proposition;
														} ?></textarea>
													<font hidden id="img_proposition_size" color='red'>
														<b>*ขนาดรูปภาพใหญ่เกินไป</b>
													</font>

													<script>
														var loadFile = function (event) {
															document.getElementById("imgProposition").hidden = false;
															var reader = new FileReader();
															reader.onload = function () {
																var imgProposition = document.getElementById('imgProposition');
																imgProposition.src = reader.result;
															};
															reader.readAsDataURL(event.target.files[0]);
														};
													</script>

												</div>
											</div>

											<div id="show">
												<?php $num_ans = 1;
												foreach ($ans_type_subject as $ans_type_subjects) { ?>
													<div class="form-group">
														<h5>ตัวเลือก
															<?php echo $ans_type_subjects ?>
														</h5>
														<div class="form-label-group">
															<img hidden id="imgOption<?php echo $num_ans; ?>" width="30%"
																height="30%" />
															<textarea type="text" rows="4"
																name="Option<?php echo $num_ans; ?>"
																id="Option<?php echo $num_ans; ?>" class="form-control"
																required="required" autofocus="autofocus"><?php if (isset($_POST["add_exam"])) {
																	echo $Option . $num_ans;
																} ?></textarea>
															<font id="imgOption<?php echo $num_ans; ?>_size" hidden
																color='red'><b>*ขนาดรูปภาพใหญ่เกินไป</b></font>
															<div class="form-inline">
																<div class="input-group mt-2">
																	<label>
																		<span class="btn btn-warning">
																			เลือกรูปภาพ <input hidden type="file"
																				name="img_Option<?php echo $num_ans; ?>"
																				id="img_Option<?php echo $num_ans; ?>"
																				class="form-control" autofocus="autofocus"
																				accept="image/*"
																				onchange="loadFile<?php echo $num_ans; ?>(event)"></span>
																	</label>
																	<font color='black'>
																		<p>(ขนาดรูปไม่เกิน 512Kb)</p>
																	</font>
																</div>
															</div>

															<script>
																var loadFile<?= $num_ans; ?> = function (event) {
																	document.getElementById("imgOption<?= $num_ans; ?>").hidden = false;
																	var reader = new FileReader();
																	reader.onload = function () {
																		var imgOption<?= $num_ans; ?> = document.getElementById('imgOption<?= $num_ans; ?>');
																		imgOption<?= $num_ans; ?>.src = reader.result;
																	};
																	reader.readAsDataURL(event.target.files[0]);
																};
															</script>

														</div>
													</div>
													<?php $num_ans++;
												} ?>

												<div class="form-group">
													<h5>คำตอบที่ถูกต้อง</h5>
													<div class="form-label-group">
														<select name="Option_true" class="form-control" id="Option_true"
															required="required">
															<option value="">คำตอบที่ถูกต้อง</option>
															<?php $x = 1;
															foreach ($ans_type_subject as $ans_type_subjects) { ?>
																<option <?php if (isset($_POST["add_exam"])) {
																	if ($Option_true == $x) {
																		echo "selected";
																	}
																} ?> value="<?php echo $x; ?>">ตัวเลือก <?php echo $ans_type_subjects; ?></option>
																<?php $x++;
															} ?>
														</select>

													</div>
												</div>

											</div>



											<button type="submit" name="add_exam"
												class="btn btn-success btn-block">บันทึกข้อสอบ</button>
											<a href="#page-top" class="btn-block"><button type="button"
													onclick="function_wash()"
													class="btn btn-info btn-block">ล้าง</button></a>
										</form>

									</div>
								</div>
							</div>





							<div class="col-sm-7">
								<div class="card-header">
									<i class='far'>&#xf022;</i>
									ข้อสอบที่บันทึกแล้ว
								</div>
								<form action="Series_Exam_Manager_DeleteAll.php" method="POST"
									onsubmit="return all_delete();">
									<div class="card mb-3">



										<div class="card-body">
											<div class="table-responsive">


												<table class="table table-bordered" id="dataTable" width="100%"
													cellspacing="0">
													<thead>


														<tr>
															<th width="5%">
																<input type="checkbox" id="Check_All"
																	onClick="check_uncheck_all()" />
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
																	<input type="submit" name="delete_all_exam"
																		value="ลบที่เลือก"
																		class="btn btn-danger"></input>
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
														$sql = "SELECT * FROM `manager_exam` WHERE `chapter_id_exam` = $id_chapter";
														$result = mysqli_query($conn, $sql);
														$num_chapter = 1;
														while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
															$exam_id = $row['id'];
															$proposition_exam = $row['proposition_exam'];
															$proposition_img_exam = $row['proposition_img_exam'];
															$answer1_exam = $row['answer1_exam'];
															$answer1_img_exam = $row['answer1_img_exam'];
															$answer2_exam = $row['answer2_exam'];
															$answer2_img_exam = $row['answer2_img_exam'];
															$answer3_exam = $row['answer3_exam'];
															$answer3_img_exam = $row['answer3_img_exam'];
															$answer4_exam = $row['answer4_exam'];
															$answer4_img_exam = $row['answer4_img_exam'];
															$answer5_exam = $row['answer5_exam'];
															$answer5_img_exam = $row['answer5_img_exam'];
															$result_exam = $row['result_exam'];
															$chapter_id_exam = $row['chapter_id_exam'];
															?>
															<tr>
																<td>

																	<input name="delete_all[]"
																		id="input_Check_num<?php echo $num_chapter; ?>"
																		type="checkbox"
																		value="<?php echo $exam_id; ?>"></input>


																</td>

									</form>
									<td>


										<div class="panel-group">
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a style="font-size:100%" id="userDropdown"
															href="#collapse<?php echo $num_chapter; ?>" role="button"
															data-toggle="collapse">
															<font color="black">
																<?php echo $num_chapter; ?>).
																<?php echo $proposition_exam; ?>
															</font>
														</a>

													</h4>
												</div>
												<div id="collapse<?php echo $num_chapter; ?>"
													class="panel-collapse collapse">
													<div class="card-body">
														<form action="Manager_Exam_Add_Sql.php" method="POST"
															enctype="multipart/form-data">
															<input hidden type="text" name="exam_id"
																value="<?php echo $exam_id; ?>" />
															<input hidden type="text" name="id_chapter"
																value="<?php echo $id_chapter; ?>">
															<div class="form-group">
																<h5>โจทย์คำถาม</h5>
																<div class="form-label-group">

																	<div class="image-area">
																		<input hidden
																			id="imgProposition_remove<?php echo $num_chapter; ?>"
																			type="text" value="p">
																		<center><img
																				id="imgProposition_sql<?php echo $num_chapter; ?>"
																				<?php if ($proposition_img_exam == null) {
																					echo "hidden";
																				} else { ?> src="upload/<?php echo $proposition_img_exam; ?>"
																				<?php } ?>
																				style="max-width: auto;height: 350px;">
																		</center>
																		<a id="btn_remove<?php echo $num_chapter; ?>"
																			onClick="hid_p<?php echo $num_chapter; ?>()"
																			<?php if ($proposition_img_exam == null) {
																				echo "hidden";
																			} ?>><button class="remove-image"
																				style="display: inline;"
																				type="button">&#215;</button></a>
																	</div>

																	<textarea type="text" rows="8" class="form-control"
																		name="proposition" required="required"
																		autofocus="autofocus"><?php echo $proposition_exam; ?></textarea>
																	<div class="input-group mt-2">
																		<label>
																			<span class="btn btn-warning">

																				เลือกรูปภาพ <input
																					onClick="hid_p_img<?php echo $num_chapter; ?>()"
																					hidden type="file"
																					name="img_proposition"
																					id="img_proposition_sql<?php echo $num_chapter; ?>"
																					class="form-control"
																					autofocus="autofocus" accept="image/*"
																					value="<?php echo $proposition_img_exam; ?>"
																					onchange="loadFiles<?php echo $num_chapter; ?>(event)">
																			</span>
																		</label>
																		<font color='black'>
																			<p>(ขนาดรูปไม่เกิน 512Kb)</p>
																		</font>
																	</div>
																	<script>
																		var loadFiles<?php echo $num_chapter; ?> = function (event) {
																			document.getElementById("imgProposition_sql<?php echo $num_chapter; ?>").hidden = false;
																			var reader = new FileReader();
																			reader.onload = function () {
																				var imgProposition_sql = document.getElementById('imgProposition_sql<?php echo $num_chapter; ?>');
																				imgProposition_sql.src = reader.result;
																			};
																			reader.readAsDataURL(event.target.files[0]);
																		};
																		function hid_p<?php echo $num_chapter; ?>() {
																			document.getElementById("imgProposition_sql<?php echo $num_chapter; ?>").hidden = true;
																			document.getElementById("btn_remove<?php echo $num_chapter; ?>").hidden = true;
																			document.getElementById("imgProposition_remove<?php echo $num_chapter; ?>").setAttribute("name", "img_proposition");
																			document.getElementById("img_proposition_sql<?php echo $num_chapter; ?>").setAttribute("name", "");
																		}
																		function hid_p_img<?php echo $num_chapter; ?>() {
																			document.getElementById("imgProposition_remove<?php echo $num_chapter; ?>").setAttribute("name", "");
																			document.getElementById("img_proposition_sql<?php echo $num_chapter; ?>").setAttribute("name", "img_proposition");
																			document.getElementById("btn_remove<?php echo $num_chapter; ?>").hidden = false;
																		}
																	</script>
																</div>
															</div>
															<hr>

															<?php $num_ans = 1;
															foreach ($ans_type_subject as $ans_type_subjects) { ?>
																<div class="form-group">
																	<h5>ตัวเลือก
																		<?php echo $ans_type_subjects; ?>
																	</h5>
																	<div class="form-label-group">

																		<div class="image-area">
																			<input hidden
																				id="Option<?php echo $num_ans; ?>_remove<?php echo $num_chapter; ?>"
																				type="text" value="<?php echo $num_ans; ?>">
																			<img id="imgOption<?php echo $num_ans; ?>sql<?php echo $num_chapter; ?>"
																				<?php
																				if ($answer1_img_exam == null && $num_ans == 1) {
																					echo "hidden";
																				} else if ($answer2_img_exam == null && $num_ans == 2) {
																					echo "hidden";
																				} else if ($answer3_img_exam == null && $num_ans == 3) {
																					echo "hidden";
																				} else if ($answer4_img_exam == null && $num_ans == 4) {
																					echo "hidden";
																				} else if ($answer5_img_exam == null && $num_ans == 5) {
																					echo "hidden";
																				}
																				if ($num_ans == 1) {
																					echo 'src="upload/' . $answer1_img_exam;
																				} else if ($num_ans == 2) {
																					echo 'src="upload/' . $answer2_img_exam;
																				} else if ($num_ans == 3) {
																					echo 'src="upload/' . $answer3_img_exam;
																				} else if ($num_ans == 4) {
																					echo 'src="upload/' . $answer4_img_exam;
																				} else if ($num_ans == 5) {
																					echo 'src="upload/' . $answer5_img_exam;
																				}
																				echo '"'; ?> width="30%" height="30%">
																			<textarea type="text" rows="4"
																				name="Option<?php echo $num_ans; ?>"
																				id="Option<?php echo $num_ans; ?>"
																				class="form-control" required="required"
																				autofocus="autofocus"><?php
																				if ($num_ans == 1) {
																					echo $answer1_exam;
																				} else if ($num_ans == 2) {
																					echo $answer2_exam;
																				} else if ($num_ans == 3) {
																					echo $answer3_exam;
																				} else if ($num_ans == 4) {
																					echo $answer4_exam;
																				} else if ($num_ans == 5) {
																					echo $answer5_exam;
																				}
																				?></textarea>
																			<a id="btn_Option<?php echo $num_ans; ?>_remove<?php echo $num_chapter; ?>"
																				onClick="Option<?php echo $num_ans; ?>_remove<?php echo $num_chapter; ?>()"
																				<?php if ($answer1_img_exam == null) {
																					echo "hidden";
																				} ?>><button class="remove-image"
																					style="display: inline;"
																					type="button">&#215;</button></a>
																		</div>
																		<div class="input-group mt-2">
																			<label>
																				<span class="btn btn-warning">
																					เลือกรูปภาพ <input
																						onClick="Option<?php echo $num_ans; ?>_remove_file<?php echo $num_chapter; ?>()"
																						hidden type="file"
																						name="img_Option<?php echo $num_ans; ?>"
																						id="img_Option<?php echo $num_ans . $num_chapter; ?>"
																						class="form-control"
																						autofocus="autofocus" accept="image/*"
																						value="<?php echo $answer1_img_exam; ?>"
																						onchange="loadFile<?php echo $num_ans; ?>_sql<?php echo $num_chapter; ?>(event)">
																				</span>
																			</label>
																			<font color='black'>
																				<p>(ขนาดรูปไม่เกิน 512Kb)</p>
																			</font>
																		</div>
																		<script>
																			var loadFile<?= $num_ans ?>_sql<?php echo $num_chapter; ?> = function (event) {
																				document.getElementById("imgOption<?= $num_ans ?>sql<?php echo $num_chapter; ?>").hidden = false;
																				var reader = new FileReader();
																				reader.onload = function () {
																					var imgOption<?= $num_ans ?>sql = document.getElementById('imgOption<?= $num_ans ?>sql<?php echo $num_chapter; ?>');
																									imgOption<?= $num_ans ?>sql.src = reader.result;
																				};
																				reader.readAsDataURL(event.target.files[0]);
																			};
																			function Option<?= $num_ans ?>_remove<?php echo $num_chapter; ?>(){
																				document.getElementById("imgOption<?= $num_ans ?>sql<?php echo $num_chapter; ?>").hidden = true;
																				document.getElementById("btn_Option<?= $num_ans ?>_remove<?php echo $num_chapter; ?>").hidden = true;
																				document.getElementById("Option<?= $num_ans ?>_remove<?php echo $num_chapter; ?>").setAttribute("name", "img_Option<?= $num_ans ?>");
																				document.getElementById("img_Option<?= $num_ans ?><?php echo $num_chapter; ?>").setAttribute("name", "");
																			}
																			function Option<?= $num_ans ?>_remove_file<?php echo $num_chapter; ?>(){
																				document.getElementById("btn_Option<?= $num_ans ?>_remove<?php echo $num_chapter; ?>").hidden = false;
																				document.getElementById("Option<?= $num_ans ?>_remove<?php echo $num_chapter; ?>").setAttribute("name", "");
																				document.getElementById("img_Option<?= $num_ans ?><?php echo $num_chapter; ?>").setAttribute("name", "img_Option<?= $num_ans ?>");
																			}
																		</script>
																	</div>
																</div>
																<hr>
																<?php $num_ans++;
															} ?>

															<!-- <div class="form-group">
						  <h5>ตัวเลือกที่ 2</h5>
							<div class="form-label-group">
							<div class="image-area">
							  <input hidden id="Option2_remove<?php echo $num_chapter; ?>" type="text" value="2">
							  <img id="imgOption2sql<?php echo $num_chapter; ?>" <?php if ($answer2_img_exam == null) {
									 echo "hidden";
								 } ?> src="upload/<?php echo $answer2_img_exam; ?>" width="30%" height="30%">
							  <textarea rows="4" type="text" name="Option2" id="Option2" class="form-control" required="required" autofocus="autofocus"><?php echo $answer2_exam; ?></textarea>
							  <a id="btn_Option2_remove<?php echo $num_chapter; ?>" onClick="Option2_remove<?php echo $num_chapter; ?>()" <?php if ($answer2_img_exam == null) {
										echo "hidden";
									} ?>><button class="remove-image"  style="display: inline;" type="button">&#215;</button></a>
							</div>
							  <div class="input-group mt-2">
									<label>
										<span class="btn btn-warning">
										  เลือกรูปภาพ  <input onClick="Option2_remove_file<?php echo $num_chapter; ?>()" hidden type="file" name="img_Option2" id="img_Option2<?php echo $num_chapter; ?>" class="form-control" autofocus="autofocus" accept="image/*" value="<?php echo $answer2_img_exam; ?>" onchange="loadFile2_sql<?php echo $num_chapter; ?>(event)">
										</span>
									</label>
									<font color='black'><p>(ขนาดรูปไม่เกิน 512Kb)</p></font>
							  </div>
							  <script>
								  var loadFile2_sql<?php echo $num_chapter; ?> = function(event) {
									document.getElementById("imgOption2sql<?php echo $num_chapter; ?>").hidden = false;
									var reader = new FileReader();
									reader.onload = function(){
									  var imgOption2sql = document.getElementById('imgOption2sql<?php echo $num_chapter; ?>');
									  imgOption2sql.src = reader.result;
									};
									reader.readAsDataURL(event.target.files[0]);
								  };
								  function Option2_remove<?php echo $num_chapter; ?>(){
										document.getElementById("imgOption2sql<?php echo $num_chapter; ?>").hidden = true;
										document.getElementById("btn_Option2_remove<?php echo $num_chapter; ?>").hidden = true;
										document.getElementById("Option2_remove<?php echo $num_chapter; ?>").setAttribute("name", "img_Option2");
										document.getElementById("img_Option2<?php echo $num_chapter; ?>").setAttribute("name", "");
									}
									function Option2_remove_file<?php echo $num_chapter; ?>(){
										document.getElementById("btn_Option2_remove<?php echo $num_chapter; ?>").hidden = false;
										document.getElementById("Option2_remove<?php echo $num_chapter; ?>").setAttribute("name", "");
										document.getElementById("img_Option2<?php echo $num_chapter; ?>").setAttribute("name", "img_Option2");
									}
								</script>
							</div>
						  </div>
						  <hr>
						  <div class="form-group">
						  <h5>ตัวเลือกที่ 3</h5>
							<div class="form-label-group">
							  <div class="image-area">
							  <input hidden id="Option3_remove<?php echo $num_chapter; ?>" type="text" value="3">
							  <img id="imgOption3sql<?php echo $num_chapter; ?>" <?php if ($answer3_img_exam == null) {
									 echo "hidden";
								 } ?> src="upload/<?php echo $answer3_img_exam; ?>" width="30%" height="30%">
							  <a id="btn_Option3_remove<?php echo $num_chapter; ?>" onClick="Option3_remove<?php echo $num_chapter; ?>()" <?php if ($answer3_img_exam == null) {
										echo "hidden";
									} ?>><button class="remove-image"  style="display: inline;" type="button">&#215;</button></a>
							  <textarea rows="4" type="text" name="Option3" id="Option3" class="form-control" required="required" autofocus="autofocus"><?php echo $answer3_exam; ?></textarea>
							  </div>
							  <div class="input-group mt-2">
									<label>
										<span class="btn btn-warning">
										  เลือกรูปภาพ  <input onClick="Option3_remove_file<?php echo $num_chapter; ?>()" hidden type="file" name="img_Option3" id="img_Option3<?php echo $num_chapter; ?>" class="form-control" autofocus="autofocus" accept="image/*" value="<?php echo $answer3_img_exam; ?>" onchange="loadFile3_sql<?php echo $num_chapter; ?>(event)">
										</span>
									</label>
									<font color='black'><p>(ขนาดรูปไม่เกิน 512Kb)</p></font>
								</div>
								<script>
								  var loadFile3_sql<?php echo $num_chapter; ?> = function(event) {
									document.getElementById("imgOption3sql<?php echo $num_chapter; ?>").hidden = false;
									var reader = new FileReader();
									reader.onload = function(){
									  var imgOption3sql = document.getElementById('imgOption3sql<?php echo $num_chapter; ?>');
									  imgOption3sql.src = reader.result;
									};
									reader.readAsDataURL(event.target.files[0]);
								  };
								  function Option3_remove<?php echo $num_chapter; ?>(){
										document.getElementById("imgOption3sql<?php echo $num_chapter; ?>").hidden = true;
										document.getElementById("btn_Option3_remove<?php echo $num_chapter; ?>").hidden = true;
										document.getElementById("Option3_remove<?php echo $num_chapter; ?>").setAttribute("name", "img_Option3");
										document.getElementById("img_Option3<?php echo $num_chapter; ?>").setAttribute("name", "");
									}
									function Option3_remove_file<?php echo $num_chapter; ?>(){
										document.getElementById("btn_Option3_remove<?php echo $num_chapter; ?>").hidden = false;
										document.getElementById("Option3_remove<?php echo $num_chapter; ?>").setAttribute("name", "");
										document.getElementById("img_Option3<?php echo $num_chapter; ?>").setAttribute("name", "img_Option3");
									}
								</script>
							</div>
						  </div>
						  <hr>



						  <div class="form-group">
						  <h5>ตัวเลือกที่ 4</h5>
							<div class="form-label-group">
							  <div class="image-area">
							  <input hidden id="Option4_remove<?php echo $num_chapter; ?>" type="text" value="4">
							  <img id="imgOption4sql<?php echo $num_chapter; ?>" <?php if ($answer4_img_exam == null) {
									 echo "hidden";
								 } ?> src="upload/<?php echo $answer4_img_exam; ?>" width="30%" height="30%">
							  <a id="btn_Option4_remove<?php echo $num_chapter; ?>" onClick="Option4_remove<?php echo $num_chapter; ?>()" <?php if ($answer4_img_exam == null) {
										echo "hidden";
									} ?>><button class="remove-image"  style="display: inline;" type="button">&#215;</button></a>
							  <textarea rows="4" type="text" name="Option4" id="Option4" class="form-control" required="required" autofocus="autofocus"><?php echo $answer4_exam; ?></textarea>
							  </div>
							  <div class="input-group mt-2">
									<label>
										<span class="btn btn-warning">
										  เลือกรูปภาพ  <input onClick="Option4_remove_file<?php echo $num_chapter; ?>()" hidden type="file" name="img_Option4" id="img_Option4<?php echo $num_chapter; ?>" class="form-control" autofocus="autofocus" accept="image/*" value="<?php echo $answer4_img_exam; ?>" onchange="loadFile4_sql<?php echo $num_chapter; ?>(event)">
										</span>
									</label>
									<font color='black'><p>(ขนาดรูปไม่เกิน 512Kb)</p></font>
							  </div>
							  <script>
								  var loadFile4_sql<?php echo $num_chapter; ?> = function(event) {
									document.getElementById("imgOption4sql<?php echo $num_chapter; ?>").hidden = false;
									var reader = new FileReader();
									reader.onload = function(){
									  var imgOption4sql = document.getElementById('imgOption4sql<?php echo $num_chapter; ?>');
									  imgOption4sql.src = reader.result;
									};
									reader.readAsDataURL(event.target.files[0]);
								  };
								  function Option4_remove<?php echo $num_chapter; ?>(){
										document.getElementById("imgOption4sql<?php echo $num_chapter; ?>").hidden = true;
										document.getElementById("btn_Option4_remove<?php echo $num_chapter; ?>").hidden = true;
										document.getElementById("Option4_remove<?php echo $num_chapter; ?>").setAttribute("name", "img_Option4");
										document.getElementById("img_Option4<?php echo $num_chapter; ?>").setAttribute("name", "");
									}
									function Option4_remove_file<?php echo $num_chapter; ?>(){
										document.getElementById("btn_Option4_remove<?php echo $num_chapter; ?>").hidden = false;
										document.getElementById("Option4_remove<?php echo $num_chapter; ?>").setAttribute("name", "");
										document.getElementById("img_Option4<?php echo $num_chapter; ?>").setAttribute("name", "img_Option4");
									}
								</script>
							</div>
						  </div>
						  <hr> -->
															<div class="form-group">
																<h5>คำตอบที่ถูกต้อง</h5>
																<div class="form-label-group">

																	<?php $x = 1;
																	foreach ($ans_type_subject as $ans_type_subjects) { ?>
																		<div class="form-check">
																			<label class="form-check-label">
																				<input type="radio" <?php if ($result_exam == $x) {
																					echo "checked";
																				} ?> class="form-check-input" name="Option_true"
																					value="<?php echo $x; ?>"> ตัวเลือก <?php echo $ans_type_subjects; ?>
																			</label>
																		</div>
																		<?php $x++;
																	} ?>
																	<!-- <div class="form-check">
								<label class="form-check-label">
									<input type="radio" <?php if ($result_exam == 2) {
										echo "checked";
									} ?> class="form-check-input" name="Option_true" value="2"> ตัวเลือกที่ 2
								</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" <?php if ($result_exam == 3) {
										echo "checked";
									} ?> class="form-check-input" name="Option_true" value="3"> ตัวเลือกที่ 3
								</label>
							</div>
							<div class="form-check">
								<label class="form-check-label">
									<input type="radio" <?php if ($result_exam == 4) {
										echo "checked";
									} ?> class="form-check-input" name="Option_true" value="4"> ตัวเลือกที่ 4
								</label>
							</div> -->


																	<!-----
							<select name="Option_true" class="form-control" id="Option_true" required="required">
							  <option value="">คำตอบที่ถูกต้อง</option>
							  <option <?php //if($a == 1){ echo "selected";} ?> value="1">ตัวเลือกที่ 1</option>
							  <option <?php //if($a == 2){ echo "selected";} ?> value="2">ตัวเลือกที่ 2</option>
							  <option <?php //if($a == 3){ echo "selected";} ?> value="3">ตัวเลือกที่ 3</option>
							  <option <?php //if($a == 4){ echo "selected";} ?> value="4">ตัวเลือกที่ 4</option>
							</select>
							----->

															</div>
														</div>
														<hr>
														<button type="submit" name="edit_exam"
															class="btn btn-primary btn-block">อัพเดทข้อสอบ</button>
													</form>



												</div>
												<hr>
											</div>
										</div>





									</div>


								</td>
								<td>
									<a href="Manager_Exam_Add_Sql.php?id_chapter=<?php echo $id_chapter; ?>&id_exam=<?php echo $exam_id; ?>&delete_exam"
										onclick="return buttonDelete<?php echo $num_chapter; ?>();"><button
											type="button" class="btn btn-danger"><b>ลบ<b></button></a>
								</td>
								</tr>
								<?php $num_chapter++;
														} ?>
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
	$sql = "SELECT * FROM `manager_exam` WHERE `chapter_id_exam` = $id_chapter";
	$result = mysqli_query($conn, $sql);
	$i = 1;
	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		?>
		<script>
			function buttonDelete<?php echo $i; ?>() {
				var result = confirm("แน่ใจว่าต้องการลบข้อที่ " + <?php echo $i; ?> + " ?");
				if (result == true) {
					return true;
				} else {
					return false;
				}
			}
		</script>
		<?php
		$i++;
	}
	?>

	<script type="text/javascript">
		function check_uncheck_all() {
			var checkedVal = document.getElementById("Check_All");
			<?php
			$sql = "SELECT * FROM `manager_exam` WHERE `chapter_id_exam` = $id_chapter";
			$result = mysqli_query($conn, $sql);
			$i = 1;
			while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				?>
				var input_Check_num = document.getElementById("input_Check_num<?php echo $i; ?>");
				if (checkedVal.checked == true) {
					input_Check_num.checked = true;
				} else {
					input_Check_num.checked = false;
				}
				<?php $i++;
			} ?>
		}
		function all_delete() { // begin function: check form
			if (!confirm("แน่ใจว่าต้องการลบ ?")) { // start if
				return (false);
			} // end if
			return (true);
		} // end function: check form
	</script>
	<script>

	</script>







</body>

</html>