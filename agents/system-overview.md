# ภาพรวมระบบและสถาปัตยกรรม (System Overview & Architecture)

เอกสารนี้ระบุรายละเอียดโครงสร้างและสถาปัตยกรรมของ **ระบบข้อสอบออนไลน์ (Online Examination System)** เพื่อใช้เป็นข้อมูลอ้างอิงในการพัฒนา ปรับปรุง หรือ refactor ระบบในอนาคต

---

## 1. ภาพรวมระบบและเทคโนโลยี (System Overview & Tech Stack)

ระบบนี้เป็นเว็บแอปพลิเคชันสำหรับบริหารจัดการและจัดสอบออนไลน์ รองรับผู้ใช้งาน 3 กลุ่มหลัก ได้แก่ **ผู้ดูแลระบบ/อาจารย์ (Admin/Teacher)**, **นักเรียน/นักศึกษา (Student)** และ **แอปพลิเคชันมือถือ (Mobile App)**

* **Backend Environment**: Procedural PHP (ใช้สไตล์การเขียนแบบดั้งเดิม/Procedural)
* **Database**: MySQL / MariaDB เชื่อมต่อผ่าน PHP `mysqli` extension
* **Frontend UI**: HTML5, Vanilla CSS, JavaScript (jQuery), Bootstrap 4 (SB Admin template), DataTables, FontAwesome
* **PDF Export**: FPDF library (`FPDF/`) สำหรับสร้างเอกสาร เช่น ใบเซ็นชื่อเข้าสอบ, แบบฟอร์มกระดาษคำตอบ, รายงานคะแนน

---

## 2. โครงสร้างโฟลเดอร์หลักและหน้าที่ของมัน (Folder Structure & Responsibilities)

```
c:/xampp/htdocs/examination/
├── auth/                      # Script จัดการการตรวจสอบสิทธิ์ (Authentication backend scripts)
├── Connect_app/               # API Endpoints สำหรับเชื่อมต่อกับ Mobile App (JSON response)
├── css/                       # ไฟล์ Stylesheet (Bootstrap, SB Admin, Custom CSS)
├── cssx/                      # ไฟล์ CSS สำรอง/ทดสอบ
├── doc/                       # เอกสารคู่มือหรือคู่มือการใช้งานระบบ
├── FPDF/                      # FPDF Library สำหรับสร้างไฟล์ PDF
├── js/                        # JavaScript assets (SB Admin, DataTables scripts)
├── jsx/                       # ไฟล์ JS สำรอง/ทดสอบ
├── print/                     # Template และ Script สำหรับพิมพ์เอกสาร (PDF / Printable views)
├── upload/                    # โฟลเดอร์จัดเก็บไฟล์อัปโหลด (ภาพข้อสอบ, ไฟล์ CSV)
├── vendor/                    # Third-party assets (Bootstrap, FontAwesome, DataTables, jQuery)
├── agents/                    # เอกสารระบบและคำสั่งสำหรับ AI / Developer Guidelines
├── backup/ & backupdb/        # โฟลเดอร์สำรองข้อมูลฐานข้อมูลและสคริปต์สำรอง
└── [Root Level PHP Files]     # ไฟล์แสดงผล UI และสคริปต์ประมวลผล CRUD ต่างๆ
```

### รายละเอียดหน้าที่ของโฟลเดอร์หลัก:

1. **Root Directory (`/`)**:
   * รวมไฟล์หน้าเว็บหลักสำหรับอาจารย์ (`index.php`, `Subject.php`, `Series_Exam.php`, `Manager_Exam_Add.php`, `Manager_Std.php`, `Manager_Teacher.php`)
   * รวมไฟล์หน้าเว็บสำหรับนักเรียนทำข้อสอบ (`testting_web.php`, `test_exam_type1.php`, `test_exam_type2.php`, `Show_Point_Std.php`)
   * รวมไฟล์สคริปต์ประมวลผลแบบฟอร์ม (CRUD operation scripts เช่น `Manager_Exam_Add_Sql.php`, `Manager_Std_Sql.php`, `Series_Exam_Manager_Sql.php`)
   * ไฟล์เชื่อมต่อฐานข้อมูลหลัก: `connect.php`
   * Layout Components: `header.php`, `footer.php`

