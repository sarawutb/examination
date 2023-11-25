<?php
header('Content-Type: text/html; charset=utf-8');
// $servername = "localhost";
// $username = "chullamane_web";
// $password = "Q2w3e4r5T6";
// $dbname = "chullamane_dynamicip";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chullamane_learn";

$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_query($conn, "SET NAMES 'utf8' ");
