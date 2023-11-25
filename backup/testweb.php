<?php

$host='localhost';
$db_name= 'chullamane_dynamicip';
$db_user= 'chullamane_web';
$db_pass= 'Q2w3e4r5T6';
$con= @mysql_connect("$db_host","$db_user","$db_pass");
$dbconnecterror=mysql_error();
$db = @mysql_select_db("$db_name",$con);
$select_db_error=mysql_error();


$sql_dynamic="SELECT * FROM `chullamane_dynamicip`.`manager_exam` ";  //desc//
	$rdy=mysql_query($sql_dynamic) or die(mysql_error());
	while($ddip=mysql_fetch_array($rdy))
	{
		echo "1234";
	}
?>