2. **`auth/`**:
   * ทำหน้าที่เป็นส่วนประมวลผลการเข้าสู่ระบบ/ออกจากระบบของ Web App
   * `login_manager.php`: ตรวจสอบ Login สำหรับอาจารย์/เจ้าหน้าที่
   * `login_manager_std.php`: ตรวจสอบ Login สำหรับนักศึกษา
   * `logout_manager.php` & `logout_manager_Std.php`: ทำลาย Session และออกจากระบบ
   * `forgot_password_manager.php`: สคริปต์ขอรหัสผ่านใหม่

3. **`Connect_app/`**:
   * ให้บริการ Web Service API แก่ Mobile Application (ส่งคืนข้อมูลแบบ JSON)
   * `login.php`: Endpoint รับค่า `id_std` และ `password` ตรวจสอบสิทธิ์ผู้ใช้ฝั่ง Mobile
   * `register.php`: Endpoint ลงทะเบียนนักศึกษาผ่าน Mobile
   * `include/db_connection.php` & `include/db_functions.php`: สคริปต์เชื่อมต่อฐานข้อมูลและฟังก์ชัน helper สำหรับ Mobile API

4. **`FPDF/` & `print/`**:
   * `FPDF/`: ไลบรารี PHP สำหรับสร้าง PDF
   * `print/` & `Page_print_list.php`: สคริปต์ดึงข้อมูลคะแนน/รายชื่อ เพื่อแปลงเป็นไฟล์ PDF เช่น ใบประกาศคะแนน หรือกระดาษข้อสอบ

5. **`agents/`**:
   * จัดเก็บเอกสารกำกับสถาปัตยกรรมระบบ (`system-overview.md`, `coding-standards.md`, `database-schema.md`) สำหรับ Developer และ AI Agents

---

## 3. จุด Entry Point ของโปรแกรม (Entry Points)

ระบบมีจุดเริ่มต้นการเข้าใช้งาน (Entry Points) แยกตามกลุ่มผู้ใช้งาน ดังนี้:

| กลุ่มผู้ใช้งาน | จุด Entry Point (URL/File) | สคริปต์ประมวลผล Auth | หน้าเป้าหมายหลัง Login |
| :--- | :--- | :--- | :--- |
| **อาจารย์ / Admin** | `Login.php` | `auth/login_manager.php` | `index.php` (Dashboard หลัก) |
| **นักเรียน / Student (Web)** | `LoginStd.php` | `auth/login_manager_std.php` | `testting_web.php?id_std=...` (หน้ารายการข้อสอบ) |
| **นักเรียน (Mobile App API)** | `Connect_app/login.php` | `Connect_app/include/db_functions.php` | ส่งคืน JSON Response (`error: false`, `user: {...}`) |

---

## 4. วิธีการ Include/Require ไฟล์ต่างๆ (File Inclusion Mechanism)

ระบบใช้งานการดึงไฟล์ในรูปแบบ **Procedural File Inclusion** (ไม่มีการใช้ Composer Autoloader หรือ MVC Framework):

1. **การเชื่อมต่อฐานข้อมูล (`connect.php`)**:
   * ทุกหน้าใน Root ที่ต้องติดต่อฐานข้อมูล จะดึงไฟล์ `connect.php` มาใช้งานที่ส่วนหัวไฟล์:
     ```php
     include("connect.php");
     ```
   * ใน `auth/` จะเรียกถอยหลัง 1 ระดับ:
     ```php
     include("../connect.php");
     ```

2. **การดึงส่วนแสดงผล Layout (`header.php` และ `footer.php`)**:
   * หน้า UI หลักจะแบ่งส่วน HTML ดังนี้:
     ```php
     <?php include("header.php"); ?>
     <!-- Main Content HTML -->
     <?php include("footer.php"); ?>
     ```

3. **การดึง Helper Functions สำหรับ Mobile API (`Connect_app/`)**:
   * ใช้ `require_once` ในการโหลดฐานข้อมูลและฟังก์ชัน:
     ```php
     require_once 'include/db_functions.php'; // ภายใน db_functions.php มี require_once("db_connection.php");
     ```

4. **การใช้งาน FPDF Library**:
   * สคริปต์ออกรายงานเรียกใช้ FPDF ดังนี้:
     ```php
     require('FPDF/fpdf.php');
     // หรือ require('../FPDF/fpdf.php');
     ```

