# มาตรฐานการเขียนโค้ด (Coding Standards & Guidelines)

เอกสารนี้ระบุมาตรฐาน สไตล์การเขียนโค้ด ข้อตกลงในการตั้งชื่อ และกฎเหล็กสำหรับการพัฒนาหรือปรับปรุงระบบ **ระบบข้อสอบออนไลน์ (Online Examination System)** เพื่อรักษาความเสถียรและความสอดคล้องของโปรเจกต์เดิม

---

## 1. มาตรฐานการเขียน Database Query (Database Query Standards)

### 1.1 รูปแบบเดิมในโปรเจกต์ (Legacy Pattern)
โปรเจกต์เดิมใช้ **Procedural MySQLi Extension** โดยเชื่อมต่อผ่านไฟล์ `connect.php` ซึ่งสร้างตัวแปรโกลบอล `$conn`:
* **การดึงข้อมูล**:
  ```php
  include("connect.php");
  $sql = "SELECT * FROM `manager_teacher` WHERE `id_teacher` = $id_teacher";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      // ดึงข้อมูล $row['column_name']
  }
  ```
* **การเพิ่ม/แก้ไข/ลบข้อมูล**:
  ```php
  $sql = "INSERT INTO `manager_std` (`id_std`, `name_std`) VALUES ('$id_std', '$name_std')";
  if ($conn->query($sql) === TRUE) {
      header("Location: Manager_Std_List.php");
  }
  ```
* **Charset**: ถูกกำหนดไว้ที่ `connect.php` ด้วย `mysqli_query($conn, "SET NAMES 'utf8' ")`

### 1.2 แนวทางการปรับปรุงและเขียนเพิ่ม (Modern / Safe Guidelines)
* **การป้องกัน SQL Injection**: โค้ดใหม่ที่เขียนเพิ่มหรือจุดที่ refactor **ควรปรับมาใช้ Prepared Statements (`mysqli_prepare`)** หรือใช้ `mysqli_real_escape_string($conn, $var)` เสมอ:
  ```php
  // ตัวอย่างการใช้ Prepared Statement กับ MySQLi
  $stmt = mysqli_prepare($conn, "SELECT * FROM `manager_std` WHERE `id_std` = ? AND `IsUse` = ?");
  mysqli_stmt_bind_param($stmt, "si", $id_std, $is_use);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  ```

---

## 2. รูปแบบการตั้งชื่อ (Naming Conventions)

### 2.1 การตั้งชื่อไฟล์ (File Naming)
* **หน้า UI / Controller หลัก**: ใช้ **PascalCase** หรือ **PascalCase_Snake_case**
  * ตัวอย่าง: `index.php`, `Login.php`, `LoginStd.php`, `Subject.php`, `Series_Exam.php`, `Manager_Exam_Add.php`, `Manager_Std_List.php`
* **สคริปต์ประมวลผล SQL Backend**: ใช้รูปแบบ `[PageName]_Sql.php`
  * ตัวอย่าง: `Manager_Exam_Add_Sql.php`, `Manager_Std_Sql.php`, `Series_Exam_Manager_Sql.php`
* **สคริปต์ Auth & API**: ใช้ **snake_case** หรือ **camelCase**
  * ตัวอย่าง: `auth/login_manager.php`, `auth/login_manager_std.php`, `Connect_app/login.php`, `Connect_app/include/db_functions.php`

### 2.2 การตั้งชื่อใน Database (Database Conventions)
* **ชื่อตาราง (Tables)**: ใช้ **snake_case** พิมพ์เล็กทั้งหมด
  * ตัวอย่าง: `manager_teacher`, `manager_std`, `manager_subject`, `manager_series_exam`, `manager_exam`, `result_exam_std`
* **ชื่อคอลัมน์ (Columns)**: ใช้ **snake_case** โดยห้อยท้ายด้วยบริบทตาราง
  * ตัวอย่าง: `id_teacher`, `email_teacher`, `name_subject`, `proposition_exam`, `id_std_result_exam`

### 2.3 การตั้งชื่อตัวแปรและฟังก์ชัน (Variables & Functions)
* **ตัวแปรใน PHP**: ส่วนใหญ่ใช้ **snake_case** หรือ **PascalCase** สำหรับตัวแปรฟอร์ม
  * ตัวอย่าง: `$id_teacher`, `$name_subject`, `$genre_std`, `$Option1`, `$Option_true`
* **ฟังก์ชันใน PHP**: ใช้ **camelCase**
  * ตัวอย่าง: `getUserByEmailAndPassword()`, `storeUser()`, `emailExists()`
