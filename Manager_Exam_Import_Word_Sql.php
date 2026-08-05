<?php
session_start();
if (!isset($_SESSION['id_teacher'])) {
    header("location:Login.php");
    exit();
}

include("connect.php");
require_once("vendor/word_parser/WordReaderHelper.php");

function AlertMsgWord($msg, $type)
{
    if ($type == 1) {
        return "<script>alert('" . $msg . "');</script>";
    } else {
        return "<script>alert('" . $msg . "'); window.history.back();</script>";
    }
}

// --------------------------------------------------------------------------
// 1. Confirm Import Action (Save previewed questions into DB)
// --------------------------------------------------------------------------
if (isset($_POST['confirm_import_word'])) {
    $id_chapter  = isset($_POST['id_chapter']) ? (int)$_POST['id_chapter'] : 0;
    $import_type = isset($_POST['import_type']) ? $_POST['import_type'] : 'mc';
    $questions   = isset($_POST['questions']) ? $_POST['questions'] : array();

    if ($id_chapter <= 0) {
        echo AlertMsgWord("ไม่พบไอดีบทเรียน", 2);
        exit();
    }

    if (empty($questions)) {
        echo AlertMsgWord("ไม่พบรายการข้อสอบที่ยืนยันนำเข้า", 2);
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
                alert('นำเข้าข้อสอบอัตนัยสำเร็จจำนวน " . $inserted_count . " ข้อ');
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
                alert('นำเข้าข้อสอบปรนัยสำเร็จจำนวน " . $inserted_count . " ข้อ');
                window.location.href = 'Manager_Exam_Add.php?id_chapter=" . $id_chapter . "';
              </script>";
        exit();
    }
}

// --------------------------------------------------------------------------
// 2. Parse Word File via AJAX and Return Preview HTML Snippet
// --------------------------------------------------------------------------
if (isset($_POST['ajax_parse_word']) || isset($_POST['import_word_ajax'])) {
    header('Content-Type: application/json; charset=utf-8');

    $id_chapter  = isset($_POST['id_chapter']) ? (int)$_POST['id_chapter'] : 0;
    $import_type = isset($_POST['import_type']) ? $_POST['import_type'] : 'mc';

    if (!isset($_FILES['word_file']) || $_FILES['word_file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(array('status' => false, 'error' => 'เกิดข้อผิดพลาดในการอัปโหลดไฟล์ Word'));
        exit();
    }

    $originalName = $_FILES['word_file']['name'];
    $tmpFilePath  = $_FILES['word_file']['tmp_name'];
    $fileExt      = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    if ($fileExt !== 'docx') {
        echo json_encode(array('status' => false, 'error' => 'รองรับเฉพาะไฟล์เอกสารประเภท .docx เท่านั้น'));
        exit();
    }

    $parseResult = WordReaderHelper::parseDocx($tmpFilePath, $import_type);

    if (!$parseResult['status']) {
        echo json_encode(array('status' => false, 'error' => $parseResult['error']));
        exit();
    }

    $questions = $parseResult['data'];

    if (empty($questions)) {
        echo json_encode(array('status' => false, 'error' => 'ไม่พบโจทย์ข้อสอบในไฟล์ Word ที่อัปโหลด กรุณาตรวจสอบรูปแบบการพิมพ์ข้อสอบ'));
        exit();
    }

    ob_start();
    ?>
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> ระบบสกัดข้อสอบได้ทั้งหมด <b><?php echo count($questions); ?></b> ข้อ จากไฟล์: <b><?php echo htmlspecialchars($originalName); ?></b>
        <br>กรุณาตรวจสอบความถูกต้องของโจทย์ ตัวเลือก และเฉลย ก่อนกดปุ่ม <b>"ยืนยันนำเข้าข้อมูล"</b>
    </div>

    <form action="Manager_Exam_Import_Word_Sql.php" method="POST" id="formConfirmWord">
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
                                        <div class="input-group mb-2 choice-group" data-choice="<?php echo $c; ?>">
                                            <span class="input-group-text choice-num <?php echo $is_ans ? 'bg-success text-white font-weight-bold' : ''; ?>">
                                                <?php echo $c; ?>.
                                            </span>
                                            <input type="text" name="questions[<?php echo $index; ?>][answer<?php echo $c; ?>]" class="form-control choice-input <?php echo $is_ans ? 'border-success' : ''; ?>" value="<?php echo htmlspecialchars($val); ?>" placeholder="ตัวเลือกที่ <?php echo $c; ?>">
                                        </div>
                                    <?php } ?>
                                    <div class="mt-2">
                                        <label class="form-label text-success font-weight-bold me-2"><i class="fas fa-check-circle"></i> เฉลยตัวเลือกที่:</label>
                                        <select name="questions[<?php echo $index; ?>][result]" class="form-control form-control-sm d-inline-block word-result-select" style="width: auto;">
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
            <button type="button" class="btn btn-secondary btn-cancel-word-preview"><i class="fas fa-arrow-left"></i> ย้อนกลับไปเลือกไฟล์ใหม่</button>
            <button type="submit" name="confirm_import_word" class="btn btn-success btn-lg" <?php if ($valid_count == 0) echo 'disabled'; ?>>
                <i class="fas fa-file-import"></i> ยืนยันนำเข้าข้อมูล (<?php echo $valid_count; ?> ข้อ)
            </button>
        </div>
    </form>

    <script>
    $(document).off('change', '.word-result-select').on('change', '.word-result-select', function() {
        var selectedVal = $(this).val();
        var $td = $(this).closest('td');
        
        $td.find('.choice-num').removeClass('bg-success text-white font-weight-bold');
        $td.find('.choice-input').removeClass('border-success');
        
        $td.find('.choice-group[data-choice="' + selectedVal + '"] .choice-num').addClass('bg-success text-white font-weight-bold');
        $td.find('.choice-group[data-choice="' + selectedVal + '"] .choice-input').addClass('border-success');
    });
    </script>
    <?php
    $html = ob_get_clean();

    echo json_encode(array(
        'status' => true,
        'html' => $html,
        'valid_count' => $valid_count,
        'total_count' => count($questions),
        'filename' => $originalName
    ));
    exit();
}