---

## 5. ระบบ Authentication และ Session ที่ใช้งานอยู่ (Authentication & Session Architecture)

ระบบใช้ **Native PHP Session (`$_SESSION`)** ในการระบุตัวตนสำหรับ Web Application และใช้ **Stateless API** สำหรับ Mobile App:

### 5.1 การเข้าสู่ระบบของอาจารย์/ผู้ดูแลระบบ (Teacher / Admin)
* **ตารางฐานข้อมูล**: `manager_teacher`
* **ข้อมูลที่เก็บบันทึกใน Session**:
  * `$_SESSION['id_teacher']`: รหัสประจำตัวอาจารย์ (`id_teacher`)
  * `$_SESSION['username']`: อีเมลอาจารย์ (`email_teacher`)
  * `$_SESSION['status_teacher']`: ระดับสิทธิ์ (เช่น `1` = ผู้ดูแลระบบ/หัวหน้า, `2` = อาจารย์ผู้สอน)
* **การตรวจสอบสิทธิ์ (Guard Check)**:
  * ในหน้าต่างๆ (เช่น `index.php`, `Subject.php`, `Manager_Exam_Add.php`) มีการตรวจสอบ:
    ```php
    session_start();
    if ($_SESSION['id_teacher']) {
        $id_teacher = $_SESSION['id_teacher'];
        $status_teacher = $_SESSION['status_teacher'];
        // ดึงข้อมูลอาจารย์จาก DB
    } else {
        session_destroy();
        header("location:Login.php");
    }
    ```

### 5.2 การเข้าสู่ระบบของนักศึกษา (Student Web)
* **ตารางฐานข้อมูล**: `manage_std` (เงื่อนไข `IsUse = 1`)
* **ข้อมูลที่เก็บบันทึกใน Session**:
  * `$_SESSION['id']`: Primary key `id`
  * `$_SESSION['id_std']`: รหัสนักศึกษา (`id_std`)
  * `$_SESSION['name_std']`: ชื่อ-นามสกุลนักศึกษา
  * `$_SESSION['status']`: กำหนดเป็น `2`
* **การตรวจสอบสิทธิ์ (Guard Check)**:
  * ในหน้าสอบ (`testting_web.php`, `test_exam_type1.php`):
    ```php
    session_start();
    if (isset($_SESSION['id_std'])) {
        // อนุญาตให้ทำข้อสอบ
    } else {
        session_destroy();
        header("location:LoginStd.php");
    }
    ```

### 5.3 การเข้าสู่ระบบผ่าน Mobile App API
* **การตรวจสอบ**: รับค่า `POST` (`id_std`, `password`) ไปยัง `Connect_app/login.php`
* **ผลลัพธ์**: ตอบกลับเป็น JSON object เช่น `{ "error": false, "user": { "id": "...", "id_std": "...", "name_std": "นาย..." } }` โดยไม่มีการสร้าง PHP Session ในฝั่ง Server

---

## 6. สรุปจุดเด่นและข้อสังเกตทางสถาปัตยกรรม (Architectural Summary)

* **เรียบง่ายและทำงานได้รวดเร็ว**: โครงสร้างแบบ Direct Scripting ทำให้แต่ละหน้าประมวลผลจบในตัวเอง ไม่ซับซ้อน
* **SQL Injection Risk**: สคริปต์ SQL ดั้งเดิมหลายจุดใช้การต่อข้อความ String โดยตรง (Raw SQL queries เช่น `WHERE email_teacher='$username' AND password_teacher='$password'`) โดยไม่ได้ใช้ Prepared Statements ซึ่งควรได้รับการปรับปรุงในอนาคตเพื่อความปลอดภัย
* **Password Storage**: รหัสผ่านเก็บเป็น Plain Text ในฐานข้อมูล ซึ่งควรปรับไปใช้ `password_hash()` และ `password_verify()`
* **การเชื่อมต่อฐานข้อมูลซ้ำซ้อน**: มีการตั้งค่าไฟล์เชื่อมต่อแยกกัน 2 จุดคือ `connect.php` (DB: `chullamane_learn4`) และ `Connect_app/include/db_connection.php` (DB: `chullamane_dynamicip`)
