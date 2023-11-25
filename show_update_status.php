<?php
include("connect.php");
$id_exam = $_GET['id_exam'];
// echo $id_exam;
$approve_series_exam = $_GET['approve_series_exam'];
$dateEnd = $_GET['dateEnd'];
$dateStart = $_GET['dateStart'];
$TimeStart = $_GET['TimeStart'];
$dateNow = $_GET['dateNow'];
$TimeEnd = $_GET['TimeEnd'];
// echo $TimeEnd;

function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate));
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		return $strHour.':'.$strMinute.'น. '.$strDay.'/'.$strMonthThai.'/'.$strYear;
	}

	function DateDiff($strDate1,$strDate2)
	 {
				return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
	 }
	 function TimeDiff($strTime1,$strTime2)
	 {
				return (strtotime($strTime2) - strtotime($strTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
	 }
	 function DateTimeDiff($strDateTime1,$strDateTime2)
	 {
				return (strtotime($strDateTime2) - strtotime($strDateTime1))/  ( 60 * 60 ); // 1 Hour =  60*60
	 }

   $sql1 = "UPDATE `manager_series_exam` SET `approve_series_exam` = '$approve_series_exam' WHERE `manager_series_exam`.`id` = $id_exam;";
   // $conn->query($sql1);
   if($conn->query($sql1)=== TRUE){
  if($approve_series_exam == 0){
    echo '<font color="gray"><b>รออนุมัติ</b></font>';
  }else if($approve_series_exam == 1){
    if(DateTimeDiff($dateEnd." ".$TimeEnd,$dateNow) >= 0 )
      {
        echo '<font color="red"><b>ปิดสอบ</b></font>';
      }
      else if(DateTimeDiff($dateStart." ".$TimeStart,$dateNow) < 0 )
      {
        echo '<font color="gray"><b">ยังไม่เปิดให้สอบ</b></font>';
      }
      else
      {
        echo '<font color="green"><b>เปิดสอบ</b></font>';
      }
  }
}

?>
