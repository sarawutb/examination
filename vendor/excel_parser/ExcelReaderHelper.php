<?php
/**
 * Helper class for parsing exam Excel / CSV files in PHP 5.6
 */
require_once dirname(__FILE__) . '/SimpleXLSX.php';

class ExcelReaderHelper {

	/**
	 * Parse uploaded file (.xlsx or .csv)
	 * @param string $filepath
	 * @param string $originalFilename
	 * @return array (success, sheets, sheetNames, error)
	 */
	public static function parseFile($filepath, $originalFilename = '') {
		$filenameToTest = !empty($originalFilename) ? $originalFilename : $filepath;
		$ext = strtolower(pathinfo($filenameToTest, PATHINFO_EXTENSION));

		if ($ext === 'xlsx') {
			$xlsx = SimpleXLSX::parse($filepath);
			if ($xlsx) {
				return array(
					'success' => true,
					'sheets' => $xlsx->sheets(),
					'sheetNames' => $xlsx->sheetNames(),
					'error' => null
				);
			} else {
				return array(
					'success' => false,
					'sheets' => array(),
					'sheetNames' => array(),
					'error' => 'ไม่สามารถอ่านไฟล์ XLSX ได้: ' . SimpleXLSX::parseError()
				);
			}
		} else if ($ext === 'csv') {
			$rows = array();
			if (($handle = fopen($filepath, "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 2000, ",")) !== FALSE) {
					// Handle UTF-8 BOM if present
					if (!empty($data[0])) {
						$data[0] = preg_replace('/[\x00-\x1F\x7F\xEF\xBB\xBF]/', '', $data[0]);
					}
					$rows[] = $data;
				}
				fclose($handle);
			}
			return array(
				'success' => true,
				'sheets' => array($rows),
				'sheetNames' => array('Sheet1'),
				'error' => null
			);
		} else {
			return array(
				'success' => false,
				'sheets' => array(),
				'sheetNames' => array(),
				'error' => 'รองรับเฉพาะไฟล์ประเภท .xlsx หรือ .csv เท่านั้น'
			);
		}
	}

	/**
	 * Map Thai / English answer characters (ก-จ, a-e, 1-5) to numeric 1-5
	 * @param string $val
	 * @return int (1-5, or 0 if invalid)
	 */
	public static function normalizeAnswerKey($val) {
		$val = trim((string)$val);
		if (empty($val)) {
			return 0;
		}

		// Thai characters
		$map_th = array('ก' => 1, 'ข' => 2, 'ค' => 3, 'ง' => 4, 'จ' => 5);
		if (isset($map_th[$val])) {
			return $map_th[$val];
		}

		// English characters
		$val_upper = strtoupper($val);
		$map_en = array('A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5);
		if (isset($map_en[$val_upper])) {
			return $map_en[$val_upper];
		}

		// Numbers 1-5
		$num = (int)$val;
		if ($num >= 1 && $num <= 5) {
			return $num;
		}

		return 0;
	}
}
