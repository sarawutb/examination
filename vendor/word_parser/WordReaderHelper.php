<?php
/**
 * WordReaderHelper.php
 * PHP 5.6 Compatible Docx Exam Reader Engine
 * Parses Microsoft Word (.docx) XML documents for Multiple Choice and Subjective Exams.
 */

class WordReaderHelper
{
    /**
     * Read and parse a .docx file for questions
     * 
     * @param string $filepath Path to .docx file
     * @param string $type 'mc' for multiple choice, 'annotated' for subjective
     * @return array Result containing 'status' (bool), 'data' (array), 'error' (string)
     */
    public static function parseDocx($filepath, $type)
    {
        if (!file_exists($filepath)) {
            return array('status' => false, 'error' => 'ไม่พบไฟล์ข้อสอบที่อัปโหลด');
        }

        if (!class_exists('ZipArchive')) {
            return array('status' => false, 'error' => 'เซิร์ฟเวอร์ไม่รองรับ ZipArchive ในการอ่านไฟล์ Word');
        }

        $zip = new ZipArchive();
        if ($zip->open($filepath) !== true) {
            return array('status' => false, 'error' => 'ไม่สามารถเปิดไฟล์ .docx ได้ กรุณาตรวจสอบว่าเป็นไฟล์ Word ที่ถูกต้อง');
        }

        $xmlContent = $zip->getFromName('word/document.xml');
        $zip->close();

        if (!$xmlContent) {
            return array('status' => false, 'error' => 'ไม่พบโครงสร้างข้อความในไฟล์ Word (word/document.xml)');
        }

        // Clean XML namespaces for easier DOM processing
        $dom = new DOMDocument();
        // Disable entity loader for security
        if (function_exists('libxml_disable_entity_loader')) {
            @libxml_disable_entity_loader(true);
        }
        @$dom->loadXML($xmlContent);

        if (!$dom) {
            return array('status' => false, 'error' => 'ไม่สามารถอ่านโครงสร้าง XML ของไฟล์ Word ได้');
        }

        $body = $dom->getElementsByTagName('body')->item(0);
        if (!$body) {
            return array('status' => false, 'error' => 'โครงสร้างไฟล์ Word ไม่ถูกต้อง (ไม่พบ body)');
        }

        $paragraphs = array();
        $tablesData = array();

        // Extract paragraphs and tables in order
        foreach ($body->childNodes as $node) {
            if ($node->nodeName === 'w:p') {
                $text = trim(self::getNodeText($node));
                if ($text !== '') {
                    $paragraphs[] = $text;
                }
            } else if ($node->nodeName === 'w:tbl') {
                $table = self::parseTableNode($node);
                if (!empty($table)) {
                    $tablesData[] = $table;
                }
            }
        }

        // Determine parsing mode based on content
        if ($type === 'annotated') {
            if (!empty($tablesData)) {
                $questions = self::parseSubjectiveTables($tablesData);
                if (!empty($questions)) {
                    return array('status' => true, 'data' => $questions, 'mode' => 'table');
                }
            }
            $questions = self::parseSubjectiveParagraphs($paragraphs);
            return array('status' => true, 'data' => $questions, 'mode' => 'paragraph');
        } else { // Multiple choice ('mc')
            if (!empty($tablesData)) {
                $questions = self::parseMCTables($tablesData);
                if (!empty($questions)) {
                    return array('status' => true, 'data' => $questions, 'mode' => 'table');
                }
            }
            $questions = self::parseMCParagraphs($paragraphs);
            return array('status' => true, 'data' => $questions, 'mode' => 'paragraph');
        }
    }

    /**
     * Get concatenated text from a DOM node
     */
    private static function getNodeText($node)
    {
        $text = '';
        if ($node->hasChildNodes()) {
            foreach ($node->childNodes as $child) {
                if ($child->nodeName === 'w:t') {
                    $text .= $child->nodeValue;
                } else if ($child->hasChildNodes()) {
                    $text .= self::getNodeText($child);
                }
            }
        }
        return $text;
    }

