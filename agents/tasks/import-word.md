# แผนการพัฒนาฟีเจอร์นำเข้าข้อสอบด้วยไฟล์ Microsoft Word (.docx) Specification & Task Plan

เอกสารนี้ระบุผลการวิเคราะห์ สเปกรูปแบบการพิมพ์ข้อสอบใน Microsoft Word (.docx) และแผนการพัฒนาฟีเจอร์นำเข้าข้อสอบ (ทั้งแบบปรนัยและอัตนัย) เข้าสู่ระบบสอบเดิม โดยรองรับสภาพแวดล้อม PHP 5.6 100%

---

## 1. ข้อจำกัดและข้อกำหนดด้านเทคนิค (Technical Constraints)

1. **PHP Version Compatibility (PHP 5.6 Only)**:
   * **ห้ามใช้ Syntax ของ PHP 7.0+ / PHP 8.0+** เด็ดขาด:
     * ❌ Null Coalescing Operator (`??`) -> ให้ใช้ `isset($var) ? $var : $default`
     * ❌ Scalar Type Hinting (`function test(string $a)`) -> ให้ถอด Type Hint ออก
     * ❌ Return Type Declarations (`function test(): array`) -> ให้ถอด Return Type ออก
     * ❌ Arrow Functions (`fn($x) => $x * 2`) -> ให้ใช้ `function($x) { return ...; }`
2. **Word Library (ZipArchive & DOMDocument)**:
   * ใช้งาน `ZipArchive` + `DOMDocument` สกัดโครงสร้าง XML (`word/document.xml`) ใน PHP 5.6 เบา รวดเร็ว และไม่ติดปัญหา Memory Limit
3. **Database Connection & Access Style**:
   * ใช้งาน `$conn` จาก `connect.php` (MySQLi Procedural)
   * ใช้งาน Prepared Statements (`mysqli_prepare` / `mysqli_stmt_bind_param`) เพื่อความปลอดภัยสูงสุด

---

## 2. รูปแบบสแตนดาร์ดการพิมพ์ข้อสอบใน Word (.docx)

กำหนดรูปแบบการพิมพ์เพื่อให้อาจารย์ผู้สอนพิมพ์ได้สะดวก และ Regex บน PHP 5.6 แกะข้อมูลได้แม่นยำ 100%:

### ก) สำหรับข้อสอบปรนัย (Multiple Choice)
```text
1. คอมพิวเตอร์คืออุปกรณ์ประเภทใด?
ก. อุปกรณ์อิเล็กทรอนิกส์
ข. เครื่องใช้ไฟฟ้าทั่วไป
ค. เครื่องคำนวณทางกลไก
ง. ยานพาหนะ
จ. ถูกทุกข้อ
เฉลย: ก

2. ภาษาใดต่อไปนี้ใช้สำหรับพัฒนาเว็บแอปพลิเคชัน?
1) Python
2) PHP
3) C++
4) Assembly
5) HTML
เฉลย: 2
```

### ข) สำหรับข้อสอบอัตนัย (Subjective / Essay)
```text
1. จงอธิบายความหมายและคุณประโยชน์ของระบบสารสนเทศเพื่อการจัดการ (MIS) มาพอสังเขป
ตอบ: ระบบสารสนเทศเพื่อการจัดการ (MIS) คือ ระบบที่รวบรวม ประมวลผล และจัดเก็บข้อมูล เพื่อนำมาใช้ในการวางแผน การตัดสินใจ และการบริหารจัดการองค์กรได้อย่างมีประสิทธิภาพ

2. จงยกตัวอย่างองค์ประกอบพื้นฐานของคอมพิวเตอร์ (Hardware) มาอย่างน้อย 3 ประการ
ตอบ: 1. หน่วยประมวลผลกลาง (CPU) 2. หน่วยความจำหลัก (RAM) 3. อุปกรณ์จัดเก็บข้อมูล (Hard Disk / SSD)
```

---

## 3. ฟีเจอร์ที่ได้รับการพัฒนาแล้ว (Completed Features)

* [x] **Word Parser Helper (`vendor/word_parser/WordReaderHelper.php`)**: สกัดข้อความโจทย์ ตัวเลือก และเฉลย รองรับทั้ง Paragraph และ Table
* [x] **Single-Modal Step Architecture (`#importWordModal`)**:
  * Step 1: อัปโหลดไฟล์เลือกสแกน
  * Step 2: แสดงตาราง Preview ตรวจสอบความถูกต้อง พร้อมแก้ไขโจทย์/ตัวเลือก/เฉลยก่อนยืนยันบันทึก
* [x] **Dynamic Highlight Selection**: สลับแถบสีเขียวไฮไลท์ตัวเลือกเฉลยอัตนัย/ปรนัยทันทีที่เปลี่ยนค่าใน Select Dropdown
* [x] **แยกไฟล์ Template Word 2 ประเภท**:
  * ปรนัย: `templates/exam_import_template_mc.docx`
  * อัตนัย: `templates/exam_import_template_annotated.docx`

---

## 4. สรุปสถานะการพัฒนา (Implementation Status)

- [x] **Phase 1: พัฒนา Class Helper อ่านไฟล์ Word (`vendor/word_parser/WordReaderHelper.php`)**
- [x] **Phase 2: สร้างไฟล์ตัวอย่าง Word Template แยก 2 ประเภท (`templates/exam_import_template_mc.docx` และ `templates/exam_import_template_annotated.docx`)**
- [x] **Phase 3: พัฒนาสคริปต์ Backend ประมวลผลและ Preview ผ่าน AJAX (`Manager_Exam_Import_Word_Sql.php`)**
- [x] **Phase 4: เพิ่ม UI ปุ่ม "นำเข้าด้วย Word" และ Single-Modal Step ในหน้า `Manager_Exam_Add.php` และ `Manager_Exam_Add_Annotated.php`**
- [x] **Phase 5: ทดสอบการสกัดข้อมูล พรีวิวแก้ไข และบันทึกลง Database (PASS 100%)**