// Fallback for standalone form submissions
if (isset($_POST['import_word'])) {
    $id_chapter  = isset($_POST['id_chapter']) ? (int)$_POST['id_chapter'] : 0;
    $import_type = isset($_POST['import_type']) ? $_POST['import_type'] : 'mc';

    if (!isset($_FILES['word_file']) || $_FILES['word_file']['error'] !== UPLOAD_ERR_OK) {
        echo AlertMsgWord("เกิดข้อผิดพลาดในการอัปโหลดไฟล์ Word", 2);
        exit();
    }

    $originalName = $_FILES['word_file']['name'];
    $tmpFilePath  = $_FILES['word_file']['tmp_name'];
    $fileExt      = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    if ($fileExt !== 'docx') {
        echo AlertMsgWord("รองรับเฉพาะไฟล์เอกสารประเภท .docx เท่านั้น", 2);
        exit();
    }

    $parseResult = WordReaderHelper::parseDocx($tmpFilePath, $import_type);

    if (!$parseResult['status']) {
        echo AlertMsgWord("เกิดข้อผิดพลาด: " . $parseResult['error'], 2);
        exit();
    }

    $questions = $parseResult['data'];
    $backPage  = ($import_type === 'annotated') ? "Manager_Exam_Add_Annotated.php?id_chapter=" . $id_chapter : "Manager_Exam_Add.php?id_chapter=" . $id_chapter;
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <title>ตรวจสอบข้อมูลข้อสอบก่อนนำเข้า (Word Preview)</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="fas fa-file-word"></i> ตรวจสอบข้อมูลข้อสอบจากไฟล์ Word ก่อนนำเข้า</h4>
        </div>
        <div class="card-body">
            <form action="Manager_Exam_Import_Word_Sql.php" method="POST">
                <input type="hidden" name="id_chapter" value="<?php echo $id_chapter; ?>">
                <input type="hidden" name="import_type" value="<?php echo $import_type; ?>">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="10%">ข้อที่</th>
                                <th width="40%">โจทย์คำถาม</th>
                                <th width="35%">ตัวเลือก & เฉลย</th>
                                <th width="15%">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($questions as $index => $q) { ?>
                                <tr>
                                    <td><?php echo ($index + 1); ?></td>
                                    <td><textarea name="questions[<?php echo $index; ?>][proposition]" class="form-control" rows="3"><?php echo htmlspecialchars($q['proposition']); ?></textarea></td>
                                    <td>
                                        <?php if ($import_type !== 'annotated') { ?>
                                            <?php for ($c = 1; $c <= 5; $c++) { ?>
                                                <input type="text" name="questions[<?php echo $index; ?>][answer<?php echo $c; ?>]" class="form-control form-control-sm mb-1" value="<?php echo htmlspecialchars(isset($q['answer'.$c])?$q['answer'.$c]:''); ?>">
                                            <?php } ?>
                                            <select name="questions[<?php echo $index; ?>][result]" class="form-control form-control-sm mt-1">
                                                <?php for ($r = 1; $r <= 5; $r++) { ?>
                                                    <option value="<?php echo $r; ?>" <?php if ($q['result'] == $r) echo 'selected'; ?>>เฉลยตัวเลือกที่ <?php echo $r; ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php } else { ?>
                                            <textarea name="questions[<?php echo $index; ?>][ans]" class="form-control" rows="3"><?php echo htmlspecialchars($q['ans']); ?></textarea>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $q['is_valid'] ? '<span class="badge badge-success">พร้อมนำเข้า</span>' : '<span class="badge badge-danger">ข้อมูลไม่ครบ</span>'; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-between">
                    <a href="<?php echo $backPage; ?>" class="btn btn-secondary">ยกเลิก</a>
                    <button type="submit" name="confirm_import_word" class="btn btn-success">ยืนยันนำเข้าข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<?php
}
?>