    /**
     * Parse a w:tbl node into 2D array
     */
    private static function parseTableNode($tblNode)
    {
        $rows = array();
        foreach ($tblNode->childNodes as $tr) {
            if ($tr->nodeName === 'w:tr') {
                $row = array();
                foreach ($tr->childNodes as $tc) {
                    if ($tc->nodeName === 'w:tc') {
                        $cellText = trim(self::getNodeText($tc));
                        $row[] = $cellText;
                    }
                }
                if (!empty($row)) {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    /**
     * Parse Multiple Choice Paragraphs
     */
    private static function parseMCParagraphs($paragraphs)
    {
        $questions = array();
        $currentQuestion = null;

        $q_pattern   = '/^(?:ข้อ\s*)?(\d+)[\.\)]\s*(.+)/u';
        // Match choices starting with letters (ก., ก), a., a)) or numbers with parenthesis (1), 1), (1))
        $c_pattern   = '/^(?:[\(\[]?([ก-จa-eA-E])[\.\)\]]|([1-5])[\)]|\(([1-5])\))\s*(.+)/u';
        $ans_pattern = '/^(?:เฉลย|เฉลยคำตอบ|ตอบ)\s*[:\s=]\s*(.+)/u';

        foreach ($paragraphs as $line) {
            $line = trim($line);
            if ($line === '') continue;

            // 1. Check Answer pattern
            if ($currentQuestion !== null && preg_match($ans_pattern, $line, $matches)) {
                $rawAns = trim($matches[1]);
                $currentQuestion['result_raw'] = $rawAns;
                $currentQuestion['result'] = self::normalizeAnswer($rawAns);
                continue;
            }

            // 2. Check Choice pattern
            if ($currentQuestion !== null && preg_match($c_pattern, $line, $matches)) {
                $rawKey = !empty($matches[1]) ? $matches[1] : (!empty($matches[2]) ? $matches[2] : $matches[3]);
                $choiceKey = self::normalizeChoiceKey($rawKey);
                $choiceText = trim($matches[4]);
                if ($choiceKey >= 1 && $choiceKey <= 5) {
                    $currentQuestion['answer' . $choiceKey] = $choiceText;
                    $currentQuestion['choices_count']++;
                    continue;
                }
            }

            // 3. Check Question Header pattern
            if (preg_match($q_pattern, $line, $matches)) {
                if ($currentQuestion !== null && !empty($currentQuestion['proposition'])) {
                    $questions[] = self::validateMCQuestion($currentQuestion);
                }
                $currentQuestion = array(
                    'num' => $matches[1],
                    'proposition' => trim($matches[2]),
                    'answer1' => '',
                    'answer2' => '',
                    'answer3' => '',
                    'answer4' => '',
                    'answer5' => '',
                    'result'  => 0,
                    'result_raw' => '',
                    'choices_count' => 0
                );
                continue;
            }

            if ($currentQuestion === null) {
                $currentQuestion = array(
                    'num' => count($questions) + 1,
                    'proposition' => $line,
                    'answer1' => '',
                    'answer2' => '',
                    'answer3' => '',
                    'answer4' => '',
                    'answer5' => '',
                    'result'  => 0,
                    'result_raw' => '',
                    'choices_count' => 0
                );
                continue;
            }

            // Fallback: append line to proposition if choices haven't started
            if ($currentQuestion['choices_count'] == 0 && empty($currentQuestion['result_raw'])) {
                $currentQuestion['proposition'] .= "\n" . $line;
            }
        }

        if ($currentQuestion !== null && !empty($currentQuestion['proposition'])) {
            $questions[] = self::validateMCQuestion($currentQuestion);
        }

        return $questions;
    }

    /**
     * Parse Subjective Paragraphs
     */
    private static function parseSubjectiveParagraphs($paragraphs)
    {
        $questions = array();
        $currentQuestion = null;

        $q_pattern   = '/^(?:ข้อ\s*)?(\d+)[\.\)]\s*(.+)/u';
        $ans_pattern = '/^(?:เฉลย|แนวตอบ|ตอบ)\s*[:\s=]\s*(.+)/u';

        foreach ($paragraphs as $line) {
            $line = trim($line);
            if ($line === '') continue;

            if ($currentQuestion !== null && preg_match($ans_pattern, $line, $matches)) {
                $currentQuestion['ans'] = trim($matches[1]);
                continue;
            }

            if (preg_match($q_pattern, $line, $matches)) {
                if ($currentQuestion !== null && !empty($currentQuestion['proposition'])) {
                    $questions[] = self::validateSubjectiveQuestion($currentQuestion);
                }
                $currentQuestion = array(
                    'num' => $matches[1],
                    'proposition' => trim($matches[2]),
                    'ans' => ''
                );
                continue;
            }

            if ($currentQuestion !== null) {
                if (empty($currentQuestion['ans'])) {
                    $currentQuestion['proposition'] .= "\n" . $line;
                } else {
                    $currentQuestion['ans'] .= "\n" . $line;
                }
            }
        }

        if ($currentQuestion !== null && !empty($currentQuestion['proposition'])) {
            $questions[] = self::validateSubjectiveQuestion($currentQuestion);
        }

        return $questions;
    }

    /**
     * Parse Multiple Choice Tables
     */
    private static function parseMCTables($tablesData)
    {
        $questions = array();
        foreach ($tablesData as $rows) {
            $startIdx = 0;
            if (count($rows) > 0 && (strpos($rows[0][0], 'ข้อ') !== false || strpos($rows[0][1], 'โจทย์') !== false)) {
                $startIdx = 1;
            }

            for ($i = $startIdx; $i < count($rows); $i++) {
                $row = $rows[$i];
                if (count($row) < 3) continue;

                $q = array(
                    'num' => isset($row[0]) ? $row[0] : ($i + 1),
                    'proposition' => isset($row[1]) ? $row[1] : '',
                    'answer1' => isset($row[2]) ? $row[2] : '',
                    'answer2' => isset($row[3]) ? $row[3] : '',
                    'answer3' => isset($row[4]) ? $row[4] : '',
                    'answer4' => isset($row[5]) ? $row[5] : '',
                    'answer5' => isset($row[6]) ? $row[6] : '',
                    'result_raw' => isset($row[7]) ? $row[7] : (isset($row[6]) && count($row) == 7 ? $row[6] : ''),
                    'result' => 0,
                    'choices_count' => 0
                );

                $q['result'] = self::normalizeAnswer($q['result_raw']);
                for ($c = 1; $c <= 5; $c++) {
                    if (!empty($q['answer' . $c])) {
                        $q['choices_count']++;
                    }
                }

                if (!empty($q['proposition'])) {
                    $questions[] = self::validateMCQuestion($q);
                }
            }
        }
        return $questions;
    }

    /**
     * Parse Subjective Tables
     */
    private static function parseSubjectiveTables($tablesData)
    {
        $questions = array();
        foreach ($tablesData as $rows) {
            $startIdx = 0;
            if (count($rows) > 0 && (strpos($rows[0][0], 'ข้อ') !== false || strpos($rows[0][1], 'โจทย์') !== false)) {
                $startIdx = 1;
            }

            for ($i = $startIdx; $i < count($rows); $i++) {
                $row = $rows[$i];
                if (count($row) < 2) continue;

                $q = array(
                    'num' => isset($row[0]) ? $row[0] : ($i + 1),
                    'proposition' => isset($row[1]) ? $row[1] : '',
                    'ans' => isset($row[2]) ? $row[2] : ''
                );

                if (!empty($q['proposition'])) {
                    $questions[] = self::validateSubjectiveQuestion($q);
                }
            }
        }
        return $questions;
    }

    /**
     * Normalize Choice Key (ก-จ, 1-5, a-e -> 1-5)
     */
    private static function normalizeChoiceKey($keyStr)
    {
        $keyStr = mb_strtolower(trim($keyStr), 'UTF-8');
        $map = array(
            'ก' => 1, 'ข' => 2, 'ค' => 3, 'ง' => 4, 'จ' => 5,
            'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5,
            '1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5
        );
        return isset($map[$keyStr]) ? $map[$keyStr] : 0;
    }

    /**
     * Normalize Answer Key (ก-จ, 1-5, a-e -> 1-5)
     */
    public static function normalizeAnswer($ansStr)
    {
        $ansStr = mb_strtolower(trim($ansStr), 'UTF-8');
        if (preg_match('/[ก-จ1-5a-e]/u', $ansStr, $m)) {
            return self::normalizeChoiceKey($m[0]);
        }
        return 0;
    }

    /**
     * Validate MC Question object
     */
    private static function validateMCQuestion($q)
    {
        $errors = array();
        if (empty($q['proposition'])) {
            $errors[] = 'ไม่มีโจทย์คำถาม';
        }
        if (empty($q['answer1']) || empty($q['answer2']) || empty($q['answer3']) || empty($q['answer4'])) {
            $errors[] = 'ตัวเลือก 1-4 ไม่ครบถ้วน';
        }
        if ($q['result'] < 1 || $q['result'] > 5) {
            $errors[] = 'เฉลยคำตอบไม่ถูกต้อง';
        }

        $q['is_valid'] = empty($errors);
        $q['errors'] = $errors;
        return $q;
    }

    /**
     * Validate Subjective Question object
     */
    private static function validateSubjectiveQuestion($q)
    {
        $errors = array();
        if (empty($q['proposition'])) {
            $errors[] = 'ไม่มีโจทย์คำถาม';
        }

        $q['is_valid'] = empty($errors);
        $q['errors'] = $errors;
        return $q;
    }
}
