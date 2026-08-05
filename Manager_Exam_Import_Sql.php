<?php
session_start();
include("connect.php");
require_once "vendor/excel_parser/ExcelReaderHelper.php";

if (!isset($_SESSION['id_teacher'])) {
	session_destroy();
	header("location:Login.php");
	exit();
}

if (isset($_POST["import_excel"])) {
	$id_chapter = isset($_POST["id_chapter"]) ? (int)$_POST["id_chapter"] : 0;
	$import_type = isset($_POST["import_type"]) ? $_POST["import_type"] : "mc"; // 'mc' (ปรนัย) or 'annotated' (อัตนัย)

	if ($id_chapter <= 0) {
		echo "<script language='JavaScript'>
				alert('ไม่พบไอดีบทเรียนที่ต้องการนำเข้า!');
				window.history.back();
			  </script>";
		exit();
	}

	if (!isset($_FILES['excel_file']) || $_FILES['excel_file']['error'] !== UPLOAD_ERR_OK) {
		echo "<script language='JavaScript'>
				alert('กรุณาเลือกไฟล์ Excel (.xlsx หรือ .csv) ที่ต้องการนำเข้า!');
				window.history.back();
			  </script>";
		exit();
	}

	$tmp_filepath = $_FILES['excel_file']['tmp_name'];
	$filename = $_FILES['excel_file']['name'];
	$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

	if ($ext !== 'xlsx' && $ext !== 'csv') {
		echo "<script language='JavaScript'>
				alert('รองรับเฉพาะไฟล์ประเภท .xlsx หรือ .csv เท่านั้น!');
				window.history.back();
			  </script>";
		exit();
	}

	$parse_result = ExcelReaderHelper::parseFile($tmp_filepath, $filename);
	if (!$parse_result['success']) {
		$err_msg = addslashes($parse_result['error']);
		echo "<script language='JavaScript'>
				alert('เกิดข้อผิดพลาดในการอ่านไฟล์: {$err_msg}');
				window.history.back();
			  </script>";
		exit();
	}

	$sheets = $parse_result['sheets'];
	$sheetNames = $parse_result['sheetNames'];

	$success_count = 0;
	$error_rows = array();

	if ($import_type === "mc") {
		// Import Multiple Choice Questions into `manager_exam`
		// Target sheet: Sheet 0 or named 'ข้อสอบปรนัย'
		$target_sheet_idx = 0;
		foreach ($sheetNames as $idx => $sname) {
			if (mb_strpos($sname, 'ปรนัย') !== false) {
				$target_sheet_idx = $idx;
				break;
			}
		}

		$rows = isset($sheets[$target_sheet_idx]) ? $sheets[$target_sheet_idx] : array();

		// Use Prepared Statement for safe insertion in PHP 5.6
		$sql = "INSERT INTO `manager_exam` 
				(`id`, `proposition_exam`, `proposition_img_exam`, 
				 `answer1_exam`, `answer1_img_exam`, 
				 `answer2_exam`, `answer2_img_exam`, 
				 `answer3_exam`, `answer3_img_exam`, 
				 `answer4_exam`, `answer4_img_exam`, 
				 `answer5_exam`, `answer5_img_exam`, 
				 `result_exam`, `chapter_id_exam`) 
				VALUES (NULL, ?, '', ?, '', ?, '', ?, '', ?, '', ?, '', ?, ?)";
		
		$stmt = mysqli_prepare($conn, $sql);

		foreach ($rows as $row_index => $row) {
			// Skip header row if contains title text
			if ($row_index === 0) {
				$first_cell = isset($row[0]) ? trim((string)$row[0]) : '';
				$second_cell = isset($row[1]) ? trim((string)$row[1]) : '';
				if (mb_strpos($second_cell, 'โจทย์') !== false || mb_strpos($first_cell, 'ข้อที่') !== false) {
					continue;
				}
			}

			// Column B (idx 1) = proposition
			// Column C (idx 2) = answer1, D (idx 3) = answer2, E (idx 4) = answer3, F (idx 5) = answer4, G (idx 6) = answer5
			// Column H (idx 7) = result_exam
			$proposition = isset($row[1]) ? trim((string)$row[1]) : '';
			$ans1 = isset($row[2]) ? trim((string)$row[2]) : '';
			$ans2 = isset($row[3]) ? trim((string)$row[3]) : '';
			$ans3 = isset($row[4]) ? trim((string)$row[4]) : '';
			$ans4 = isset($row[5]) ? trim((string)$row[5]) : '';
			$ans5 = isset($row[6]) ? trim((string)$row[6]) : '';
			$raw_result = isset($row[7]) ? trim((string)$row[7]) : '';

			// If empty row, skip
			if (empty($proposition) && empty($ans1) && empty($ans2)) {
				continue;
			}

			// Validate mandatory fields
			if (empty($proposition)) {
				$error_rows[] = "แถวที่ " . ($row_index + 1) . ": ไม่ระบุโจทย์คำถาม";
				continue;
			}

			if (empty($ans1) || empty($ans2) || empty($ans3) || empty($ans4)) {
				$error_rows[] = "แถวที่ " . ($row_index + 1) . ": ตัวเลือกที่ 1-4 ต้องไม่เป็นค่าว่าง";
				continue;
			}

			$norm_result = ExcelReaderHelper::normalizeAnswerKey($raw_result);
			if ($norm_result < 1 || $norm_result > 5) {
				$error_rows[] = "แถวที่ " . ($row_index + 1) . ": เฉลยคำตอบไม่ถูกต้อง ('{$raw_result}') ต้องเป็น 1-5 หรือ ก-จ";
				continue;
			}

			if ($stmt) {
				mysqli_stmt_bind_param($stmt, "ssssssii", 
					$proposition, $ans1, $ans2, $ans3, $ans4, $ans5, $norm_result, $id_chapter
				);
				if (mysqli_stmt_execute($stmt)) {
					$success_count++;
				} else {
					$error_rows[] = "แถวที่ " . ($row_index + 1) . ": บันทึกลงฐานข้อมูลล้มเหลว (" . mysqli_error($conn) . ")";
				}
			}
		}

		if ($stmt) {
			mysqli_stmt_close($stmt);
		}

	} else if ($import_type === "annotated") {
		// Import Subjective Questions into `manager_exam_annotated`
		$target_sheet_idx = 0;
		foreach ($sheetNames as $idx => $sname) {
			if (mb_strpos($sname, 'อัตนัย') !== false) {
				$target_sheet_idx = $idx;
				break;
			}
		}

		$rows = isset($sheets[$target_sheet_idx]) ? $sheets[$target_sheet_idx] : array();

		$sql = "INSERT INTO `manager_exam_annotated` 
				(`id`, `proposition_exam`, `proposition_img_exam`, `ans_exam`, `chapter_id_exam`) 
				VALUES (NULL, ?, '', ?, ?)";
		
		$stmt = mysqli_prepare($conn, $sql);

		foreach ($rows as $row_index => $row) {
			if ($row_index === 0) {
				$first_cell = isset($row[0]) ? trim((string)$row[0]) : '';
				$second_cell = isset($row[1]) ? trim((string)$row[1]) : '';
				if (mb_strpos($second_cell, 'โจทย์') !== false || mb_strpos($first_cell, 'ข้อที่') !== false) {
					continue;
				}
			}

			// Column B (idx 1) = proposition
			// Column C (idx 2) = ans_annotated
			$proposition = isset($row[1]) ? trim((string)$row[1]) : '';
			$ans_annotated = isset($row[2]) ? trim((string)$row[2]) : '';

			if (empty($proposition) && empty($ans_annotated)) {
				continue;
			}

			if (empty($proposition)) {
				$error_rows[] = "แถวที่ " . ($row_index + 1) . ": ไม่ระบุโจทย์คำถาม";
				continue;
			}

			if ($stmt) {
				mysqli_stmt_bind_param($stmt, "ssi", $proposition, $ans_annotated, $id_chapter);
				if (mysqli_stmt_execute($stmt)) {
					$success_count++;
				} else {
					$error_rows[] = "แถวที่ " . ($row_index + 1) . ": บันทึกลงฐานข้อมูลล้มเหลว (" . mysqli_error($conn) . ")";
				}
			}
		}

		if ($stmt) {
			mysqli_stmt_close($stmt);
		}
	}

	// Prepare feedback message
	$msg = "นำเข้าข้อสอบสำเร็จจำนวน {$success_count} ข้อ";
	if (count($error_rows) > 0) {
		$msg .= "\\n\\nข้อผิดพลาดที่พบ (" . count($error_rows) . " รายการ):\\n" . implode("\\n", array_slice($error_rows, 0, 10));
		if (count($error_rows) > 10) {
			$msg .= "\\n...และข้อผิดพลาดอื่นอีก " . (count($error_rows) - 10) . " รายการ";
		}
	}

	$msg_escaped = addslashes($msg);
	echo "<script language='JavaScript'>
			alert('{$msg_escaped}');
			window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
		  </script>";
	exit();
}