* **ฟังก์ชันใน JavaScript**: ใช้ **camelCase** หรือ **snake_case** ที่มีหมายเลขกำกับ (สำหรับลูปฟอร์ม)
  * ตัวอย่าง: `show_password_login()`, `buttonDelete1()`, `buttonDelete2()`

---

## 3. การจัดการ Form Submission และ Validation (Form Handling & Validation)

### 3.1 การส่งข้อมูลจาก HTML Form
* **Form Method**: ใช้ `POST` เป็นหลัก
* **Form Action**: ส่งไปยังไฟล์ `_Sql.php` หรือส่งกลับมายังหน้าเดิม
* **Trigger Check**: ในไฟล์ประมวลผล PHP จะเช็คสวิตช์ปุ่มกดด้วย `isset($_POST['btn_name'])`
  ```php
  if (isset($_POST["add_std"])) {
      $id_std = $_POST["id_std"];
      $name_std = $_POST["name_std"];
      // ประมวลผล...
  }
  ```

### 3.2 การตรวจสอบข้อมูล (Validation Patterns)
* **Client-Side Validation**:
  * ใช้ HTML5 Validation Attribute: `required="required"`
  * ใช้ Bootstrap 4 Validation Class: `.needs-validation`
  * ใช้ JavaScript Filter ป้องกันการพิมพ์อักขระที่ไม่ใช่ตัวเลข:
    `oninput="this.value = this.value.replace(/[^0-9]/g, '');"`
* **Server-Side Validation & Feedback**:
  * เมื่อเกิดข้อผิดพลาดในการประมวลผล จะตอบกลับผู้ใช้ผ่านการ `echo` สคริปต์ JavaScript `window.alert()` และถอยกลับด้วย `window.history.back()`:
    ```php
    echo "<script language='JavaScript'>
            window.alert('ตรวจพบว่ามีบัญชีนักศึกษาในระบบแล้ว!');
            window.history.back();
          </script>";
    ```
  * หรือทำ Redirect ไปยังหน้าปลายทางเมื่อสำเร็จด้วย `header("Location: Manager_Std_List.php?...");`

---

## 4. กฎเหล็กที่ห้ามทำ เพื่อป้องกันไม่ให้ระบบเดิมพัง (Golden Rules & Protections)

1. **🚨 ห้ามเปิด Database Connection ซ้ำซ้อน (`New Connection Leak`)**:
   * ห้ามสร้าง `new mysqli(...)` หรือ `mysqli_connect(...)` ซ้ำในไฟล์ทั่วไป ให้ `include("connect.php")` หรือ `include("../connect.php")` แล้วใช้ตัวแปร `$conn` เสมอ
2. **🚨 ห้ามส่ง Output ล่วงหน้าก่อนคำสั่ง `header()` (`Headers Already Sent`)**:
   * ห้ามทำการ `echo`, พิมพ์ช่องว่าง, หรือมี HTML Tag ก่อนคำสั่ง `header("Location: ...")` หรือ `session_start()`
3. **🚨 ห้ามลืม หรือย้ายตำแหน่ง `session_start()`**:
   * หน้าเว็บที่มีการใช้งาน Session ต้องมี `session_start();` อยู่ที่บรรทัดแรกสุดของไฟล์ PHP ก่อนเริ่มแสดงผล HTML
4. **🚨 ห้ามลบ Session Guard Check บนหน้าควบคุม**:
   * ทุกหน้าฝั่งอาจารย์ต้องคงเงื่อนไข `if ($_SESSION['id_teacher'])` และฝั่งนักเรียนต้องคง `if (isset($_SESSION['id_std']))` เพื่อป้องกันความปลอดภัยและการเข้าถึงโดยตรงโดยไม่ Login
5. **🚨 ห้ามเปลี่ยนชื่อคอลัมน์ใน DB หรือ Key ใน Session ที่ใช้งานอยู่**:
   * ห้ามเปลี่ยนชื่อ `$_SESSION['id_teacher']`, `$_SESSION['status_teacher']`, `$_SESSION['id_std']` เนื่องจากมีผลกระทบวงกว้างในสคริปต์หลายสิบไฟล์
6. **🚨 ห้ามเปลี่ยนโครงสร้างการเก็บรูปภาพอัปโหลด (`upload/`)**:
   * รูปภาพโจทย์และตัวเลือกจะถูกสุ่มชื่อด้วย `date("mdy").substr(md5(rand(0, 9999999)), 0, 100)` และเก็บไว้ในโฟลเดอร์ `upload/` ห้ามแก้ไขไดเรกทอรีปลายทางโดยไม่มีการ Migration ไฟล์เดิม
