<?php
	/**
	*Database config variables
	*/
	define("DB_HOST","localhost");
	define("DB_USER","chullamane_web");
	define("DB_PASSWORD","Q2w3e4r5T6");
	define("DB_DATABASE","chullamane_dynamicip");

	$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);

	if(mysqli_connect_errno()){
		die("Database connnection failed " . "(" .
			mysqli_connect_error() . " - " . mysqli_connect_errno() . ")"
				);
	}
?>