<!-- <a href="inex2.php">2121212121</a> -->
<?php
include("connect.php");
session_start();
$id_STD = $_SESSION['id'];
$std_id = $_GET['std_id'];
$_SESSION['term_std'] = $_GET['term_std'];
$term_std = $_SESSION['term_std'];
    $number = 1;
    $sql2 = "SELECT DISTINCT manager_subject.name_subject, manager_subject.id as subject_id , manager_subject.id_subject,manager_teacher.name_teacher,manager_teacher.gender_teacher
    FROM `result_exam_std`
    INNER JOIN manager_series_exam on result_exam_std.id_name_series_exam = manager_series_exam.id
    INNER JOIN manager_subject on manager_series_exam.id_subject_series_exam = manager_subject.id
    INNER JOIN manager_teacher on manager_subject.name_teacher_subject = manager_teacher.id_teacher
    WHERE result_exam_std.id_std_result_exam = $std_id AND manager_subject.term_subject = '$term_std'
    ORDER BY `manager_subject`.`id_subject` ASC";
    $result2 = mysqli_query($conn, $sql2);
    while ($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
      $subject_id =  $row2['subject_id'];
      $name_subject =  $row2['name_subject'];
      $id_subject =  $row2['id_subject'];
      $gender_teacher =  $row2['gender_teacher'];
      $name_teacher =  $row2['name_teacher'];
      if($gender_teacher == 1){
        $gender_teacher = "นาย";
      }else if($gender_teacher == 2){
        $gender_teacher = "นาง";
      }else if($gender_teacher == 3){
        $gender_teacher = "นางสาว";
      }

?>
<tr>
<td>
  <div class="list-group">
    <a class="list-group-item list-group-item-action list-group-item-success" href="Show_Point_Std.php?show_chapter&id_sid=<?php echo $id_STD;?>&subject_id=<?php echo $subject_id;?>">
      <!-- <button type="button" class="list-group-item list-group-item-action"> -->
      <?php echo $number.") ".$id_subject." วิชา".$name_subject."<br> อาจารย์ผู้สอน ".$gender_teacher.$name_teacher;?>
    <!-- </button> -->
    </a>
  </div>
</td>
</tr>
<?php
    $number++;
  }
?>
