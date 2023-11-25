<?php
header('Content-Type: text/html; charset=utf-8');
//$servername = "localhost";
//$username = "chullamane_web";
//$password = "Q2w3e4r5T6";
//$dbname = "chullamane_dynamicip";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "online_exam";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//$con= mysqli_connect("localhost","root","","online_exam") or die("Error: " . mysqli_error($con));
mysqli_query($conn, "SET NAMES 'utf8' "); 

//mysqli_set_charset($conn, "utf8");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 



							
							

?>