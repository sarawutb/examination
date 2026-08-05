# แผนการพัฒนาฟีเจอร์นำเข้าข้อสอบด้วยไฟล์ Excel (Excel Exam Import Specification & Task Plan)

เอกสารนี้ระบุการวิเคราะห์ ออกแบบ และแผนการดำเนินงานสำหรับการเพิ่มฟีเจอร์นำเข้าข้อสอบ (ทั้งแบบปรนัยและอัตนัย) ผ่านไฟล์ Excel (.xls / .xlsx) เข้าสู่ระบบสอบเดิม โดยคำนึงถึงข้อจำกัดด้านเทคนิคของระบบเดิมอย่างเคร่งครัด

---

## 1. ข้อจำกัดและข้อกำหนดด้านเทคนิค (Technical Constraints)

1. **PHP Version Compatibility (PHP 5.6 Only)**:
   * **ห้ามใช้ Syntax ของ PHP 7.0+ / PHP 8.0+** เด็ดขาด ได้แก่:
     * ❌ Null Coalescing Operator (`??`) -> ให้ใช้ `isset($var) ? $var : $default`
     * ❌ Scalar Type Hinting (`function test(string $a, int $b)`) -> ให้ถอด Type Hint ออก
     * ❌ Return Type Declarations (`function test(): array`) -> ให้ถอด Return Type ออก
     * ❌ Arrow Functions (`fn($x) => $x * 2`) -> ให้ใช้ Anonymous function แบบเดิม `function($x) { return ...; }`
     * ❌ Attributes / Annotations (`#[Attribute]`)
2. **Excel Library**:
   * ใช้งานไลบรารี **PHPExcel 1.8.x** (รองรับ PHP 5.6 และไฟล์ `.xls` / `.xlsx`) หรืออ่านด้วย `SimpleXLSX` (กรณี XLSX)
   * ห้ามใช้ `PhpSpreadsheet` เนื่องจากต้องการ PHP 7.3+
3. **Database Connection & Access Style**:
   * ใช้งาน `$conn` จาก `connect.php` (MySQLi Procedural)
   * ใช้ Prepared Statements (`mysqli_prepare` / `bind_param`) หรือ `mysqli_real_escape_string()` เพื่อความปลอดภัยสูงสุด

---

## 2. ผลการวิเคราะห์ Flow การทำงานเดิม (Existing Flow Analysis)

1. **ข้อสอบปรนัย (Multiple Choice)**:
   * **ตารางปลายทาง**: `manager_exam`
   * **ฟิลด์สำคัญ**:
     * `id`: Auto Increment (PRIMARY KEY)
     * `proposition_exam`: ข้อความโจทย์
     * `answer1_exam` ถึง `answer5_exam`: ข้อความตัวเลือกที่ 1-5
     * `result_exam`: เฉลยตัวเลือกที่ถูกต้อง (`1`, `2`, `3`, `4`, หรือ `5`)
     * `chapter_id_exam`: ไอดีบทเรียน (`id_chapter` จากตาราง `manager_chapter`)
2. **ข้อสอบอัตนัย (Subjective / Essay)**:
   * **ตารางปลายทาง**: `manager_exam_annotated`
   * **ฟิลด์สำคัญ**:
     * `id`: Auto Increment (PRIMARY KEY)
     * `proposition_exam`: ข้อความโจทย์
     * `ans_exam`: แนวทางการตอบ/เฉลยคำตอบ
     * `chapter_id_exam`: ไอดีบทเรียน (`id_chapter`)

---

## 3. โครงสร้าง Excel Template (Excel Template Specification)

กำหนดให้ Excel Template มี **2 Sheets** เพื่อรองรับการนำเข้าทั้ง 2 ประเภทในไฟล์เดียว หรือแยกไฟล์ตามแผ่นงาน:

### Sheet 1: `ข้อสอบปรนัย` (Multiple Choice Sheet)

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

*การ Mapping ค่าเฉลยใน Column H*:

* `1`, `ก`, `a`, `A` $\rightarrow$ บันทึกเป็น `1`
* `2`, `ข`, `b`, `B` $\rightarrow$ บันทึกเป็น `2`
* `3`, `ค`, `c`, `C` $\rightarrow$ บันทึกเป็น `3`
* `4`, `ง`, `d`, `D` $\rightarrow$ บันทึกเป็น `4`
* `5`, `จ`, `e`, `E` $\rightarrow$ บันทึกเป็น `5`

---

### Sheet 2: `ข้อสอบอัตนัย` (Subjective / Essay Sheet)

| คอลัมน์ (Column) | ชื่อหัวข้อ (Header Text)  | ความจำเป็น (Required) | ตัวอย่างข้อมูล                       | คำอธิบาย / Rule                                 |
| :---------------------- | :---------------------------------- | :------------------------------ | :------------------------------------------------- | :------------------------------------------------------ |
| **A**             | `ข้อที่`                    | Optional                        | 1                                                  | ลำดับข้อสอบเพื่อการอ้างอิง    |
| **B**             | `โจทย์คำถาม`            | **Mandatory**             | จงอธิบายหลักการทำงานของ CPU | ข้อความโจทย์ข้อสอบ (ห้ามว่าง) |
| **C**             | `แนวทางเฉลย/คำตอบ` | Optional                        | CPU ทำงานโดยดึงคำสั่ง (Fetch)...  | แนวทางการให้คะแนน/เฉลย             |

---

## 4. จุดเสี่ยงและข้อควรระวัง (Risks & Mitigations)

1. **ปัญหา Memory Limit ใน PHPExcel (PHP 5.6)**:
   * *เสี่ยง*: ไฟล์ Excel ขนาดใหญ่กินหน่วยความจำสูงจนเกิด Memory Exhausted Error
   * *แก้ไข*:
     * กำหนด `ini_set('memory_limit', '256M');` ในสคริปต์นำเข้า
     * ใช้งาน `PHPExcel_Settings::setCacheStorageMethod(PHPExcel_Settings::cache_to_phpTemp);`
     * จำกัดจำนวนแถวไม่เกิน 200 แถวต่อการอัปโหลด 1 ครั้ง
2. **การตรวจสอบความถูกต้องของข้อมูล (Data Validation & Sanitize)**:
   * ตรวจสอบว่าโจทย์ (`proposition`) และตัวเลือกบังคับ (1-4) ไม่เป็นค่าว่าง
   * ตรวจสอบว่า `เฉลยคำตอบ` มีค่าตรงตามเงื่อนไข (1-5) หากไม่ถูกต้องให้รวบรวมแจ้งเตือนผู้ใช้เป็นรายแถว (Row-level Error Reporting)
3. **Encoding & Special Characters**:
   * แปลงค่าข้อความจากเซลล์เป็น UTF-8 เพื่อป้องกันภาษาไทยต่างด้าว
   * ลบช่องว่างส่วนเกินด้วย `trim()`

---

## 5. แผนขั้นตอนการพัฒนา (Implementation Steps)

- [ ] **Phase 1: ติดตั้ง PHPExcel Library ในโฟลเดอร์ `vendor/PHPExcel`**
- [x] **Phase 2: สร้างไฟล์ตัวอย่าง Excel Template (`templates/exam_import_template.xlsx`)**
- [ ] **Phase 3: พัฒนา UI สำหรับอัปโหลดไฟล์ Excel ในหน้าจัดการข้อสอบ**
  - เพิ่มปุ่ม "นำเข้าข้อสอบด้วย Excel" และ Modal อัปโหลดใน `Manager_Exam_Add.php` และ `Manager_Exam_Add_Annotated.php`
- [ ] **Phase 4: สร้างสคริปต์ประมวลผล Backend (`Manager_Exam_Import_Sql.php`)**
  - รับไฟล์ `.xls`/`.xlsx` และ `id_chapter`
  - วนลูปอ่านข้อมูลด้วย PHPExcel
  - ตรวจสอบ Validation และ Insert ข้อมูลลง `manager_exam` หรือ `manager_exam_annotated`
  - สรุปผลการนำเข้า (จำนวนข้อที่สำเร็จ และข้อที่พบ Error)
- [ ] **Phase 5: ทดสอบการนำเข้าและสอบทานความถูกต้อง**
