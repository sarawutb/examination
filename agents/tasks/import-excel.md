# แผนการพัฒนาฟีเจอร์นำเข้าข้อสอบด้วยไฟล์ Excel (Excel Exam Import Specification & Task Plan)

เอกสารนี้ระบุการวิเคราะห์ ออกแบบ และสรุปการดำเนินงานสำหรับการเพิ่มฟีเจอร์นำเข้าข้อสอบ (ทั้งแบบปรนัยและอัตนัย) ผ่านไฟล์ Excel (.xlsx / .csv) เข้าสู่ระบบสอบเดิม โดยรองรับสภาพแวดล้อม PHP 5.6 100%

---

## 1. ข้อจำกัดและข้อกำหนดด้านเทคนิค (Technical Constraints)

1. **PHP Version Compatibility (PHP 5.6 Only)**:
   * **ห้ามใช้ Syntax ของ PHP 7.0+ / PHP 8.0+** เด็ดขาด:
     * ❌ Null Coalescing Operator (`??`) -> ให้ใช้ `isset($var) ? $var : $default`
     * ❌ Scalar Type Hinting (`function test(string $a, int $b)`) -> ให้ถอด Type Hint ออก
     * ❌ Return Type Declarations (`function test(): array`) -> ให้ถอด Return Type ออก
     * ❌ Arrow Functions (`fn($x) => $x * 2`) -> ให้ใช้ Anonymous function แบบเดิม `function($x) { return ...; }`
2. **Excel Library**:
   * ใช้งานไลบรารี **SimpleXLSX** และ **ExcelReaderHelper** (รองรับ PHP 5.6 เบา และรวดเร็ว)
3. **Database Connection & Access Style**:
   * ใช้งาน `$conn` จาก `connect.php` (MySQLi Procedural)
   * ใช้ Prepared Statements (`mysqli_prepare` / `mysqli_stmt_bind_param`) เพื่อความปลอดภัยสูงสุด

---

## 2. โครงสร้าง Excel Template (Excel Template Specification)

### ก) ข้อสอบปรนัย (Multiple Choice Sheet: `templates/exam_import_template_mc.xlsx`)

| คอลัมน์ (Column) | ชื่อหัวข้อ (Header Text) | ความจำเป็น (Required) | ตัวอย่างข้อมูล               | คำอธิบาย / Rule                                                    |
| :---------------------- | :--------------------------------- | :------------------------------ | :----------------------------------------- | :------------------------------------------------------------------------- |
| **A**             | `ข้อที่`                   | Optional                        | 1                                          | ลำดับข้อสอบเพื่อการอ้างอิง                       |
| **B**             | `โจทย์คำถาม`           | **Mandatory**             | คอมพิวเตอร์คืออะไร?      | ข้อความโจทย์ข้อสอบ (ห้ามว่าง)                    |
| **C**             | `ตัวเลือกที่ 1`       | **Mandatory**             | อุปกรณ์อิเล็กทรอนิกส์ | ข้อความตัวเลือก 1 (ห้ามว่าง)                        |
| **D**             | `ตัวเลือกที่ 2`       | **Mandatory**             | เครื่องคิดเลข                 | ข้อความตัวเลือก 2 (ห้ามว่าง)                        |
| **E**             | `ตัวเลือกที่ 3`       | **Mandatory**             | เครื่องใช้ไฟฟ้า             | ข้อความตัวเลือก 3 (ห้ามว่าง)                        |
| **F**             | `ตัวเลือกที่ 4`       | **Mandatory**             | ยานพาหนะ                           | ข้อความตัวเลือก 4 (ห้ามว่าง)                        |
| **G**             | `ตัวเลือกที่ 5`       | Optional                        | ถูกทุกข้อ                         | ข้อความตัวเลือก 5 (ปล่อยว่างได้)                |
| **H**             | `เฉลยคำตอบ`             | **Mandatory**             | 1                                          | ระบุเป็นตัวเลข`1-5` หรืออักษร `ก-จ` / `a-e` |

---

### ข) ข้อสอบอัตนัย (Subjective / Essay Sheet: `templates/exam_import_template_annotated.xlsx`)

| คอลัมน์ (Column) | ชื่อหัวข้อ (Header Text)  | ความจำเป็น (Required) | ตัวอย่างข้อมูล                       | คำอธิบาย / Rule                                 |
| :---------------------- | :---------------------------------- | :------------------------------ | :------------------------------------------------- | :------------------------------------------------------ |
| **A**             | `ข้อที่`                    | Optional                        | 1                                                  | ลำดับข้อสอบเพื่อการอ้างอิง    |
| **B**             | `โจทย์คำถาม`            | **Mandatory**             | จงอธิบายหลักการทำงานของ CPU | ข้อความโจทย์ข้อสอบ (ห้ามว่าง) |
| **C**             | `แนวทางเฉลย/คำตอบ` | Optional                        | CPU ทำงานโดยดึงคำสั่ง (Fetch)...  | แนวทางการให้คะแนน/เฉลย             |

---

## 3. ฟีเจอร์ที่ได้รับการพัฒนาแล้ว (Completed Features)

* [x] **Excel Parser Helper (`vendor/excel_parser/ExcelReaderHelper.php`)**: อ่านไฟล์ `.xlsx` และ `.csv` อย่างรวดเร็วใน PHP 5.6
* [x] **Single-Modal Step Architecture (`#importExcelModal`)**:
  * Step 1: อัปโหลดไฟล์เลือกสแกน
  * Step 2: แสดงตาราง Preview ตรวจสอบความถูกต้อง พร้อมแก้ไขโจทย์/ตัวเลือก/เฉลยก่อนยืนยันบันทึก
* [x] **Dynamic Highlight Selection**: สลับแถบสีเขียวไฮไลท์ตัวเลือกเฉลยอัตนัย/ปรนัยทันทีที่เปลี่ยนค่าใน Select Dropdown (`.excel-result-select`)
* [x] **แยกไฟล์ Template Excel 2 ประเภท**:
  * ปรนัย: `templates/exam_import_template_mc.xlsx`
  * อัตนัย: `templates/exam_import_template_annotated.xlsx`

---

## 4. สรุปสถานะการพัฒนา (Implementation Status)

- [x] **Phase 1: ติดตั้ง SimpleXLSX และพัฒนา `ExcelReaderHelper.php`**
- [x] **Phase 2: สร้างไฟล์ตัวอย่าง Excel Template แยก 2 ประเภท (`templates/exam_import_template_mc.xlsx` และ `templates/exam_import_template_annotated.xlsx`)**
- [x] **Phase 3: พัฒนาสคริปต์ Backend ประมวลผลและ Preview ผ่าน AJAX (`Manager_Exam_Import_Sql.php`)**
- [x] **Phase 4: เพิ่ม UI ปุ่ม "นำเข้าด้วย Excel" และ Single-Modal Step ในหน้า `Manager_Exam_Add.php` และ `Manager_Exam_Add_Annotated.php`**
- [x] **Phase 5: ทดสอบการอ่านไฟล์ พรีวิวแก้ไข และบันทึกลง Database (PASS 100%)**
