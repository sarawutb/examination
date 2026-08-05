<?php
/**
 * SimpleXLSX parse XLSX files (PHP 5.3+)
 * Author: Sergey Shuchkin <sergey.shuchkin@gmail.com>
 * License: MIT
 */

class SimpleXLSX {

	// Elements
	const SCHEMA_REL_CELLS = 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet';
	const SCHEMA_REL_SHARED_STRINGS = 'http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings';

	private $sheets = array();
	private $sheetNames = array();
	private $sharedstrings = array();
	private $error = false;
	private $package = array(
		'filename' => '',
		'mtime' => 0,
		'size' => 0,
		'comment' => '',
		'entries' => array()
	);

	public function __construct( $filename = null, $is_data = false ) {
		if ( $filename ) {
			$this->parse( $filename, $is_data );
		}
	}

	private static $lastError = '';

	public static function parse( $filename, $is_data = false ) {
		$xlsx = new self();
		if ( $xlsx->_parse( $filename, $is_data ) ) {
			return $xlsx;
		}
		self::$lastError = $xlsx->error();
		return false;
	}

	public static function parseError() {
		return self::$lastError;
	}

	public function error( $set = null ) {
		if ( $set !== null ) {
			$this->error = $set;
			self::$lastError = $set;
		}
		return $this->error;
	}

	public function sheets() {
		return $this->sheets;
	}

	public function sheetNames() {
		return $this->sheetNames;
	}

	public function sheetName( $sheet_id ) {
		if ( isset( $this->sheetNames[ $sheet_id ] ) ) {
			return $this->sheetNames[ $sheet_id ];
		}
		return false;
	}

	public function rows( $sheet_id = 0 ) {
		if ( isset( $this->sheets[ $sheet_id ] ) ) {
			return $this->sheets[ $sheet_id ];
		}
		return array();
	}

	private function _parse( $filename, $is_data = false ) {
		$this->error = false;

		if ( $is_data ) {
			$zip = $this->_unzipData( $filename );
		} else {
			if ( ! file_exists( $filename ) || ! is_readable( $filename ) ) {
				$this->error( 'File not found or not readable: ' . $filename );
				return false;
			}
			$zip = $this->_unzip( $filename );
		}

		if ( ! $zip ) {
			return false;
		}

		// Read workbook relationships & sheet names
		$workbook_xml = $this->_getEntryData( 'xl/workbook.xml' );
		if ( ! $workbook_xml ) {
			$this->error( 'Invalid XLSX format: xl/workbook.xml missing' );
			return false;
		}

		$xml = simplexml_load_string( $workbook_xml );
		if ( ! $xml ) {
			$this->error( 'Invalid XML in xl/workbook.xml' );
			return false;
		}

		if ( isset( $xml->sheets->sheet ) ) {
			$i = 0;
			foreach ( $xml->sheets->sheet as $sheet ) {
				$attributes = $sheet->attributes();
				$name = (string) $attributes['name'];
				$this->sheetNames[ $i ] = $name;
				$i++;
			}
		}

		// Read shared strings
		$shared_strings_xml = $this->_getEntryData( 'xl/sharedStrings.xml' );
		if ( $shared_strings_xml ) {
			$xml_ss = simplexml_load_string( $shared_strings_xml );
			if ( $xml_ss && isset( $xml_ss->si ) ) {
				foreach ( $xml_ss->si as $val ) {
					$str = '';
					if ( isset( $val->t ) ) {
						$str = (string) $val->t;
					} else if ( isset( $val->r ) ) {
						foreach ( $val->r as $r ) {
							if ( isset( $r->t ) ) {
								$str .= (string) $r->t;
							}
						}
					}
					$this->sharedstrings[] = $str;
				}
			}
		}

		// Read sheets
		$sheet_index = 1;
		while ( $sheet_xml = $this->_getEntryData( 'xl/worksheets/sheet' . $sheet_index . '.xml' ) ) {
			$rows = array();
			$xml_sheet = simplexml_load_string( $sheet_xml );
			if ( $xml_sheet && isset( $xml_sheet->sheetData->row ) ) {
				foreach ( $xml_sheet->sheetData->row as $row ) {
					$row_data = array();
					$cur_col = 0;
					if ( isset( $row->c ) ) {
						foreach ( $row->c as $c ) {
							$r = (string) $c['r']; // e.g. "A1", "B1"
							$t = (string) $c['t']; // e.g. "s", "inlineStr", "n"
							$v = '';

							if ( isset( $c->v ) ) {
								$v = (string) $c->v;
							} else if ( isset( $c->is->t ) ) {
								$v = (string) $c->is->t;
							}

							// Convert column letter to 0-based index
							$col_letter = preg_replace( '/[0-9]/', '', $r );
							$col_idx = $this->_columnIndex( $col_letter );

							// Fill empty columns before this cell
							while ( $cur_col < $col_idx ) {
								$row_data[ $cur_col ] = '';
								$cur_col++;
							}

							// Decode shared string
							if ( $t === 's' ) {
								$v_idx = (int) $v;
								$v = isset( $this->sharedstrings[ $v_idx ] ) ? $this->sharedstrings[ $v_idx ] : '';
							}

							$row_data[ $cur_col ] = $v;
							$cur_col++;
						}
					}
					$rows[] = $row_data;
				}
			}
			$this->sheets[] = $rows;
			$sheet_index++;
		}

		return true;
	}

	private function _columnIndex( $cell_string ) {
		$cell_string = strtoupper( $cell_string );
		$length = strlen( $cell_string );
		$index = 0;
		for ( $i = 0; $i < $length; $i++ ) {
			$index = $index * 26 + ( ord( $cell_string[ $i ] ) - 64 );
		}
		return $index - 1;
	}

	private function _unzip( $filename ) {
		if ( ! class_exists( 'ZipArchive' ) ) {
			$this->error( 'ZipArchive PHP extension is required' );
			return false;
		}

		$zip = new ZipArchive();
		$res = $zip->open( $filename );
		if ( $res !== true ) {
			$this->error( 'Failed to open ZIP archive: ' . $filename );
			return false;
		}

		for ( $i = 0; $i < $zip->numFiles; $i++ ) {
			$stat = $zip->statIndex( $i );
			$this->package['entries'][ $stat['name'] ] = $zip->getFromIndex( $i );
		}

		$zip->close();
		return true;
	}

	private function _unzipData( $data ) {
		$temp_file = tempnam( sys_get_temp_dir(), 'xlsx_' );
		file_put_contents( $temp_file, $data );
		$res = $this->_unzip( $temp_file );
		@unlink( $temp_file );
		return $res;
	}

	private function _getEntryData( $name ) {
		if ( isset( $this->package['entries'][ $name ] ) ) {
			return $this->package['entries'][ $name ];
		}
		return false;
	}
}
