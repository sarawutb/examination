<?php
include("connect.php");

$branch_raw = isset($_REQUEST["branch"]) ? $_REQUEST["branch"] : '0';
if (is_array($branch_raw)) {
	$branch_ids = array_map('intval', $branch_raw);
} else {
	$branch_ids = array_map('intval', explode(',', (string)$branch_raw));
}
$branch_ids = array_filter($branch_ids);
$branch_ids_str = !empty($branch_ids) ? implode(',', $branch_ids) : '0';

$degree = isset($_REQUEST["degree"]) ? $_REQUEST["degree"] : '';
$branch_id = isset($_REQUEST["branch_id"]) ? $_REQUEST["branch_id"] : '';

$sql2 = "SELECT DISTINCT 
			b.branch_id,
			b.branch_name,
			s.degree_std,
			s.section_std 
		 FROM `manager_std` s
		 INNER JOIN `manager_branch` b ON s.branch_id_std = b.branch_id
		 WHERE s.branch_id_std IN ($branch_ids_str) AND s.IsUse = 1 
		 ORDER BY b.branch_name ASC, s.degree_std ASC, s.section_std + 0 ASC";

$grouped = array();
$result2 = mysqli_query($conn, $sql2);
if ($result2) {
	while ($row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
		$b_name = $row2['branch_name'];
		if (!isset($grouped[$b_name])) {
			$grouped[$b_name] = array();
		}
		$grouped[$b_name][] = $row2;
	}
}

if (empty($grouped)) {
	echo '<div class="alert alert-warning py-2 mb-0" style="font-size: 0.9rem;">
			<i class="fas fa-exclamation-triangle"></i> ไม่พบห้องเรียนในสาขาที่เลือก (กรุณาเลือกสาขาวิชาด้านบน)
		  </div>';
} else {
	$id_num = 1;
	$year_count = explode(',', $degree);

	foreach ($grouped as $branch_name => $items) {
		echo '<div class="branch-group mb-2 p-2" style="background-color: #ffffff; border: 1px solid #cbd5e1; border-radius: 6px;">';
		echo '<div class="font-weight-bold text-primary mb-2" style="font-size: 0.95rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px;">';
		echo '<i class="fas fa-graduation-cap"></i> สาขา: ' . htmlspecialchars($branch_name);
		echo '</div>';
		echo '<div class="row px-3">';

		foreach ($items as $item) {
			$level = $item['degree_std'];
			$room = $item['section_std'];
			$degree_std = $level . "/" . $room;
			$inlineCheckbox = "inlineCheckbox" . $id_num;

			$checked = '';
			for ($i_arr = 0; $i_arr < count($year_count); $i_arr++) {
				if ($degree_std === $year_count[$i_arr]) {
					$checked = ' checked ';
					break;
				}
			}

			echo '<div class="form-check col-sm-6 mb-1">';
			echo '<input ' . $checked . ' class="form-check-input" name="year_std_series_exam[]" type="checkbox" id="' . $inlineCheckbox . '" value="' . $degree_std . '">';
			echo '<label class="form-check-label" for="' . $inlineCheckbox . '">ชั้นปีที่ ' . $level . ' ห้อง ' . $room . ' (' . $degree_std . ')</label>';
			echo '</div>';

			$id_num++;
		}

		echo '</div>';
		echo '</div>';
	}
}
?>
