<?php
date_default_timezone_set("Asia/Bangkok");
if(isset($_GET['Time'])){
	
	$time2 = $_GET['Time'];
	//echo $time2;
	
	$timeex = explode(',',$time2);
	
						for ($i_arr=0; $i_arr < count($timeex); $i_arr++) {   
						    $time_status = $timeex[$i_arr];
						
						if($i_arr == 0){
										$datetime_start = $time_status.":00";
										echo $datetime_start."<br>";

										$datetime_startCreate=date_create($datetime_start);
										$datetime_START =  date_format($datetime_startCreate,"d-m-Y");
										echo $datetime_START."<br>";
									}else if($i_arr == 1){
										$datetime_end = $time_status.":00";
										echo $datetime_end."<br>";
										$datetime_endCreate=date_create($datetime_end);
										$datetime_END =  date_format($datetime_endCreate,"d-m-Y");
										echo $datetime_END."<br>";
									}
						}

}if(isset($_GET['TimeNEW'])){
	//echo "<br>";
	//echo $_GET['TimeNEW'];

}
?>
<input type="button" value="Open Window"
onclick="window.open('http://www.google.com')">