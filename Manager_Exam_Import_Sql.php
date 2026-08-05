<?php
session_start();
include("connect.php");
require_once "vendor/excel_parser/ExcelReaderHelper.php";

if (!isset($_SESSION['id_teacher'])) {
    session_destroy();
    header("location:Login.php");
    exit();
}

function AlertMsgExcel($msg, $type)
{
    if ($type == 1) {
        return "<script>alert('" . $msg . "');</script>";
    } else {
        return "<script>alert('" . $msg . "'); window.history.back();</script>";
    }
}

// --------------------------------------------------------------------------
// 1. Confirm Import Action (Save previewed Excel questions into DB)
// --------------------------------------------------------------------------
if (isset($_POST['confirm_import_excel'])) {
    $id_chapter  = isset($_POST['id_chapter']) ? (int)$_POST['id_chapter'] : 0;
    $import_type = isset($_POST['import_type']) ? $_POST['import_type'] : 'mc';
    $questions   = isset($_POST['questions']) ? $_POST['questions'] : array();

    if ($id_chapter <= 0) {
        echo AlertMsgExcel("ไม่พบไอดีบทเรียน", 2);
        exit();
    }

    if (empty($questions)) {
        echo AlertMsgExcel("ไม่พบรายการข้อสอบที่ยืนยันนำเข้า", 2);
        exit();
    }

    $inserted_count = 0;

    if ($import_type === 'annotated') { // Subjective (manager_exam_annotated)
        $sql = "INSERT INTO `manager_exam_annotated`
                (`proposition_exam`, `ans_exam`, `chapter_id_exam`)
                VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            foreach ($questions as $q) {
                $prop = isset($q['proposition']) ? trim($q['proposition']) : '';
                $ans  = isset($q['ans']) ? trim($q['ans']) : '';

                if ($prop !== '') {
                    mysqli_stmt_bind_param($stmt, "ssi", $prop, $ans, $id_chapter);
                    if (mysqli_stmt_execute($stmt)) {
                        $inserted_count++;
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }

        echo "<script>
                alert('นำเข้าข้อสอบอัตนัยจาก Excel สำเร็จจำนวน " . $inserted_count . " ข้อ');
                window.location.href = 'Manager_Exam_Add_Annotated.php?id_chapter=" . $id_chapter . "';
              </script>";
        exit();

    } else { // Multiple Choice (manager_exam)
        $sql = "INSERT INTO `manager_exam`
                (`proposition_exam`, `answer1_exam`, `answer2_exam`, `answer3_exam`, `answer4_exam`, `answer5_exam`, `result_exam`, `chapter_id_exam`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            foreach ($questions as $q) {
                $prop = isset($q['proposition']) ? trim($q['proposition']) : '';
                $a1   = isset($q['answer1']) ? trim($q['answer1']) : '';
                $a2   = isset($q['answer2']) ? trim($q['answer2']) : '';
                $a3   = isset($q['answer3']) ? trim($q['answer3']) : '';
                $a4   = isset($q['answer4']) ? trim($q['answer4']) : '';
                $a5   = isset($q['answer5']) ? trim($q['answer5']) : '';
                $res  = isset($q['result']) ? (int)$q['result'] : 1;

                if ($prop !== '' && $a1 !== '' && $a2 !== '') {
                    mysqli_stmt_bind_param($stmt, "ssssssii", $prop, $a1, $a2, $a3, $a4, $a5, $res, $id_chapter);
                    if (mysqli_stmt_execute($stmt)) {
                        $inserted_count++;
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }

        echo "<script>
                alert('นำเข้าข้อสอบปรนัยจาก Excel สำเร็จจำนวน " . $inserted_count . " ข้อ');
                window.location.href = 'Manager_Exam_Add.php?id_chapter=" . $id_chapter . "';
              </script>";
        exit();
    }
}

// --------------------------------------------------------------------------
// 2. Parse Excel File via AJAX and Return Preview HTML Snippet
// --------------------------------------------------------------------------
if (isset($_POST['ajax_parse_excel']) || isset($_POST['import_excel_ajax'])) {
    header('Content-Type: application/json; charset=utf-8');

    $id_chapter  = isset($_POST['id_chapter']) ? (int)$_POST['id_chapter'] : 0;
    $import_type = isset($_POST['import_type']) ? $_POST['import_type'] : 'mc';

    if (!isset($_FILES['excel_file']) || $_FILES['excel_file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(array('status' => false, 'error' => 'เกิดข้อผิดพลาดในการอัปโหลดไฟล์ Excel'));
        exit();
    }

    $filename     = $_FILES['excel_file']['name'];
    $tmp_filepath = $_FILES['excel_file']['tmp_name'];
    $ext          = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if ($ext !== 'xlsx' && $ext !== 'csv') {
        echo json_encode(array('status' => false, 'error' => 'รองรับเฉพาะไฟล์เอกสารประเภท .xlsx หรือ .csv เท่านั้น'));
        exit();
    }

    $parse_result = ExcelReaderHelper::parseFile($tmp_filepath, $filename);
    if (!$parse_result['success']) {
        echo json_encode(array('status' => false, 'error' => $parse_result['error']));
        exit();
    }

    $sheets     = $parse_result['sheets'];
    $sheetNames = $parse_result['sheetNames'];

    $questions = array();

    if ($import_type === "mc") {
        $target_sheet_idx = 0;
        foreach ($sheetNames as $idx => $sname) {
            if (mb_strpos($sname, 'ปรนัย') !== false) {
                $target_sheet_idx = $idx;
                break;
            }
        }

        $rows = isset($sheets[$target_sheet_idx]) ? $sheets[$target_sheet_idx] : array();

        foreach ($rows as $row_index => $row) {
            if ($row_index === 0) {
                $first_cell  = isset($row[0]) ? trim((string)$row[0]) : '';
                $second_cell = isset($row[1]) ? trim((string)$row[1]) : '';
                if (mb_strpos($second_cell, 'โจทย์') !== false || mb_strpos($first_cell, 'ข้อที่') !== false) {
                    continue;
                }
            }

            $proposition = isset($row[1]) ? trim((string)$row[1]) : '';
            $ans1        = isset($row[2]) ? trim((string)$row[2]) : '';
            $ans2        = isset($row[3]) ? trim((string)$row[3]) : '';
            $ans3        = isset($row[4]) ? trim((string)$row[4]) : '';
            $ans4        = isset($row[5]) ? trim((string)$row[5]) : '';
            $ans5        = isset($row[6]) ? trim((string)$row[6]) : '';
            $raw_result  = isset($row[7]) ? trim((string)$row[7]) : '';

            if (empty($proposition) && empty($ans1) && empty($ans2)) {
                continue;
            }

            $is_valid = true;
            $errors   = array();

            if (empty($proposition)) {
                $is_valid = false;
                $errors[] = 'ไม่ระบุโจทย์คำถาม';
            }

            if (empty($ans1) || empty($ans2)) {
                $is_valid = false;
                $errors[] = 'ตัวเลือก 1-2 ต้องไม่เป็นว่าง';
            }

            $norm_result = ExcelReaderHelper::normalizeAnswerKey($raw_result);
            if ($norm_result < 1 || $norm_result > 5) {
                $is_valid = false;
                $errors[] = "เฉลยไม่ถูกต้อง ('{$raw_result}')";
                $norm_result = 1;
            }

            $questions[] = array(
                'proposition' => $proposition,
                'answer1'     => $ans1,
                'answer2'     => $ans2,
                'answer3'     => $ans3,
                'answer4'     => $ans4,
                'answer5'     => $ans5,
                'result'      => $norm_result,
                'is_valid'    => $is_valid,
                'errors'      => $errors
            );
        }

    } else { // annotated
        $target_sheet_idx = 0;
        foreach ($sheetNames as $idx => $sname) {
            if (mb_strpos($sname, 'อัตนัย') !== false) {
                $target_sheet_idx = $idx;
                break;
            }
        }

        $rows = isset($sheets[$target_sheet_idx]) ? $sheets[$target_sheet_idx] : array();

        foreach ($rows as $row_index => $row) {
            if ($row_index === 0) {
                $first_cell  = isset($row[0]) ? trim((string)$row[0]) : '';
                $second_cell = isset($row[1]) ? trim((string)$row[1]) : '';
                if (mb_strpos($second_cell, 'โจทย์') !== false || mb_strpos($first_cell, 'ข้อที่') !== false) {
                    continue;
                }
            }

            $proposition   = isset($row[1]) ? trim((string)$row[1]) : '';
            $ans_annotated = isset($row[2]) ? trim((string)$row[2]) : '';

            if (empty($proposition) && empty($ans_annotated)) {
                continue;
            }

            $is_valid = true;
            $errors   = array();

            if (empty($proposition)) {
                $is_valid = false;
                $errors[] = 'ไม่ระบุโจทย์คำถาม';
            }

            $questions[] = array(
                'proposition' => $proposition,
                'ans'         => $ans_annotated,
                'is_valid'    => $is_valid,
                'errors'      => $errors
            );
        }
    }

    if (empty($questions)) {
        echo json_encode(array('status' => false, 'error' => 'ไม่พบข้อมูลข้อสอบในไฟล์ Excel กรุณาตรวจสอบรูปแบบไฟล์'));
        exit();
    }

    ob_start();
    ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> ระบบอ่านข้อมูลจาก Excel ได้ทั้งหมด <b><?php echo count($questions); ?></b> ข้อ จากไฟล์: <b><?php echo htmlspecialchars($filename); ?></b>
        <br>กรุณาตรวจสอบความถูกต้องของโจทย์ ตัวเลือก และเฉลย ก่อนกดปุ่ม <b>"ยืนยันนำเข้าข้อมูล"</b>
    </div>

    <form action="Manager_Exam_Import_Sql.php" method="POST" id="formConfirmExcel">
        <input type="hidden" name="id_chapter" value="<?php echo $id_chapter; ?>">
        <input type="hidden" name="import_type" value="<?php echo $import_type; ?>">

        <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
            <table class="table table-bordered align-middle">
                <thead class="table-light sticky-top" style="top: 0; z-index: 10;">
                    <tr>
                        <th width="10%" class="text-center">ข้อที่</th>
                        <th width="<?php echo ($import_type === 'annotated') ? '55%' : '40%'; ?>">โจทย์คำถาม</th>
                        <?php if ($import_type !== 'annotated') { ?>
                            <th width="35%">ตัวเลือกคำตอบ & เฉลย</th>
                        <?php } else { ?>
                            <th width="25%">แนวทางเฉลย/คำตอบ</th>
                        <?php } ?>
                        <th width="10%" class="text-center">สถานะ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $valid_count = 0;
                    foreach ($questions as $index => $q) { 
                        $is_valid = isset($q['is_valid']) ? $q['is_valid'] : true;
                        if ($is_valid) $valid_count++;
                    ?>
                        <tr>
                            <td class="text-center font-weight-bold"><?php echo ($index + 1); ?></td>
                            <td>
                                <textarea name="questions[<?php echo $index; ?>][proposition]" class="form-control mb-1" rows="3" required><?php echo htmlspecialchars($q['proposition']); ?></textarea>
                            </td>

                            <?php if ($import_type !== 'annotated') { ?>
                                <td>
                                    <?php for ($c = 1; $c <= 5; $c++) { 
                                        $val = isset($q['answer' . $c]) ? $q['answer' . $c] : '';
                                        $is_ans = ($q['result'] == $c);
                                    ?>
                                        <div class="input-group mb-2 choice-group-excel" data-choice="<?php echo $c; ?>">
                                            <span class="input-group-text choice-num-excel <?php echo $is_ans ? 'bg-success text-white font-weight-bold' : ''; ?>">
                                                <?php echo $c; ?>.
                                            </span>
                                            <input type="text" name="questions[<?php echo $index; ?>][answer<?php echo $c; ?>]" class="form-control choice-input-excel <?php echo $is_ans ? 'border-success' : ''; ?>" value="<?php echo htmlspecialchars($val); ?>" placeholder="ตัวเลือกที่ <?php echo $c; ?>">
                                        </div>
                                    <?php } ?>
                                    <div class="mt-2">
                                        <label class="form-label text-success font-weight-bold me-2"><i class="fas fa-check-circle"></i> เฉลยตัวเลือกที่:</label>
                                        <select name="questions[<?php echo $index; ?>][result]" class="form-control form-control-sm d-inline-block excel-result-select" style="width: auto;">
                                            <?php for ($r = 1; $r <= 5; $r++) { ?>
                                                <option value="<?php echo $r; ?>" <?php if ($q['result'] == $r) echo 'selected'; ?>>ตัวเลือกที่ <?php echo $r; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </td>
                            <?php } else { ?>
                                <td>
                                    <textarea name="questions[<?php echo $index; ?>][ans]" class="form-control" rows="3"><?php echo htmlspecialchars($q['ans']); ?></textarea>
                                </td>
                            <?php } ?>

                            <td class="text-center align-middle">
                                <?php if ($is_valid) { ?>
                                    <span class="badge badge-success"><i class="fas fa-check"></i> พร้อมนำเข้า</span>
                                <?php } else { ?>
                                    <span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> ข้อมูลไม่ครบ</span>
                                    <small class="text-danger d-block mt-1"><?php echo implode('<br>', $q['errors']); ?></small>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="modal-footer px-0 pb-0 pt-3">
            <button type="button" class="btn btn-secondary btn-cancel-excel-preview"><i class="fas fa-arrow-left"></i> ย้อนกลับไปเลือกไฟล์ใหม่</button>
            <button type="submit" name="confirm_import_excel" class="btn btn-success btn-lg" <?php if ($valid_count == 0) echo 'disabled'; ?>>
                <i class="fas fa-file-import"></i> ยืนยันนำเข้าข้อมูล (<?php echo $valid_count; ?> ข้อ)
            </button>
        </div>
    </form>

    <script>
    $(document).off('change', '.excel-result-select').on('change', '.excel-result-select', function() {
        var selectedVal = $(this).val();
        var $td = $(this).closest('td');
        
        $td.find('.choice-num-excel').removeClass('bg-success text-white font-weight-bold');
        $td.find('.choice-input-excel').removeClass('border-success');
        
        $td.find('.choice-group-excel[data-choice="' + selectedVal + '"] .choice-num-excel').addClass('bg-success text-white font-weight-bold');
        $td.find('.choice-group-excel[data-choice="' + selectedVal + '"] .choice-input-excel').addClass('border-success');
    });
    </script>
    <?php
    $html = ob_get_clean();

    echo json_encode(array(
        'status' => true,
        'html' => $html,
        'valid_count' => $valid_count,
        'total_count' => count($questions),
        'filename' => $filename
    ));
    exit();
}
